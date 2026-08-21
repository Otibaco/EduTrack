<?php
// get_student.php - Fetch student data for edit modal

$host = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, department, student_id, enrollment_date, status, email, phone FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo json_encode(['success' => true] + $student);
    } else {
        echo json_encode(['success' => false, 'error' => 'Student not found.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid student ID.']);
}

$conn->close();
?>