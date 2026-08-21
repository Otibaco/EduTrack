<?php
// report.php - Generate Student Reports
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
// GET FILTERS FROM URL
// =========================================================

$department_filter = isset($_GET['department']) ? trim($_GET['department']) : 'all';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : 'all';
$date_filter = isset($_GET['date']) ? trim($_GET['date']) : '';
$search_filter = isset($_GET['search']) ? trim($_GET['search']) : '';

// =========================================================
// BUILD QUERY
// =========================================================

$sql = "SELECT * FROM students WHERE 1=1";
$params = [];
$types = "";

if ($department_filter !== 'all' && !empty($department_filter)) {
    $sql .= " AND department = ?";
    $params[] = $department_filter;
    $types .= "s";
}

if ($status_filter !== 'all' && !empty($status_filter)) {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($date_filter)) {
    $sql .= " AND enrollment_date >= ?";
    $params[] = $date_filter . "-01";
    $types .= "s";
}

if (!empty($search_filter)) {
    $sql .= " AND (name LIKE ? OR student_id LIKE ? OR department LIKE ?)";
    $search_param = "%$search_filter%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$sql .= " ORDER BY id DESC";

// Prepare and execute
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$students = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
$stmt->close();

// =========================================================
// CALCULATE SUMMARY STATS
// =========================================================

$total = count($students);
$active = 0;
$inactive = 0;
$departments = [];

foreach ($students as $s) {
    if (strtolower($s['status']) === 'active') {
        $active++;
    } elseif (strtolower($s['status']) === 'inactive' || strtolower($s['status']) === 'graduated') {
        $inactive++;
    }
    if (!in_array($s['department'], $departments)) {
        $departments[] = $s['department'];
    }
}
$dept_count = count($departments);

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report — EduTrack</title>

    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="./assets/style/style.css">

    <!-- Dashboard Layout Styles -->
    <link rel="stylesheet" href="./assets/style/dashboard.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

 <link rel="stylesheet" href="./assets/style/report.css">k
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
        <a href="./dashboard/dashboard.php">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="students.php">
            <span class="nav-icon">👥</span> Students
        </a>
       
        <a href="report.php" class="active">
            <span class="nav-icon">📄</span> Reports
        </a>
        <a href="add-student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
        <a href="index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Back to home
        </a>
        <a href="login.php" style="color: #ff6b6b;">
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
            <h1>📄 <span>Generate Report</span></h1>
            <p>Filter, preview, and export student data.</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-avatar">SM</div>
        </div>
    </header>

    <!-- =========================================================
         FILTER SECTION
    ========================================================= -->
    <section class="report-card">
        <div class="card-title">🔍 Filter Criteria</div>

        <form method="GET" action="report.php" id="filterForm">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="department">Department</label>
                    <select id="department" name="department">
                        <option value="all" <?php echo $department_filter === 'all' ? 'selected' : ''; ?>>All Departments</option>
                        <option value="Computer Science" <?php echo $department_filter === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                        <option value="Software Engineering" <?php echo $department_filter === 'Software Engineering' ? 'selected' : ''; ?>>Software Engineering</option>
                        <option value="Information Technology" <?php echo $department_filter === 'Information Technology' ? 'selected' : ''; ?>>Information Technology</option>
                        <option value="Mathematics" <?php echo $department_filter === 'Mathematics' ? 'selected' : ''; ?>>Mathematics</option>
                        <option value="Physics" <?php echo $department_filter === 'Physics' ? 'selected' : ''; ?>>Physics</option>
                        <option value="Chemistry" <?php echo $department_filter === 'Chemistry' ? 'selected' : ''; ?>>Chemistry</option>
                        <option value="Biology" <?php echo $department_filter === 'Biology' ? 'selected' : ''; ?>>Biology</option>
                        <option value="Business Administration" <?php echo $department_filter === 'Business Administration' ? 'selected' : ''; ?>>Business Administration</option>
                        <option value="Economics" <?php echo $department_filter === 'Economics' ? 'selected' : ''; ?>>Economics</option>
                        <option value="Psychology" <?php echo $department_filter === 'Psychology' ? 'selected' : ''; ?>>Psychology</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                        <option value="Active" <?php echo $status_filter === 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo $status_filter === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="Graduated" <?php echo $status_filter === 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                        <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date">Enrollment Date (from)</label>
                    <input type="month" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">🔄 Generate</button>
                    <a href="report.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>

            <!-- Hidden search field to preserve search term if needed -->
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_filter); ?>">
        </form>
    </section>

    <!-- =========================================================
         SUMMARY STATS
    ========================================================= -->
    <div class="report-summary">
        <div class="summary-item highlight">
            <strong><?php echo $total; ?></strong>
            <span>Total Records</span>
        </div>
        <div class="summary-item">
            <strong><?php echo $active; ?></strong>
            <span>Active</span>
        </div>
        <div class="summary-item">
            <strong><?php echo $inactive; ?></strong>
            <span>Inactive / Graduated</span>
        </div>
        <div class="summary-item">
            <strong><?php echo $dept_count; ?></strong>
            <span>Departments</span>
        </div>
    </div>

    <!-- =========================================================
         RESULTS TABLE
    ========================================================= -->
    <section class="report-card">
        <div class="card-title">
            📋 Report Results
            <span style="font-size: 12px; font-weight: 400; color: var(--text-muted); margin-left: 8px;">
                (Last updated: <span id="lastUpdated"><?php echo date('H:i:s'); ?></span>)
            </span>
        </div>

        <div class="table-responsive">
            <?php if ($total > 0): ?>
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
                    <tbody>
                        <?php foreach ($students as $student):
                            $status_class = 'active';
                            if (strtolower($student['status']) === 'inactive' || strtolower($student['status']) === 'graduated') {
                                $status_class = 'inactive';
                            } elseif (strtolower($student['status']) === 'pending') {
                                $status_class = 'pending';
                            }
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($student['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($student['department']); ?></td>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?></td>
                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($student['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <span class="icon">🔍</span>
                    <h3>No students found</h3>
                    <p>Try adjusting your filter criteria to see more results.</p>
                </div>
            <?php endif; ?>
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
    // MOBILE SIDEBAR TOGGLE
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
    // EXPORT FUNCTIONS
    // =========================================================

    function exportCSV() {
        // Collect table data
        const table = document.getElementById('reportTable');
        if (!table) {
            alert('No data to export.');
            return;
        }

        let csv = [];
        // Get headers
        const headers = [];
        table.querySelectorAll('thead th').forEach(th => {
            headers.push(th.textContent.trim());
        });
        csv.push(headers.join(','));

        // Get rows
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach(td => {
                // Clean text (remove extra spaces, commas)
                let text = td.textContent.trim();
                // If contains comma or quotes, wrap in quotes
                if (text.includes(',') || text.includes('"')) {
                    text = '"' + text.replace(/"/g, '""') + '"';
                }
                row.push(text);
            });
            csv.push(row.join(','));
        });

        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'student_report_' + new Date().toISOString().slice(0,10) + '.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    function exportPDF() {
        alert('📄 PDF Export will be available soon.\n\nIn production, this would generate a PDF using libraries like dompdf or TCPDF.');
        // You could implement server-side PDF generation using dompdf:
        // window.location.href = 'export_pdf.php?' + window.location.search.substring(1);
    }

    function copyTable() {
        const table = document.getElementById('reportTable');
        if (!table) {
            alert('No data to copy.');
            return;
        }

        // Create a range and select the table
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

    // Auto-refresh last updated time on filter change
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filterForm');
        if (form) {
            form.addEventListener('submit', () => {
                document.getElementById('lastUpdated').textContent = new Date().toLocaleTimeString();
            });
        }
    });
</script>

</body>
</html>