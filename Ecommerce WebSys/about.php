<?php
$page_title = "About Us - Arcteryx Shop";
include_once __DIR__ . '/includes/header.php';
?>

<section class="py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Our Story</h6>
            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($page_title); ?></h1>
            <div class="section-divider mx-auto my-3"></div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://mgba.com/wp-content/uploads/2024/04/Storefront-2-2.jpg" alt="Our Shop" class="img-fluid rounded-3 shadow-sm">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-3">Our Mission</h2>
                <p class="lead text-secondary mb-4">"To empower explorers, athletes, and outdoor enthusiasts with meticulously crafted gear that redefines performance, innovation, and sustainability. We exist to elevate human potential in the wildest environments while preserving the planet for future generations. Every product is born from relentless engineering, respect for nature, and a commitment to enabling transformative outdoor experiences."</p>
            </div>
        </div>

        <div class="row align-items-center flex-lg-row-reverse">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="data:image/jpeg;base64,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" alt="Our Vision" class="img-fluid rounded-3 shadow-sm">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-3">Our Vision</h2>
                <p class="lead text-secondary mb-4">"To pioneer the future of outdoor exploration by creating the world’s most advanced, sustainable, and purpose-driven gear. We envision a world where humanity and nature thrive in harmony, and every journey—from urban peaks to remote wilderness—is fueled by cutting-edge design, ethical responsibility, and an unyielding passion for the unknown."</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Why Choose Us</h6>
            <h2 class="display-6 fw-bold">Our Values</h2>
            <div class="section-divider mx-auto my-3"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-shield-check text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title">Quality Assurance</h4>
                        <p class="card-text">Every device undergoes rigorous testing and quality checks before reaching our customers.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-recycle text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title">Sustainability</h4>
                        <p class="card-text">We're committed to reducing e-waste by giving devices a second life through refurbishment.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-headset text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title">Customer Support</h4>
                        <p class="card-text">Our dedicated team is always ready to assist you with any questions or concerns.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Join Our Journey</h6>
            <h2 class="display-6 fw-bold">Ready to Experience the Difference?</h2>
            <div class="section-divider mx-auto my-3"></div>
            <p class="lead text-secondary mb-4">Discover our collection of premium refurbished mountain gears today.</p>
            <a href="shop.php" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">Shop Now</a>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
