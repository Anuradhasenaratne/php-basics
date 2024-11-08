<?php
session_start();

// Include database connection
include 'db.php';

// Get form data
$student_id = $_POST['student_id'];
$student_password = $_POST['student_password'];

// Prepare and execute SQL query
$sql = "SELECT * FROM students WHERE student_id = ? AND student_password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $student_id, $student_password);
$stmt->execute();
$result = $stmt->get_result();

// Check if login is successful
if ($result->num_rows > 0) {
    // Successful login
    $_SESSION['student_id'] = $student_id;
    header("Location: dashboard.html");
    exit(); // Ensure no further code execution after redirection
} else {
    // Failed login
    echo '<script>alert("Invalid credentials. Please try again."); window.location.href="login.html";</script>';
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
