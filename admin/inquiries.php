<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle inquiry status updates
if ($_POST && isset($_POST['update_status'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    $stmt->execute([$status, $inquiry_id]);
    
    header('Location: inquiries.php');
    exit;
}

// Handle inquiry deletion
if ($_POST && isset($_POST['delete_inquiry'])) {
    $inquiry_id = $_POST['inquiry_id'];
    
    $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
    $stmt->execute([$inquiry_id]);
    
    header('Location: inquiries.php');
    exit;
}

// Get all inquiries
$stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC");
$inquiries = $stmt->fetchAll();

// Get inquiry statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_inquiries FROM inquiries");
$total_inquiries = $stmt->fetch()['total_inquiries'];

$stmt = $pdo->query("SELECT COUNT(*) as pending_inquiries FROM inquiries WHERE status = 'pending'");
$pending_inquiries = $stmt->fetch()['pending_inquiries'];

$stmt = $pdo->query("SELECT COUNT(*) as responded_inquiries FROM inquiries WHERE status = 'responded'");
$responded_inquiries = $stmt->fetch()['responded_inquiries'];

$stmt = $pdo->query("SELECT COUNT(*) as new_inquiries FROM inquiries WHERE DATE(created_at) = CURDATE()");
$new_inquiries = $stmt->fetch()['new_inquiries'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inquiries - Momai Event Admin</title>
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
</style>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-gradient">
                        <i class="fas fa-envelope me-2"></i>Manage Inquiries
                    </h1>
                </div>

                <!-- Inquiry Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Total Inquiries</h5>
                                        <h2 class="stat-number"><?php echo $total_inquiries; ?></h2>
                                        <p class="stat-subtitle">All inquiries</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card stat-card stat-card-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Pending</h5>
                                        <h2 class="stat-number"><?php echo $pending_inquiries; ?></h2>
                                        <p class="stat-subtitle">Need response</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: <?php echo $total_inquiries > 0 ? ($pending_inquiries / $total_inquiries) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card stat-card stat-card-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Responded</h5>
                                        <h2 class="stat-number"><?php echo $responded_inquiries; ?></h2>
                                        <p class="stat-subtitle">Completed</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: <?php echo $total_inquiries > 0 ? ($responded_inquiries / $total_inquiries) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card stat-card stat-card-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">New Today</h5>
                                        <h2 class="stat-number"><?php echo $new_inquiries; ?></h2>
                                        <p class="stat-subtitle">Today's inquiries</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inquiries Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2"></i>Inquiries List
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Event Type</th>
                                        <th>Event Date</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inquiries as $inquiry): ?>
                                    <tr>
                                        <td><?php echo $inquiry['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($inquiry['email']); ?></td>
                                        <td>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($inquiry['event_type']); ?></span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($inquiry['event_date'])); ?></td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($inquiry['status']) {
                                                case 'pending': $status_class = 'warning'; break;
                                                case 'responded': $status_class = 'success'; break;
                                                case 'closed': $status_class = 'secondary'; break;
                                                default: $status_class = 'primary';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $status_class; ?>">
                                                <?php echo ucfirst($inquiry['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($inquiry['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $inquiry['id']; ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $inquiry['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $inquiry['id']; ?>">
                                                <i class="fas fa-trash"></i>
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

    <!-- View Inquiry Modals -->
    <?php foreach ($inquiries as $inquiry): ?>
    <div class="modal fade" id="viewModal<?php echo $inquiry['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>Inquiry Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Contact Information</h6>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($inquiry['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($inquiry['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($inquiry['phone']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Event Details</h6>
                            <p><strong>Event Type:</strong> <?php echo htmlspecialchars($inquiry['event_type']); ?></p>
                            <p><strong>Event Date:</strong> <?php echo date('F d, Y', strtotime($inquiry['event_date'])); ?></p>
                            <p><strong>Guests:</strong> <?php echo htmlspecialchars($inquiry['guests']); ?></p>
                            <p><strong>Budget:</strong> $<?php echo number_format($inquiry['budget']); ?></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Message</h6>
                            <p class="border p-3 rounded"><?php echo nl2br(htmlspecialchars($inquiry['message'])); ?></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-<?php echo $status_class; ?>">
                                    <?php echo ucfirst($inquiry['status']); ?>
                                </span>
                            </p>
                            <p><strong>Received:</strong> <?php echo date('F d, Y g:i A', strtotime($inquiry['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" class="btn btn-primary">
                        <i class="fas fa-reply me-2"></i>Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal<?php echo $inquiry['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Update Inquiry Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                    <div class="modal-body">
                        <p><strong>Inquiry from:</strong> <?php echo htmlspecialchars($inquiry['name']); ?></p>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="pending" <?php echo $inquiry['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="responded" <?php echo $inquiry['status'] == 'responded' ? 'selected' : ''; ?>>Responded</option>
                                <option value="closed" <?php echo $inquiry['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_status" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?php echo $inquiry['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-trash me-2"></i>Delete Inquiry
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this inquiry from <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                        <button type="submit" name="delete_inquiry" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin-theme.js"></script>
</body>
</html>
