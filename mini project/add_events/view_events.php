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

// Function to update an event
function updateEvent($eventName, $eventCategory, $eventTime, $eventDate, $eventLocation, $eventID) {
    global $conn;
    $sql = "UPDATE events SET event_name = '$eventName', event_category = '$eventCategory', event_time = '$eventTime', event_date = '$eventDate', event_location = '$eventLocation' WHERE event_id = $eventID";
    if ($conn->query($sql) === TRUE) {
        return "Event updated successfully!";
    } else {
        return "Error updating event: " . $conn->error;
    }
}

// Function to delete an event
function deleteEvent($eventID) {
    global $conn;
    $sql = "DELETE FROM events WHERE event_id = $eventID";
    if ($conn->query($sql) === TRUE) {
        return "Event deleted successfully!";
    } else {
        return "Error deleting event: " . $conn->error;
    }
}

// Check if the form is submitted for updating an event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_event'])) {
    $eventID = $_POST['event_id'];
    $eventName = $_POST['event_name'];
    $eventCategory = $_POST['event_category'];
    $eventTime = $_POST['event_time'];
    $eventDate = $_POST['event_date'];
    $eventLocation = $_POST['event_location'];

    // Check if the event name already exists
    $existingEventSql = "SELECT * FROM events WHERE event_name = '$eventName' AND event_id != $eventID";
    $existingEventResult = $conn->query($existingEventSql);
    if ($existingEventResult->num_rows > 0) {
        $error = "Event name already exists. Please choose a different name.";
    } else {
        $message = updateEvent($eventName, $eventCategory, $eventTime, $eventDate, $eventLocation, $eventID);
    }
}

// Check if the form is submitted for deleting an event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $eventID = $_POST['event_id'];
    $message1 = deleteEvent($eventID);
}

// Check if the form is submitted for viewing an event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_event'])) {
    $eventName = $_POST['event_name'];

    // Retrieve the event details from the database based on event name
    $sql = "SELECT * FROM events WHERE event_name = '$eventName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        $error = "Event not found.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>View and Edit Events</title>
    <link rel="stylesheet" type="text/css" href="view.css">
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
                <a class="nav-link" href="add_events.php">Add Events</a>
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
<h2>View and Edit Events</h2>
<form  method="POST" action="view_events.php">
    <?php if (isset($error)) { ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>
    <?php if (isset($message)) { ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php } ?>
        <?php if (isset($message1)) { ?>
            <p class="error-message"><?php echo $message1; ?></p>
        <?php } ?>
    <label for="event_name">Enter Event Name:</label>
    <input type="text" name="event_name" required>
    <br>
    <input type="submit" name="view_event" value="View Event">
</form>
<?php if (isset($event)) : ?><h3>Event Details</h3>
<form class="viewform" method="POST" action="view_events.php">
    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
    <label for="event_name">Event Name:</label>
    <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>" required>
    <br>
    <label for="event_category">Event Category:</label>
    <input type="text" name="event_category" value="<?php echo $event['event_category']; ?>" required>
    <br>
    <label for="event_time">Event Time:</label>
    <input type="time" name="event_time" value="<?php echo $event['event_time']; ?>" required>
    <br>
    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
    <br>
    <label for="event_location">Event Location:</label>
    <input type="text" name="event_location" value="<?php echo $event['event_location']; ?>" required>
    <br>
    <input type="submit" name="update_event" value="Update Event">
    <input class="delete" type="submit" name="delete_event" value="Delete Event" onclick="return confirm('Are you sure you want to delete this event?')">
</form>
<?php endif; ?>
<div class="event-list">
    <h3>All Events</h3>
    <?php
    // Retrieve all events from the database
    $sql = "SELECT * FROM events";$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Event ID</th><th>Event Name</th><th>Event Category</th><th>Event Time</th><th>Event Date</th><th>Event Location</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['event_id'] . "</td>";
            echo "<td>" . $row['event_name'] . "</td>";
            echo "<td>" . $row['event_category'] . "</td>";
            echo "<td>" . $row['event_time'] . "</td>";
            echo "<td>" . $row['event_date'] . "</td>";
            echo "<td>" . $row['event_location'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No events found.</p>";
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>    
