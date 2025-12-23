<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Momai Event | Get in Touch for Elegant Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/main-theme.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section-small hero-contact">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title elegant-serif">Contact Us</h1>
                <p class="hero-subtitle elegant-script">Let's create something beautiful together for your special day</p>
                <div class="hero-buttons">
                    <a href="#contact-form" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-envelope me-2"></i>Send Message
                    </a>
                    <a href="tel:+1234567890" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Call Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <!-- Contact Information Cards -->
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="card service-card h-100 text-center no-animate">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5 class="fw-bold">Visit Our Office</h5>
                        <p class="text-muted">123 Event Street<br>City Center, State 12345</p>
                        <a href="https://www.google.com/maps/place/Ahmedabad,+Gujarat/@23.0201581,72.4149301,11z/data=!3m1!4b1!4m6!3m5!1s0x395e848aba5bd449:0x4fcedd11614f6516!8m2!3d23.022505!4d72.5713621!16zL20vMDFkODhj?entry=ttu&g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D"
                             target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-directions me-1"></i>Get Directions
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card service-card h-100 text-center">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5 class="fw-bold">Call Us</h5>
                        <p class="text-muted">Phone: +91 8511585803<br>WhatsApp: +91 8511585803</p>
                        <a href="tel:+918511585803" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-1"></i>Call Now
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card service-card h-100 text-center">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="fw-bold">Email Us</h5>
                        <p class="text-muted">info@momaievent.com<br>support@momaievent.com</p>
                        <a href="mailto:info@momaievent.com" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Send Email
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="row" id="contact-form">
            <div class="col-md-8">
                <div class="card animate-on-scroll">
                    <div class="card-header">
                        <h4><i class="fas fa-envelope me-2"></i>Send Us a Message</h4>
                    </div>
                    <div class="card-body">
                        <form action="inquiry.php" method="GET">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Type</label>
                                    <select class="form-select" name="event_type">
                                        <option value="">Select Event Type</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday">Birthday Party</option>
                                        <option value="Corporate">Corporate Event</option>
                                        <option value="Baby Shower">Baby Shower</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message *</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Tell us about your event requirements..." required></textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                                <a href="inquiry.php" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-edit me-2"></i>Detailed Inquiry
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4><i class="fas fa-map-marker-alt me-2"></i>Visit Our Office</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Main Office</h5>
                                <p>
                                    123 Event Street<br>
                                    City Center, State 12345<br>
                                    United States
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Business Hours</h5>
                                <p>
                                    Monday - Friday: 9:00 AM - 6:00 PM<br>
                                    Saturday: 10:00 AM - 4:00 PM<br>
                                    Sunday: By Appointment Only
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-phone me-2"></i>Contact Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <strong>Phone:</strong><br>
                            <a href="tel:+918511585803">+91 8511585803</a>
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <strong>Email:</strong><br>
                            <a href="mailto:info@momaievent.com">info@momaievent.com</a>
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>24/7 Emergency:</strong><br>
                            <a href="tel:+918511585803">+91 8511585803</a>
                        </div>

                        <!-- <hr> -->

                        <!-- <h5>Follow Us</h5>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div> -->
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4><i class="fas fa-star me-2"></i>Why Choose Us?</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>10+ Years Experience</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Professional Team</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>24/7 Support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Affordable Pricing</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Custom Solutions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main-theme.js"></script>
</body>
</html>