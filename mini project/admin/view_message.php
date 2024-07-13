<?php
// Database connection code - Replace with your own
$servername = "p:127.0.0.1:3307"; // replace with your server name if different
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "college_events"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve messages from the database
$sql = "SELECT * FROM contact";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Messages</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom stylesheets or Bootstrap CSS here -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="..\judges.php">judges</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="..\add_events\add_events.php">Add Events</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="admindashboard.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminlogout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
        <h1>View Messages</h1>

        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>KTU RegNo</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['ktu_regno']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No messages found.</p>
        <?php } ?>

        <!-- Add your additional content here -->

    </div>

    <!-- Add your JavaScript code or external script files here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
