<?php
// students.php - Student Management (Full CRUD with Pagination)
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
// HANDLE ACTIONS (Add, Edit, Delete)
// =========================================================

// --- DELETE ---
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "Student deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error deleting student.";
        $message_type = "error";
    }
    $stmt->close();
}

// --- ADD ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $enrollment_date = trim($_POST['enrollment_date'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if (!empty($name) && !empty($department) && !empty($student_id)) {
        $stmt = $conn->prepare("INSERT INTO students (name, department, student_id, enrollment_date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $department, $student_id, $enrollment_date, $status);
        if ($stmt->execute()) {
            $message = "Student added successfully!";
            $message_type = "success";
        } else {
            $message = "Error adding student.";
            $message_type = "error";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    }
}

// --- EDIT ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $enrollment_date = trim($_POST['enrollment_date'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if (!empty($name) && !empty($department) && !empty($student_id)) {
        $stmt = $conn->prepare("UPDATE students SET name = ?, department = ?, student_id = ?, enrollment_date = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $department, $student_id, $enrollment_date, $status, $id);
        if ($stmt->execute()) {
            $message = "Student updated successfully!";
            $message_type = "success";
        } else {
            $message = "Error updating student.";
            $message_type = "error";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    }
}

// =========================================================
// FETCH STUDENTS (with search & pagination)
// =========================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Count total records for pagination (with search filter)
$count_sql = "SELECT COUNT(*) as total FROM students";
$count_params = [];
$count_types = "";

if (!empty($search)) {
    $count_sql .= " WHERE name LIKE ? OR department LIKE ? OR student_id LIKE ?";
    $search_param = "%$search%";
    $count_params = [$search_param, $search_param, $search_param];
    $count_types = "sss";
}

$count_stmt = $conn->prepare($count_sql);
if (!empty($count_params)) {
    $count_stmt->bind_param($count_types, ...$count_params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_records = $count_result->fetch_assoc()['total'] ?? 0;
$count_stmt->close();

$total_pages = ceil($total_records / $per_page);

// Fetch students with pagination
$sql = "SELECT * FROM students";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " WHERE name LIKE ? OR department LIKE ? OR student_id LIKE ?";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

$sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= "ii";

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
// GET STUDENT FOR EDIT (Fallback for no AJAX)
// =========================================================

$edit_student = null;
$edit_triggered = isset($_GET['edit']) && is_numeric($_GET['edit']);
if ($edit_triggered) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_result = $stmt->get_result();
    if ($edit_result && $edit_result->num_rows > 0) {
        $edit_student = $edit_result->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students — EduTrack</title>

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

    <style>
        /* =========================================================
           STUDENTS PAGE SPECIFIC STYLES
        ========================================================= */

        .students-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .students-header .header-left h1 {
            font-family: var(--heading-font);
            font-size: 26px;
            letter-spacing: -0.02em;
        }

        .students-header .header-left h1 span {
            color: var(--primary-light);
        }

        .students-header .header-left p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 2px;
        }

        .students-header .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-wrapper .search-input {
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--text);
            font-size: 13px;
            min-width: 220px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .search-wrapper .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-wrapper .search-input:focus {
            border-color: var(--primary);
        }

        .search-wrapper .btn {
            min-height: 42px;
            padding: 0 18px;
            font-size: 13px;
        }

        .students-table-wrapper {
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            background: var(--surface);
            overflow: hidden;
        }

        .students-table-wrapper .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .students-table-wrapper .table-toolbar .count {
            color: var(--text-muted);
            font-size: 13px;
        }

        .students-table-wrapper .table-toolbar .count strong {
            color: var(--text);
        }

        .students-table-wrapper table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .students-table-wrapper th {
            text-align: left;
            padding: 14px 24px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.02);
        }

        .students-table-wrapper td {
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
            color: var(--text-soft);
            vertical-align: middle;
        }

        .students-table-wrapper tr:last-child td {
            border-bottom: 0;
        }

        .students-table-wrapper tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .student-avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), #927dff);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: white;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .student-cell {
            display: flex;
            align-items: center;
        }

        .student-cell .info {
            display: flex;
            flex-direction: column;
        }

        .student-cell .info strong {
            font-weight: 600;
            color: var(--text);
        }

        .student-cell .info small {
            color: var(--text-muted);
            font-size: 11px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(64, 211, 156, 0.12);
            color: var(--success);
        }

        .status-badge.inactive {
            background: rgba(255, 107, 107, 0.12);
            color: #ff6b6b;
        }

        .status-badge.pending {
            background: rgba(255, 193, 7, 0.12);
            color: #ffc107;
        }

        .status-badge.graduated {
            background: rgba(109, 93, 252, 0.12);
            color: var(--primary-light);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-buttons .btn-sm {
            padding: 4px 12px;
            font-size: 11px;
            min-height: 30px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg-soft);
            color: var(--text-soft);
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .action-buttons .btn-sm:hover {
            background: var(--surface-light);
            border-color: var(--border-light);
        }

        .action-buttons .btn-sm.edit:hover {
            border-color: var(--primary);
            color: var(--primary-light);
        }

        .action-buttons .btn-sm.delete:hover {
            border-color: #ff6b6b;
            color: #ff6b6b;
        }

        .no-students {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .no-students .icon {
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
        }

        .no-students h3 {
            font-family: var(--heading-font);
            color: var(--text-soft);
            margin-bottom: 8px;
        }

        .message-banner {
            padding: 14px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-banner.success {
            background: rgba(64, 211, 156, 0.08);
            border: 1px solid rgba(64, 211, 156, 0.2);
            color: var(--success);
        }

        .message-banner.error {
            background: rgba(255, 107, 107, 0.08);
            border: 1px solid rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .message-banner .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
            padding: 0 4px;
        }

        .message-banner .close-btn:hover {
            color: var(--text);
        }

        /* --- Pagination --- */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 20px;
            flex-wrap: wrap;
            border-top: 1px solid var(--border);
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-soft);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: rgba(109, 93, 252, 0.1);
            border-color: var(--primary);
            color: white;
        }

        .pagination .active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .pagination .disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* --- Modal Styles --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
            max-width: 520px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: var(--shadow);
            animation: modalSlide 0.3s ease;
        }

        @keyframes modalSlide {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal .modal-close {
            position: absolute;
            top: 16px;
            right: 20px;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 24px;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
        }

        .modal .modal-close:hover {
            color: var(--text);
        }

        .modal h2 {
            font-family: var(--heading-font);
            font-size: 22px;
            margin-bottom: 8px;
        }

        .modal .subtitle {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 24px;
        }

        .modal .form-group {
            margin-bottom: 18px;
        }

        .modal .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .modal .form-group input,
        .modal .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--text);
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .modal .form-group input:focus,
        .modal .form-group select:focus {
            border-color: var(--primary);
        }

        .modal .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23697386' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
            cursor: pointer;
        }

        .modal .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .modal .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .modal .modal-actions .btn {
            flex: 1;
            justify-content: center;
            min-height: 44px;
        }

        .modal .modal-actions .btn-secondary {
            flex: 0.5;
        }

        /* --- Responsive --- */
        @media (max-width: 820px) {
            .students-header {
                flex-direction: column;
                align-items: stretch;
            }

            .students-header .header-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrapper .search-input {
                min-width: unset;
                width: 100%;
            }

            .students-table-wrapper .table-toolbar {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .students-table-wrapper th,
            .students-table-wrapper td {
                padding: 10px 14px;
                font-size: 12px;
            }

            .action-buttons .btn-sm {
                padding: 3px 10px;
                font-size: 10px;
            }

            .modal {
                padding: 28px 20px;
            }

            .modal .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .students-table-wrapper {
                overflow-x: auto;
            }

            .students-table-wrapper table {
                min-width: 600px;
                font-size: 12px;
            }

            .student-avatar-sm {
                width: 28px;
                height: 28px;
                font-size: 9px;
                margin-right: 8px;
            }
        }

        @media (max-width: 480px) {
            .students-header .header-left h1 {
                font-size: 22px;
            }

            .modal .modal-actions {
                flex-direction: column;
            }

            .modal .modal-actions .btn-secondary {
                flex: 1;
            }

            .pagination a,
            .pagination span {
                min-width: 32px;
                height: 32px;
                font-size: 12px;
                padding: 0 8px;
            }
        }
    </style>
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
        <a href="dashboard.php">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="students.php" class="active">
            <span class="nav-icon">👥</span> Students
        </a>
        <a href="add-student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
        <a href="report.php">
            <span class="nav-icon">📄</span> Reports
        </a>
        <a href="about.php">
            <span class="nav-icon">ℹ️</span> About
        </a>
        <a href="index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Visit Site
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
            <h1>👥 <span>Students</span></h1>
            <p>Manage all student records in one place.</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-avatar">SM</div>
        </div>
    </header>

    <!-- =========================================================
         PAGE HEADER
    ========================================================= -->
    <div class="students-header">
        <div class="header-left">
            <h1>All <span>Students</span></h1>
            <p><?php echo number_format($total_records); ?> students in the system</p>
        </div>
        <div class="header-actions">
            <form class="search-wrapper" method="GET" action="students.php">
                <input
                    type="text"
                    class="search-input"
                    name="search"
                    placeholder="Search by name, department, or ID..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >
                <button type="submit" class="btn btn-primary">🔍 Search</button>
                <?php if (!empty($search)): ?>
                    <a href="students.php" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </form>
            <a href="#addModal" class="btn btn-primary" onclick="openModal('addModal')">
                ➕ Add Student
            </a>
        </div>
    </div>

    <!-- =========================================================
         MESSAGE BANNER
    ========================================================= -->
    <?php if (isset($message) && !empty($message)): ?>
        <div class="message-banner <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
            <span><?php echo $message_type === 'success' ? '✓' : '!'; ?></span>
            <?php echo htmlspecialchars($message); ?>
            <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
        </div>
    <?php endif; ?>

    <!-- =========================================================
         STUDENTS TABLE
    ========================================================= -->
    <div class="students-table-wrapper">

        <div class="table-toolbar">
            <span class="count">
                Showing <strong><?php echo count($students); ?></strong> of <strong><?php echo number_format($total_records); ?></strong> students
            </span>
            <span class="count" style="font-size: 11px;">
                Page <?php echo $page; ?> of <?php echo $total_pages > 0 ? $total_pages : 1; ?>
            </span>
        </div>

        <?php if (count($students) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Student ID</th>
                        <th>Enrolled</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = $offset + 1; ?>
                    <?php foreach ($students as $student):
                        // Generate initials from name
                        $initials = '';
                        $name_parts = explode(' ', $student['name']);
                        foreach ($name_parts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper($part[0]);
                            }
                        }
                        $initials = substr($initials, 0, 2);

                        // Status badge class
                        $status_class = 'active';
                        $status_lower = strtolower($student['status']);
                        if ($status_lower === 'inactive') {
                            $status_class = 'inactive';
                        } elseif ($status_lower === 'graduated') {
                            $status_class = 'graduated';
                        } elseif ($status_lower === 'pending') {
                            $status_class = 'pending';
                        }
                    ?>
                        <tr>
                            <td style="color: var(--text-muted); font-size: 12px;"><?php echo $counter++; ?></td>
                            <td>
                                <div class="student-cell">
                                    <span class="student-avatar-sm"><?php echo $initials; ?></span>
                                    <div class="info">
                                        <strong><?php echo htmlspecialchars($student['name']); ?></strong>
                                        <small><?php echo htmlspecialchars($student['student_id']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                            <td><code style="background: var(--bg-soft); padding: 2px 8px; border-radius: 4px; font-size: 12px;"><?php echo htmlspecialchars($student['student_id']); ?></code></td>
                            <td><?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?></td>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($student['status']); ?></span></td>
                            <td style="text-align: right;">
                                <div class="action-buttons" style="justify-content: flex-end;">
                                    <a href="students.php?edit=<?php echo $student['id']; ?>" class="btn-sm edit" onclick="openEditModal(event, <?php echo $student['id']; ?>)">✏️ Edit</a>
                                    <a href="students.php?delete=<?php echo $student['id']; ?>" class="btn-sm delete" onclick="return confirmDelete(event, '<?php echo htmlspecialchars($student['name']); ?>')">🗑️ Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">‹ Prev</a>
                    <?php else: ?>
                        <span class="disabled">‹ Prev</span>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);

                    if ($start_page > 1) {
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '">1</a>';
                        if ($start_page > 2) echo '<span class="disabled">…</span>';
                    }

                    for ($i = $start_page; $i <= $end_page; $i++):
                    ?>
                        <?php if ($i === $page): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1) echo '<span class="disabled">…</span>'; ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $total_pages])); ?>"><?php echo $total_pages; ?></a>
                    <?php endif; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next ›</a>
                    <?php else: ?>
                        <span class="disabled">Next ›</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="no-students">
                <span class="icon">📭</span>
                <h3>No students found</h3>
                <p>
                    <?php if (!empty($search)): ?>
                        No results match your search. Try adjusting your search terms.
                    <?php else: ?>
                        Start by adding your first student to the system.
                    <?php endif; ?>
                </p>
                <?php if (!empty($search)): ?>
                    <a href="students.php" class="btn btn-secondary" style="margin-top: 12px;">Clear Search</a>
                <?php else: ?>
                    <a href="#addModal" class="btn btn-primary" style="margin-top: 12px;" onclick="openModal('addModal')">
                        ➕ Add Your First Student
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>

</main>

<!-- =========================================================
     ADD MODAL
========================================================= -->
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal('addModal')">×</button>
        <h2>➕ Add New Student</h2>
        <p class="subtitle">Enter the student's information below.</p>

        <form method="POST" action="students.php" id="addForm">
            <input type="hidden" name="action" value="add">

            <div class="form-group">
                <label for="add_name">Full Name *</label>
                <input type="text" id="add_name" name="name" placeholder="e.g., Samuel Molokwu" required>
            </div>

            <div class="form-group">
                <label for="add_department">Department *</label>
                <select id="add_department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Physics">Physics</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Biology">Biology</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Economics">Economics</option>
                    <option value="Psychology">Psychology</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="add_student_id">Student ID *</label>
                    <input type="text" id="add_student_id" name="student_id" placeholder="e.g., CS-2024-012" required>
                </div>
                <div class="form-group">
                    <label for="add_enrollment_date">Enrollment Date</label>
                    <input type="date" id="add_enrollment_date" name="enrollment_date" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="add_status">Status</label>
                <select id="add_status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Graduated">Graduated</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Student →</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     EDIT MODAL
========================================================= -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal('editModal')">×</button>
        <h2>✏️ Edit Student</h2>
        <p class="subtitle">Update the student's information below.</p>

        <form method="POST" action="students.php" id="editForm">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id" value="">

            <div class="form-group">
                <label for="edit_name">Full Name *</label>
                <input type="text" id="edit_name" name="name" placeholder="e.g., Samuel Molokwu" required>
            </div>

            <div class="form-group">
                <label for="edit_department">Department *</label>
                <select id="edit_department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Physics">Physics</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Biology">Biology</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Economics">Economics</option>
                    <option value="Psychology">Psychology</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_student_id">Student ID *</label>
                    <input type="text" id="edit_student_id" name="student_id" placeholder="e.g., CS-2024-012" required>
                </div>
                <div class="form-group">
                    <label for="edit_enrollment_date">Enrollment Date</label>
                    <input type="date" id="edit_enrollment_date" name="enrollment_date">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_status">Status</label>
                <select id="edit_status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Graduated">Graduated</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Student →</button>
            </div>
        </form>
    </div>
</div>

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
            if (e.key === 'Escape') {
                if (sidebar.classList.contains('open')) closeSidebar();
                closeModal('addModal');
                closeModal('editModal');
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 820 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });
    });

    // =========================================================
    // MODAL FUNCTIONS
    // =========================================================

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal when clicking overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // =========================================================
    // EDIT MODAL - Load Student Data via AJAX
    // =========================================================

    function openEditModal(event, studentId) {
        event.preventDefault();

        // First, try AJAX
        fetch('get_student.php?id=' + studentId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_department').value = data.department;
                    document.getElementById('edit_student_id').value = data.student_id;
                    document.getElementById('edit_enrollment_date').value = data.enrollment_date;
                    document.getElementById('edit_status').value = data.status;
                    openModal('editModal');
                } else {
                    // Fallback: load via URL
                    window.location.href = 'students.php?edit=' + studentId;
                }
            })
            .catch(() => {
                // Fallback on network error: load via URL
                window.location.href = 'students.php?edit=' + studentId;
            });
    }

    // =========================================================
    // PHP FALLBACK: If edit parameter is in URL, open modal with data
    // =========================================================

    <?php if ($edit_student && !empty($edit_student)): ?>
        document.addEventListener('DOMContentLoaded', () => {
            // Remove the edit parameter from URL without reload
            const url = new URL(window.location);
            url.searchParams.delete('edit');
            window.history.replaceState({}, document.title, url);

            // Populate and open modal
            document.getElementById('edit_id').value = <?php echo (int)$edit_student['id']; ?>;
            document.getElementById('edit_name').value = <?php echo json_encode($edit_student['name']); ?>;
            document.getElementById('edit_department').value = <?php echo json_encode($edit_student['department']); ?>;
            document.getElementById('edit_student_id').value = <?php echo json_encode($edit_student['student_id']); ?>;
            document.getElementById('edit_enrollment_date').value = <?php echo json_encode($edit_student['enrollment_date']); ?>;
            document.getElementById('edit_status').value = <?php echo json_encode($edit_student['status']); ?>;
            openModal('editModal');
        });
    <?php endif; ?>

    // =========================================================
    // DELETE CONFIRMATION
    // =========================================================

    function confirmDelete(event, studentName) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete "' + studentName + '"? This action cannot be undone.')) {
            window.location.href = event.currentTarget.href;
        }
        return false;
    }

    // =========================================================
    // AUTO-CLOSE MESSAGE BANNER
    // =========================================================

    document.addEventListener('DOMContentLoaded', () => {
        const banners = document.querySelectorAll('.message-banner');
        banners.forEach(banner => {
            setTimeout(() => {
                banner.style.opacity = '0';
                setTimeout(() => {
                    banner.style.display = 'none';
                }, 300);
            }, 5000);
        });
    });
</script>

</body>
</html>