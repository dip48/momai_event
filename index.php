<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momai Event - Elegant Wedding & Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/main-theme.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Creating Timeless Elegance</h1>
                <p class="hero-subtitle">Exquisite wedding and event management with sophisticated design and impeccable attention to detail</p>
                <div class="hero-buttons d-flex justify-content-center gap-3">
                    <a href="inquiry.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Get Quote
                    </a>
                    <a href="gallery.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-images me-2"></i>View Gallery
                    </a>
                </div>
            </div>
        </div>
        <br>
    </section>
    <br>
    <center>
    <div>
            <div class="col-md-6">
                <h2 class="elegant-serif" style="color: var(--primary-color);">Our Story</h2>
                <p class="lead" style="color: var(--text-secondary);">Momai Event has been creating timeless elegance for over a decade, specializing in sophisticated wedding and event design services.</p>
                <p style="color: var(--text-primary);">Founded with a passion for creating unforgettable experiences, we have grown to become one of the most trusted luxury event management companies in the region. Our team of creative professionals brings years of experience and innovative design concepts to every celebration we craft.</p>
                <p style="color: var(--text-primary);">From intimate ceremonies to grand celebrations, we ensure every detail reflects sophistication and every moment becomes a cherished memory.</p>
            </div>
    </div>
    </center>
    <!-- Services Section -->
    <section id="services" class="py-5" style="background: var(--bg-secondary);">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="display-5 elegant-serif" style="color: var(--primary-color);">Our Exquisite Services</h2>
                <p class="lead elegant-script" style="color: var(--text-secondary);">Crafting unforgettable moments with sophistication and grace</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h5 class="fw-bold">Destination Wedding Decorations</h5>
                            <p class="text-muted">Beautiful wedding decorations for your dream destination wedding with elegant themes and stunning arrangements</p>
                            <a href="services.php#destination-wedding" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <h5 class="fw-bold">Decoration with Catering</h5>
                            <p class="text-muted">Complete event planning with decoration and catering services for a seamless experience</p>
                            <a href="services.php#decoration-catering" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <h5 class="fw-bold">Pick and Drop</h5>
                            <p class="text-muted">Convenient and reliable transportation services for your events and special occasions</p>
                            <a href="services.php#pick-drop" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <h5 class="fw-bold">Birthday Party</h5>
                            <p class="text-muted">Memorable birthday celebrations with themed decorations and entertainment coordination</p>
                            <a href="services.php#birthday-party" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-baby"></i>
                            </div>
                            <h5 class="fw-bold">Baby Shower</h5>
                            <p class="text-muted">Adorable baby shower decorations and arrangements to celebrate new beginnings</p>
                            <a href="services.php#baby-shower" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card h-100 animate-on-scroll">
                        <div class="card-body text-center">
                            <div class="service-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h5 class="fw-bold">Event Timeline</h5>
                            <p class="text-muted">Professional event timeline planning and coordination for flawless execution</p>
                            <a href="services.php#event-timeline" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-5" style="background: var(--bg-cream);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="elegant-serif mb-4" style="color: var(--primary-color);">Why Choose Momai Event?</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-gem me-3" style="color: var(--rose-gold);"></i>10+ Years of Elegant Experience</li>
                        <li class="mb-3"><i class="fas fa-users me-3" style="color: var(--rose-gold);"></i>Expert Design Team</li>
                        <li class="mb-3"><i class="fas fa-palette me-3" style="color: var(--rose-gold);"></i>Bespoke Event Solutions</li>
                        <li class="mb-3"><i class="fas fa-heart me-3" style="color: var(--rose-gold);"></i>Luxury Within Reach</li>
                        <li class="mb-3"><i class="fas fa-clock me-3" style="color: var(--rose-gold);"></i>Dedicated Support</li>
                    </ul>
                    <a href="about.php" class="btn btn-primary">Discover Our Story</a>
                </div>
                <div class="col-md-6">
                    <img src="assets/gallery/wedding1.jpg" class="img-fluid rounded shadow-lg" alt="Elegant Wedding Setup" style="border-radius: var(--radius-xl);">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main-theme.js"></script>
</body>
</html>