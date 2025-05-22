<?php
$page_title = "Admin Dashboard - 2nd Phone Shop";
// This file is in the 'admin' subdirectory, so paths to includes need to be adjusted.
include_once __DIR__ . '/../includes/header.php';

// Ensure user is logged in AND is an admin
if (!isLoggedIn()) {
    header('Location: ../login/login.php?message=Please login to access the admin panel.');
    exit;
}
if (!isAdmin()) {
    // Optional: Redirect to a generic "access denied" page or user dashboard
    header('Location: ../user/dashboard.php?message=Access Denied: You do not have admin privileges.');
    // Or simply: echo "<p>Access Denied. You do not have admin privileges.</p>"; include_once __DIR__ . '/../includes/footer.php';
    exit;
}

$admin_first_name = isset($_SESSION['user_first_name']) ? htmlspecialchars($_SESSION['user_first_name']) : 'Admin';

// Placeholder: Fetch some basic stats for the dashboard
// $total_users = $conn->query("SELECT COUNT(*) as count FROM user")->fetch_assoc()['count'];
// $total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
// $total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
// $pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 'Processing'")->fetch_assoc()['count'];

$total_users = 150; // Mock data
$total_products = 75; // Mock data
$total_orders = 300; // Mock data
$pending_orders = 12; // Mock data
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
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $admin_first_name; ?>! Manage your shop from here.</p>
        <hr>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Total Users</h5>
                        <p class="card-text fs-4"><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-box-seam me-2"></i>Total Products</h5>
                        <p class="card-text fs-4"><?php echo $total_products; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-receipt me-2"></i>Total Orders</h5>
                        <p class="card-text fs-4"><?php echo $total_orders; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-hourglass-split me-2"></i>Pending Orders</h5>
                        <p class="card-text fs-4"><?php echo $pending_orders; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h2>Quick Actions</h2>
        <p>
            <a href="products.php?action=add" class="btn btn-success me-2"><i class="bi bi-plus-circle"></i> Add New Product</a>
            <a href="orders.php?filter=pending" class="btn btn-warning me-2"><i class="bi bi-eye"></i> View Pending Orders</a>
            <?php // Add more quick action links as needed ?>
        </p>

        <?php // Placeholder for more dashboard widgets like recent orders, charts, etc. ?>
        <p class="mt-4"><em class="text-muted">More dashboard widgets like recent activity or charts will appear here.</em></p>

    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 