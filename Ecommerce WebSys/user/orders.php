<?php
$page_title = "My Orders - 2nd Phone Shop";
include_once __DIR__ . '/../includes/header.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: ../login/login.php?message=Please login to view your orders.');
    exit;
}

$user_id = $_SESSION['user_id'];
$orders = [];

// Fetch orders for the current user from the database
// $sql = "SELECT id, order_date, total_amount, status FROM orders WHERE user_id = ? ORDER BY order_date DESC";
// if ($stmt = $conn->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     while ($row = $result->fetch_assoc()) {
//         $orders[] = $row;
//     }
//     $stmt->close();
// } else {
//     // Handle error - though for a placeholder, we might not show db errors directly
//     error_log("Error fetching orders: " . $conn->error);
// }

// Mock orders for now
$orders = [
    ['id' => 'ORD12345', 'order_date' => '2023-10-26 10:30:00', 'total_amount' => 349.98, 'status' => 'Shipped'],
    ['id' => 'ORD12300', 'order_date' => '2023-10-15 14:12:00', 'total_amount' => 499.99, 'status' => 'Delivered'],
    ['id' => 'ORD12250', 'order_date' => '2023-09-20 09:00:00', 'total_amount' => 75.50, 'status' => 'Processing'],
];
?>

<div class="d-flex flex-column flex-lg-row">
    <nav class="nav flex-column nav-pills bg-light p-3 mb-3 mb-lg-0 me-lg-3 rounded" style="min-width: 220px;">
        <a class="nav-link" href="dashboard.php?page=overview"><i class="bi bi-person-circle me-2"></i>Dashboard Overview</a>
        <a class="nav-link active" href="orders.php"><i class="bi bi-box-seam me-2"></i>My Orders</a>
        <a class="nav-link" href="profile.php"><i class="bi bi-person-badge me-2"></i>My Profile</a>
        <a class="nav-link" href="profile.php?section=settings"><i class="bi bi-gear me-2"></i>Account Settings</a>
        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </nav>

    <div class="flex-grow-1">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info">You have not placed any orders yet.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo date("M d, Y h:i A", strtotime($order['order_date'])); ?></td>
                                <td class="text-end">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td><span class="badge bg-<?php echo strtolower(htmlspecialchars($order['status'])) === 'delivered' ? 'success' : (strtolower(htmlspecialchars($order['status'])) === 'shipped' ? 'info' : (strtolower(htmlspecialchars($order['status'])) === 'processing' ? 'warning' : 'secondary')); ?>"><?php echo htmlspecialchars($order['status']); ?></span></td>
                                <td class="text-center">
                                    <a href="order_detail.php?order_id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> View</a>
                                    <?php // Add other actions like 'Track Order' or 'Request Return' if applicable ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include_once __DIR__ . '/../includes/footer.php';
?> 