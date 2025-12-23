<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_bookings FROM bookings");
$total_bookings = $stmt->fetch()['total_bookings'];

$stmt = $pdo->query("SELECT COUNT(*) as pending_bookings FROM bookings WHERE status = 'pending'");
$pending_bookings = $stmt->fetch()['pending_bookings'];

$stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
$total_users = $stmt->fetch()['total_users'];

$stmt = $pdo->query("SELECT COUNT(*) as total_categories FROM event_categories WHERE is_active = 1");
$total_categories = $stmt->fetch()['total_categories'];

$stmt = $pdo->query("SELECT COUNT(*) as total_gallery FROM gallery WHERE is_active = 1");
$total_gallery = $stmt->fetch()['total_gallery'];

$stmt = $pdo->query("SELECT COUNT(*) as total_inquiries FROM inquiries");
$total_inquiries = $stmt->fetch()['total_inquiries'];

$stmt = $pdo->query("SELECT SUM(budget) as booking_profit FROM bookings WHERE status = 'completed'");
$booking_profit = $stmt->fetch()['booking_profit'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Momai Event | Administrative Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                        <i class="fas fa-tachometer-alt sidebar-icon"></i>
                        Admin Dashboard</h1>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Total Bookings</h5>
                                        <h2 class="stat-number"><?php echo $total_bookings; ?></h2>
                                        <p class="stat-subtitle">All time bookings</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Pending Bookings</h5>
                                        <h2 class="stat-number"><?php echo $pending_bookings; ?></h2>
                                        <p class="stat-subtitle">Awaiting confirmation</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                      <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Booking Profit</h5>
                                        <h2 class="stat-number">₹<?php echo number_format($booking_profit, 2); ?></h2>
                                        <p class="stat-subtitle">Total profit from completed bookings</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-success">
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
                                    <div class="stat-progress-bar" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Event Categories</h5>
                                        <h2 class="stat-number"><?php echo $total_categories; ?></h2>
                                        <p class="stat-subtitle">Active categories</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-list"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-secondary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Gallery Images</h5>
                                        <h2 class="stat-number"><?php echo $total_gallery; ?></h2>
                                        <p class="stat-subtitle">Active images</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Inquiries</h5>
                                        <h2 class="stat-number"><?php echo $total_inquiries; ?></h2>
                                        <p class="stat-subtitle">Customer inquiries</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <a href="bookings.php" class="btn btn-primary w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-calendar-alt mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Manage Bookings</span>
                                            <small class="d-block opacity-75">View & update bookings</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="categories.php" class="btn btn-success w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-tags mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Event Categories</span>
                                            <small class="d-block opacity-75">Manage event types</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="decorations.php" class="btn btn-info w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-palette mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Decorations</span>
                                            <small class="d-block opacity-75">Manage decoration images</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="inquiries.php" class="btn btn-warning w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-envelope mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Inquiries</span>
                                            <small class="d-block opacity-75">Customer inquiries</small>
                                        </a>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-3">
                                        <a href="users.php" class="btn btn-secondary w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-users mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Manage Users</span>
                                            <small class="d-block opacity-75">User management</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="../gallery.php" class="btn btn-info w-100 btn-lg quick-action-btn" target="_blank">
                                            <i class="fas fa-images mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Gallery</span>
                                            <small class="d-block opacity-75">View public gallery</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="../index.php" class="btn btn-outline-primary w-100 btn-lg quick-action-btn" target="_blank">
                                            <i class="fas fa-globe mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">View Website</span>
                                            <small class="d-block opacity-75">Visit frontend</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="logout.php" class="btn btn-danger w-100 btn-lg quick-action-btn">
                                            <i class="fas fa-sign-out-alt mb-2 d-block fa-2x"></i>
                                            <span class="d-block fw-bold">Logout</span>
                                            <small class="d-block opacity-75">Sign out safely</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin-theme.js"></script>
</body>
</html>