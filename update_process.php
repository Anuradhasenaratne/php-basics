<?php
include 'db.php';

// Get the student data from the form
$student_id = $_POST['student_id'];
$student_name = $_POST['student_name'];
$student_nic = $_POST['student_nic'];
$student_course = $_POST['student_course'];

// SQL to update student details
$sql = "UPDATE students SET student_name = ?, student_nic = ?, student_course = ? WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $student_name, $student_nic, $student_course, $student_id);
$stmt->execute();

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();

$stmt->close();
$conn->close();
?>
