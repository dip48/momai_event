 <?php
    session_start();
    require_once '../config/database.php';

    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }

    // Handle status updates
    if ($_POST && isset($_POST['update_status'])) {
        $booking_id = $_POST['booking_id'];
        $new_status = $_POST['status'];

        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $booking_id]);

        header('Location: bookings.php');
        exit;
    }

    // Get all bookings
    $stmt = $pdo->query("
    SELECT 
        b.*, 
        u.name AS name, 
        u.email AS email, 
        u.phone AS phone
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.id 
    ORDER BY b.created_at DESC
    ");
    $bookings = $stmt->fetchAll();
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Manage Bookings - Momai Event Admin</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link href="../assets/css/main-theme.css" rel="stylesheet">
 </head>
<style>
        /* ✅ Remove white space at top */
        html, body {
            margin: 0;
            padding: 0;
            }
        
        .h2{
            color: var(--primary-color, #333);
        }
</style>
 <body>
     <?php include 'includes/navbar.php'; ?>

     <div class="container-fluid">
         <div class="row">
             <?php include 'includes/sidebar.php'; ?>

             <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                     <h1 class="h2">
                        <i class="fas fa-calendar sidebar-icon"></i> 
                        Manage Bookings</h1>
                 </div>

                 <div class="card">
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>ID</th>
                                         <th>Customer</th>
                                         <th>Event Type</th>
                                         <th>Date</th>
                                         <th>Venue</th>
                                         <th>Guests</th>
                                         <th>Status</th>
                                         <th>Actions</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php foreach ($bookings as $booking): ?>
                                         <tr>
                                             <td><?php echo $booking['id']; ?></td>
                                             <td>
                                                 <?php echo htmlspecialchars($booking['name']); ?><br>
                                                 <small class="text-muted"><?php echo htmlspecialchars($booking['email']); ?></small>
                                             </td>
                                             <td><?php echo htmlspecialchars($booking['event_type']); ?></td>
                                             <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                                             <td><?php echo htmlspecialchars($booking['venue']); ?></td>
                                             <td><?php echo $booking['guest_count']; ?></td>
                                             <td>
                                                 <?php
                                                    $status_class = '';
                                                    switch ($booking['status']) {
                                                        case 'pending':
                                                            $status_class = 'warning';
                                                            break;
                                                        case 'confirmed':
                                                            $status_class = 'success';
                                                            break;
                                                        case 'in_progress':
                                                            $status_class = 'info';
                                                            break;
                                                        case 'completed':
                                                            $status_class = 'primary';
                                                            break;
                                                        case 'cancelled':
                                                            $status_class = 'danger';
                                                            break;
                                                    }
                                                    ?>
                                                 <span class="badge bg-<?php echo $status_class; ?>">
                                                     <?php echo ucfirst($booking['status']); ?>
                                                 </span>
                                             </td>
                                             <td>
                                                 <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $booking['id']; ?>">
                                                     <i class="fas fa-eye"></i>
                                                 </button>
                                                 <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $booking['id']; ?>">
                                                     <i class="fas fa-edit"></i>
                                                 </button>
                                             </td>
                                         </tr>


                                     <?php endforeach; ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </main>
         </div>
     </div>
     <?php foreach ($bookings as $booking): ?>
         <!-- View Modal -->
         <div class="modal fade" id="viewModal<?php echo $booking['id']; ?>" tabindex="-1">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">Booking Details - #<?php echo $booking['id']; ?></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>
                     <div class="modal-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <p><strong>Customer:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
                                 <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
                                 <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></p>
                                 <p><strong>Event Type:</strong> <?php echo htmlspecialchars($booking['event_type']); ?></p>
                             </div>
                             <div class="col-md-6">
                                 <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($booking['event_date'])); ?></p>
                                 <p><strong>Time:</strong> <?php echo $booking['event_time'] ? date('h:i A', strtotime($booking['event_time'])) : 'Not specified'; ?></p>
                                 <p><strong>Venue:</strong> <?php echo htmlspecialchars($booking['venue']); ?></p>
                                 <p><strong>Guest Count:</strong> <?php echo $booking['guest_count']; ?></p>
                             </div>
                         </div>
                         <?php if ($booking['services_required']): ?>
                             <p><strong>Services Required:</strong><br><?php echo nl2br(htmlspecialchars($booking['services_required'])); ?></p>
                         <?php endif; ?>
                         <?php if ($booking['special_requirements']): ?>
                             <p><strong>Special Requirements:</strong><br><?php echo nl2br(htmlspecialchars($booking['special_requirements'])); ?></p>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Status Update Modal -->
         <div class="modal fade" id="statusModal<?php echo $booking['id']; ?>" tabindex="-1">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">Update Status</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>
                     <form method="POST">
                         <div class="modal-body">
                             <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                             <div class="mb-3">
                                 <label class="form-label">Status</label>
                                 <select class="form-select" name="status" required>
                                     <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                     <option value="confirmed" <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                     <option value="in_progress" <?php echo $booking['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                     <option value="completed" <?php echo $booking['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                     <option value="cancelled" <?php echo $booking['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                 </select>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     <?php endforeach; ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="assets/js/admin-theme.js"></script>
 </body>

 </html>