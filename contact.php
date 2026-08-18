<?php
// contact.php - Contact Us Page
// =========================================================
// Handle form submission (optional - for demo purposes)
// =========================================================

$form_submitted = false;
$form_error = false;
$form_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // In production, send email here
        // For demo, just show success message
        $form_submitted = true;
        $form_message = "Thank you for your message! We'll get back to you within 24 hours.";
    } else {
        $form_error = true;
        $form_message = "Please fill in all fields.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

<link rel="stylesheet" href="./assets/style/contact.css">
</head>

<body>

<!-- =========================================================
     NAVBAR
========================================================= -->

<header class="navbar">

    <div class="container nav-inner">

        <a href="index.php" class="logo">
            <span class="logo-icon">E</span>
            <span class="logo-text">Edu<span>Track</span></span>
        </a>

        <nav class="nav-links">
            <a href="index.php#home">Home</a>
            <a href="index.php#features">Features</a>
            <a href="index.php#overview">Overview</a>
            <a href="about-us.php">About</a>
            <a href="contact.php" style="color: white;">Contact</a>
        </nav>

        <div class="nav-actions">
            <a href="login.php" class="login-link">Sign in</a>
            <a href="dashboard.php" class="btn btn-primary">
                Open Dashboard
                <span>→</span>
            </a>
        </div>

    </div>

</header>

<!-- =========================================================
     CONTACT HERO
========================================================= -->

<section class="contact-hero">

    <div class="glow glow-one"></div>
    <div class="glow glow-two"></div>

    <div class="container">

        <span class="section-label">GET IN TOUCH</span>

        <h1>We'd love to <span>hear from you.</span></h1>

        <p>
            Have questions, feedback, or suggestions? Reach out to us —
            we're here to help make EduTrack better for everyone.
        </p>

    </div>

</section>

<!-- =========================================================
     CONTENT
========================================================= -->

<main>

    <div class="container">

        <div class="contact-grid">

            <!-- =========================================================
                 LEFT: CONTACT INFO
            ========================================================= -->
            <section class="contact-info">

                <div>
                    <span class="section-label">CONTACT INFORMATION</span>
                    <h2>Let's <span>connect.</span></h2>
                    <p>
                        Whether you need support, have a question about our
                        platform, or just want to share your thoughts —
                        we're all ears.
                    </p>
                </div>

                <div class="info-items">

                    <div class="info-item">
                        <span class="icon">📧</span>
                        <div class="content">
                            <strong>Email</strong>
                            <span>
                                <a href="mailto:support@edutrack.com">support@edutrack.com</a>
                            </span>
                            <span style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">
                                We respond within 24 hours
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="icon">📱</span>
                        <div class="content">
                            <strong>Phone</strong>
                            <span>
                                <a href="tel:+2348000000000">+234 800 000 0000</a>
                            </span>
                            <span style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">
                                Mon–Fri, 9 AM – 6 PM WAT
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="icon">📍</span>
                        <div class="content">
                            <strong>Office</strong>
                            <span>Lagos, Nigeria</span>
                            <span style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">
                                Remote-first team
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="icon">🕐</span>
                        <div class="content">
                            <strong>Support Hours</strong>
                            <span>24/7 Email Support</span>
                            <span style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">
                                Live chat coming soon
                            </span>
                        </div>
                    </div>

                </div>

                <div>
                    <strong style="font-size: 14px; color: var(--text);">Follow us</strong>
                    <div class="social-links">
                        <a href="#" aria-label="Twitter">𝕏</a>
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="GitHub">⌘</a>
                        <a href="#" aria-label="YouTube">▶</a>
                    </div>
                </div>

            </section>

            <!-- =========================================================
                 RIGHT: CONTACT FORM
            ========================================================= -->
            <section class="contact-form-wrapper">

                <h3>📩 Send us a message</h3>
                <p class="subtitle">Fill in the form below and we'll get back to you shortly.</p>

                <!-- FORM MESSAGES -->
                <?php if ($form_submitted): ?>
                    <div class="form-message success">
                        <span>✓</span>
                        <?php echo htmlspecialchars($form_message); ?>
                        <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
                    </div>
                <?php elseif ($form_error): ?>
                    <div class="form-message error">
                        <span>!</span>
                        <?php echo htmlspecialchars($form_message); ?>
                        <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
                    </div>
                <?php endif; ?>

                <!-- FORM -->
                <form method="POST" action="contact.php" id="contactForm" novalidate>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <span class="input-icon">👤</span>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Samuel Molokwu"
                                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <span class="input-icon">@</span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="you@example.com"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon">📌</span>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                placeholder="What's this about?"
                                value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Message <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <span class="input-icon" style="top: 16px; transform: none;">✏️</span>
                            <textarea
                                id="message"
                                name="message"
                                placeholder="Tell us how we can help you..."
                                required
                            ><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span id="btnText">Send Message</span>
                            <span class="button-arrow">→</span>
                        </button>
                    </div>

                </form>

            </section>

        </div>

        <!-- =========================================================
             MAP PLACEHOLDER
        ========================================================= -->
        <div class="map-placeholder">
            <span class="map-icon">🗺️</span>
            <p>📍 Lagos, Nigeria — <span style="color: var(--text-soft);">We're remote-first!</span></p>
            <span style="font-size: 12px; color: var(--text-muted);">
                Interactive map integration coming soon
            </span>
        </div>

    </div>

</main>

<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="footer">

    <div class="container footer-top">

        <div class="footer-brand">

            <a href="index.php" class="logo">
                <span class="logo-icon">E</span>
                <span class="logo-text">Edu<span>Track</span></span>
            </a>

            <p>
                Simple student management for
                modern classrooms.
            </p>

        </div>

        <div class="footer-column">

            <h4>Platform</h4>

            <a href="students.php">Students</a>
            <a href="add-student.php">Add Student</a>
            <a href="index.php#features">Features</a>

        </div>

        <div class="footer-column">

            <h4>Company</h4>

            <a href="about.php">About</a>
            <a href="index.php#overview">Overview</a>
            <a href="contact.php" style="color: var(--primary-light);">Contact</a>

        </div>

        <div class="footer-column">

            <h4>Legal</h4>

            <a href="terms.php">Terms of Service</a>
            <a href="privacy.php">Privacy Policy</a>
            <a href="#">Cookie Policy</a>

        </div>

    </div>

    <div class="container footer-bottom">

        <span>© 2026 EduTrack. All rights reserved.</span>

        <span>Student Management System</span>

    </div>

</footer>

<!-- =========================================================
     SCRIPT – Form Submit Feedback
========================================================= -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');

        if (form) {
            form.addEventListener('submit', function(e) {
                // Show loading state on submit
                submitBtn.disabled = true;
                btnText.textContent = 'Sending...';
                submitBtn.querySelector('.button-arrow').textContent = '⏳';

                // Re-enable after a moment (in case of errors)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    btnText.textContent = 'Send Message';
                    submitBtn.querySelector('.button-arrow').textContent = '→';
                }, 3000);
            });
        }

        // Auto-close message banners after 5 seconds
        const messages = document.querySelectorAll('.form-message');
        messages.forEach(msg => {
            setTimeout(() => {
                msg.style.opacity = '0';
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 300);
            }, 5000);
        });

        // Close button for messages
        document.querySelectorAll('.form-message .close-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });

    });
</script>

</body>
</html>