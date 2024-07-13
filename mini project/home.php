<?php
// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection code - Replace with your own
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve registered events for the logged-in user
$uname = $_SESSION['username'];
$sql = "SELECT eventreg.event_name, eventreg.event_category, events.event_location, events.event_date, events.event_time 
        FROM eventreg 
        LEFT JOIN events ON eventreg.event_name = events.event_name 
        WHERE eventreg.username = '$uname'";
$result = $conn->query($sql);


if ($result === false) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit();
}

// Delete event functionality
if (isset($_POST['delete_event'])) {
    $event_name = $_POST['event_name'];
    $event_category = $_POST['event_category'];
    $delete_sql = "DELETE FROM eventreg WHERE username = '$uname' AND event_name = '$event_name'";
    if ($conn->query($delete_sql) === true) {
        header("Refresh:0"); // Refresh the page to show updated events
    } else {
        echo "Error deleting event: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="events.php">Events</a>
            </li>
            <li class="nav-item active"> 
					<a class="nav-link" href="view_schedule.php">View Schedule</a>
				</li>
            <li class="nav-item active"> 
					<a class="nav-link" href="announcements\view_announcements.php">Announcements</a>
				</li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="edit.php">Edit Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
    <h2>Your username is: <?php echo $_SESSION['username']; ?></h2>
    <h2>Registered Events</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Event Category</th>
                <th>Event Location</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['event_name']; ?></td>
                    <td><?php echo $row['event_category']; ?></td>
                    <td><?php echo $row['event_location']; ?></td>
                    <td><?php echo $row['event_date']; ?></td>
                    <td><?php echo $row['event_time']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="event_name" value="<?php echo $row['event_name']; ?>">
                            <input type="hidden" name="event_category" value="<?php echo $row['event_category']; ?>">
                            <button type="submit" name="delete_event" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No events registered.</p>
    <?php } ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- <script>
    // Auto-refresh the page every 5 seconds
    setInterval(function () {
        location.reload();
    }, 5000);
</script> -->
</body>
</html>
