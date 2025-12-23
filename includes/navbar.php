<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Determine base path for links
$base_path = '';
if ($current_dir === 'user' || $current_dir === 'admin') {
    $base_path = '../';
}
?>

<style>
    .navbar .nav-link.btn.btn-primary:hover {
        color: #fff !important;
        background-color: var(--primary-color, #333) !important;
        border-color: var(--primary-color, #333) !important;
        box-shadow: 0 0 15px var(--primary-color, #333);
        transition: all 0.3s ease;
    }
</style>


<nav class="navbar navbar-expand-lg fixed-top navbar-modern">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
            <i class="fas fa-gem me-2"></i>Momai Event
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php' || $current_page == 'index.html') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>index.php">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>about.php">
                        <i class="fas fa-info-circle me-1"></i>About Us
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($current_page == 'services.php') ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-concierge-bell me-1"></i>Services
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#destination-wedding">
                            <i class="fas fa-heart me-2"></i>Destination Wedding Decorations
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#decoration-catering">
                            <i class="fas fa-utensils me-2"></i>Decoration with Catering Planning
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#pick-drop">
                            <i class="fas fa-car me-2"></i>Pick and Drop
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#birthday-party">
                            <i class="fas fa-birthday-cake me-2"></i>Birthday Party
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#baby-shower">
                            <i class="fas fa-baby me-2"></i>Baby Shower
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo $base_path; ?>services.php#event-timeline">
                            <i class="fas fa-calendar-check me-2"></i>Event Timeline
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>gallery.php">
                        <i class="fas fa-images me-1"></i>Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'inquiry.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>inquiry.php">
                        <i class="fas fa-envelope me-1"></i>Inquiry
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>contact.php">
                        <i class="fas fa-phone me-1"></i>Contact Us
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in - show user menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>user/dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>user/dashboard.php#my-bookings">
                                <i class="fas fa-calendar-check me-2"></i>My Bookings
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>user/booking.php">
                                <i class="fas fa-calendar-plus me-2"></i>New Booking
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_path; ?>user/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                <?php elseif (isset($_SESSION['admin_id'])): ?>
                    <!-- Admin is logged in - show admin menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-danger" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield me-1"></i>Admin <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/dashboard.php">
                                <i class="fas fa-cogs me-2"></i>Admin Panel
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/bookings.php">
                                <i class="fas fa-calendar-alt me-2"></i>Manage Bookings
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/users.php">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_path; ?>admin/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- No one is logged in - show only client login button -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary" href="<?php echo $base_path; ?>user/login.php">
                            <i class="fas fa-user me-1"></i>Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>