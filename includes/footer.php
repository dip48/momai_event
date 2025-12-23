<?php
// Get current page for footer links
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$base_path = '';
if ($current_dir === 'user' || $current_dir === 'admin') {
    $base_path = '../';
}
?>

<footer class="py-5 mt-5" style="background: linear-gradient(135deg, var(--bg-dark), var(--secondary-color)); color: var(--text-white);">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-gradient fw-bold elegant-serif">
                    <i class="fas fa-gem me-2"></i>Momai Event
                </h5>
                <p class="text-light opacity-75">Creating timeless elegance for your most cherished moments with sophisticated event design and impeccable service.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light opacity-75 hover-primary">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 hover-primary">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 hover-primary">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 hover-primary">
                        <i class="fab fa-whatsapp fa-lg"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>index.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>about.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>services.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>Services
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>gallery.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>Gallery
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>contact.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>Contact
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo $base_path; ?>inquiry.php" class="text-light opacity-75 text-decoration-none hover-primary">
                            <i class="fas fa-chevron-right me-2"></i>Get Quote
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Contact Info</h5>
                <div class="mb-3">
                    <i class="fas fa-phone text-primary me-2"></i>
                    <a href="tel:+918511585803" class="text-light opacity-75 text-decoration-none hover-primary">
                        +91 8511585803
                    </a>
                </div>
                <div class="mb-3">
                    <i class="fas fa-envelope text-primary me-2"></i>
                    <a href="mailto:info@momaievent.com" class="text-light opacity-75 text-decoration-none hover-primary">
                        info@momaievent.com
                    </a>
                </div>
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                    <span class="text-light opacity-75">123 Event Street, City Center</span>
                </div>
                <div class="mb-3">
                    <i class="fas fa-clock text-primary me-2"></i>
                    <span class="text-light opacity-75">Mon-Fri: 9AM-6PM</span>
                </div>
            </div>
        </div>
        <hr class="my-4 opacity-25">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-light opacity-75">
                    &copy; 2024 Momai Event. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-light opacity-75 elegant-script">
                    Crafted with <i class="fas fa-heart" style="color: var(--rose-gold);"></i> for your most precious moments
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
.hover-primary:hover {
    color: var(--primary-color) !important;
    transition: color 0.3s ease;
}
</style>