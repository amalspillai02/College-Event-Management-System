<?php
// Database connection settings
$servername = "p:127.0.0.1:3307"; // replace with your server name if different
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "college_events"; // replace with your database name

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Delete assigned judge
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    
    $deleteQuery = "DELETE FROM assign_judges WHERE judge_id = '$deleteId'";
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: judgedeleted.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve the assigned judges
$assignedJudgesQuery = "SELECT * FROM assign_judges";
$assignedJudgesResult = $conn->query($assignedJudgesQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assigned Judges</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if ($assignedJudgesResult && $assignedJudgesResult->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Judge ID</th>
                        <th>Judge Name</th>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Event Time</th>
                        <th>Event Location</th>
                        <th>Event Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $assignedJudgesResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['judge_id']; ?></td>
                            <td><?php echo $row['judge_name']; ?></td>
                            <td><?php echo $row['event_id']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_time']; ?></td>
                            <td><?php echo $row['event_location']; ?></td>
                            <td><?php echo $row['event_category']; ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $row['judge_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No assigned judges found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
