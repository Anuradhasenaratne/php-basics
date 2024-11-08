<?php
include 'db.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_nic = $_POST['student_nic'];
    $student_course = $_POST['student_course'];
    $student_password = $_POST['student_password'];
    $retype_password = $_POST['retype_password'];

    // Check if passwords match
    if ($student_password !== $retype_password) {
        echo '<script>alert("Passwords do not match!"); window.location.href="register.html";</script>';
        exit();
    }

    // Check if student_id already exists
    $sql_check = "SELECT * FROM students WHERE student_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo '<script>alert("Student ID already exists. Please choose a different one."); window.location.href="register.html";</script>';
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO students (student_id, student_name, student_nic, student_course, student_password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_id, $student_name, $student_nic, $student_course, $student_password);

    // Execute the query
    if ($stmt->execute()) {
        echo '<script>alert("Registration successful!"); window.location.href="dashboard.html";</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href="register.html";</script>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
