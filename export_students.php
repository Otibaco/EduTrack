<?php
// export_students.php - Export filtered students to CSV

$host = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}

// Get filters from URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$department_filter = isset($_GET['department']) ? trim($_GET['department']) : 'all';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : 'all';

// Build query
$sql = "SELECT name, department, student_id, enrollment_date, status, email, phone FROM students WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR department LIKE ? OR student_id LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

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

$sql .= " ORDER BY name";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="students_export_' . date('Y-m-d') . '.csv"');

// Output BOM for UTF-8
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');

// Headers
fputcsv($output, ['Name', 'Department', 'Student ID', 'Enrollment Date', 'Status', 'Email', 'Phone']);

// Data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['name'],
        $row['department'],
        $row['student_id'],
        date('Y-m-d', strtotime($row['enrollment_date'])),
        $row['status'],
        $row['email'] ?? '',
        $row['phone'] ?? ''
    ]);
}

fclose($output);
$stmt->close();
$conn->close();
exit;
?>