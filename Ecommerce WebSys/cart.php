<?php
$page_title = "Shopping Cart - Arcteryx Shop";
include_once __DIR__ . '/includes/header.php';

// --- Cart Logic ---
// (This will be significantly more complex later)

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
$cart_total = 0;

// Example: Add item to cart (normally triggered by a form POST from product page)
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    // In a real app, fetch product details from DB to ensure it exists and get price
    // For now, let's assume a mock product
   $mock_products = [
    1 => ['name' => 'Arceryx Alpha Jacket', 'price' => 16870, 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJ5lvf2V3aGkoStiIpXuum6_yPzSr6_E0Y7lMWo5r2qZiwdwLQrrbtP4XQ6kJsTGi3G4w&usqp'],
    2 => ['name' => 'Arcteryx Bora 65 Backpack Mens', 'price' => 32860, 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjov3Tz_ZIpcBeyLqkWcwjnlHn0o5h8TaTPyfihnNfySSo7ikw6zqeifsvcQ3tbwnvXbE&usqp=CAU'],
    3 => ['name' => 'Arcteryx Bird Head Toque Beanie', 'price' => 3500, 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUxJysu662Y8a-Est5fNhPUB8sYI4C9jaF9Q&s'],
];


    

    if (array_key_exists($product_id, $mock_products)) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product_id,
                'name' => $mock_products[$product_id]['name'],
                'price' => $mock_products[$product_id]['price'],
                'quantity' => 1,
                'image' => $mock_products[$product_id]['image']
            ];
        }
        // Redirect to cart page to prevent re-adding on refresh, or use POST for add to cart actions
        header('Location: cart.php');
        exit;
    }
}

// Example: Update quantity
if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['id'])) {
    $product_id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]); // Remove if quantity is 0 or less
        }
    }
    header('Location: cart.php');
    exit;
}

// Example: Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header('Location: cart.php');
    exit;
}

$cart_items = $_SESSION['cart'];
foreach ($cart_items as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}
?>

<!-- Cart Section with Enhanced UI -->
<section class="cart-section py-5 position-relative overflow-hidden bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Your Shopping Cart</h6>
            <h2 class="display-6 fw-bold"><?php echo htmlspecialchars($page_title); ?></h2>
            <div class="section-divider mx-auto my-3" style="width: 80px; height: 3px; background-color: var(--bs-primary);"></div>
        </div>

        <?php if (empty($cart_items)): ?>
            <div class="card shadow-sm border-0 rounded-3 p-5 mb-4 text-center">
                <div class="py-4">
                    <i class="bi bi-cart-x text-primary" style="font-size: 4rem;"></i>
                    <h3 class="mt-4 mb-3">Your cart is currently empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
                    <a href="shop.php" class="btn btn-primary rounded-pill px-5 py-2 auth-btn">
                        <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" colspan="2" class="py-3 ps-4">Product</th>
                                <th scope="col" class="text-center py-3">Price</th>
                                <th scope="col" class="text-center py-3">Quantity</th>
                                <th scope="col" class="text-end py-3">Total</th>
                                <th scope="col" class="text-center py-3 pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td style="width: 100px;" class="p-3 ps-4">
                                        <div class="product-image-wrapper bg-white rounded shadow-sm p-2 text-center">
                                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid rounded product-img">
                                        </div>
                                    </td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="text-center text-primary fw-bold">₱<?php echo number_format($item['price'], 2); ?></td>
                                    <td class="text-center" style="min-width: 150px;">
                                        <form action="cart.php" method="POST" class="d-inline-flex align-items-center">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <div class="input-group input-group-sm quantity-control">
                                                <button type="button" class="btn btn-outline-primary" onclick="this.nextElementSibling.stepDown();this.form.submit();">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" class="form-control text-center" min="1" style="width: 50px;">
                                                <button type="button" class="btn btn-outline-primary" onclick="this.previousElementSibling.stepUp();this.form.submit();">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold">₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    <td class="text-center pe-4">
                                        <a href="cart.php?action=remove&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger rounded-circle" title="Remove item">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                        <h4 class="mb-3 fw-bold text-primary">Order Summary</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">₱<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Grand Total</span>
                            <span class="fw-bold text-primary fs-4">₱<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="checkout.php" class="btn btn-primary btn-lg rounded-pill auth-btn">
                                <i class="bi bi-credit-card me-2"></i> Proceed to Checkout
                            </a>
                            <a href="shop.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="hero-shape-1" style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background-color: rgba(var(--bs-primary-rgb), 0.1); border-radius: 50%;"></div>
    <div class="hero-shape-2" style="position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px; background-color: rgba(var(--bs-primary-rgb), 0.05); border-radius: 50%;"></div>
</section>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
