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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $eventName = trim($_POST['event_name']);
    $eventCategory = trim($_POST['event_category']);
    $eventTime = trim($_POST['event_time']);
    $eventDate = trim($_POST['event_date']);
    $eventLocation = trim($_POST['event_location']);

    // Check if the event name already exists
    $query = "SELECT * FROM events WHERE event_name = '$eventName'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $error =  "Error: Event name already exists!";
    } else {
        // Check if an event with the same date, time, and location already exists
        $query = "SELECT * FROM events WHERE event_date = '$eventDate' AND event_time = '$eventTime' AND event_location = '$eventLocation'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $error =  "Error: An event with the same date, time, and location already exists!";
        } else {
            // Insert the event into the database
            $sql = "INSERT INTO events (event_name, event_category, event_time, event_date, event_location) VALUES ('$eventName', '$eventCategory', '$eventTime', '$eventDate', '$eventLocation')";

            if ($conn->query($sql) === TRUE) {
                $success = "Event added successfully!";
            } else {
                $success = "Error adding event: " . $conn->error;
            }
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"> 
					<a class="nav-link" href="view_events.php">View Events</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="events.php">Events</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="..\admin\admindashboard.php">Admin</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact</a>
				</li>
			</ul>
		</div>
	</nav>
    <h2>Add Event</h2>
    <div class="container">
    <form method="POST" action="add_events.php">
    <?php if (isset($error)) { ?>
          <p class="error-message"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (isset($success)) { ?>
          <p class="success-message"><?php echo $success; ?></p>
        <?php } ?>
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required>
        <br>
        <label for="event_category">Event Category:</label>
        <select name="event_category" id="event_category">
            <option value="solo">Solo</option>
            <option value="group">Group</option>
        </select>
        <br>
        <label for="event_time">Event Time:</label>
        <input type="time" name="event_time" required>
        <br>
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" required>
        <br>
        <label for="event_location">Event Location:</label>
        <input type="text" name="event_location" required>
        <br>
        <input type="submit" value="Add Event">
    </form>
    <label for="event_image">Event Image:</label>
    <input type="file" name="event_image">
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
