<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success_message = '';
$error_message = '';

if ($_POST) {
    $event_type = $_POST['event_type'] ?? '';
    $event_date = $_POST['event_date'] ?? '';
    $event_time = $_POST['event_time'] ?? '';
    $venue = $_POST['venue'] ?? '';
    $guest_count = $_POST['guest_count'] ?? '';
    $budget = $_POST['budget'] ?? '';

    // Handle services array from checkboxes
    $services_required = '';
    if (isset($_POST['services']) && is_array($_POST['services'])) {
        $services_required = implode(', ', $_POST['services']);
    } elseif (isset($_POST['services_required'])) {
        $services_required = $_POST['services_required'];
    }

    $special_requirements = $_POST['special_requirements'] ?? '';

    if ($event_type && $event_date && $venue && $guest_count) {
        try {
            // Get user details
            $user_stmt = $pdo->prepare("SELECT name, email, phone FROM users WHERE id = ?");
            $user_stmt->execute([$_SESSION['user_id']]);
            $user = $user_stmt->fetch();

            if (!$user) {
                $error_message = "User not found. Please login again.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_type, event_date, event_time, venue, guest_count, budget, services_required, special_requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([
                    $_SESSION['user_id'],
                    $event_type,
                    $event_date,
                    $event_time,
                    $venue,
                    $guest_count,
                    $budget,
                    $services_required,
                    $special_requirements
                ]);

                $success_message = "Your booking request has been submitted successfully! We'll contact you soon.";
            }
        } catch(PDOException $e) {
            $error_message = "Error submitting booking: " . $e->getMessage();
        }
    } else {
        $error_message = "Please fill in all required fields (Event Type, Date, Venue, and Guest Count).";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking - Momai Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    <!-- User Booking Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="fas fa-star me-2"></i>Momai Event
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bookingNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="bookingNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link me-2" href="../index.php">
                        <i class="fas fa-home me-1"></i>Go to Home
                    </a>
                    <a class="nav-link me-2" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Submit Booking Request</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success_message): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                                <div class="mt-2">
                                    <a href="dashboard.php" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-tachometer-alt me-1"></i>View Dashboard
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($error_message): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Debug Info (remove in production) -->
                        <?php if (isset($_POST) && !empty($_POST)): ?>
                            <div class="alert alert-info">
                                <small><strong>Debug:</strong> Form submitted. User ID: <?php echo $_SESSION['user_id']; ?></small>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Type *</label>
                                    <select class="form-select" name="event_type" required>
                                        <option value="">Select Event Type</option>
                                        <option value="Destination Wedding Decorations" <?php echo (($_POST['event_type'] ?? '') == 'Destination Wedding Decorations') ? 'selected' : ''; ?>>Destination Wedding Decorations</option>
                                        <option value="Decoration with Catering Planning" <?php echo (($_POST['event_type'] ?? '') == 'Decoration with Catering Planning') ? 'selected' : ''; ?>>Decoration with Catering Planning</option>
                                        <option value="Birthday Party" <?php echo (($_POST['event_type'] ?? '') == 'Birthday Party') ? 'selected' : ''; ?>>Birthday Party</option>
                                        <option value="Baby Shower" <?php echo (($_POST['event_type'] ?? '') == 'Baby Shower') ? 'selected' : ''; ?>>Baby Shower</option>
                                        <option value="Other" <?php echo (($_POST['event_type'] ?? '') == 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Date *</label>
                                    <input type="date" class="form-control" name="event_date"
                                           min="<?php echo date('Y-m-d'); ?>"
                                           value="<?php echo $_POST['event_date'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Time</label>
                                    <input type="time" class="form-control" name="event_time" value="<?php echo $_POST['event_time'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expected Guest Count *</label>
                                    <input type="number" class="form-control" name="guest_count" min="1" value="<?php echo $_POST['guest_count'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Venue *</label>
                                <input type="text" class="form-control" name="venue" placeholder="Event venue address" value="<?php echo $_POST['venue'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Budget Range</label>
                                <select class="form-select" name="budget">
                                    <option value="">Select Budget Range</option>
                                    <option value="50000">Under ₹50,000</option>
                                    <option value="100000">₹50,000 - ₹1,00,000</option>
                                    <option value="500000">₹1,00,000 - ₹5,00,000</option>
                                    <option value="100000">₹5,00,000 - ₹10,00,000</option>
                                    <option value="200000">₹10,00,000 - ₹20,00,000</option>
                                    <option value="300000">Above ₹20,00,000</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Services Required</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Decoration" id="decoration">
                                            <label class="form-check-label" for="decoration">Decoration</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Catering" id="catering">
                                            <label class="form-check-label" for="catering">Catering</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Photography" id="photography">
                                            <label class="form-check-label" for="photography">Photography</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Transportation" id="transportation">
                                            <label class="form-check-label" for="transportation">Transportation</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Entertainment" id="entertainment">
                                            <label class="form-check-label" for="entertainment">Entertainment</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="services[]" value="Coordination" id="coordination">
                                            <label class="form-check-label" for="coordination">Event Coordination</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Special Requirements</label>
                                <textarea class="form-control" name="special_requirements" rows="4" placeholder="Any special requirements or additional information..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Submit Booking Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle services checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="services[]"]');
            const servicesInput = document.createElement('input');
            servicesInput.type = 'hidden';
            servicesInput.name = 'services_required';
            document.querySelector('form').appendChild(servicesInput);

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const selectedServices = Array.from(checkboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);
                    servicesInput.value = selectedServices.join(', ');
                });
            });
        });
    </script>
    <script src="../assets/js/main-theme.js"></script>
</body>
</html>