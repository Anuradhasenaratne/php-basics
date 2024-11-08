<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html");
    exit();
}

// Include the database connection file
include 'db.php';

// Fetch all students from the database
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die('Query failed: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Student Dashboard</h2>

        <!-- Logout Button -->
        <div class="text-right mb-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <!-- Table to display students -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>NIC</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_nic']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_course']); ?></td>
                            <td>
                                <a href="update.php?id=<?php echo urlencode($row['student_id']); ?>" class="btn btn-sm btn-warning">Update</a>
                                <a href="delete.php?id=<?php echo urlencode($row['student_id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No students found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
