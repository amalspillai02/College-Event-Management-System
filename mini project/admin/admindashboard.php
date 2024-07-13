<?php
// Start the session and check if the admin is logged in
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php"); // Redirect to admin login page if not logged in
    exit();
}

// Database connection code - Replace with your own
$servername = "p:127.0.0.1:3307"; // replace with your server name if different
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "college_events"; // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve registered events from the database
$sql = "SELECT * FROM eventreg";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit();
}
// Retrieve registered events from the database
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $sql = "SELECT * FROM eventreg WHERE username LIKE '%$searchTerm%' OR ktu_regno LIKE '%$searchTerm%' OR student_name LIKE '%$searchTerm%' OR semester LIKE '%$searchTerm%' OR department LIKE '%$searchTerm%' OR event_name LIKE '%$searchTerm%' OR event_category LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM eventreg";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin-sidebar.css">
    <script src="script.js"></script>
    <!-- Add your custom stylesheets or Bootstrap CSS here -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="adminlogout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="admindashboard.php" data-toggle="collapse" data-target="#dashboardMenu">Admin Dashboard</a>
                        <div class="collapse" id="dashboardMenu">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="..\judges.php">Add Judges</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="../assign_judgesform.php">Assign Judges</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="..\add_events\add_events.php">Add Events</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="..\add_events\view_events.php">View Events</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="view_message.php">Messages</a>
                    </li>
                    <li class="list-group-item">
                        <a href="..\announcements\announcement_form.php">Create Announcements</a>
                    </li>
                    <!-- Add more sidebar items here if needed -->
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <h1>Admin</h1>
            <h2>Registered Events</h2>
            <form method="GET" action="admindashboard.php" class="search-form">
                <input type="text" name="search" placeholder="Search" class="search-input">
                <button type="submit" class="search-button">Search</button>
            </form>
            <!-- <button onclick="sortTable()">Sort Table</button> -->
            <?php if ($result->num_rows > 0) { ?>
                <table id='event-table'>
                    <tr>
                        <th>Username</th>
                        <th>KTU Reg No</th>
                        <th>Student Name</th>
                        <th>Semester</th>
                        <th>Department</th>
                        <th>Event Name</th>
                        <th>Event Category</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['ktu_regno']; ?></td>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['semester']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_category']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <button onclick="printTable()" class="print-button">Print</button>
            <?php } else { ?>
                <p>No events registered.</p>
            <?php } ?>

            <!-- Add your additional admin dashboard content here -->
        </div>
    </div>
</div>

<!-- Add your JavaScript code or external script files here -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
