 <style>
        .navbar-dark .navbar-brand {
            color: white !important;
        }
    </style>
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
    <div class="container-fluid">
        <!-- <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <i class="fas fa-bars"></i>
        </button> -->
        <div class="navbar-brand-container">
            <a class="navbar-brand fw-bold elegant-serif" href="dashboard.php">
                <i class="fas fa-gem me-2"></i>
                <span class="navbar-brand-text">Momai Event Admin</span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="dashboardNav">
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                <i class="fas fa-user-circle me-2"></i>
                Welcome, <?php echo $_SESSION['admin_username']; ?></span>
            </div>
            
                <a class="nav-link me-2" href="../index.php">
                    <i class="fas fa-home me-1"></i>Go to Home
                </a>
                <a class="nav-link me-2" href="../user/login.php">
                    <i class="fas fa-user me-1"></i>User Login
                </a>
                <a class="nav-link me-2" href="logout.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            
        </div>
    </div>
</nav>