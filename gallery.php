<?php
require_once 'config/database.php';

// Get gallery images
$stmt = $pdo->query("SELECT * FROM gallery WHERE is_active = 1 ORDER BY is_featured DESC, created_at DESC");
$gallery_images = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Momai Event | Elegant Wedding & Event Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/main-theme.css" rel="stylesheet">

</head>
<style>
    .decoration-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .decoration-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .decoration-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .decoration-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .decoration-card:hover .decoration-image {
        transform: scale(1.1);
    }
    .decoration-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-secondary);
    }
    .decoration-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .decoration-card:hover .decoration-overlay {
        opacity: 1;
    }
    .decoration-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>
<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section-small hero-gallery">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title elegant-serif">Our Elegant Gallery</h1>
                <p class="hero-subtitle elegant-script">Discover our portfolio of timeless celebrations and sophisticated designs</p>
                <div class="hero-buttons">
                    <a href="#gallery-grid" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-images me-2"></i>View Gallery
                    </a>
                    <a href="inquiry.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Get inquiry
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
     <!-- Gallery Filter Buttons -->
        <div class="gallery-filter-buttons mb-4">
            <div class="d-flex flex-wrap gap-2" role="group" aria-label="Gallery categories">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">
                    <i class="fas fa-th me-2"></i>All Events
                </button>
                <?php
                $categories = array_unique(array_filter(array_map(function($img) { return $img['category']; }, $gallery_images)));
                foreach ($categories as $cat) {
                    $icon = 'fa-star';
                    if (stripos($cat, 'wedding') !== false) $icon = 'fa-heart';
                    elseif (stripos($cat, 'event') !== false) $icon = 'fa-calendar';
                    elseif (stripos($cat, 'celebration') !== false) $icon = 'fa-star';
                    elseif (stripos($cat, 'party') !== false) $icon = 'fa-birthday-cake';
                    elseif (stripos($cat, 'luxury') !== false) $icon = 'fa-gem';
                    elseif (stripos($cat, 'corporate') !== false) $icon = 'fa-briefcase';
                    elseif (stripos($cat, 'anniversary') !== false) $icon = 'fa-heart';
                    elseif (stripos($cat, 'baby') !== false) $icon = 'fa-baby';
                    echo '<button type="button" class="btn btn-outline-primary" style="min-width:140px;" data-filter="'.strtolower(str_replace(' ', '-', $cat)).'">
                        <i class="fas '.$icon.' me-2"></i>'.htmlspecialchars($cat).'
                    </button>';
                }
                ?>
            </div>
        </div>
        <!-- Gallery Grid -->
        <div class="row" id="gallery-grid">
            <?php if (!empty($gallery_images)): ?>
                <?php foreach ($gallery_images as $image): ?>
                <div class="col-md-4 col-lg-3 mb-4 gallery-item animate-on-scroll" data-category="<?php echo strtolower(str_replace(' ', '-', $image['category'])); ?>">
                    <div class="card decoration-card h-100">
                        <div class="decoration-image-container">
                            <?php if ($image['image_path'] && file_exists($image['image_path'])): ?>
                                <img src="<?php echo $image['image_path']; ?>" class="card-img-top decoration-image" alt="<?php echo htmlspecialchars($image['title']); ?>">
                            <?php else: ?>
                                <div class="decoration-placeholder">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="decoration-overlay">
                                <div class="decoration-actions">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $image['id']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo htmlspecialchars($image['title']); ?></h6>
                            <p class="card-text text-muted small"><?php echo htmlspecialchars(substr($image['description'], 0, 80)) . '...'; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-info"><?php echo htmlspecialchars($image['category']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- View Modal -->
                <div class="modal fade" id="viewModal<?php echo $image['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-eye me-2"></i><?php echo htmlspecialchars($image['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <?php if ($image['image_path'] && file_exists($image['image_path'])): ?>
                                    <img src="<?php echo $image['image_path']; ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($image['title']); ?>">
                                <?php endif; ?>
                                <h5><?php echo htmlspecialchars($image['title']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($image['description']); ?></p>
                                <span class="badge bg-info"><?php echo htmlspecialchars($image['category']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-images fa-2x mb-3"></i><br>
                    No images found in the gallery.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main-theme.js"></script>
    <script>
        // Enhanced Gallery Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Gallery filter functionality
            const filterButtons = document.querySelectorAll('[data-filter]');
            const galleryItems = document.querySelectorAll('.gallery-item');

            // Initialize gallery items animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, observerOptions);

            galleryItems.forEach(item => {
                observer.observe(item);
            });

            // Filter functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');

                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Filter items with animation
                    galleryItems.forEach(item => {
                        const category = item.getAttribute('data-category');

                        if (filter === 'all' || category === filter) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.classList.add('show');
                            }, 100);
                        } else {
                            item.classList.remove('show');
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Smooth scroll for gallery view button
            document.querySelector('a[href="#gallery-grid"]')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('gallery-grid').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            // Enhanced modal functionality
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const img = this.querySelector('img');
                    if (img) {
                        img.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            img.style.transform = 'scale(1)';
                        }, 300);
                    }
                });
            });

            // Lazy loading for images
            const images = document.querySelectorAll('img[loading="lazy"]');
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src; // Trigger loading
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });

            // Gallery card hover effects
            const galleryCards = document.querySelectorAll('.gallery-card');
            galleryCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add loading animation
            const galleryGrid = document.getElementById('gallery-grid');
            if (galleryGrid && galleryItems.length === 0) {
                galleryGrid.innerHTML = `
                    <div class="col-12 gallery-loading">
                        <div class="loading-spinner"></div>
                        <h5>Loading Gallery...</h5>
                        <p class="text-muted">Please wait while we load our beautiful event gallery.</p>
                    </div>
                `;
            }

            // Keyboard navigation for gallery
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openModal = document.querySelector('.modal.show');
                    if (openModal) {
                        const modal = bootstrap.Modal.getInstance(openModal);
                        modal.hide();
                    }
                }
            });
        });

        // Gallery statistics counter
        function updateGalleryStats() {
            const totalItems = document.querySelectorAll('.gallery-item').length;
            const visibleItems = document.querySelectorAll('.gallery-item[style*="block"], .gallery-item:not([style*="none"])').length;

            console.log(`Gallery: ${visibleItems} of ${totalItems} items visible`);
        }

        // Call stats update on filter change
        document.querySelectorAll('[data-filter]').forEach(button => {
            button.addEventListener('click', () => {
                setTimeout(updateGalleryStats, 500);
            });
        });
    </script>
</body>
</html>