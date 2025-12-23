<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle user status updates
if ($_POST && isset($_POST['update_status'])) {
    $user_id = $_POST['user_id'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $stmt = $pdo->prepare("UPDATE users SET is_active = ? WHERE id = ?");
    $stmt->execute([$is_active, $user_id]);
    
    header('Location: users.php');
    exit;
}

// Get all users with their booking counts
$stmt = $pdo->query("
    SELECT u.*, 
           COUNT(b.id) as total_bookings,
           COUNT(CASE WHEN b.status = 'pending' THEN 1 END) as pending_bookings,
           COUNT(CASE WHEN b.status = 'confirmed' THEN 1 END) as confirmed_bookings
    FROM users u 
    LEFT JOIN bookings b ON u.id = b.user_id 
    GROUP BY u.id 
    ORDER BY u.created_at DESC
");
$users = $stmt->fetchAll();

// Get user statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
$total_users = $stmt->fetch()['total_users'];

$stmt = $pdo->query("SELECT COUNT(*) as active_users FROM users WHERE is_active = 1");
$active_users = $stmt->fetch()['active_users'];

$stmt = $pdo->query("SELECT COUNT(*) as new_users FROM users WHERE DATE(created_at) = CURDATE()");
$new_users = $stmt->fetch()['new_users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Momai Event Admin</title>
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
                        <i class="fas fa-users me-2"></i>Manage Users
                    </h1>
                </div>

                <!-- User Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Total Users</h5>
                                        <h2 class="stat-number"><?php echo $total_users; ?></h2>
                                        <p class="stat-subtitle">Registered users</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Active Users</h5>
                                        <h2 class="stat-number"><?php echo $active_users; ?></h2>
                                        <p class="stat-subtitle">Currently active</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: <?php echo $total_users > 0 ? ($active_users / $total_users) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">New Today</h5>
                                        <h2 class="stat-number"><?php echo $new_users; ?></h2>
                                        <p class="stat-subtitle">Registered today</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2"></i>Users List
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
                                        <th>Phone</th>
                                        <th>Bookings</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2">
                                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($user['name']); ?></strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo $user['total_bookings']; ?> Total</span>
                                            <?php if ($user['pending_bookings'] > 0): ?>
                                                <span class="badge bg-warning"><?php echo $user['pending_bookings']; ?> Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($user['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $user['id']; ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $user['id']; ?>">
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

    <!-- View User Modals -->
    <?php foreach ($users as $user): ?>
    <div class="modal fade" id="viewModal<?php echo $user['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>User Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Personal Information</h6>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
                            <p><strong>Status:</strong> 
                                <?php if ($user['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Booking Statistics</h6>
                            <p><strong>Total Bookings:</strong> <?php echo $user['total_bookings']; ?></p>
                            <p><strong>Pending Bookings:</strong> <?php echo $user['pending_bookings']; ?></p>
                            <p><strong>Confirmed Bookings:</strong> <?php echo $user['confirmed_bookings']; ?></p>
                            <p><strong>Joined:</strong> <?php echo date('F d, Y', strtotime($user['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal<?php echo $user['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Update User Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <div class="modal-body">
                        <p><strong>User:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                            <label class="form-check-label">Active User</label>
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
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin-theme.js"></script>
</body>
</html>
