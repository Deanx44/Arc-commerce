<?php 
$page_title = "Arcyterx Shop";
include_once __DIR__ . '/includes/header.php'; 

// Initialize database connection if not already done in header
// if (!isset($conn)) {
//     require_once __DIR__ . '/includes/db_connect.php';
// }

// Initialize variables for filtering and sorting
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$min_price = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? floatval($_GET['min_price']) : '';
$max_price = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? floatval($_GET['max_price']) : '';
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';

// Build the query based on filters
$products_sql = "SELECT id, name, price, main_image_url, slug FROM products WHERE is_active = TRUE";

// Add category filter if set
if (!empty($category_filter)) {
    // Assuming you have a category_slug column in products table or a join with categories
    $category_slug = $conn->real_escape_string($category_filter);
    $products_sql .= " AND category_slug = '$category_slug'";
}

// Add price filters if set
if ($min_price !== '') {
    $products_sql .= " AND price >= $min_price";
}
if ($max_price !== '') {
    $products_sql .= " AND price <= $max_price";
}

// Add sorting
switch ($sort_option) {
    case 'name_desc':
        $products_sql .= " ORDER BY name DESC";
        break;
    case 'price_asc':
        $products_sql .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $products_sql .= " ORDER BY price DESC";
        break;
    case 'name_asc':
    default:
        $products_sql .= " ORDER BY name ASC";
        break;
}
?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Categories section -->
            <div class="card shadow-sm mb-4">
                 <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-list me-2"></i>Categories</h4>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item <?php echo empty($category_filter) ? 'active' : ''; ?>">
                <a href="shop.php<?php echo !empty($sort_option) ? '?sort=' . htmlspecialchars($sort_option) : ''; ?>" class="text-decoration-none d-block">
                    <i class="bi bi-grid me-2"></i>All Products
                </a>
            </li>
            <?php
            // Fetch categories from database
            $cat_sql = "SELECT id, name, slug FROM categories WHERE is_active = TRUE ORDER BY name ASC";
            $cat_result = $conn->query($cat_sql);
            if ($cat_result && $cat_result->num_rows > 0) {
                while($category = $cat_result->fetch_assoc()) {
                    $active = $category_filter == $category['slug'] ? 'active' : '';
                    $url_params = 'category=' . htmlspecialchars($category['slug']);
                    if (!empty($sort_option)) {
                        $url_params .= '&sort=' . htmlspecialchars($sort_option);
                    }
                    if ($min_price !== '') {
                        $url_params .= '&min_price=' . $min_price;
                    }
                    if ($max_price !== '') {
                        $url_params .= '&max_price=' . $max_price;
                    }
                    echo '<li class="list-group-item '.$active.'"><a href="shop.php?'.$url_params.'" class="text-decoration-none d-block"><i class="bi bi-tag me-2"></i>'.htmlspecialchars($category['name']).'</a></li>';
                }
            } else {
                // Fallback to placeholder categories if no categories in database
                ?>
                <li class="list-group-item <?php echo $category_filter == 'jackets' ? 'active' : ''; ?>">
                    <a href="shop.php?category=jackets<?php echo !empty($sort_option) ? '&sort=' . htmlspecialchars($sort_option) : ''; ?><?php echo $min_price !== '' ? '&min_price=' . $min_price : ''; ?><?php echo $max_price !== '' ? '&max_price=' . $max_price : ''; ?>" class="text-decoration-none d-block">
                        <i class="bi bi-layers me-2"></i>Jackets
                    </a>
                </li>
                <li class="list-group-item <?php echo $category_filter == 'gears' ? 'active' : ''; ?>">
                    <a href="shop.php?category=gears<?php echo !empty($sort_option) ? '&sort=' . htmlspecialchars($sort_option) : ''; ?><?php echo $min_price !== '' ? '&min_price=' . $min_price : ''; ?><?php echo $max_price !== '' ? '&max_price=' . $max_price : ''; ?>" class="text-decoration-none d-block">
                        <i class="bi bi-bag me-2"></i>Gears
                    </a>
                </li>
                <li class="list-group-item <?php echo $category_filter == 'accessories' ? 'active' : ''; ?>">
                    <a href="shop.php?category=accessories<?php echo !empty($sort_option) ? '&sort=' . htmlspecialchars($sort_option) : ''; ?><?php echo $min_price !== '' ? '&min_price=' . $min_price : ''; ?><?php echo $max_price !== '' ? '&max_price=' . $max_price : ''; ?>" class="text-decoration-none d-block">
                        <i class="bi bi-person me-2"></i>Accessories
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

            
                       <!-- Price Filter -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter by Price</h4>
                </div>
                <div class="card-body">
                    <form action="shop.php" method="GET" id="price-filter-form">
                        <div class="mb-3">
                            <label for="min_price" class="form-label">Min Price:</label>
                            <input type="number" class="form-control" id="min_price" name="min_price" min="0" value="<?php echo $min_price; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="max_price" class="form-label">Max Price:</label>
                            <input type="number" class="form-control" id="max_price" name="max_price" min="0" value="<?php echo $max_price; ?>">
                        </div>
                        <?php if(!empty($category_filter)): ?>
                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_filter); ?>">
                        <?php endif; ?>
                        <?php if(!empty($sort_option)): ?>
                            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_option); ?>">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Apply Filter</button>
                        <?php if($min_price !== '' || $max_price !== ''): ?>
                            <a href="shop.php<?php echo !empty($category_filter) ? '?category=' . htmlspecialchars($category_filter) : ''; ?><?php echo !empty($sort_option) ? (!empty($category_filter) ? '&' : '?') . 'sort=' . htmlspecialchars($sort_option) : ''; ?>" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-x-circle me-2"></i>Clear Price Filter
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0"><i class="bi bi-shop me-2"></i>Our Products</h1>
                <div class="d-flex align-items-center">
                    <label for="sort_by" class="me-2">Sort by:</label>
                    <select id="sort_by" class="form-select" onchange="updateSortOrder(this.value)">
                        <option value="name_asc" <?php echo $sort_option == 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                        <option value="name_desc" <?php echo $sort_option == 'name_desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
                        <option value="price_asc" <?php echo $sort_option == 'price_asc' ? 'selected' : ''; ?>>Price (Low to High)</option>
                        <option value="price_desc" <?php echo $sort_option == 'price_desc' ? 'selected' : ''; ?>>Price (High to Low)</option>
                    </select>
                </div>
            </div>
            
            <?php if(!empty($category_filter) || $min_price !== '' || $max_price !== ''): ?>
                <div class="alert alert-info">
                    <i class="bi bi-filter-circle me-2"></i>
                    <?php if(!empty($category_filter)): ?>
                        <span>Category: <strong><?php echo htmlspecialchars(ucfirst($category_filter)); ?></strong></span>
                    <?php endif; ?>
                    
                    <?php if($min_price !== '' || $max_price !== ''): ?>
                        <span>Price: 
                            <?php if($min_price !== '' && $max_price !== ''): ?>
                                <strong>₱<?php echo $min_price; ?> - ₱<?php echo $max_price; ?></strong>
                            <?php elseif($min_price !== ''): ?>
                                <strong>Min ₱<?php echo $min_price; ?></strong>
                            <?php elseif($max_price !== ''): ?>
                                <strong>Max ₱<?php echo $max_price; ?></strong>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>

                    
                    <a href="shop.php" class="float-end text-decoration-none">Clear all filters</a>
                </div>
            <?php endif; ?>
            
            <div class="row g-4">
                <?php
                // Fetch products from database with the built query
                // $products_result = $conn->query($products_sql);
                // if ($products_result && $products_result->num_rows > 0) {
                //   while($product = $products_result->fetch_assoc()) {
                //     echo '<div class="col-md-4">';
                //     echo '  <div class="card product-card h-100 shadow-sm">';
                //     echo '    <div class="position-relative">';
                //     echo '      <a href="product_detail.php?slug='.htmlspecialchars($product['slug']).'">';
                //     echo '        <img src="'.htmlspecialchars($product['main_image_url'] ? $product['main_image_url'] : 'https://via.placeholder.com/300x200?text=No+Image').'" class="card-img-top p-3" style="height:200px; object-fit:contain;" alt="'.htmlspecialchars($product['name']).'">';
                //     echo '      </a>';
                //     echo '      <div class="position-absolute top-0 end-0 p-2">';
                //     echo '        <button class="btn btn-sm btn-outline-danger rounded-circle wishlist-btn" data-product-id="'.$product['id'].'"><i class="bi bi-heart"></i></button>';
                //     echo '      </div>';
                //     echo '    </div>';
                //     echo '    <div class="card-body d-flex flex-column">';
                //     echo '      <h5 class="card-title"><a href="product_detail.php?slug='.htmlspecialchars($product['slug']).'" class="text-decoration-none text-dark">'.htmlspecialchars($product['name']).'</a></h5>';
                //     echo '      <div class="d-flex justify-content-between align-items-center mt-auto">';
                //     echo '        <h6 class="text-primary fw-bold mb-0">$'.number_format($product['price'], 2).'</h6>';
                //     echo '        <a href="cart.php?action=add&id='.$product['id'].'" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus"></i> Add to Cart</a>';
                //     echo '      </div>';
                //     echo '    </div>';
                //     echo '  </div>';
                //     echo '</div>';
                //   }
                // } else {
                //   echo '<div class="col-12"><div class="alert alert-info text-center">No products found matching your criteria.</div></div>';
                // }
                ?>
                
                <!-- Placeholder Product Cards with Enhanced UI -->
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <div class="position-relative">
                            <a href="product_detail.php?slug=sample-product-1">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJ5lvf2V3aGkoStiIpXuum6_yPzSr6_E0Y7lMWo5r2qZiwdwLQrrbtP4XQ6kJsTGi3G4w&usqp=CAU=Arc Jacket" class="card-img-top p-3" style="height:200px; object-fit:contain;" alt="Arc JacketS">
                            </a>
                            <div class="position-absolute top-0 end-0 p-2">
                                <button class="btn btn-sm btn-outline-danger rounded-circle wishlist-btn"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><a href="product_detail.php?slug=sample-product-1" class="text-decoration-none text-dark">Arc'teryx Alpha Jacket</a></h5>
                            <p class="card-text text-muted small">The Arc'teryx Alpha Jacket is a versatile, weather-resistant hardshell jacket designed for demanding alpine conditions. It features GORE-TEX PRO fabrics, including a rugged version for high-wear areas and a lighter Hadron fabric for reduced weight and improved breathability. Key features include a durable, waterproof shell, a helmet-compatible StormHood, and pit zippers for ventilation.</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <h6 class="text-primary fw-bold mb-0">₱16,870</h6>
                                <a href="cart.php?action=add&id=1" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <div class="position-relative">
                            <a href="product_detail.php?slug=sample-product-2">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjov3Tz_ZIpcBeyLqkWcwjnlHn0o5h8TaTPyfihnNfySSo7ikw6zqeifsvcQ3tbwnvXbE&usqp=CAU=Arc Bag" class="card-img-top p-3" style="height:200px; object-fit:contain;" alt="Arc Bag">
                            </a>
                            <div class="position-absolute top-0 end-0 p-2">
                                <button class="btn btn-sm btn-outline-danger rounded-circle wishlist-btn"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="position-absolute top-0 start-0 p-2">
                                <span class="badge bg-danger">Sale!</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><a href="product_detail.php?slug=sample-product-2" class="text-decoration-none text-dark">Arc'teryx Bora 65 Backpack Men's</a></h5>
                            <p class="card-text text-muted small">Weekend or a week, the Bora 65’s comfortable carry helps you push farther and discover new terrain. Its RotoGlide™ hipbelt moves with you for better balance and stride, locks out for added stability. GridLock™ harness adjustability creates a precision fit, and the thermoformed Tegris® frame sheet and aluminum stays add support</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <h6 class="text-primary fw-bold mb-0">₱32,860</h6>
                                <a href="cart.php?action=add&id=2" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <div class="position-relative">
                            <a href="product_detail.php?slug=sample-product-3">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUxJysu662Y8a-Est5fNhPUB8sYI4C9jaF9Q&s=Arc Beanie" class="card-img-top p-3" style="height:200px; object-fit:contain;" alt="Arc Beanie">
                            </a>
                            <div class="position-absolute top-0 end-0 p-2">
                                <button class="btn btn-sm btn-outline-danger rounded-circle wishlist-btn"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><a href="product_detail.php?slug=sample-product-3" class="text-decoration-none text-dark">Arc'teryx Bird Head Toque Beanie</a></h5>
                            <p class="card-text text-muted small">Arc'teryx beanies are known for their quality materials, including merino wool and recycled polyester, and are designed for warmth and comfort during various activities. Many offer moisture-wicking properties and come in a range of styles, including the classic Bird Head Toque and lighter versions like the Lightweight Bird Head Toque. </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <h6 class="text-primary fw-bold mb-0">₱3,500</h6>
                                <a href="cart.php?action=add&id=3" class="btn btn-primary btn-sm"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?> 
