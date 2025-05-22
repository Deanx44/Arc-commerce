<?php
$page_title = "My Dashboard - 2nd Phone Shop";
// This file is in the 'user' subdirectory, so paths to includes need to be adjusted.
include_once __DIR__ . '/../includes/header.php';

// Ensure user is logged in, otherwise redirect to login page
if (!isLoggedIn()) {
    header('Location: ../login/login.php?message=Please login to access your dashboard.');
    exit;
}

// Get user's first name from session to personalize the welcome message
$user_first_name = isset($_SESSION['user_first_name']) ? htmlspecialchars($_SESSION['user_first_name']) : 'User';

// Placeholder for dashboard content sections (e.g., recent orders, profile summary)
$active_section = isset($_GET['page']) ? $_GET['page'] : 'overview';
?>

<div class="d-flex flex-column flex-lg-row">
    <nav class="nav flex-column nav-pills bg-light p-3 mb-3 mb-lg-0 me-lg-3 rounded" style="min-width: 220px;">
        <a class="nav-link <?php if ($active_section === 'overview') echo 'active'; ?>" href="dashboard.php?page=overview"><i class="bi bi-person-circle me-2"></i>Dashboard Overview</a>
        <a class="nav-link <?php if ($active_section === 'orders') echo 'active'; ?>" href="orders.php"><i class="bi bi-box-seam me-2"></i>My Orders</a>
        <a class="nav-link <?php if ($active_section === 'profile') echo 'active'; ?>" href="profile.php"><i class="bi bi-person-badge me-2"></i>My Profile</a>
        <a class="nav-link <?php if ($active_section === 'settings') echo 'active'; ?>" href="profile.php?section=settings"><i class="bi bi-gear me-2"></i>Account Settings</a>
        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>

    <div class="flex-grow-1">
        <h1>Welcome, <?php echo $user_first_name; ?>!</h1>
        <p>This is your dashboard. From here you can manage your orders, profile, and account settings.</p>
        <hr>

        <?php
        // Basic content switching based on $active_section
        // More sophisticated routing or includes can be used for larger sections
        switch ($active_section) {
            case 'orders':
                echo "<h2>My Orders</h2><p>Order history will be displayed here. (Content from orders.php will be integrated or shown here)</p>";
                // Typically, you might include a file here like: include_once '_dashboard_orders.php';
                break;
            case 'profile':
            case 'settings':
                echo "<h2>My Profile / Settings</h2><p>Profile and account settings form will be displayed here. (Content from profile.php will be integrated or shown here)</p>";
                // Typically, you might include a file here like: include_once '_dashboard_profile.php';
                break;
            case 'overview':
            default:
                echo "<h2>Dashboard Overview</h2><p>A summary of your recent activity, like recent orders or account status, will appear here.</p>";
                // Example: Display a summary card
                echo '<div class="card"><div class="card-body">You have 0 new notifications and 0 pending orders. (Placeholder)</div></div>';
                break;
        }
        ?>
    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 