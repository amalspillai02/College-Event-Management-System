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

// Check if the event name is provided
if (isset($_POST['event_name'])) {
    $eventName = $_POST['event_name'];

    // Retrieve event details based on the event name
    $eventQuery = "SELECT * FROM events WHERE event_name = '$eventName'";
    $eventResult = $conn->query($eventQuery);

    if ($eventResult && $eventResult->num_rows > 0) {
        $eventRow = $eventResult->fetch_assoc();

        // Create an array to hold the event details
        $eventDetails = array(
            'event_id' => $eventRow['event_id'],
            'event_time' => $eventRow['event_time'],
            'event_date' => $eventRow['event_date'],
            'event_location' => $eventRow['event_location'],
            'event_category' => $eventRow['event_category']
        );

        // Convert the event details array to JSON format and send the response
        echo json_encode($eventDetails);
    } else {
        // Event not found
        echo "Event not found";
    }
} else {
    // Event name not provided
    echo "Event name not provided";
}

// Close the database connection
$conn->close();
?>
