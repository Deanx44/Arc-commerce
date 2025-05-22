<?php
$page_title = "Site Settings - Admin Panel";
include_once __DIR__ . '/../includes/header.php';

// Admin access check
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login/login.php?message=Access Denied');
    exit;
}

// Placeholder for Site Settings content
?>

<div class="d-flex flex-column flex-lg-row">
    <nav class="nav flex-column nav-pills bg-light p-3 mb-3 mb-lg-0 me-lg-3 rounded" style="min-width: 220px;">
        <a class="nav-link active" href="index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a class="nav-link" href="products.php"><i class="bi bi-box-seam me-2"></i>Manage Products</a>
        <a class="nav-link" href="categories.php"><i class="bi bi-tags me-2"></i>Manage Categories</a>
        <a class="nav-link" href="orders.php"><i class="bi bi-receipt me-2"></i>Manage Orders</a>
        <a class="nav-link" href="users.php"><i class="bi bi-people me-2"></i>Manage Users</a>
        <a class="nav-link" href="homepage_settings.php"><i class="bi bi-people me-2"></i>Homepage Settings</a>
        <a class="nav-link" href="settings.php"><i class="bi bi-gear me-2"></i>Site Settings</a>
        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>

    <div class="flex-grow-1">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        <p class="lead">Site settings and configuration options will be managed here.</p>
        <!-- Content for managing site settings -->
        <div class="alert alert-info">This page is a placeholder for Site Settings.</div>
    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 