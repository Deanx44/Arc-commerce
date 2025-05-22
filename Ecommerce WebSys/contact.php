<?php
$page_title = "Contact Us - Arcteryx Shop";
include_once __DIR__ . '/includes/header.php';

// Placeholder for form handling logic
$form_message = "";
$form_submitted_successfully = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic validation (expand as needed)
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $form_message = "<div class=\"alert alert-danger\">All fields are required.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_message = "<div class=\"alert alert-danger\">Invalid email format.</div>";
    } else {
        // Simulate form submission (e.g., save to DB, send email)
        // For now, just set a success message
        // In a real scenario, you would integrate with the contact_submissions table

        $insert_submission_sql = "INSERT INTO contact_submissions (name, email, subject, message, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($insert_submission_sql)) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $stmt->bind_param("ssssss", $name, $email, $subject, $message, $ip_address, $user_agent);
            if ($stmt->execute()) {
                $form_message = "<div class=\"alert alert-success\">Thank you for your message! We will get back to you soon.</div>";
                $form_submitted_successfully = true;
            } else {
                $form_message = "<div class=\"alert alert-danger\">Error submitting your message. Please try again. Error: " . $stmt->error . "</div>";
                error_log("Contact form submission DB error: " . $stmt->error);
            }
            $stmt->close();
        } else {
            $form_message = "<div class=\"alert alert-danger\">Error preparing your message submission. Please try again. Error: " . $conn->error . "</div>";
            error_log("Contact form prepare DB error: " . $conn->error);
        }
    }
}
?>

<!-- Hero section with Arcteryx logo shadow -->
<div class="py-5 position-relative">
    <div class="position-absolute w-100 h-100 top-0 start-0 overflow-hidden" style="z-index: -1; opacity: 0.05;">
        <img src="assets/images/arcteryx-logo.png" alt="Arcteryx Logo" class="position-absolute top-50 start-50 translate-middle" style="min-width: 80%; min-height: 80%; object-fit: contain;">
    </div>
    
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Get In Touch</h6>
            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($page_title); ?></h1>
            <div class="section-divider mx-auto my-3"></div>
            <p class="lead">We're here to help with any questions about our products or services.</p>
        </div>
        
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm border-0 rounded-3 mb-5">
                    <div class="card-body p-4 p-md-5">
                        <?php if (!empty($form_message)) { echo $form_message; } ?>
                        <?php if (!$form_submitted_successfully): ?>
                            <form action="contact.php" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary auth-btn w-100">Send Message</button>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                                <h4 class="mt-3">Message Sent Successfully!</h4>
                                <p class="mb-4">We'll get back to you as soon as possible.</p>
                                <a href="index.php" class="btn btn-outline-primary">Return to Homepage</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4 g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-geo-alt-fill text-primary mb-3" style="font-size: 2rem;"></i>
                        <h4>Our Address</h4>
                        <p class="mb-0">123 Main Street, City, Philippines</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-envelope-fill text-primary mb-3" style="font-size: 2rem;"></i>
                        <h4>Email Us</h4>
                        <p class="mb-0">Arcteryx@ph.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-telephone-fill text-primary mb-3" style="font-size: 2rem;"></i>
                        <h4>Call Us</h4>
                        <p class="mb-0">+63 (123) 456-789</p>
                        <p class="small text-muted mt-2">Monday to Friday, 9:00 AM to 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map section (optional) -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.802548850001!2d121.04882931744384!3d14.553740589828378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8efd99aad53%3A0xb64b39847a866fde!2sMakati%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1651234567890!5m2!1sen!2sph" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>

