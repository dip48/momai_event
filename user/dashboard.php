<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user bookings
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

// Get booking statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as total_bookings FROM bookings WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_bookings = $stmt->fetch()['total_bookings'];

$stmt = $pdo->prepare("SELECT COUNT(*) as pending_bookings FROM bookings WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$_SESSION['user_id']]);
$pending_bookings = $stmt->fetch()['pending_bookings'];

$stmt = $pdo->prepare("SELECT COUNT(*) as confirmed_bookings FROM bookings WHERE user_id = ? AND status = 'confirmed'");
$stmt->execute([$_SESSION['user_id']]);
$confirmed_bookings = $stmt->fetch()['confirmed_bookings'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Momai Event | Client Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/main-theme.css" rel="stylesheet">
     <style>
        .navbar-dark .navbar-brand {
            color: white !important;
        }

           /* ✅ Remove white space at top */
        html, body {
            margin: 0;
            padding: 0;
            }

        .col-10{
                font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary-color, #333);
        }
    </style>
</head>

<body>
    <!-- User Dashboard Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold elegant-serif" href="dashboard.php"  >
                <i class="fas fa-gem me-2"></i>Momai Event Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dashboardNav">
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text me-3">
                        <i class="fas fa-user me-1"></i>Welcome, <?php echo $_SESSION['user_name']; ?>
                    </span>
                    <a class="nav-link me-2" href="../index.php">
                        <i class="fas fa-home me-1"></i>Go to Home
                    </a>
                    <a class="nav-link me-2" href="booking.php">
                        <i class="fas fa-plus me-1"></i>New Booking
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row">
            <div class="col-10">
                <h2>Dashboard</h2>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Total Bookings</h5>
                                <h2><?php echo $total_bookings; ?></h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Pending</h5>
                                <h2><?php echo $pending_bookings; ?></h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Confirmed</h5>
                                <h2><?php echo $confirmed_bookings; ?></h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="row" id="my-bookings">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Bookings</h5>
                        <a href="booking.php" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>New Booking</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($bookings)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5>No bookings found</h5>
                                <p class="text-muted">You haven't made any bookings yet.</p>
                                <a href="booking.php" class="btn btn-primary">Make Your First Booking</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Event Type</th>
                                            <th>Date</th>
                                            <th>Venue</th>
                                            <th>Guests</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
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
                                                <td><?php echo date('M d, Y', strtotime($booking['created_at'])); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $booking['id']; ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>


                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($bookings as $booking): ?>
        <!-- View Modal -->
        <div class="modal fade" id="viewModal<?php echo $booking['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Booking Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Event Type:</strong> <?php echo htmlspecialchars($booking['event_type']); ?></p>
                                <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($booking['event_date'])); ?></p>
                                <p><strong>Time:</strong> <?php echo $booking['event_time'] ? date('h:i A', strtotime($booking['event_time'])) : 'Not specified'; ?></p>
                                <p><strong>Venue:</strong> <?php echo htmlspecialchars($booking['venue']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Guest Count:</strong> <?php echo $booking['guest_count']; ?></p>
                                <p><strong>Budget:</strong> <?php echo $booking['budget'] ? '$' . number_format($booking['budget'], 2) : 'Not specified'; ?></p>
                                <p><strong>Status:</strong> <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($booking['status']); ?></span></p>
                            </div>
                        </div>
                        <?php if ($booking['services_required']): ?>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <p><strong>Services Required:</strong></p>
                                    <p><?php echo nl2br(htmlspecialchars($booking['services_required'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($booking['special_requirements']): ?>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <p><strong>Special Requirements:</strong></p>
                                    <p><?php echo nl2br(htmlspecialchars($booking['special_requirements'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll to bookings section if hash is present
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#my-bookings') {
                setTimeout(function() {
                    document.getElementById('my-bookings').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }
        });
    </script>
</body>

</html>