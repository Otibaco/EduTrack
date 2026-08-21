<?php
// dashboard.php - Main Control Panel with Backend Integration
// =========================================================
// DATABASE CONNECTION
// =========================================================

$host = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// =========================================================
// GET DASHBOARD STATS
// =========================================================

// --- Total Students ---
$total_result = $conn->query("SELECT COUNT(*) as total FROM students");
$total_students = $total_result->fetch_assoc()['total'] ?? 0;

// --- Active Students ---
$active_result = $conn->query("SELECT COUNT(*) as active FROM students WHERE LOWER(status) = 'active'");
$active_students = $active_result->fetch_assoc()['active'] ?? 0;

// --- Inactive / Graduated Students ---
$inactive_result = $conn->query("SELECT COUNT(*) as inactive FROM students WHERE LOWER(status) IN ('inactive', 'graduated')");
$inactive_students = $inactive_result->fetch_assoc()['inactive'] ?? 0;

// --- Unique Departments ---
$dept_result = $conn->query("SELECT COUNT(DISTINCT department) as dept_count FROM students");
$department_count = $dept_result->fetch_assoc()['dept_count'] ?? 0;

// --- Monthly Enrollments (Current Year) ---
$current_year = date('Y');
$monthly_result = $conn->query("
    SELECT MONTH(enrollment_date) as month, COUNT(*) as count 
    FROM students 
    WHERE YEAR(enrollment_date) = $current_year 
    GROUP BY MONTH(enrollment_date)
    ORDER BY month
");

$monthly_data = [];
$month_names = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
for ($i = 1; $i <= 12; $i++) {
    $monthly_data[$i] = 0;
}
while ($row = $monthly_result->fetch_assoc()) {
    $monthly_data[(int)$row['month']] = (int)$row['count'];
}

// Calculate max value for bar chart scaling
$max_monthly = max(array_values($monthly_data)) > 0 ? max(array_values($monthly_data)) : 1;

// --- Department Distribution ---
$dept_dist_result = $conn->query("
    SELECT department, COUNT(*) as count 
    FROM students 
    GROUP BY department 
    ORDER BY count DESC 
    LIMIT 5
");
$department_distribution = [];
while ($row = $dept_dist_result->fetch_assoc()) {
    $department_distribution[] = $row;
}

// Calculate percentages for donut chart
$dept_colors = ['var(--primary)', '#927dff', 'var(--success)', 'var(--text-muted)', '#f39c12'];
$dept_color_map = [];
$dept_index = 0;
foreach ($department_distribution as $dept) {
    $dept_color_map[$dept['department']] = $dept_colors[$dept_index % count($dept_colors)];
    $dept_index++;
}

// Build conic gradient for donut chart
$conic_gradient = '';
$cumulative = 0;
foreach ($department_distribution as $dept) {
    $percentage = ($dept['count'] / $total_students) * 100;
    $conic_gradient .= $dept_color_map[$dept['department']] . ' ' . $cumulative . '% ' . ($cumulative + $percentage) . '%, ';
    $cumulative += $percentage;
}
$conic_gradient = rtrim($conic_gradient, ', ');

// --- Recent Students ---
$recent_result = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 5");
$recent_students = [];
if ($recent_result && $recent_result->num_rows > 0) {
    while ($row = $recent_result->fetch_assoc()) {
        $recent_students[] = $row;
    }
}

// --- Calculate trend percentages (comparing to last month) ---
$last_month = date('m') - 1;
$last_month_year = date('Y');
if ($last_month == 0) {
    $last_month = 12;
    $last_month_year = date('Y') - 1;
}

$current_month_count = $monthly_data[(int)date('m')] ?? 0;
$last_month_count = 0;

// Get last month's count from database
$last_month_result = $conn->query("
    SELECT COUNT(*) as count 
    FROM students 
    WHERE MONTH(enrollment_date) = $last_month AND YEAR(enrollment_date) = $last_month_year
");
if ($last_month_result && $last_month_result->num_rows > 0) {
    $last_month_count = $last_month_result->fetch_assoc()['count'] ?? 0;
}

$trend_percent = 0;
$trend_class = '';
if ($last_month_count > 0) {
    $trend_percent = round((($current_month_count - $last_month_count) / $last_month_count) * 100);
    $trend_class = $trend_percent >= 0 ? '' : 'down';
} else {
    $trend_class = '';
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="../assets/style/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="./dashboard.css">


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
        <a href="../students.php">
            <span class="nav-icon">👥</span> Students
        </a>
        <a href="../report.php">
            <span class="nav-icon">📄</span> Reports
        </a>
        <a href="../Add-Student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
        <a href="../index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Back to Home
        </a>
        <a href="../login.php" style="color: #ff6b6b;">
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
            <input type="text" class="search-box" placeholder="Search students..." id="searchInput" onkeydown="if(event.key==='Enter'){window.location.href='../students.php?search='+encodeURIComponent(this.value)}">
            <div class="topbar-avatar">SM</div>
        </div>
    </header>

    <!-- Stats Row -->
    <section class="stats-dashboard-grid">
        <div class="stat-dashboard-card">
            <span class="stat-label">Total Students</span>
            <div class="stat-number"><?php echo number_format($total_students); ?></div>
            <span class="stat-trend <?php echo $trend_class ?: 'neutral'; ?>">
                <?php if ($trend_percent > 0): ?>↑ <?php echo $trend_percent; ?>% this month
                <?php elseif ($trend_percent < 0): ?>↓ <?php echo abs($trend_percent); ?>% this month
                <?php else: ?>↔ No change this month
                <?php endif; ?>
            </span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Active Students</span>
            <div class="stat-number"><?php echo number_format($active_students); ?></div>
            <span class="stat-trend positive">
                <?php
                $active_percent = $total_students > 0 ? round(($active_students / $total_students) * 100) : 0;
                ?>
                <?php echo $active_percent; ?>% of total
            </span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Inactive / Graduated</span>
            <div class="stat-number"><?php echo number_format($inactive_students); ?></div>
            <span class="stat-trend neutral">
                <?php
                $inactive_percent = $total_students > 0 ? round(($inactive_students / $total_students) * 100) : 0;
                ?>
                <?php echo $inactive_percent; ?>% of total
            </span>
        </div>
        <div class="stat-dashboard-card">
            <span class="stat-label">Departments</span>
            <div class="stat-number"><?php echo number_format($department_count); ?></div>
            <span class="stat-trend neutral">
                Across all programs
            </span>
        </div>
    </section>

    <!-- Charts Row -->
    <section class="charts-row">

        <!-- Bar Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Monthly Enrollments</h3>
                <span><?php echo $current_year; ?></span>
            </div>
            <div class="bar-chart">
                <?php for ($i = 1; $i <= 12; $i++):
                    $height = $max_monthly > 0 ? ($monthly_data[$i] / $max_monthly) * 92 : 4;
                    $height_percent = max(4, $height);
                ?>
                    <div class="bar-item">
                        <div class="bar" style="height: <?php echo $height_percent; ?>%;"></div>
                        <span class="bar-label"><?php echo $month_names[$i - 1]; ?></span>
                    </div>
                <?php endfor; ?>
            </div>
            <?php if ($total_students == 0): ?>
                <div class="no-data-message">No enrollment data available yet. Add some students!</div>
            <?php endif; ?>
        </div>

        <!-- Donut Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Department Distribution</h3>
                <span>By program</span>
            </div>
            <div class="donut-wrapper">
                <?php if ($total_students > 0 && count($department_distribution) > 0): ?>
                    <div class="donut"></div>
                    <div class="donut-legend">
                        <?php foreach ($department_distribution as $dept):
                            $percentage = round(($dept['count'] / $total_students) * 100);
                            $color = $dept_color_map[$dept['department']];
                        ?>
                            <span>
                                <span class="dot" style="background: <?php echo $color; ?>;"></span>
                                <?php echo htmlspecialchars($dept['department']); ?> (<?php echo $percentage; ?>%)
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-data-message" style="padding: 40px 0;">
                        No department data available yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </section>

    <!-- Recent Students Table -->
    <section class="table-section">
        <div class="table-header">
            <h3>📋 Recent Students</h3>
            <a href="../students.php">View all →</a>
        </div>
        <?php if (count($recent_students) > 0): ?>
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
                    <?php foreach ($recent_students as $student):
                        $initials = '';
                        $name_parts = explode(' ', $student['name']);
                        foreach ($name_parts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper($part[0]);
                            }
                        }
                        $initials = substr($initials, 0, 2);

                        $status_class = 'active';
                        $status_lower = strtolower($student['status']);
                        if ($status_lower === 'inactive') {
                            $status_class = 'inactive';
                        } elseif ($status_lower === 'graduated') {
                            $status_class = 'inactive';
                        }
                    ?>
                        <tr>
                            <td>
                                <span class="table-avatar"><?php echo $initials; ?></span>
                                <?php echo htmlspecialchars($student['name']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($student['status']); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                <p style="font-size: 16px;">No students added yet.</p>
                <p style="font-size: 13px; margin-top: 4px;">Start by adding your first student!</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="../add-student.php" class="btn btn-primary">➕ Add New Student</a>
        <a href="../students.php" class="btn btn-secondary">👥 View All Students</a>
        <a href="report.php" class="btn btn-secondary">📄 Generate Report</a>
    </div>

</main>

<!-- =========================================================
     MOBILE SIDEBAR TOGGLE SCRIPT
========================================================= -->
<script src="../scripts/dashboard.js"></script>

</body>
</html>