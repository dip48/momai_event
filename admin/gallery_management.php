<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_POST) {
    if (isset($_POST['add_gallery'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
            $category = isset($_POST['new_category']) && trim($_POST['new_category']) !== '' ? trim($_POST['new_category']) : $_POST['category'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = '../assets/gallery/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $file_extension;
            $image_path = 'assets/gallery/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $stmt = $pdo->prepare("INSERT INTO gallery (title, description, category, image_path, is_active, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$title, $description, $category, $image_path, $is_active]);
            }
        }
        header('Location: gallery_management.php');
        exit;
    }
    if (isset($_POST['update_gallery'])) {
        $id = $_POST['gallery_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $image_path = null;
        if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
            $upload_dir = '../assets/gallery/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_extension = pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $file_extension;
            $image_path = 'assets/gallery/' . $filename;
            if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $upload_dir . $filename)) {
                // Optionally delete old image
                $stmt_old = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
                $stmt_old->execute([$id]);
                $old = $stmt_old->fetch();
                if ($old && file_exists('../' . $old['image_path'])) {
                    unlink('../' . $old['image_path']);
                }
                $stmt = $pdo->prepare("UPDATE gallery SET title = ?, description = ?, category = ?, is_active = ?, image_path = ? WHERE id = ?");
                $stmt->execute([$title, $description, $category, $is_active, $image_path, $id]);
                header('Location: gallery_management.php');
                exit;
            }
        } else {
            $stmt = $pdo->prepare("UPDATE gallery SET title = ?, description = ?, category = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $description, $category, $is_active, $id]);
            header('Location: gallery_management.php');
            exit;
        }
    }
    if (isset($_POST['delete_gallery'])) {
        $id = $_POST['gallery_id'];
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        if ($image && file_exists('../' . $image['image_path'])) {
            unlink('../' . $image['image_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: gallery_management.php');
        exit;
    }
}

// Category filter logic
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
if ($selected_category && $selected_category !== 'all') {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY created_at DESC");
    $stmt->execute([$selected_category]);
    $gallery = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    $gallery = $stmt->fetchAll();
}

// Get gallery statistics
$total_gallery = $pdo->query("SELECT COUNT(*) as total_gallery FROM gallery")->fetch()['total_gallery'];
$active_gallery = $pdo->query("SELECT COUNT(*) as active_gallery FROM gallery WHERE is_active = 1")->fetch()['active_gallery'];
$categories = $pdo->query("SELECT category, COUNT(*) as count FROM gallery GROUP BY category")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gallery_management - Momai Event Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-gradient">
                        <i class="fas fa-images me-2"></i>gallery_management
                    </h1>
                    <div>
                        <a href="../gallery.php" target="_blank" class="btn btn-primary">
                            <i class="fas fa-globe"></i> Go to Public Gallery
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                            <i class="fas fa-plus me-2"></i>Add Image
                        </button>
                    </div>
                </div>
                    <!-- Category Filter Form -->
                    <form method="get" class="mb-4 px-3 d-flex align-items-center gap-2">
                        <label for="category" class="form-label mb-0"><strong>Filter by Category:</strong></label>
                        <select name="category" id="category" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="all" <?php echo ($selected_category === 'all' || $selected_category === '') ? 'selected' : ''; ?>>All Events</option>
                            <?php
                            $all_categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != ''")->fetchAll();
                            foreach ($all_categories as $cat_row) {
                                $cat = $cat_row['category'];
                                echo '<option value="'.htmlspecialchars($cat).'"'.($selected_category === $cat ? ' selected' : '').'>'.htmlspecialchars($cat).'</option>';
                            }
                            ?>
                        </select>
                    </form>
                <!-- Gallery Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Total Images</h5>
                                        <h2 class="stat-number"><?php echo $total_gallery; ?></h2>
                                        <p class="stat-subtitle">All gallery images</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Active Images</h5>
                                        <h2 class="stat-number"><?php echo $active_gallery; ?></h2>
                                        <p class="stat-subtitle">Currently visible</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: <?php echo $total_gallery > 0 ? ($active_gallery / $total_gallery) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Categories</h5>
                                        <h2 class="stat-number"><?php echo count($categories); ?></h2>
                                        <p class="stat-subtitle">Different types</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Gallery Grid -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-th me-2"></i>Gallery Images
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($gallery as $image): ?>
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card decoration-card h-100">
                                    <div class="decoration-image-container">
                                        <?php if ($image['image_path'] && file_exists('../' . $image['image_path'])): ?>
                                            <img src="../<?php echo $image['image_path']; ?>" class="card-img-top decoration-image" alt="<?php echo htmlspecialchars($image['title']); ?>">
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
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $image['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $image['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo htmlspecialchars($image['title']); ?></h6>
                                        <p class="card-text text-muted small"><?php echo htmlspecialchars(substr($image['description'], 0, 80)) . '...'; ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-info"><?php echo htmlspecialchars($image['category']); ?></span>
                                            <?php if ($image['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Add Gallery Modal -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Add New Gallery Image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">Select Category</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Baby Shower">Baby Shower</option>
                                <option value="Anniversary">Anniversary</option>
                                <option value="Other">Other</option>
                            </select>
                                <input type="text" class="form-control mt-2" name="new_category" id="new-category" placeholder="Or add new category">
                                <small class="text-muted">Select an existing category or enter a new one.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_gallery" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Add Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- View/Edit/Delete Modals for each gallery image -->
    <?php foreach ($gallery as $image): ?>
    <!-- View Modal -->
    <div class="modal fade" id="viewModal<?php echo $image['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i><?php echo htmlspecialchars($image['title']); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <?php if ($image['image_path'] && file_exists('../' . $image['image_path'])): ?>
                        <img src="../<?php echo $image['image_path']; ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($image['title']); ?>">
                    <?php endif; ?>
                    <h5><?php echo htmlspecialchars($image['title']); ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($image['description']); ?></p>
                    <span class="badge bg-info"><?php echo htmlspecialchars($image['category']); ?></span>
                    <?php if ($image['is_active']): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactive</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal<?php echo $image['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Gallery Image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gallery_id" value="<?php echo $image['id']; ?>">
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($image['title']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select mb-2" name="category" required>
                                        <?php
                                        $all_categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != ''")->fetchAll();
                                        foreach ($all_categories as $cat_row) {
                                            $cat = $cat_row['category'];
                                            echo '<option value="'.htmlspecialchars($cat).'"'.($image['category'] == $cat ? ' selected' : '').'>'.htmlspecialchars($cat).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" <?php echo $image['is_active'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($image['description']); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Change Image</label>
                                    <input type="file" class="form-control" name="edit_image" accept="image/*">
                                    <?php if ($image['image_path'] && file_exists('../' . $image['image_path'])): ?>
                                        <img src="../<?php echo $image['image_path']; ?>" class="img-fluid mt-2 rounded border" style="max-height:140px;" alt="Current Image">
                                    <?php endif; ?>
                                    <small class="text-muted">Upload a new image to replace the current one.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_gallery" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?php echo $image['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-trash me-2"></i>Delete Gallery Image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete "<strong><?php echo htmlspecialchars($image['title']); ?></strong>"?</p>
                    <p class="text-danger"><small>This action cannot be undone and will also delete the image file.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="gallery_id" value="<?php echo $image['id']; ?>">
                        <button type="submit" name="delete_gallery" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin-theme.js"></script>
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
</body>
</html>
