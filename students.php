<?php
// students.php - Professional Student Management
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
// HANDLE ACTIONS (Add, Edit, Delete, Bulk Delete)
// =========================================================

// --- SINGLE DELETE ---
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

// --- BULK DELETE ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'bulk_delete') {
    if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
        $ids = array_map('intval', explode(',', $_POST['selected_ids']));
        if (count($ids) > 0) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $conn->prepare("DELETE FROM students WHERE id IN ($placeholders)");
            $types = str_repeat('i', count($ids));
            $stmt->bind_param($types, ...$ids);
            if ($stmt->execute()) {
                $message = count($ids) . " students deleted successfully!";
                $message_type = "success";
            } else {
                $message = "Error deleting students.";
                $message_type = "error";
            }
            $stmt->close();
        } else {
            $message = "Please select at least one student to delete.";
            $message_type = "error";
        }
    } else {
        $message = "Please select at least one student to delete.";
        $message_type = "error";
    }
}

// --- ADD ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $enrollment_date = trim($_POST['enrollment_date'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (!empty($name) && !empty($department) && !empty($student_id)) {
        $stmt = $conn->prepare("INSERT INTO students (name, department, student_id, enrollment_date, status, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $department, $student_id, $enrollment_date, $status, $email, $phone);
        if ($stmt->execute()) {
            $message = "Student added successfully!";
            $message_type = "success";
        } else {
            $message = "Error adding student: " . $stmt->error;
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
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (!empty($name) && !empty($department) && !empty($student_id)) {
        $stmt = $conn->prepare("UPDATE students SET name = ?, department = ?, student_id = ?, enrollment_date = ?, status = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $name, $department, $student_id, $enrollment_date, $status, $email, $phone, $id);
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
// FETCH STUDENTS (with search, filter & pagination) - FIXED
// =========================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$department_filter = isset($_GET['department']) ? trim($_GET['department']) : 'all';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : 'all';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 15;
$offset = ($page - 1) * $per_page;

// --- BUILD WHERE CLAUSE ---
$where_conditions = [];
$params = [];
$types = "";

if (!empty($search)) {
    $where_conditions[] = "(name LIKE ? OR department LIKE ? OR student_id LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if ($department_filter !== 'all' && !empty($department_filter)) {
    $where_conditions[] = "department = ?";
    $params[] = $department_filter;
    $types .= "s";
}

if ($status_filter !== 'all' && !empty($status_filter)) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// --- COUNT QUERY (FIXED) ---
$count_sql = "SELECT COUNT(*) as total FROM students $where_clause";

// Only prepare if there are parameters, otherwise use simple query
if (!empty($params)) {
    $count_stmt = $conn->prepare($count_sql);
    if ($count_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $count_stmt->bind_param($types, ...$params);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
} else {
    // No parameters, use simple query
    $count_result = $conn->query($count_sql);
    if ($count_result === false) {
        die("Query failed: " . $conn->error);
    }
}

$total_records = $count_result->fetch_assoc()['total'] ?? 0;
if (isset($count_stmt)) {
    $count_stmt->close();
}

$total_pages = max(1, ceil($total_records / $per_page));

// --- DATA QUERY (FIXED) ---
$sql = "SELECT * FROM students $where_clause ORDER BY id DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param($types, ...$params);
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
// GET STUDENT FOR EDIT (Fallback)
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

// Get distinct departments for filter dropdown
$dept_result = $conn->query("SELECT DISTINCT department FROM students ORDER BY department");
$departments = [];
if ($dept_result && $dept_result->num_rows > 0) {
    while ($row = $dept_result->fetch_assoc()) {
        $departments[] = $row['department'];
    }
}

$conn->close();

// Build query string for pagination links
$query_params = $_GET;
unset($query_params['page']);
$query_string = http_build_query($query_params);
$pagination_base = !empty($query_string) ? '?' . $query_string . '&page=' : '?page=';

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

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >
<link rel="stylesheet" href="./assets/style/students.css">
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
        <a href="students.php" class="active">
            <span class="nav-icon">👥</span> Students
        </a>
        <a href="report.php">
            <span class="nav-icon">📄</span> Reports
        </a>
       
       <a href="add-student.php">
            <span class="nav-icon">➕</span> Add Student
        </a>
        <a href="index.php" style="margin-top: auto;">
            <span class="nav-icon">🏠</span> Back to Home
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
            <p>Manage all student records with ease.</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-avatar">SM</div>
        </div>
    </header>

    <!-- =========================================================
         PAGE HEADER
    ========================================================= -->
    <div class="page-header">
        <div class="header-left">
            <h1>
                All Students
                <span class="badge-count"><?php echo number_format($total_records); ?></span>
            </h1>
            <p>View, search, and manage student records</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="openModal('addModal')">
                <i class="fas fa-plus"></i> Add Student
            </button>
            <a href="export_students.php<?php echo !empty($query_string) ? '?' . $query_string : ''; ?>" class="btn btn-secondary" target="_blank">
                <i class="fas fa-file-export"></i> Export
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
         FILTER BAR
    ========================================================= -->
    <form method="GET" action="students.php" class="filter-bar" id="filterForm">
        <div class="search-wrapper">
            <input
                type="text"
                name="search"
                placeholder="Search by name, department, or ID..."
                value="<?php echo htmlspecialchars($search); ?>"
            >
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search"></i> Search
            </button>
            <?php if (!empty($search) || $department_filter !== 'all' || $status_filter !== 'all'): ?>
                <a href="students.php" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i> Clear
                </a>
            <?php endif; ?>
        </div>

        <div class="filter-group">
            <label for="department_filter">Department</label>
            <select id="department_filter" name="department" onchange="this.form.submit()">
                <option value="all">All Departments</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo $department_filter === $dept ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dept); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="status_filter">Status</label>
            <select id="status_filter" name="status" onchange="this.form.submit()">
                <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                <option value="Active" <?php echo $status_filter === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $status_filter === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                <option value="Graduated" <?php echo $status_filter === 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
            </select>
        </div>
    </form>

    <!-- =========================================================
         STUDENTS TABLE
    ========================================================= -->
    <div class="students-table-wrapper">

        <div class="table-toolbar">
            <span class="count">
                Showing <strong><?php echo count($students); ?></strong> of <strong><?php echo number_format($total_records); ?></strong> students
            </span>
            <div class="bulk-actions">
                <form method="POST" action="students.php" id="bulkDeleteForm" onsubmit="return confirmBulkDelete()">
                    <input type="hidden" name="action" value="bulk_delete">
                    <input type="hidden" name="selected_ids" id="selectedIdsInput" value="">
                    <button type="submit" class="btn-sm danger" id="bulkDeleteBtn" disabled>
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </form>
            </div>
        </div>

        <?php if (count($students) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox-custom" id="selectAll" onclick="toggleAllCheckboxes()">
                        </th>
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

                        // Random avatar color
                        $colors = ['green', 'orange', 'pink', 'blue', ''];
                        $avatar_color = $colors[array_rand($colors)];

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
                        <tr id="row_<?php echo $student['id']; ?>">
                            <td>
                                <input
                                    type="checkbox"
                                    class="checkbox-custom student-checkbox"
                                    data-id="<?php echo $student['id']; ?>"
                                    onclick="updateBulkDeleteButton()"
                                >
                            </td>
                            <td>
                                <div class="student-cell">
                                    <span class="student-avatar-sm <?php echo $avatar_color; ?>"><?php echo $initials; ?></span>
                                    <div class="student-info">
                                        <span class="name"><?php echo htmlspecialchars($student['name']); ?></span>
                                        <?php if (!empty($student['email'])): ?>
                                            <span class="email"><?php echo htmlspecialchars($student['email']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                            <td><code style="background: var(--bg-soft); padding: 2px 8px; border-radius: 4px; font-size: 12px;"><?php echo htmlspecialchars($student['student_id']); ?></code></td>
                            <td><?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?></td>
                            <td>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <span class="dot"></span>
                                    <?php echo htmlspecialchars($student['status']); ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-buttons" style="justify-content: flex-end;">
                                    <a href="students.php?edit=<?php echo $student['id']; ?>" class="btn-icon edit" onclick="openEditModal(event, <?php echo $student['id']; ?>)" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="students.php?delete=<?php echo $student['id']; ?>" class="btn-icon delete" onclick="return confirmDelete(event, '<?php echo htmlspecialchars($student['name']); ?>')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <span class="info">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                    </span>
                    <div class="pages">
                        <?php if ($page > 1): ?>
                            <a href="<?php echo $pagination_base . ($page - 1); ?>">‹ Prev</a>
                        <?php else: ?>
                            <span class="disabled">‹ Prev</span>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        if ($start_page > 1) {
                            echo '<a href="' . $pagination_base . '1">1</a>';
                            if ($start_page > 2) echo '<span class="disabled">…</span>';
                        }

                        for ($i = $start_page; $i <= $end_page; $i++):
                        ?>
                            <?php if ($i === $page): ?>
                                <span class="active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="<?php echo $pagination_base . $i; ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1) echo '<span class="disabled">…</span>'; ?>
                            <a href="<?php echo $pagination_base . $total_pages; ?>"><?php echo $total_pages; ?></a>
                        <?php endif; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="<?php echo $pagination_base . ($page + 1); ?>">Next ›</a>
                        <?php else: ?>
                            <span class="disabled">Next ›</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="no-students">
                <span class="icon">📭</span>
                <h3>No students found</h3>
                <p>
                    <?php if (!empty($search) || $department_filter !== 'all' || $status_filter !== 'all'): ?>
                        No results match your filters. Try adjusting your search terms.
                    <?php else: ?>
                        Start by adding your first student to the system.
                    <?php endif; ?>
                </p>
                <?php if (!empty($search) || $department_filter !== 'all' || $status_filter !== 'all'): ?>
                    <a href="students.php" class="btn btn-secondary" style="margin-top: 12px;">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                <?php else: ?>
                    <button class="btn btn-primary" style="margin-top: 12px;" onclick="openModal('addModal')">
                        <i class="fas fa-plus"></i> Add Your First Student
                    </button>
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
        <div class="modal-icon">➕</div>
        <h2>Add New Student</h2>
        <p class="subtitle">Enter the student's information below.</p>

        <form method="POST" action="students.php" id="addForm">
            <input type="hidden" name="action" value="add">

            <div class="form-group">
                <label for="add_name">Full Name <span class="required">*</span></label>
                <input type="text" id="add_name" name="name" placeholder="e.g., Samuel Molokwu" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="add_department">Department <span class="required">*</span></label>
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
                <div class="form-group">
                    <label for="add_student_id">Student ID <span class="required">*</span></label>
                    <input type="text" id="add_student_id" name="student_id" placeholder="e.g., CS-2024-012" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="add_email">Email</label>
                    <input type="email" id="add_email" name="email" placeholder="student@example.com">
                </div>
                <div class="form-group">
                    <label for="add_phone">Phone</label>
                    <input type="text" id="add_phone" name="phone" placeholder="+234 800 000 0000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="add_enrollment_date">Enrollment Date</label>
                    <input type="date" id="add_enrollment_date" name="enrollment_date" value="<?php echo date('Y-m-d'); ?>">
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
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Student
                </button>
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
        <div class="modal-icon">✏️</div>
        <h2>Edit Student</h2>
        <p class="subtitle">Update the student's information below.</p>

        <form method="POST" action="students.php" id="editForm">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id" value="">

            <div class="form-group">
                <label for="edit_name">Full Name <span class="required">*</span></label>
                <input type="text" id="edit_name" name="name" placeholder="e.g., Samuel Molokwu" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_department">Department <span class="required">*</span></label>
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
                <div class="form-group">
                    <label for="edit_student_id">Student ID <span class="required">*</span></label>
                    <input type="text" id="edit_student_id" name="student_id" placeholder="e.g., CS-2024-012" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" id="edit_email" name="email" placeholder="student@example.com">
                </div>
                <div class="form-group">
                    <label for="edit_phone">Phone</label>
                    <input type="text" id="edit_phone" name="phone" placeholder="+234 800 000 0000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_enrollment_date">Enrollment Date</label>
                    <input type="date" id="edit_enrollment_date" name="enrollment_date">
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
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Student
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     SCRIPTS
========================================================= -->

<script src="./scripts/student.js"></script>
</body>
</html>