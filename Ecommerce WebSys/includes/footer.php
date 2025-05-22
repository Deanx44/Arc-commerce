</div> <!-- End of main page content container -->

<?php if ($current_page === 'login.php' || $current_page === 'register.php'): ?>
    <footer class="bg-light text-muted text-center small py-3 mt-auto w-100">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> Arc'teryx Philippines. All Rights Reserved.</p>
    </footer>
<?php else: ?>
    <footer class="bg-dark text-white text-center p-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-primary mb-3">Arc'teryx Philippines</h5>
                    <p class="small">Premium outdoor clothing and equipment designed for performance and durability.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-primary mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="products.php" class="text-white text-decoration-none">Products</a></li>
                        <li><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
                        <li><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-primary mb-3">Contact Us</h5>
                    <address class="small text-white">
                        <i class="bi bi-geo-alt me-2"></i> 123 Main Street, City, Philippines<br>
                        <i class="bi bi-telephone me-2"></i> +63 (123) 456-789 <br>
                        <i class="bi bi-envelope me-2"></i> Arcteryx@ph.com
                    </address>
                </div>
            </div>
            <hr class="my-3 bg-secondary">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Arc'teryx Philippines. All Rights Reserved.</p>
        </div>
    </footer>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php 
    // Adjust jQuery path based on directory depth for pages that might still use it (like register.php)
    // Note: Bootstrap 5 JS components do not require jQuery.
    $jquery_path = 'asset/js/jquery-3.7.0.slim.min.js'; // Example path, adjust if you have local jQuery
    // For pages like register.php that used it directly in their script block:
    if ($current_page === 'register.php' || (isset($include_jquery) && $include_jquery)) {
      // echo '<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"></script>';
      // If you want to use a local copy:
      // echo '<script src="'. ((strpos($_SERVER['REQUEST_URI'], '/login/') !== false || strpos($_SERVER['REQUEST_URI'], '/user/') !== false) ? '../' : '') .'asset/js/jquery.min.js"></script>';
    }
?>
<!-- Add page-specific JS files here if needed -->

</body>
</html>
<?php
// Close the database connection if it was opened by the header
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
