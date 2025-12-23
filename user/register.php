<?php
require_once '../config/database.php';

$success_message = '';
$error_message = '';

if ($_POST) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($name && $email && $password && $confirm_password) {
        if ($password === $confirm_password) {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error_message = "Email already exists. Please use a different email.";
            } else {
                try {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $hashed_password, $phone, $address]);
                    $success_message = "Registration successful! You can now login.";
                    // header('Location: login.php');
                    // Redirect after 2 seconds
                    echo "<script>
                        setTimeout(function(){
                            window.location.href = 'login.php';
                        }, 1000);
                    </script>";
                } catch(PDOException $e) {
                    $error_message = "Registration failed. Please try again.";
                }
            }
        } else {
            $error_message = "Passwords do not match.";
        }
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Momai Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="../assets/css/main-theme.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--blush) 50%, var(--primary-color) 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .signup-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .signup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            display: flex;
            min-height: 600px;
        }

        .signup-form-side {
            flex: 1.2;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 600px;
            overflow-y: auto;
        }

        .signup-info-side {
            flex: 0.8;
            background: linear-gradient(135deg, rgba(201, 169, 110, 0.9));
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .signup-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
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

        .btn-signup {
            background: linear-gradient(135deg, rgba(201, 169, 110, 0.9));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .social-signup {
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

        .btn-login {
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

        .btn-login:hover {
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

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }

        .checkbox-group label {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
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
            .signup-card {
                flex-direction: column;
                margin: 1rem;
                max-height: none;
            }

            .signup-form-side, .signup-info-side {
                padding: 2rem;
                max-height: none;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
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
        <a href="../admin/login.php" class="nav-btn">
            <i class="fas fa-shield-alt me-1"></i>Admin
        </a>
    </div>

    <div class="signup-container">
        <div class="signup-card">
            <!-- Sign Up Form Side -->
            <div class="signup-form-side">
                <h2 class="signup-title">Register</h2>

                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <input type="tel" 
                                class="form-control" name="phone" id="phone"
                                placeholder="Phone"
                                pattern="[0-9]{10}" maxlength="10" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)">
                        </div>
                        <div class="form-group password-toggle">
                            <input type="password" class="form-control" 
                                name="password" placeholder="Password"  
                                id="register-password" minlength="4" 
                                 required>
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('register-password')">
                                <i class="fas fa-eye" id="register-password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group password-toggle">
                        <input type="password" class="form-control" 
                            name="confirm_password" placeholder="Confirm Password" 
                            id="confirm-password" minlength="4"  required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('confirm-password')">
                            <i class="fas fa-eye" id="confirm-password-icon"></i>
                        </button>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="address" placeholder="Address" rows="2"></textarea>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">I accept the terms & conditions</label>
                    </div>

                    <button type="submit" class="btn-signup">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </form>
            </div>

            <!-- Info Side -->
            <div class="signup-info-side">
                <h3 class="info-title">Already have an account?</h3>
                <p class="info-text">Login to your account!</p>
                <a href="login.php" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
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