<?php
$page_title = "Product Details - 2nd Phone Shop"; // Will be updated with product name
include_once __DIR__ . '/includes/header.php';

$product = null;
$product_slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if ($product_slug) {
    // In a real application, fetch product details from the database using the slug
    // $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = ? AND p.is_active = TRUE";
    // For now, let's use a mock product if slug matches 'sample-product-one'
    if ($product_slug === 'sample-product-one') {
        $product = [
            'id' => 1,
            'name' => 'Awesome Smartphone X',
            'slug' => 'sample-product-one',
            'description' => 'This is a fantastic smartphone with all the latest features. High-resolution camera, super-fast processor, and a sleek design. Perfect for professionals and tech enthusiasts alike!',
            'price' => 299.99,
            'stock_quantity' => 50,
            'main_image_url' => 'https://via.placeholder.com/400x300.png?text=Smartphone+X',
            'category_name' => 'Smartphones',
            'images' => [
                ['image_url' => 'https://via.placeholder.com/400x300.png?text=Smartphone+X+View+1', 'alt_text' => 'View 1'],
                ['image_url' => 'https://via.placeholder.com/100x75.png?text=Thumb+2', 'alt_text' => 'View 2'],
                ['image_url' => 'https://via.placeholder.com/100x75.png?text=Thumb+3', 'alt_text' => 'View 3']
            ],
            'reviews' => [ // Placeholder for reviews
                ['user_name' => 'John D.', 'rating' => 5, 'comment' => 'Absolutely love this phone!'],
                ['user_name' => 'Jane S.', 'rating' => 4, 'comment' => 'Great value for money.']
            ]
        ];
        $page_title = htmlspecialchars($product['name']) . " - 2nd Phone Shop"; // Update page title
    } elseif ($product_slug === 'sample-product-two') {
        $product = [
            'id' => 2,
            'name' => 'Super Tablet Z',
            'slug' => 'sample-product-two',
            'description' => 'A powerful tablet perfect for work and play. Large screen, long battery life, and a responsive interface. Comes with a stylus.',
            'price' => 499.99,
            'stock_quantity' => 0, // Example for out of stock
            'main_image_url' => 'https://via.placeholder.com/400x300.png?text=Tablet+Z',
            'category_name' => 'Tablets',
            'images' => [
                ['image_url' => 'https://via.placeholder.com/400x300.png?text=Tablet+Z+View+1', 'alt_text' => 'View 1'],
                ['image_url' => 'https://via.placeholder.com/100x75.png?text=Thumb+2', 'alt_text' => 'View 2']
            ],
            'reviews' => []
        ];
        $page_title = htmlspecialchars($product['name']) . " - 2nd Phone Shop"; // Update page title
    }
    // If product not found after DB query, you would handle that here
}
?>

<div class="py-5">
    <div class="container">
        <?php if ($product): ?>
            <div class="row">
                <div class="col-md-6">
                    <!-- Product Image Gallery (Basic) -->
                    <img src="<?php echo htmlspecialchars($product['main_image_url']); ?>" class="img-fluid rounded main-product-image mb-3" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if (!empty($product['images']) && count($product['images']) > 1): ?>
                        <div class="row gx-2 gy-2 product-thumbnails">
                            <?php foreach($product['images'] as $index => $image): ?>
                                <div class="col-auto">
                                    <a href="<?php echo htmlspecialchars($image['image_url']); ?>" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $index; ?>">
                                        <img src="<?php echo htmlspecialchars(str_replace('400x300', '100x75', $image['image_url'])); ?>" class="img-thumbnail" alt="<?php echo htmlspecialchars($image['alt_text']); ?>" style="max-width:75px; cursor:pointer;" onclick="document.querySelector('.main-product-image').src='<?php echo htmlspecialchars($image['image_url']); ?>'">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                    <h3 class="text-primary fw-bold">$<?php echo number_format($product['price'], 2); ?></h3>

                    <form action="cart.php" method="GET" class="my-3"> <!-- Using GET for simplicity here, POST is better for cart actions -->
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <label for="quantity" class="col-form-label">Quantity:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" <?php if($product['stock_quantity'] <= 0) echo 'disabled'; ?>>
                            </div>
                            <div class="col-auto">
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <button type="submit" class="btn btn-primary auth-btn"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary" disabled><i class="bi bi-x-circle"></i> Out of Stock</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($product['stock_quantity'] > 0 && $product['stock_quantity'] < 10): ?>
                            <p class="text-danger mt-2"><small>Only <?php echo $product['stock_quantity']; ?> left in stock!</small></p>
                        <?php elseif ($product['stock_quantity'] <= 0): ?>
                            <p class="text-danger mt-2"><small>This item is currently out of stock.</small></p>
                        <?php endif; ?>
                    </form>

                    <h4>Product Description</h4>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                    <!-- Placeholder for Specifications, Reviews etc. -->
                </div>
            </div>

            <hr class="my-5">

            <!-- Product Reviews Section -->
            <div class="row">
                <div class="col-12">
                    <h3>Customer Reviews</h3>
                    <?php if (!empty($product['reviews'])): ?>
                        <?php foreach($product['reviews'] as $review): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($review['user_name']); ?> <span class="text-warning"><?php echo str_repeat('★', $review['rating']); ?><?php echo str_repeat('☆', 5 - $review['rating']); ?></span></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($review['comment']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet for this product.</p>
                    <?php endif; ?>
                    <!-- Add Review Form (placeholder) -->
                    <div class="mt-4">
                        <h4>Leave a Review</h4>
                        <p><em>Review submission form will go here. (Requires user to be logged in)</em></p>
                    </div>
                </div>
            </div>

        <?php elseif ($product_slug): ?>
            <div class="alert alert-danger text-center">Product not found. It might have been removed or the link is incorrect.</div>
            <p class="text-center"><a href="shop.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Back to Shop</a></p>
        <?php else: ?>
            <div class="alert alert-warning text-center">No product specified. Please select a product from our shop.</div>
            <p class="text-center"><a href="shop.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Go to Shop</a></p>
        <?php endif; ?>
    </div>
</div>

<?php
// The header needs to be included again if the page title was changed dynamically after the first include.
// However, a better approach is to set $page_title before the first header include and don't re-include it.
// For this specific dynamic title case based on product, it's tricky without output buffering.
// Let's assume the title set by product details is final and only include footer once.
include_once __DIR__ . '/includes/footer.php';
?> 