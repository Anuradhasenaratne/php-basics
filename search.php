<?php
include 'db.php'; // Ensure this file connects to your database

// Initialize the search variable
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Prepare the query with the correct column names
$query = "SELECT * FROM students WHERE student_nic LIKE '%$search%' OR student_name LIKE '%$search%' OR student_course LIKE '%$search%'";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
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


        <div class="text-right mb-3">
            <a href="login.html" class="btn btn-danger">Logout</a>
        </div>

        <!-- Search Form -->
        <form action="search.php" method="get" class="form-inline mb-3">
            <input type="text" class="form-control mr-2" name="search" placeholder="Search by name, NIC or course" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
