<?php
$page_title = "Manage Users - Admin Panel";
include_once __DIR__ . '/../includes/header.php';

// Admin access check
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login/login.php?message=Access Denied');
    exit;
}

// Fetch users from DB
$users = [];
$res = $conn->query("SELECT id, first_name, last_name, email, role, is_active, date_created FROM user ORDER BY id DESC");
if ($res && $res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        $users[] = $row;
    }
}
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
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="7" class="text-center">No users found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($user['role'])); ?></td>
                                <td><?php echo $user['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?></td>
                                <td><?php echo date('M d, Y', strtotime($user['date_created'])); ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary disabled"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger disabled"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 