<?php
// about.php - Professional version
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Us — EduTrack</title>

    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/about.css">

    
</head>

<body>

<!-- =========================
     NAVBAR
========================= -->

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
            <a href="about.php" style="color: white;">About</a>
        </nav>
        <div class="nav-actions">
            <a href="login.php" class="login-link">Sign in</a>
            <a href="students.php" class="btn btn-primary">
                Open Dashboard <span>→</span>
            </a>
        </div>
    </div>
</header>

<!-- =========================
     MAIN
========================= -->

<main>

    <!-- =========================
         ABOUT HERO
    ========================= -->

    <section class="hero" style="min-height: 520px; padding: 80px 0;">
        <div class="hero-glow hero-glow-one"></div>
        <div class="hero-glow hero-glow-two"></div>

        <div class="container">
            <div class="about-hero-wrapper">

                <div class="trust-badge">
                    <span class="dot"></span>
                    Trusted by 50+ institutions worldwide
                </div>

                <h1>
                    Crafting the future of
                    <span>education technology.</span>
                </h1>

                <p>
                    EduTrack is more than just software — it's a movement
                    to bring clarity, efficiency, and joy back into
                    educational administration. Built by educators,
                    for educators.
                </p>

                <a href="students.php" class="btn btn-primary btn-large">
                    Explore the System <span>→</span>
                </a>

            </div>
        </div>
    </section>

    <!-- =========================
         IMPACT STATS (Animated)
    ========================= -->

    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 10px;">
                <span class="section-label">OUR IMPACT</span>
            </div>
            <div class="impact-grid" id="impactGrid">
                <div class="impact-item">
                    <span class="number" data-count="50">0</span>
                    <span class="label">Institutions</span>
                </div>
                <div class="impact-item">
                    <span class="number" data-count="12000">0</span>
                    <span class="label">Students Managed</span>
                </div>
                <div class="impact-item">
                    <span class="number" data-count="98">0</span>
                    <span class="label">% Satisfaction Rate</span>
                </div>
                <div class="impact-item">
                    <span class="number" data-count="4">0</span>
                    <span class="label">Years of Innovation</span>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         MISSION & VISION
    ========================= -->

    <section class="section" style="padding-top: 0; background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 10px;">
                <span class="section-label">OUR PURPOSE</span>
                <h2 style="font-family: var(--heading-font); font-size: clamp(32px, 3.5vw, 48px);">
                    Why we built <span style="color: var(--primary-light);">EduTrack</span>
                </h2>
            </div>

            <div class="mission-grid">
                <div class="mission-card">
                    <span class="icon">🎯</span>
                    <h3>Our Mission</h3>
                    <p>
                        To empower schools and educators with a digital
                        platform that simplifies administrative tasks,
                        reduces paperwork, and gives them more time to
                        focus on what truly matters — their students.
                    </p>
                </div>
                <div class="mission-card">
                    <span class="icon">👁️</span>
                    <h3>Our Vision</h3>
                    <p>
                        To become the go-to student management solution
                        for modern classrooms across the globe, setting
                        a new standard for how educational data is
                        organized, accessed, and utilized.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         TIMELINE
    ========================= -->

    <section class="section">
        <div class="container">
            <div style="text-align: center; max-width: 700px; margin: 0 auto 20px;">
                <span class="section-label">OUR JOURNEY</span>
                <h2 style="font-family: var(--heading-font); font-size: clamp(32px, 3.5vw, 48px);">
                    The <span style="color: var(--primary-light);">EduTrack story.</span>
                </h2>
                <p style="color: var(--text-soft); margin-top: 10px;">
                    From a simple idea to a powerful platform — here's how we got here.
                </p>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="year">2022</div>
                    <div class="content">
                        <h4>🌟 The Idea</h4>
                        <p>EduTrack was conceived in a university classroom, born from the frustration of scattered student records and endless spreadsheets.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="year">2023</div>
                    <div class="content">
                        <h4>⚙️ First Prototype</h4>
                        <p>Our development team built the first working version, focusing on core CRUD operations and a clean, intuitive interface.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="year">2024</div>
                    <div class="content">
                        <h4>🚀 Beta Launch</h4>
                        <p>EduTrack went live with a select group of schools, gathering real-world feedback that shaped the platform's evolution.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="year">2025</div>
                    <div class="content">
                        <h4>🏆 Full Release</h4>
                        <p>Today, EduTrack empowers thousands of educators worldwide with a robust, secure, and beautifully designed management system.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         CORE VALUES
    ========================= -->

    <section class="section" style="background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
        <div class="container">
            <div style="text-align: center; max-width: 700px; margin: 0 auto 60px;">
                <span class="section-label">WHAT WE STAND FOR</span>
                <h2 style="font-family: var(--heading-font); font-size: clamp(32px, 3.5vw, 48px);">
                    Built on <span style="color: var(--primary-light);">four core values.</span>
                </h2>
                <p style="color: var(--text-soft); margin-top: 12px;">
                    These principles guide every decision we make and every line of code we write.
                </p>
            </div>

            <div class="features-grid">
                <article class="feature-card">
                    <div class="feature-icon">01</div>
                    <h3>Simplicity First</h3>
                    <p>Complex systems create confusion. We strip away the unnecessary to leave only what matters.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">02</div>
                    <h3>Security & Privacy</h3>
                    <p>Student data is sensitive. We treat it with the utmost care and follow strict security standards.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">03</div>
                    <h3>Continuous Innovation</h3>
                    <p>We never stop improving. Feedback from educators directly shapes our roadmap and updates.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">04</div>
                    <h3>Community Driven</h3>
                    <p>EduTrack is built for the education community, by developers who care deeply about classroom needs.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- =========================
         MEET THE TEAM
    ========================= -->

    <section class="section">
        <div class="container">
            <div style="text-align: center; max-width: 700px; margin: 0 auto 20px;">
                <span class="section-label">BEHIND THE CODE</span>
                <h2 style="font-family: var(--heading-font); font-size: clamp(32px, 3.5vw, 48px);">
                    Meet the <span style="color: var(--primary-light);">team.</span>
                </h2>
                <p style="color: var(--text-soft); margin-top: 10px;">
                    Passionate individuals dedicated to transforming education through technology.
                </p>
            </div>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">AK</div>
                    <h4>Amara Kalu</h4>
                    <span class="role">Founder & CEO</span>
                    <div class="team-socials">
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="Twitter">𝕏</a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">BO</div>
                    <h4>Boma Ogbonna</h4>
                    <span class="role">Lead Developer</span>
                    <div class="team-socials">
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="GitHub">⌘</a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">CE</div>
                    <h4>Chidi Eze</h4>
                    <span class="role">UI/UX Designer</span>
                    <div class="team-socials">
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="Dribbble">⚽</a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">DI</div>
                    <h4>Dara Ibe</h4>
                    <span class="role">Product Manager</span>
                    <div class="team-socials">
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="Twitter">𝕏</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         TECH STACK (Pills)
    ========================= -->

    <section class="section" style="background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 80px 0;">
        <div class="container">
            <div style="text-align: center; max-width: 600px; margin: 0 auto;">
                <span class="section-label">TECHNOLOGY STACK</span>
                <h2 style="font-family: var(--heading-font); font-size: clamp(28px, 3vw, 40px);">
                    Built with <span style="color: var(--primary-light);">modern tools.</span>
                </h2>
                <p style="color: var(--text-soft); margin-top: 10px; margin-bottom: 10px;">
                    A full-stack foundation crafted for speed, security, and scalability.
                </p>
                <div class="tech-pills-wrapper">
                    <span class="tech-pill">⚡ PHP 8</span>
                    <span class="tech-pill">🐬 MySQL</span>
                    <span class="tech-pill">🌐 HTML5</span>
                    <span class="tech-pill">🎨 CSS3</span>
                    <span class="tech-pill">⚙️ JavaScript</span>
                    <span class="tech-pill">🔒 SSL Security</span>
                    <span class="tech-pill">📱 Responsive</span>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         FINAL CTA
    ========================= -->

    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="cta-glow"></div>
                <span class="section-label">READY TO SEE IT IN ACTION?</span>
                <h2>
                    Experience the <span>EduTrack difference.</span>
                </h2>
                <p>
                    Dive into the dashboard and explore how we manage
                    student records with elegance and ease.
                </p>
                <a href="students.php" class="btn btn-light btn-large">
                    Open Dashboard <span>→</span>
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
                <span class="logo-text">Edu<span>Track</span></span>
            </a>
            <p>Simple student management for modern classrooms.</p>
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
            <a href="index.php#contact">Contact</a>
        </div>
        <div class="footer-column">
            <h4>Account</h4>
            <a href="login.php">Sign In</a>
            <a href="register.php">Register</a>
            <a href="students.php">Dashboard</a>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© 2026 EduTrack. All rights reserved.</span>
        <span>Student Management System</span>
    </div>
</footer>

<!-- =========================
     SCRIPT – Number Counter Animation
========================= -->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const counters = document.querySelectorAll('.number[data-count]');

        if (!counters.length) return;

        // Use Intersection Observer to trigger counting when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'), 10);
                    const duration = 1500; // ms
                    const startTime = performance.now();

                    // Add '+' suffix if target is 50 (institutions)
                    const suffix = target === 50 ? '+' : (target === 98 ? '%' : '');

                    function updateCounter(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        // Ease-out cubic
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(eased * target);

                        el.textContent = current + suffix;

                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            el.textContent = target + suffix;
                        }
                    }

                    requestAnimationFrame(updateCounter);

                    // Stop observing once triggered
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach(counter => observer.observe(counter));

    });
</script>

</body>
</html>