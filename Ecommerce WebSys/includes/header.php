<?php 
session_start(); // Start session on all pages
include_once __DIR__ . '/connection/db_conn.php'; // Adjusted path for includes folder

// Helper function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper function to check if the logged-in user is an admin
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

$current_page = basename($_SERVER['PHP_SELF']);
$page_title = "Arc'teryx Philippines"; // Default title

// You can set specific titles for pages in each page file before including the header
// For example, in login.php, before include header: $page_title = "Login - 2nd Phone Shop";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <?php 
        $css_path = 'asset/css/styles.css';
        if (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
            $css_path = '../asset/css/styles.css';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e54c8;
            --secondary-color: #8f94fb;
            --accent-color: #6a11cb;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fcfcfc;
        }
        
        .navbar {
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }
        
        .gradient-text {
            background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        
        .nav-link {
            font-weight: 500;
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: 80%;
        }
        
        .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 84, 200, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-color: transparent;
            transform: translateY(-2px);
        }
        
        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 0.3rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: rgba(78, 84, 200, 0.1);
            color: var(--primary-color);
        }
        
        .auth-page-body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        @media (max-width: 992px) {
            .navbar-nav {
                padding: 1rem 0;
            }
            .nav-link {
                padding: 0.5rem 0;
            }
            .nav-link:after {
                display: none;
            }
        }
    </style>
</head>
<body class="<?php if ($current_page === 'login.php' || $current_page === 'register.php') echo 'auth-page-body'; ?>">

<?php if ($current_page === 'login.php' || $current_page === 'register.php'): ?>
    <nav class="navbar navbar-light bg-white py-3 shadow-sm w-100">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../index.php' : 'index.php'; ?>">Arc<span class="gradient-text">t</span>eryx</a>
        </div>
    </nav>
<?php else: ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
      <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../index.php' : 'index.php'; ?>">Arc<span class="gradient-text">t</span>eryx</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
            <?php 
                $home_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../index.php' : 'index.php';
                $about_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../about.php' : 'about.php';
                $shop_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../shop.php' : 'shop.php';
                $contact_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../contact.php' : 'contact.php';
                $cart_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../cart.php' : 'cart.php';
                $login_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false) ? 'login.php' : ( (strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../login/login.php' : 'login/login.php');
                $register_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false) ? '../register.php' : ( (strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../register.php' : 'register.php');
                $dashboard_link = (strpos($_SERVER['REQUEST_URI'], '/user/') !== false) ? 'dashboard.php' : ( (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../user/dashboard.php' : 'user/dashboard.php');
                $admin_dashboard_link = (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? 'index.php' : 'admin/index.php';
                $logout_link = (strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../logout.php' : 'logout.php';
            ?>
            <li class="nav-item"><a class="nav-link <?php if($current_page === 'index.php') echo 'active'; ?>" href="<?php echo $home_link; ?>">Home</a></li>
            <li class="nav-item"><a class="nav-link <?php if($current_page === 'about.php') echo 'active'; ?>" href="<?php echo $about_link; ?>">About</a></li>
            <li class="nav-item"><a class="nav-link <?php if($current_page === 'shop.php') echo 'active'; ?>" href="<?php echo $shop_link; ?>">Shop</a></li>
            <li class="nav-item"><a class="nav-link <?php if($current_page === 'contact.php') echo 'active'; ?>" href="<?php echo $contact_link; ?>">Contact</a></li>
            <li class="nav-item"><a class="nav-link <?php if($current_page === 'cart.php') echo 'active'; ?>" href="<?php echo $cart_link; ?>"><i class="bi bi-cart"></i> Cart</a></li>
            <?php if (isLoggedIn()): ?>
                <li class="nav-item dropdown ms-lg-2">
                  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownUserLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['user_first_name']); ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUserLink">
                    <li><a class="dropdown-item" href="<?php echo $dashboard_link; ?>"><i class="bi bi-speedometer2 me-2"></i>My Dashboard</a></li>
                    <li><a class="dropdown-item" href="<?php echo $dashboard_link; ?>?page=orders"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                    <li><a class="dropdown-item" href="<?php echo $dashboard_link; ?>?page=settings"><i class="bi bi-gear me-2"></i>Account Settings</a></li>
                    <?php if (isAdmin()): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo $admin_dashboard_link; ?>"><i class="bi bi-shield-lock me-2"></i>Admin Panel</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo $logout_link; ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                  </ul>
                </li>
            <?php else: ?>
                <li class="nav-item ms-lg-2">
                  <a class="btn btn-outline-primary rounded-pill px-3" href="<?php echo $login_link; ?>"><i class="bi bi-person me-1"></i> Login</a>
                </li>
                <li class="nav-item ms-lg-2">
                  <a class="btn btn-primary rounded-pill px-3" href="<?php echo $register_link; ?>"><i class="bi bi-person-plus me-1"></i> Register</a>
                </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
<?php endif; ?>

<!-- Start of main page content -->
<div class="container mt-4 mb-4 flex-grow-1"> 
