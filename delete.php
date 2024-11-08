<?php
include 'db.php';

// Get student ID from the URL
$student_id = $_GET['id'];

// SQL to delete the student
$sql = "DELETE FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();

$stmt->close();
$conn->close();
?>
