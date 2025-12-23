<?php require_once 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Momai Event | Elegant Wedding & Event Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/main-theme.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section-small hero-services">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title elegant-serif">Our Exquisite Services</h1>
                <p class="hero-subtitle elegant-script">Sophisticated event design solutions crafted for your most precious moments</p>
                <div class="hero-buttons">
                    <a href="#destination-wedding" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-heart me-2"></i>View Services
                    </a>
                    <a href="inquiry.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Get Quote
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">

        <!-- Destination Wedding Decorations -->
        <div id="destination-wedding" class="row mb-5">
            <div class="col-md-6">
                <img src="assets/services/destination-wedding.jpg" class="img-fluid rounded" alt="Destination Wedding">
            </div>
            <div class="col-md-6">
                <h2><i class="fas fa-heart text-danger me-2"></i>Destination Wedding Decorations</h2>
                <p class="lead">Make your dream wedding come true with our exquisite destination wedding decoration services.</p>
                <ul>
                    <li>Beach wedding setups</li>
                    <li>Mountain venue decorations</li>
                    <li>Palace and heritage venue styling</li>
                    <li>Floral arrangements and lighting</li>
                    <li>Complete venue transformation</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>

        <!-- Decoration with Catering Planning -->
        <div id="decoration-catering" class="row mb-5">
            <div class="col-md-6 order-md-2">
                <img src="assets/services/catering.jpg" class="img-fluid rounded" alt="Catering">
            </div>
            <div class="col-md-6 order-md-1">
                <h2><i class="fas fa-utensils text-success me-2"></i>Decoration with Catering Planning</h2>
                <p class="lead">Complete event solutions combining beautiful decorations with delicious catering services.</p>
                <ul>
                    <li>Menu planning and customization</li>
                    <li>Professional catering staff</li>
                    <li>Themed decoration coordination</li>
                    <li>Table setting and arrangement</li>
                    <li>Complete event coordination</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>

        <!-- Pick and Drop -->
        <div id="pick-drop" class="row mb-5">
            <div class="col-md-6">
                <img src="assets/services/transport.jpg" class="img-fluid rounded" alt="Transportation">
            </div>
            <div class="col-md-6">
                <h2><i class="fas fa-car text-primary me-2"></i>Pick and Drop Services</h2>
                <p class="lead">Convenient and reliable transportation services for your events and guests.</p>
                <ul>
                    <li>Guest transportation coordination</li>
                    <li>Luxury vehicle arrangements</li>
                    <li>Airport pickup and drop services</li>
                    <li>Decorated vehicles for special occasions</li>
                    <li>Professional chauffeur services</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>

        <!-- Birthday Party -->
        <div id="birthday-party" class="row mb-5">
            <div class="col-md-6 order-md-2">
                <img src="assets/services/birthday.jpg" class="img-fluid rounded" alt="Birthday Party">
            </div>
            <div class="col-md-6 order-md-1">
                <h2><i class="fas fa-birthday-cake text-warning me-2"></i>Birthday Party Planning</h2>
                <p class="lead">Create unforgettable birthday celebrations with our themed decoration and planning services.</p>
                <ul>
                    <li>Themed decorations for all ages</li>
                    <li>Balloon arrangements and backdrops</li>
                    <li>Entertainment coordination</li>
                    <li>Custom cake arrangements</li>
                    <li>Photography and videography</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>

        <!-- Baby Shower -->
        <div id="baby-shower" class="row mb-5">
            <div class="col-md-6">
                <img src="assets/services/babyshower.jpg" class="img-fluid rounded" alt="Baby Shower">
            </div>
            <div class="col-md-6">
                <h2><i class="fas fa-baby text-info me-2"></i>Baby Shower Celebrations</h2>
                <p class="lead">Adorable and memorable baby shower decorations and arrangements for the special day.</p>
                <ul>
                    <li>Gender-specific themed decorations</li>
                    <li>Cute balloon arrangements</li>
                    <li>Photo booth setups</li>
                    <li>Game coordination and prizes</li>
                    <li>Refreshment arrangements</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>

        <!-- Event Timeline -->
        <div id="event-timeline" class="row mb-5">
            <div class="col-md-6 order-md-2">
                <img src="assets/services/timeline.jpg" class="img-fluid rounded" alt="Event Timeline">
            </div>
            <div class="col-md-6 order-md-1">
                <h2><i class="fas fa-calendar-check text-secondary me-2"></i>Event Timeline Planning</h2>
                <p class="lead">Professional event timeline planning and coordination to ensure everything runs smoothly.</p>
                <ul>
                    <li>Detailed event scheduling</li>
                    <li>Vendor coordination</li>
                    <li>Timeline management</li>
                    <li>On-site event coordination</li>
                    <li>Contingency planning</li>
                </ul>
                <a href="inquiry.php" class="btn btn-primary">Get Quote</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main-theme.js"></script>
</body>
</html>