<?php
$page_title = "Homepage Settings - Admin Panel";
include_once __DIR__ . '/../includes/header.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login/login.php?message=Access Denied');
    exit;
}

// --- Handle Form Submissions ---
$hero_message = $brand_message = $review_message = '';

// Save Hero Section (with file upload)
if (isset($_POST['hero_title'])) {
    $title = trim($_POST['hero_title']);
    $subtitle = trim($_POST['hero_subtitle']);
    $button_text = trim($_POST['hero_button_text']);
    $button_link = trim($_POST['hero_button_link']);
    $image_url = '';
    // Handle file upload
    if (isset($_FILES['hero_image_file']) && $_FILES['hero_image_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['hero_image_file']['tmp_name'];
        $file_name = basename($_FILES['hero_image_file']['name']);
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp','svg'];
        if (in_array($ext, $allowed)) {
            $new_name = 'hero_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $target_dir = __DIR__ . '/../asset/images/upload/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $target_file = $target_dir . $new_name;
            if (move_uploaded_file($file_tmp, $target_file)) {
                $image_url = 'asset/images/upload/' . $new_name;
            }
        }
    } else {
        // If no new file uploaded, keep the old image
        $image_url = $hero['image_url'] ?? '';
    }
    // Upsert (insert or update)
    $stmt = $conn->prepare("REPLACE INTO homepage_hero (id, title, subtitle, button_text, button_link, image_url) VALUES (1,?,?,?,?,?)");
    $stmt->bind_param('sssss', $title, $subtitle, $button_text, $button_link, $image_url);
    if ($stmt->execute()) {
        $hero_message = '<div class="alert alert-success">Hero section updated.</div>';
    } else {
        $hero_message = '<div class="alert alert-danger">Failed to update hero section.</div>';
    }
    $stmt->close();
}

// Add Brand Logo (with file upload)
if (isset($_POST['brand_logo_url']) || isset($_FILES['brand_logo_file'])) {
    $logo_url = trim($_POST['brand_logo_url'] ?? '');
    $alt_text = trim($_POST['brand_alt_text'] ?? '');
    $upload_path = '';
    if (isset($_FILES['brand_logo_file']) && $_FILES['brand_logo_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['brand_logo_file']['tmp_name'];
        $file_name = basename($_FILES['brand_logo_file']['name']);
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp','svg'];
        if (in_array($ext, $allowed)) {
            $new_name = 'brand_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $target_dir = __DIR__ . '/../asset/images/upload/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $target_file = $target_dir . $new_name;
            if (move_uploaded_file($file_tmp, $target_file)) {
                $upload_path = 'asset/images/upload/' . $new_name;
            }
        }
    }
    $final_logo = $upload_path ?: $logo_url;
    if ($final_logo) {
        $stmt = $conn->prepare("INSERT INTO homepage_brands (logo_url, alt_text) VALUES (?, ?)");
        $stmt->bind_param('ss', $final_logo, $alt_text);
        if ($stmt->execute()) {
            $brand_message = '<div class="alert alert-success">Brand logo added.</div>';
        } else {
            $brand_message = '<div class="alert alert-danger">Failed to add brand logo.</div>';
        }
        $stmt->close();
    }
}
// Delete Brand Logo
if (isset($_GET['delete_brand'])) {
    $id = intval($_GET['delete_brand']);
    $conn->query("DELETE FROM homepage_brands WHERE id=$id");
    header('Location: homepage_settings.php');
    exit;
}

// Add Review
if (isset($_POST['reviewer_name'])) {
    $name = trim($_POST['reviewer_name']);
    $avatar = trim($_POST['reviewer_avatar_url']);
    $text = trim($_POST['review_text']);
    $rating = intval($_POST['review_rating']);
    if ($name && $text && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO homepage_reviews (reviewer_name, avatar_url, review_text, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $name, $avatar, $text, $rating);
        if ($stmt->execute()) {
            $review_message = '<div class="alert alert-success">Review added.</div>';
        } else {
            $review_message = '<div class="alert alert-danger">Failed to add review.</div>';
        }
        $stmt->close();
    }
}
// Delete Review
if (isset($_GET['delete_review'])) {
    $id = intval($_GET['delete_review']);
    $conn->query("DELETE FROM homepage_reviews WHERE id=$id");
    header('Location: homepage_settings.php');
    exit;
}

// Handle Edit Brand (with file upload)
if (isset($_POST['edit_brand_id'])) {
    $edit_id = intval($_POST['edit_brand_id']);
    $edit_logo_url = trim($_POST['edit_brand_logo_url'] ?? '');
    $edit_alt_text = trim($_POST['edit_brand_alt_text'] ?? '');
    $upload_path = '';
    if (isset($_FILES['edit_brand_logo_file']) && $_FILES['edit_brand_logo_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['edit_brand_logo_file']['tmp_name'];
        $file_name = basename($_FILES['edit_brand_logo_file']['name']);
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp','svg'];
        if (in_array($ext, $allowed)) {
            $new_name = 'brand_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $target_dir = __DIR__ . '/../asset/images/upload/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $target_file = $target_dir . $new_name;
            if (move_uploaded_file($file_tmp, $target_file)) {
                $upload_path = 'asset/images/upload/' . $new_name;
            }
        }
    }
    $final_logo = $upload_path ?: $edit_logo_url;
    $stmt = $conn->prepare("UPDATE homepage_brands SET logo_url=?, alt_text=? WHERE id=?");
    $stmt->bind_param('ssi', $final_logo, $edit_alt_text, $edit_id);
    if ($stmt->execute()) {
        $brand_message = '<div class="alert alert-success">Brand updated.</div>';
    } else {
        $brand_message = '<div class="alert alert-danger">Failed to update brand.</div>';
    }
    $stmt->close();
}
// Handle Edit Review
if (isset($_POST['edit_review_id'])) {
    $edit_id = intval($_POST['edit_review_id']);
    $edit_name = trim($_POST['edit_reviewer_name']);
    $edit_avatar = trim($_POST['edit_reviewer_avatar_url']);
    $edit_text = trim($_POST['edit_review_text']);
    $edit_rating = intval($_POST['edit_review_rating']);
    $stmt = $conn->prepare("UPDATE homepage_reviews SET reviewer_name=?, avatar_url=?, review_text=?, rating=? WHERE id=?");
    $stmt->bind_param('sssii', $edit_name, $edit_avatar, $edit_text, $edit_rating, $edit_id);
    if ($stmt->execute()) {
        $review_message = '<div class="alert alert-success">Review updated.</div>';
    } else {
        $review_message = '<div class="alert alert-danger">Failed to update review.</div>';
    }
    $stmt->close();
}

// --- Fetch Current Data ---
// Hero
$hero = ["title"=>"","subtitle"=>"","button_text"=>"","button_link"=>"","image_url"=>""];
$res = $conn->query("SELECT * FROM homepage_hero WHERE id=1");
if ($row = $res->fetch_assoc()) $hero = $row;
// Brands
$brands = [];
$res = $conn->query("SELECT * FROM homepage_brands ORDER BY id DESC");
while ($row = $res->fetch_assoc()) $brands[] = $row;
// Reviews
$reviews = [];
$res = $conn->query("SELECT * FROM homepage_reviews ORDER BY id DESC");
while ($row = $res->fetch_assoc()) $reviews[] = $row;

// Get edit mode IDs from GET
$edit_brand_id = isset($_GET['edit_brand']) ? intval($_GET['edit_brand']) : 0;
$edit_review_id = isset($_GET['edit_review']) ? intval($_GET['edit_review']) : 0;
?>
<div class="d-flex flex-column flex-lg-row">
    <nav class="nav flex-column nav-pills bg-light p-3 mb-3 mb-lg-0 me-lg-3 rounded" style="min-width: 220px;">
        <a class="nav-link" href="index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a class="nav-link" href="products.php"><i class="bi bi-box-seam me-2"></i>Manage Products</a>
        <a class="nav-link" href="categories.php"><i class="bi bi-tags me-2"></i>Manage Categories</a>
        <a class="nav-link" href="orders.php"><i class="bi bi-receipt me-2"></i>Manage Orders</a>
        <a class="nav-link" href="users.php"><i class="bi bi-people me-2"></i>Manage Users</a>
        <a class="nav-link active" href="homepage_settings.php"><i class="bi bi-house me-2"></i>Homepage Settings</a>
        <a class="nav-link" href="settings.php"><i class="bi bi-gear me-2"></i>Site Settings</a>
        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>
    <div class="flex-grow-1">
        <h1>Homepage Settings</h1>
        <hr>
        <h3>Hero Section</h3>
        <?php echo $hero_message; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="hero_title" value="<?php echo htmlspecialchars($hero['title']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" class="form-control" name="hero_subtitle" value="<?php echo htmlspecialchars($hero['subtitle']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Button Text</label>
                <input type="text" class="form-control" name="hero_button_text" value="<?php echo htmlspecialchars($hero['button_text']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Button Link</label>
                <input type="text" class="form-control" name="hero_button_link" value="<?php echo htmlspecialchars($hero['button_link']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Hero Image (Upload)</label>
                <input type="file" class="form-control" name="hero_image_file" accept="image/*">
                <?php if (!empty($hero['image_url'])): ?>
                    <div class="mt-2"><img src="../<?php echo htmlspecialchars($hero['image_url']); ?>" alt="Hero Image" style="max-width:220px;max-height:120px;"></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save Hero Section</button>
        </form>
        <hr>
        <h3>Brand Logos</h3>
        <?php echo $brand_message; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Brand Logo Image (Upload)</label>
                <input type="file" class="form-control" name="brand_logo_file" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Or Brand Logo URL</label>
                <input type="text" class="form-control" name="brand_logo_url" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">Alt Text</label>
                <input type="text" class="form-control" name="brand_alt_text" value="">
            </div>
            <button type="submit" class="btn btn-secondary">Add Brand Logo</button>
        </form>
        <div class="mt-3">
            <h5>Existing Brands</h5>
            <ul class="list-group">
                <?php foreach ($brands as $b): ?>
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <?php if ($edit_brand_id === intval($b['id'])): ?>
                            <form method="post" enctype="multipart/form-data" class="d-flex flex-grow-1 align-items-center gap-2">
                                <input type="hidden" name="edit_brand_id" value="<?php echo $b['id']; ?>">
                                <input type="file" name="edit_brand_logo_file" class="form-control" accept="image/*" style="max-width:160px;">
                                <input type="text" name="edit_brand_logo_url" class="form-control" value="<?php echo htmlspecialchars($b['logo_url']); ?>" placeholder="Logo URL" style="max-width:220px;">
                                <input type="text" name="edit_brand_alt_text" class="form-control" value="<?php echo htmlspecialchars($b['alt_text']); ?>" placeholder="Alt Text" required style="max-width:160px;">
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check"></i></button>
                                <a href="homepage_settings.php" class="btn btn-secondary btn-sm"><i class="bi bi-x"></i></a>
                            </form>
                        <?php else: ?>
                            <span><img src="<?php echo htmlspecialchars($b['logo_url']); ?>" alt="<?php echo htmlspecialchars($b['alt_text']); ?>" style="height:32px;max-width:80px;object-fit:contain;"> <?php echo htmlspecialchars($b['alt_text']); ?></span>
                            <span>
                                <a href="?edit_brand=<?php echo $b['id']; ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                                <a href="?delete_brand=<?php echo $b['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this brand?');"><i class="bi bi-trash"></i></a>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <hr>
        <h3>Reviews</h3>
        <?php echo $review_message; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Reviewer Name</label>
                <input type="text" class="form-control" name="reviewer_name" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">Avatar URL</label>
                <input type="text" class="form-control" name="reviewer_avatar_url" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">Review Text</label>
                <textarea class="form-control" name="review_text"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating (1-5)</label>
                <input type="number" class="form-control" name="review_rating" min="1" max="5" value="5">
            </div>
            <button type="submit" class="btn btn-secondary">Add Review</button>
        </form>
        <div class="mt-3">
            <h5>Existing Reviews</h5>
            <ul class="list-group">
                <?php foreach ($reviews as $r): ?>
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <?php if ($edit_review_id === intval($r['id'])): ?>
                            <form method="post" class="d-flex flex-grow-1 align-items-center gap-2">
                                <input type="hidden" name="edit_review_id" value="<?php echo $r['id']; ?>">
                                <input type="text" name="edit_reviewer_name" class="form-control" value="<?php echo htmlspecialchars($r['reviewer_name']); ?>" placeholder="Name" required style="max-width:140px;">
                                <input type="text" name="edit_reviewer_avatar_url" class="form-control" value="<?php echo htmlspecialchars($r['avatar_url']); ?>" placeholder="Avatar URL" style="max-width:180px;">
                                <input type="number" name="edit_review_rating" class="form-control" value="<?php echo intval($r['rating']); ?>" min="1" max="5" required style="max-width:60px;">
                                <input type="text" name="edit_review_text" class="form-control" value="<?php echo htmlspecialchars($r['review_text']); ?>" placeholder="Review" required style="max-width:260px;">
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check"></i></button>
                                <a href="homepage_settings.php" class="btn btn-secondary btn-sm"><i class="bi bi-x"></i></a>
                            </form>
                        <?php else: ?>
                            <span>
                                <?php if ($r['avatar_url']): ?><img src="<?php echo htmlspecialchars($r['avatar_url']); ?>" alt="avatar" style="height:32px;width:32px;object-fit:cover;border-radius:50%;margin-right:8px;"> <?php endif; ?>
                                <strong><?php echo htmlspecialchars($r['reviewer_name']); ?></strong> (<?php echo intval($r['rating']); ?>/5): <?php echo htmlspecialchars($r['review_text']); ?>
                            </span>
                            <span>
                                <a href="?edit_review=<?php echo $r['id']; ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                                <a href="?delete_review=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this review?');"><i class="bi bi-trash"></i></a>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
