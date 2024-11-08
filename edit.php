<?php
// Include the database connection
include 'db.php';

// Get the student ID from the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the student's details from the database
    $sql = "SELECT * FROM students WHERE student_id='$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <form action="update.php" method="POST">
            <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $student['student_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_nic">NIC</label>
                <input type="text" class="form-control" id="student_nic" name="student_nic" value="<?php echo $student['student_nic']; ?>" required>
            </div>
            <div class="form-group">
                <label for="student_course">Course</label>
                <input type="text" class="form-control" id="student_course" name="student_course" value="<?php echo $student['student_course']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-success">Update</button>
        </form>
    </div>
</body>
</html>
