<?php
include 'db.php'; // Include the database connection file

// Check if an ID is provided
if (!isset($_GET['id'])) {
    die('No student ID provided.');
}

$student_id = $_GET['id'];

// Fetch the student details
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Student not found.');
}

$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $student_nic = $_POST['student_nic'];
    $student_course = $_POST['student_course'];

    // Prepare and bind
    $stmt_update = $conn->prepare("UPDATE students SET student_name = ?, student_nic = ?, student_course = ? WHERE student_id = ?");
    $stmt_update->bind_param("ssss", $student_name, $student_nic, $student_course, $student_id);

    // Execute the query
    if ($stmt_update->execute()) {
        echo '<script>alert("Update successful!"); window.location.href="dashboard.php";</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt_update->error . '"); window.location.href="dashboard.php";</script>';
    }

    // Close the statement
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Update Student</h2>
        <form action="update.php?id=<?php echo htmlspecialchars($student_id); ?>" method="post">
            <div class="form-group">
                <label for="student_name">Name:</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student['student_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="student_nic">NIC:</label>
                <input type="text" class="form-control" id="student_nic" name="student_nic" value="<?php echo htmlspecialchars($student['student_nic']); ?>" required>
            </div>
            <div class="form-group">
                <label for="student_course">Course:</label>
                <input type="text" class="form-control" id="student_course" name="student_course" value="<?php echo htmlspecialchars($student['student_course']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
