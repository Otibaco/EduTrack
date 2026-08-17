<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduTrack — Student Management System</title>

    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
</head>

<body>

<!-- =========================
     NAVBAR
========================= -->

<header class="navbar">

    <div class="container nav-inner">

        <a href="index.php" class="logo">
            <span class="logo-icon">E</span>

            <span class="logo-text">
                Edu<span>Track</span>
            </span>
        </a>

        <nav class="nav-links">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="#overview">Overview</a>
            <a href="about-us.php">About</a>
        </nav>

        <div class="nav-actions">
            <a href="signup.php" class="login-link">Sign in</a>

            <a href="students.php" class="btn btn-primary">
                Open Dashboard
                <span>→</span>
            </a>
        </div>

    </div>

</header>


<!-- =========================
     HERO
========================= -->

<main>

<section class="hero" id="home">

    <div class="hero-glow hero-glow-one"></div>
    <div class="hero-glow hero-glow-two"></div>

    <div class="container hero-grid">

        <div class="hero-content">

            <div class="eyebrow">
                <span class="eyebrow-dot"></span>
                Student Management System
            </div>

            <h1>
                Everything you need to
                <span>manage friends.</span>
            </h1>

            <p>
                EduTrack gives schools and educators a simple,
                organized way to manage student records,
                track information, and keep everything in one place.
            </p>

            <div class="hero-actions">

                <a href="students.php" class="btn btn-primary btn-large">
                    Get Started
                    <span>→</span>
                </a>

                <a href="#features" class="btn btn-secondary btn-large">
                    Explore Features
                </a>

            </div>

            <div class="hero-trust">

                <div class="avatar-stack">
                    <span>JD</span>
                    <span>AM</span>
                    <span>SK</span>
                    <span>+</span>
                </div>

                <div>
                    <strong>Simple & organized</strong>
                    <small>Built for modern classrooms</small>
                </div>

            </div>

        </div>


        <!-- Dashboard Preview -->

        <div class="dashboard-preview">

            <div class="dashboard-window">

                <div class="window-header">

                    <div class="window-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <span class="window-title">
                        EduTrack Dashboard
                    </span>

                </div>


                <div class="preview-body">

                    <div class="preview-sidebar">

                        <div class="preview-brand">
                            <span>E</span>
                        </div>

                        <div class="preview-menu active"></div>
                        <div class="preview-menu"></div>
                        <div class="preview-menu"></div>
                        <div class="preview-menu"></div>
                        <div class="preview-menu"></div>

                    </div>


                    <div class="preview-content">

                        <div class="preview-top">

                            <div>
                                <small>Good morning</small>
                                <strong>Dashboard</strong>
                            </div>

                            <div class="preview-user"></div>

                        </div>


                        <div class="preview-stats">

                            <div class="mini-stat">
                                <span>Total Students</span>
                                <strong>248</strong>
                                <small>↑ 12% this month</small>
                            </div>

                            <div class="mini-stat">
                                <span>Active Students</span>
                                <strong>231</strong>
                                <small>↑ 8% this month</small>
                            </div>

                        </div>


                        <div class="preview-table">

                            <div class="table-heading">
                                <span>Recent Students</span>
                                <span>View all</span>
                            </div>

                            <div class="student-row">
                                <span class="student-avatar">AM</span>

                                <div>
                                    <strong>Amaka Michael</strong>
                                    <small>Computer Science</small>
                                </div>

                                <span class="student-status">
                                    Active
                                </span>
                            </div>

                            <div class="student-row">
                                <span class="student-avatar">DO</span>

                                <div>
                                    <strong>David Okafor</strong>
                                    <small>Software Engineering</small>
                                </div>

                                <span class="student-status">
                                    Active
                                </span>
                            </div>

                            <div class="student-row">
                                <span class="student-avatar">CN</span>

                                <div>
                                    <strong>Chisom Nwosu</strong>
                                    <small>Information Technology</small>
                                </div>

                                <span class="student-status">
                                    Active
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     STATS
========================= -->

<section class="stats-section">

    <div class="container stats-grid">

        <div class="stat-item">
            <strong>250+</strong>
            <span>Student Records</span>
        </div>

        <div class="stat-item">
            <strong>12</strong>
            <span>Departments</span>
        </div>

        <div class="stat-item">
            <strong>99%</strong>
            <span>Data Organized</span>
        </div>

        <div class="stat-item">
            <strong>24/7</strong>
            <span>Access</span>
        </div>

    </div>

</section>


<!-- =========================
     FEATURES
========================= -->

<section class="section" id="features">

    <div class="container">

        <div class="section-heading">

            <div>
                <span class="section-label">FEATURES</span>

                <h2>
                    Everything in one
                    <span>place.</span>
                </h2>
            </div>

            <p>
                Manage your student information with tools
                designed to keep your workflow simple and organized.
            </p>

        </div>


        <div class="features-grid">

            <article class="feature-card feature-large">

                <div class="feature-icon">01</div>

                <div>
                    <h3>Student Records</h3>

                    <p>
                        Create and manage complete student profiles
                        including names, contact information,
                        departments and other important records.
                    </p>
                </div>

                <a href="students.php" class="feature-link">
                    Manage records →
                </a>

            </article>


            <article class="feature-card">

                <div class="feature-icon">02</div>

                <h3>Quick Search</h3>

                <p>
                    Find student records quickly without
                    searching through endless paperwork.
                </p>

                <a href="students.php" class="feature-link">
                    Explore →
                </a>

            </article>


            <article class="feature-card">

                <div class="feature-icon">03</div>

                <h3>Easy Updates</h3>

                <p>
                    Update student information whenever
                    details change.
                </p>

                <a href="students.php" class="feature-link">
                    Explore →
                </a>

            </article>


            <article class="feature-card">

                <div class="feature-icon">04</div>

                <h3>Secure Storage</h3>

                <p>
                    Keep your records structured and stored
                    inside a centralized database.
                </p>

                <a href="#about" class="feature-link">
                    Learn more →
                </a>

            </article>


            <article class="feature-card">

                <div class="feature-icon">05</div>

                <h3>Simple Workflow</h3>

                <p>
                    Add, view, edit and delete records
                    from one intuitive interface.
                </p>

                <a href="students.php" class="feature-link">
                    Open dashboard →
                </a>

            </article>

        </div>

    </div>

</section>


<!-- =========================
     OVERVIEW
========================= -->

<section class="overview-section" id="overview">

    <div class="container overview-grid">

        <div class="overview-visual">

            <div class="visual-card">

                <div class="visual-header">
                    <span>Student Overview</span>
                    <span class="visual-menu">•••</span>
                </div>

                <div class="chart-area">

                    <div class="chart-number">
                        <small>Total Students</small>
                        <strong>248</strong>
                    </div>

                    <div class="fake-chart">
                        <span style="height: 35%"></span>
                        <span style="height: 50%"></span>
                        <span style="height: 42%"></span>
                        <span style="height: 68%"></span>
                        <span style="height: 58%"></span>
                        <span style="height: 82%"></span>
                        <span style="height: 94%"></span>
                    </div>

                </div>

            </div>


            <div class="floating-card">

                <span class="check-icon">✓</span>

                <div>
                    <strong>Record Updated</strong>
                    <small>Just now</small>
                </div>

            </div>

        </div>


        <div class="overview-content">

            <span class="section-label">BUILT FOR SIMPLICITY</span>

            <h2>
                Less paperwork.
                <span>More control.</span>
            </h2>

            <p>
                EduTrack replaces scattered student information
                with a centralized digital system that is easy
                to understand and operate.
            </p>


            <div class="check-list">

                <div>
                    <span>✓</span>
                    <p>Centralized student database</p>
                </div>

                <div>
                    <span>✓</span>
                    <p>Fast record management</p>
                </div>

                <div>
                    <span>✓</span>
                    <p>Clean and responsive interface</p>
                </div>

                <div>
                    <span>✓</span>
                    <p>Simple CRUD workflow</p>
                </div>

            </div>

            <a href="students.php" class="btn btn-primary">
                View Students →
            </a>

        </div>

    </div>

</section>


<!-- =========================
     HOW IT WORKS
========================= -->

<section class="section workflow-section">

    <div class="container">

        <div class="center-heading">

            <span class="section-label">HOW IT WORKS</span>

            <h2>
                Manage records in
                <span>three steps.</span>
            </h2>

            <p>
                A simple workflow designed for speed and clarity.
            </p>

        </div>


        <div class="workflow-grid">

            <div class="workflow-item">

                <span class="workflow-number">01</span>

                <h3>Add</h3>

                <p>
                    Add a new student and enter their
                    information into the system.
                </p>

            </div>


            <div class="workflow-line"></div>


            <div class="workflow-item">

                <span class="workflow-number">02</span>

                <h3>Manage</h3>

                <p>
                    View and search through your
                    student records whenever needed.
                </p>

            </div>


            <div class="workflow-line"></div>


            <div class="workflow-item">

                <span class="workflow-number">03</span>

                <h3>Update</h3>

                <p>
                    Edit or remove records to keep
                    your database accurate.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     ABOUT
========================= -->

<section class="about-section" id="about">

    <div class="container about-card">

        <div>

            <span class="section-label">ABOUT EDUTRACK</span>

            <h2>
                A smarter way to
                <span>manage students.</span>
            </h2>

        </div>

        <div>

            <p>
                EduTrack is a student management application
                created to demonstrate how modern web technologies
                can be used to build a practical CRUD system.
            </p>

            <p>
                Built with HTML, CSS, JavaScript, PHP and SQL,
                the platform provides a clean foundation for
                managing student information.
            </p>

        </div>

    </div>

</section>


<!-- =========================
     CTA
========================= -->

<section class="cta-section">

    <div class="container">

        <div class="cta-card">

            <div class="cta-glow"></div>

            <span class="section-label">READY TO START?</span>

            <h2>
                Your student records,
                <span>organized.</span>
            </h2>

            <p>
                Start managing your students from one simple dashboard.
            </p>

            <a href="students.php" class="btn btn-light btn-large">
                Open EduTrack
                <span>→</span>
            </a>

        </div>

    </div>

</section>

</main>


<!-- =========================
     FOOTER
========================= -->

<footer class="footer">

    <div class="container footer-top">

        <div class="footer-brand">

            <a href="index.php" class="logo">
                <span class="logo-icon">E</span>

                <span class="logo-text">
                    Edu<span>Track</span>
                </span>
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
            <a href="#features">Features</a>

        </div>


        <div class="footer-column">

            <h4>Company</h4>

            <a href="#about">About</a>
            <a href="#overview">Overview</a>
            <a href="#contact">Contact</a>

        </div>


        <div class="footer-column">

            <h4>Account</h4>

            <a href="login.php">Sign In</a>
            <a href="signup.php">Register</a>
            <a href="students.php">Dashboard</a>

        </div>

    </div>


    <div class="container footer-bottom">

        <span>
            © 2026 EduTrack. All rights reserved.
        </span>

        <span>
            Student Management System
        </span>

    </div>

</footer>


</body>
</html>