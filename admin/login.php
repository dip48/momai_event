<?php
session_start();
require_once '../config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            // For development - check plain text password
            if ($username === 'kamal' && $password === 'kamal1234') {
                // Create admin user if doesn't exist
                $check_stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
                $check_stmt->execute(['kamal']);
                if (!$check_stmt->fetch()) {
                    $hashed_password = password_hash('kamal1234', PASSWORD_DEFAULT);
                    $create_stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)");
                    $create_stmt->execute(['kamal', $hashed_password, 'kamal@momaievent.com']);
                }

                // Get admin ID
                $admin_stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
                $admin_stmt->execute(['kamal']);
                $admin_user = $admin_stmt->fetch();

                $_SESSION['admin_id'] = $admin_user['id'];
                $_SESSION['admin_username'] = 'kamal';
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        }
    } else {
        $error = 'Please fill in all fields';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Momai Event | Administrative Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/main-theme.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--blush) 50%, var(--primary-color) 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 500px;
        }

        .login-form-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-info-side {
            flex: 1;
            background: linear-gradient(135deg,  rgba(201, 169, 110, 0.9));
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .admin-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg,  rgba(201, 169, 110, 0.9));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-text {
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-user-login {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-user-login:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .nav-buttons {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .password-toggle-btn:hover {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                margin: 1rem;
            }

            .login-form-side, .login-info-side {
                padding: 2rem;
            }

            .nav-buttons {
                position: relative;
                top: auto;
                right: auto;
                justify-content: center;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Buttons -->
    <div class="nav-buttons">
        <a href="../index.php" class="nav-btn">
            <i class="fas fa-home me-1"></i>Home
        </a>
    </div>

    <div class="login-container">
        <div class="login-card">
            <!-- Login Form Side -->
            <div class="login-form-side">
                <h2 class="login-title">Admin Login</h2>
                <div class="admin-badge">
                    <i class="fas fa-shield-alt me-1"></i>ADMIN PORTAL
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group password-toggle">
                        <input type="password" class="form-control" name="password" placeholder="Password" id="admin-password" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('admin-password')">
                            <i class="fas fa-eye" id="admin-password-icon"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
                    </button>
                </form>
            </div>

            <!-- Info Side -->
            <div class="login-info-side">
                <h3 class="info-title">Already have an account?</h3>
                <p class="info-text">Login to your account!</p>
                <a href="../user/login.php" class="btn-user-login">
                    <i class="fas fa-user me-2"></i>User Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(inputId + '-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>