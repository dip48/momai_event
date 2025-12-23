<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_POST) {
    if (isset($_POST['add_decoration'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        
        // Handle file upload
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = '../assets/decorations/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $file_extension;
            $image_path = 'assets/decorations/' . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $stmt = $pdo->prepare("INSERT INTO decorations (title, description, category, image_path, is_active) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$title, $description, $category, $image_path]);
            }
        }
        
        header('Location: decorations.php');
        exit;
    }
    
    if (isset($_POST['update_decoration'])) {
        $id = $_POST['decoration_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $stmt = $pdo->prepare("UPDATE decorations SET title = ?, description = ?, category = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$title, $description, $category, $is_active, $id]);
        
        header('Location: decorations.php');
        exit;
    }
    
    if (isset($_POST['delete_decoration'])) {
        $id = $_POST['decoration_id'];
        
        // Get image path to delete file
        $stmt = $pdo->prepare("SELECT image_path FROM decorations WHERE id = ?");
        $stmt->execute([$id]);
        $decoration = $stmt->fetch();
        
        if ($decoration && file_exists('../' . $decoration['image_path'])) {
            unlink('../' . $decoration['image_path']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM decorations WHERE id = ?");
        $stmt->execute([$id]);
        
        header('Location: decorations.php');
        exit;
    }
}

// Get all decorations
$stmt = $pdo->query("SELECT * FROM decorations ORDER BY created_at DESC");
$decorations = $stmt->fetchAll();

// Get decoration statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_decorations FROM decorations");
$total_decorations = $stmt->fetch()['total_decorations'];

$stmt = $pdo->query("SELECT COUNT(*) as active_decorations FROM decorations WHERE is_active = 1");
$active_decorations = $stmt->fetch()['active_decorations'];

$stmt = $pdo->query("SELECT category, COUNT(*) as count FROM decorations GROUP BY category");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decoration Images - Momai Event Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                        <i class="fas fa-palette me-2"></i>Decoration Images
                    </h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDecorationModal">
                        <i class="fas fa-plus me-2"></i>Add Decoration
                    </button>
                </div>

                <!-- Decoration Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stat-content">
                                        <h5 class="stat-title">Total Images</h5>
                                        <h2 class="stat-number"><?php echo $total_decorations; ?></h2>
                                        <p class="stat-subtitle">All decorations</p>
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
                                        <h2 class="stat-number"><?php echo $active_decorations; ?></h2>
                                        <p class="stat-subtitle">Currently visible</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar" style="width: <?php echo $total_decorations > 0 ? ($active_decorations / $total_decorations) * 100 : 0; ?>%"></div>
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

                <!-- Decorations Grid -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-th me-2"></i>Decoration Gallery
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($decorations as $decoration): ?>
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card decoration-card h-100">
                                    <div class="decoration-image-container">
                                        <?php if ($decoration['image_path'] && file_exists('../' . $decoration['image_path'])): ?>
                                            <img src="../<?php echo $decoration['image_path']; ?>" class="card-img-top decoration-image" alt="<?php echo htmlspecialchars($decoration['title']); ?>">
                                        <?php else: ?>
                                            <div class="decoration-placeholder">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="decoration-overlay">
                                            <div class="decoration-actions">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $decoration['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $decoration['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $decoration['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo htmlspecialchars($decoration['title']); ?></h6>
                                        <p class="card-text text-muted small"><?php echo htmlspecialchars(substr($decoration['description'], 0, 80)) . '...'; ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-info"><?php echo htmlspecialchars($decoration['category']); ?></span>
                                            <?php if ($decoration['is_active']): ?>
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

    <!-- Add Decoration Modal -->
    <div class="modal fade" id="addDecorationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Add New Decoration
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
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Baby Shower">Baby Shower</option>
                                <option value="Anniversary">Anniversary</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_decoration" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Add Decoration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View/Edit/Delete Modals for each decoration -->
    <?php foreach ($decorations as $decoration): ?>
    <!-- View Modal -->
    <div class="modal fade" id="viewModal<?php echo $decoration['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i><?php echo htmlspecialchars($decoration['title']); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <?php if ($decoration['image_path'] && file_exists('../' . $decoration['image_path'])): ?>
                        <img src="../<?php echo $decoration['image_path']; ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($decoration['title']); ?>">
                    <?php endif; ?>
                    <h5><?php echo htmlspecialchars($decoration['title']); ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($decoration['description']); ?></p>
                    <span class="badge bg-info"><?php echo htmlspecialchars($decoration['category']); ?></span>
                    <?php if ($decoration['is_active']): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactive</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal<?php echo $decoration['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Decoration
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="decoration_id" value="<?php echo $decoration['id']; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($decoration['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($decoration['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="Wedding" <?php echo $decoration['category'] == 'Wedding' ? 'selected' : ''; ?>>Wedding</option>
                                <option value="Birthday" <?php echo $decoration['category'] == 'Birthday' ? 'selected' : ''; ?>>Birthday</option>
                                <option value="Corporate" <?php echo $decoration['category'] == 'Corporate' ? 'selected' : ''; ?>>Corporate</option>
                                <option value="Baby Shower" <?php echo $decoration['category'] == 'Baby Shower' ? 'selected' : ''; ?>>Baby Shower</option>
                                <option value="Anniversary" <?php echo $decoration['category'] == 'Anniversary' ? 'selected' : ''; ?>>Anniversary</option>
                                <option value="Other" <?php echo $decoration['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" <?php echo $decoration['is_active'] ? 'checked' : ''; ?>>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_decoration" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?php echo $decoration['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-trash me-2"></i>Delete Decoration
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete "<strong><?php echo htmlspecialchars($decoration['title']); ?></strong>"?</p>
                    <p class="text-danger"><small>This action cannot be undone and will also delete the image file.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="decoration_id" value="<?php echo $decoration['id']; ?>">
                        <button type="submit" name="delete_decoration" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin-theme.js"></script>

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
