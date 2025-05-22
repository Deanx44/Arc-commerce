<?php
$page_title = "My Profile - 2nd Phone Shop";
include_once __DIR__ . '/../includes/header.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: ../login/login.php?message=Please login to view your profile.');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_data = [];
$update_message = "";
$error_message = "";

// Fetch current user data
// $sql_fetch_user = "SELECT first_name, middle_name, last_name, email, mobile_number FROM user WHERE id = ?";
// if ($stmt_fetch = $conn->prepare($sql_fetch_user)) {
//     $stmt_fetch->bind_param("i", $user_id);
//     $stmt_fetch->execute();
//     $result = $stmt_fetch->get_result();
//     if ($result->num_rows === 1) {
//         $user_data = $result->fetch_assoc();
//     } else {
//         $error_message = "Could not retrieve user data.";
//     }
//     $stmt_fetch->close();
// } else {
//     $error_message = "Database error preparing to fetch user data: " . $conn->error;
//     error_log($error_message);
// }

// Mock user data for now
$user_data = [
    'first_name' => isset($_SESSION['user_first_name']) ? $_SESSION['user_first_name'] : 'John',
    'middle_name' => 'M.',
    'last_name' => isset($_SESSION['user_last_name']) ? $_SESSION['user_last_name'] : 'Doe',
    'email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'john.doe@example.com',
    'mobile_number' => '09123456789'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        // Sanitize and validate inputs
        $first_name = trim($_POST['first_name']);
        $middle_name = trim($_POST['middle_name']);
        $last_name = trim($_POST['last_name']);
        $mobile_number = trim($_POST['mobile_number']);
        // Email is typically not changed here or requires verification, handle separately

        // Basic validation (expand as needed)
        if (empty($first_name) || empty($last_name)) {
            $error_message = "First name and Last name are required.";
        } elseif (!preg_match("/^09\d{9}$/", $mobile_number)) {
            $error_message = "Mobile number must start with 09 and be exactly 11 digits.";
        } else {
            // Update user data in the database
            // $sql_update = "UPDATE user SET first_name = ?, middle_name = ?, last_name = ?, mobile_number = ? WHERE id = ?";
            // if ($stmt_update = $conn->prepare($sql_update)) {
            //     $stmt_update->bind_param("ssssi", $first_name, $middle_name, $last_name, $mobile_number, $user_id);
            //     if ($stmt_update->execute()) {
            //         $update_message = "Profile updated successfully!";
            //         // Update session variables if they changed
            //         $_SESSION['user_first_name'] = $first_name;
            //         $_SESSION['user_last_name'] = $last_name;
            //         // Refresh user_data array
            //         $user_data['first_name'] = $first_name; $user_data['middle_name'] = $middle_name; $user_data['last_name'] = $last_name; $user_data['mobile_number'] = $mobile_number;
            //     } else {
            //         $error_message = "Error updating profile: " . $stmt_update->error;
            //         error_log("Profile update error: " . $stmt_update->error);
            //     }
            //     $stmt_update->close();
            // } else {
            //     $error_message = "Database error preparing to update profile: " . $conn->error;
            //     error_log($error_message);
            // }
            $update_message = "Profile updated successfully! (Mock update)";
            $_SESSION['user_first_name'] = $first_name; $_SESSION['user_last_name'] = $last_name;
            $user_data['first_name'] = $first_name; $user_data['middle_name'] = $middle_name; $user_data['last_name'] = $last_name; $user_data['mobile_number'] = $mobile_number;
        }
    } elseif (isset($_POST['change_password'])) {
        // Handle password change logic (requires current password, new password, confirm new password)
        // This is a more complex part, involving hashing and secure practices.
        $update_message = "Password change functionality will be implemented here. (Mock message)";
    }
}

$active_sub_section = isset($_GET['section']) ? $_GET['section'] : 'profile';
?>

<div class="d-flex flex-column flex-lg-row">
    <nav class="nav flex-column nav-pills bg-light p-3 mb-3 mb-lg-0 me-lg-3 rounded" style="min-width: 220px;">
        <a class="nav-link" href="dashboard.php?page=overview"><i class="bi bi-person-circle me-2"></i>Dashboard Overview</a>
        <a class="nav-link" href="orders.php"><i class="bi bi-box-seam me-2"></i>My Orders</a>
        <a class="nav-link <?php if ($active_sub_section === 'profile') echo 'active'; ?>" href="profile.php?section=profile"><i class="bi bi-person-badge me-2"></i>My Profile</a>
        <a class="nav-link <?php if ($active_sub_section === 'settings') echo 'active'; ?>" href="profile.php?section=settings"><i class="bi bi-gear me-2"></i>Account Settings</a>
        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>

    <div class="flex-grow-1">
        <?php if (!empty($update_message)): ?>
            <div class="alert alert-success"><?php echo $update_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($active_sub_section === 'settings'): ?>
            <h1>Account Settings</h1>
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="profile.php?section=settings" method="POST">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="form-text">Must be at least 8 characters, with 1 uppercase and numbers.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary auth-btn">Change Password</button>
                    </form>
                </div>
            </div>
        <?php else: // Default to profile section ?>
            <h1><?php echo htmlspecialchars($page_title); ?></h1>
            <div class="card">
                <div class="card-header">Personal Information</div>
                <div class="card-body">
                    <form action="profile.php?section=profile" method="POST">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_data['first_name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($user_data['middle_name'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user_data['last_name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" readonly disabled>
                            <div class="form-text">Email address cannot be changed from this form.</div>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user_data['mobile_number'] ?? ''); ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary auth-btn">Save Changes</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php // Placeholder for address management - could be another section or tab
        /*
        <h2 class="mt-5">My Addresses</h2>
        <div class="card">
            <div class="card-body">
                <p>Address management will go here. You will be able to add, edit, and remove shipping/billing addresses.</p>
                <a href="#" class="btn btn-secondary"><i class="bi bi-plus-circle"></i> Add New Address</a>
            </div>
        </div>
        */
        ?>
    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 