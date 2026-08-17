<?php
// report.php - Generate Student Reports
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Dashboard Layout Styles (separate file, just like yours) -->
    <link rel="stylesheet" href="./assets/style/dashboard.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
<link rel="stylesheet" href="./assets/style/dash.css">
    <!-- Report-specific styles (kept inline since they're unique to this page) -->
    <style>
   
    </style>
</head>

<body>

<!-- =========================================================
     SIDEBAR OVERLAY (Mobile)
========================================================= -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- =========================================================
     SIDEBAR (Matches your updated dashboard.php EXACTLY)
========================================================= -->
<aside class="dashboard-sidebar" id="dashboardSidebar">

    <div class="sidebar-brand">
        <span class="logo-icon">E</span>
        <span class="logo-text">Edu<span>Track</span></span>
    </div>

    <nav class="sidebar-nav">
        <!-- FIXED: Removed the stray ./ and backtick that was in your dashboard -->
        <a href="dashboard.php">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="students.php">
            <span class="nav-icon">👥</span> Students
        </a>
        <a href="add-student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
        <!-- Report link is ACTIVE on this page -->
        <a href="report.php" class="active">
            <span class="nav-icon">📄</span> Reports
        </a>
        <a href="index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Back to home
        </a>
        <a href="login.php" style="color: #ff6b6b;">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="avatar">S</div>
        <div class="user-info">
            <strong>Student</strong>
            <small>Administrator</small>
        </div>
    </div>

</aside>

<!-- =========================================================
     MAIN CONTENT
========================================================= -->
<main class="dashboard-main">

    <!-- Top Bar (Matches your updated dashboard EXACTLY) -->
    <header class="dashboard-topbar">
        <div class="greeting">
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle sidebar">☰</button>
            <h1>📄 <span>Generate Report</span></h1>
            <!-- Removed the subtitle paragraph to match your dashboard -->
        </div>
        <div class="topbar-actions">
            <input type="text" class="search-box" placeholder="Search students...">
            <div class="topbar-avatar">S</div>
        </div>
    </header>

    <!-- =========================
         FILTER SECTION
    ========================= -->
    <section class="report-card">
        <div class="card-title">🔍 Filter Criteria</div>

        <form id="reportForm" onsubmit="event.preventDefault(); generateReport();">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="department">Department</label>
                    <select id="department">
                        <option value="all">All Departments</option>
                        <option value="cs">Computer Science</option>
                        <option value="se">Software Engineering</option>
                        <option value="it">Information Technology</option>
                        <option value="math">Mathematics</option>
                        <option value="physics">Physics</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive / Graduated</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="dateRange">Enrollment Date</label>
                    <input type="month" id="dateRange" value="2026-07">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">🔄 Generate</button>
                    <button type="reset" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
                </div>
            </div>
        </form>
    </section>

    <!-- =========================
         SUMMARY STATS
    ========================= -->
    <div class="report-summary" id="summaryStats">
        <div class="summary-item highlight">
            <strong id="totalCount">48</strong>
            <span>Total Records</span>
        </div>
        <div class="summary-item">
            <strong id="activeCount">42</strong>
            <span>Active</span>
        </div>
        <div class="summary-item">
            <strong id="inactiveCount">6</strong>
            <span>Inactive</span>
        </div>
        <div class="summary-item">
            <strong id="deptCount">4</strong>
            <span>Departments</span>
        </div>
    </div>

    <!-- =========================
         RESULTS TABLE
    ========================= -->
    <section class="report-card">
        <div class="card-title">
            📋 Report Results
            <span style="font-size: 12px; font-weight: 400; color: var(--text-muted); margin-left: 8px;">
                (Last updated: <span id="lastUpdated">Just now</span>)
            </span>
        </div>

        <div class="table-responsive">
            <table class="report-table" id="reportTable">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Student ID</th>
                        <th>Enrolled</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <!-- Sample Data -->
                    <tr>
                        <td><strong>Amaka Michael</strong></td>
                        <td>Computer Science</td>
                        <td>CS-2024-012</td>
                        <td>Jan 2024</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>David Okafor</strong></td>
                        <td>Software Engineering</td>
                        <td>SE-2024-045</td>
                        <td>Feb 2024</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>Chisom Nwosu</strong></td>
                        <td>Information Technology</td>
                        <td>IT-2024-078</td>
                        <td>Mar 2024</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>Tunde Eze</strong></td>
                        <td>Computer Science</td>
                        <td>CS-2024-103</td>
                        <td>Apr 2024</td>
                        <td><span class="status-badge inactive">Inactive</span></td>
                    </tr>
                    <tr>
                        <td><strong>Fatima Ibrahim</strong></td>
                        <td>Software Engineering</td>
                        <td>SE-2024-156</td>
                        <td>May 2024</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>Michael Okafor</strong></td>
                        <td>Mathematics</td>
                        <td>MTH-2024-201</td>
                        <td>Jun 2024</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>Ngozi Adeyemi</strong></td>
                        <td>Physics</td>
                        <td>PHY-2024-234</td>
                        <td>Jul 2024</td>
                        <td><span class="status-badge inactive">Inactive</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Export Actions -->
        <div class="export-actions">
            <button class="btn-export primary-export" onclick="exportCSV()">
                📥 Export as CSV
            </button>
            <button class="btn-export" onclick="exportPDF()">
                📄 Export as PDF
            </button>
            <button class="btn-export" onclick="window.print()">
                🖨️ Print Report
            </button>
            <button class="btn-export" onclick="copyTable()">
                📋 Copy to Clipboard
            </button>
        </div>
    </section>

</main>

<!-- =========================================================
     SCRIPTS
========================================================= -->

<script>
    // =========================================================
    // MOBILE SIDEBAR TOGGLE (Matches your dashboard)
    // =========================================================
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 820 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });
    });

    // =========================================================
    // REPORT GENERATION SIMULATION (UI Demo)
    // =========================================================

    function generateReport() {
        const dept = document.getElementById('department').value;
        const status = document.getElementById('status').value;

        const btn = document.querySelector('.filter-actions .btn-primary');
        btn.textContent = '⏳ Loading...';
        btn.disabled = true;

        setTimeout(() => {
            document.getElementById('lastUpdated').textContent = new Date().toLocaleTimeString();

            let total = 48;
            let active = 42;
            let inactive = 6;

            if (dept !== 'all') {
                total = Math.floor(Math.random() * 20) + 5;
                active = Math.floor(Math.random() * total);
                inactive = total - active;
            }

            if (status === 'active') {
                total = active;
            } else if (status === 'inactive') {
                total = inactive;
            }

            document.getElementById('totalCount').textContent = total;
            document.getElementById('activeCount').textContent = active;
            document.getElementById('inactiveCount').textContent = inactive;
            document.getElementById('deptCount').textContent = dept === 'all' ? '4' : '1';

            const tbody = document.getElementById('reportBody');
            const names = ['Amaka Michael', 'David Okafor', 'Chisom Nwosu', 'Tunde Eze', 'Fatima Ibrahim', 'Michael Okafor', 'Ngozi Adeyemi', 'Chidi Obi', 'Zainab Musa', 'Kofi Mensah'];
            const depts = ['Computer Science', 'Software Engineering', 'Information Technology', 'Mathematics', 'Physics'];
            const statuses = ['Active', 'Active', 'Active', 'Inactive', 'Active', 'Active', 'Inactive', 'Active', 'Active', 'Inactive'];

            let html = '';
            const count = Math.min(total, 7);

            for (let i = 0; i < count; i++) {
                const idx = Math.floor(Math.random() * names.length);
                const name = names[idx];
                const department = depts[Math.floor(Math.random() * depts.length)];
                const studentStatus = statuses[Math.floor(Math.random() * statuses.length)];
                const id = `${department.substring(0, 3).toUpperCase()}-2024-${String(Math.floor(Math.random() * 900) + 100)}`;
                const date = `${Math.floor(Math.random() * 12) + 1}/${Math.floor(Math.random() * 28) + 1}/2024`;

                const badgeClass = studentStatus === 'Active' ? 'status-badge' : 'status-badge inactive';

                html += `
                    <tr>
                        <td><strong>${name}</strong></td>
                        <td>${department}</td>
                        <td>${id}</td>
                        <td>${date}</td>
                        <td><span class="${badgeClass}">${studentStatus}</span></td>
                    </tr>
                `;
            }

            tbody.innerHTML = html;

            btn.textContent = '🔄 Generate';
            btn.disabled = false;

        }, 800);
    }

    function resetFilters() {
        document.getElementById('department').value = 'all';
        document.getElementById('status').value = 'all';
        document.getElementById('dateRange').value = '2026-07';
        generateReport();
    }

    function exportCSV() {
        alert('📥 CSV Export triggered!\n\nIn production, this would download a CSV file containing the filtered student data.');
    }

    function exportPDF() {
        alert('📄 PDF Export triggered!\n\nIn production, this would generate a beautiful PDF report for printing or sharing.');
    }

    function copyTable() {
        const table = document.getElementById('reportTable');
        const range = document.createRange();
        range.selectNode(table);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);

        try {
            document.execCommand('copy');
            alert('📋 Table copied to clipboard!');
        } catch (err) {
            alert('❌ Could not copy. Please select the table manually and press Ctrl+C.');
        }

        window.getSelection().removeAllRanges();
    }

    // Auto-generate report on page load
    document.addEventListener('DOMContentLoaded', () => {
        generateReport();
    });
</script>

</body>
</html>