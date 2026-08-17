<?php
// dashboard.php - Main Control Panel
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="./assets/style/dashboard.css">
</head>

<body>

<!-- =========================================================
     SIDEBAR OVERLAY (Mobile)
========================================================= -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- =========================================================
     SIDEBAR
========================================================= -->
<aside class="dashboard-sidebar" id="dashboardSidebar">

    <div class="sidebar-brand">
        <span class="logo-icon">E</span>
        <span class="logo-text">Edu<span>Track</span></span>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php" class="active">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="students.php">
            <span class="nav-icon">👥</span> Students
        </a>
        <a href="add-student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
     
        <a href="index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Back to Home
        </a>
        <a href="logout.php" style="color: #ff6b6b;">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="avatar">SM</div>
        <div class="user-info">
            <strong>Samuel Molokwu</strong>
            <small>Administrator</small>
        </div>
    </div>

</aside>

<!-- =========================================================
     MAIN CONTENT
========================================================= -->
<main class="dashboard-main">

    <!-- Top Bar -->
    <header class="dashboard-topbar">
        <div class="greeting">
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle sidebar">☰</button>
            <h1>Welcome back, <span>Samuel</span> 👋</h1>
            <p>Here's what's happening with your students today.</p>
        </div>
        <div class="topbar-actions">
            <input type="text" class="search-box" placeholder="Search students...">
            <div class="topbar-avatar">SM</div>
        </div>
    </header>

    <!-- Stats Row -->
    <section class="stats-dashboard-grid">
        <div class="stat-dashboard-card">
            <span class="stat-label">Total Students</span>
            <div class="stat-number">256</div>
            <span class="stat-trend">↑ 12% this month</span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Active Students</span>
            <div class="stat-number">231</div>
            <span class="stat-trend">↑ 8% this month</span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Inactive / Graduated</span>
            <div class="stat-number">25</div>
            <span class="stat-trend down">↓ 2% this month</span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Departments</span>
            <div class="stat-number">12</div>
            <span class="stat-trend">↑ 1 new this year</span>
        </div>
    </section>

    <!-- Charts Row -->
    <section class="charts-row">

        <!-- Bar Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Monthly Enrollments</h3>
                <span>2026</span>
            </div>
            <div class="bar-chart">
                <div class="bar-item"><div class="bar" style="height: 28%;"></div><span class="bar-label">Jan</span></div>
                <div class="bar-item"><div class="bar" style="height: 45%;"></div><span class="bar-label">Feb</span></div>
                <div class="bar-item"><div class="bar" style="height: 38%;"></div><span class="bar-label">Mar</span></div>
                <div class="bar-item"><div class="bar" style="height: 62%;"></div><span class="bar-label">Apr</span></div>
                <div class="bar-item"><div class="bar" style="height: 55%;"></div><span class="bar-label">May</span></div>
                <div class="bar-item"><div class="bar" style="height: 78%;"></div><span class="bar-label">Jun</span></div>
                <div class="bar-item"><div class="bar" style="height: 92%;"></div><span class="bar-label">Jul</span></div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Department Distribution</h3>
                <span>By program</span>
            </div>
            <div class="donut-wrapper">
                <div class="donut"></div>
                <div class="donut-legend">
                    <span><span class="dot" style="background: var(--primary);"></span> CS (40%)</span>
                    <span><span class="dot" style="background: #927dff;"></span> SE (25%)</span>
                    <span><span class="dot" style="background: var(--success);"></span> IT (17%)</span>
                    <span><span class="dot" style="background: var(--text-muted);"></span> Other (18%)</span>
                </div>
            </div>
        </div>

    </section>

    <!-- Recent Students Table -->
    <section class="table-section">
        <div class="table-header">
            <h3>📋 Recent Students</h3>
            <a href="students.php">View all →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Department</th>
                    <th>ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="table-avatar">AM</span> Amaka Michael
                    </td>
                    <td>Computer Science</td>
                    <td>CS-2024-012</td>
                    <td><span class="status-badge">Active</span></td>
                </tr>
                <tr>
                    <td>
                        <span class="table-avatar">DO</span> David Okafor
                    </td>
                    <td>Software Engineering</td>
                    <td>SE-2024-045</td>
                    <td><span class="status-badge">Active</span></td>
                </tr>
                <tr>
                    <td>
                        <span class="table-avatar">CN</span> Chisom Nwosu
                    </td>
                    <td>Information Technology</td>
                    <td>IT-2024-078</td>
                    <td><span class="status-badge">Active</span></td>
                </tr>
                <tr>
                    <td>
                        <span class="table-avatar">TE</span> Tunde Eze
                    </td>
                    <td>Computer Science</td>
                    <td>CS-2024-103</td>
                    <td><span class="status-badge inactive">Inactive</span></td>
                </tr>
                <tr>
                    <td>
                        <span class="table-avatar">FI</span> Fatima Ibrahim
                    </td>
                    <td>Software Engineering</td>
                    <td>SE-2024-156</td>
                    <td><span class="status-badge">Active</span></td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="add-student.php" class="btn btn-primary">➕ Add New Student</a>
        <a href="students.php" class="btn btn-secondary">👥 View All Students</a>
        <a href="#" class="btn btn-secondary">📄 Generate Report</a>
    </div>

</main>

<!-- =========================================================
     MOBILE SIDEBAR TOGGLE SCRIPT
========================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const sidebar = document.getElementById('dashboardSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('mobileToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        // Auto-close on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 820 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

    });
</script>

</body>
</html>