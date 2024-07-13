<?php
// Database connection details
$servername = "p:127.0.0.1:3307"; // replace with your server name if different
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "college_events"; // replace with your database name

// Get form data
$uname = $_POST['uname'];
$ktuRegNo = $_POST['ktu_regno'];
$studentName = $_POST['student_name'];
$semester = $_POST['semester'];
$department = $_POST['department'];
$eventName = $_POST['event_name'];
$eventCategory = $_POST['event_category'];

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate username and KTU registration number
$query = "SELECT * FROM users WHERE username = '$uname' AND ktu_regno = '$ktuRegNo'";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    // Username and KTU registration number do not match
    header("Location: singleform.php?error=InvalidCredentials");
    exit();
}

$registeredGroupEventsQuery = "SELECT COUNT(*) AS total FROM eventreg WHERE username = '$uname' AND event_category = 'group'";
$registeredGroupEventsResult = $conn->query($registeredGroupEventsQuery);
$registeredGroupEventsCount = $registeredGroupEventsResult->fetch_assoc()['total'];

if ($registeredGroupEventsCount >= 5 && $eventCategory === 'group') {
    // User has already registered maximum allowed group events
    header("Location: groupform.php?error=MaxGroupEventLimitReached");
    exit();
}
$checkEventQuery = "SELECT * FROM eventreg WHERE username = '$uname' AND event_name = '$eventName' AND event_category = 'group'";
$checkEventResult = $conn->query($checkEventQuery);

if ($checkEventResult->num_rows > 0) {
    // User has already registered for the same event
    header("Location: groupform.php?error=AlreadyRegistered");
    exit();
}

// Insert registration data into eventreg table
$insertQuery = "INSERT INTO eventreg (username, ktu_regno, student_name, semester, department, event_name, event_category) VALUES ('$uname', '$ktuRegNo', '$studentName', '$semester', '$department', '$eventName', '$eventCategory')";

if ($conn->query($insertQuery) === TRUE) {
    // Registration successful
    header("Location: success.php");
    exit();
} else {
    // Error in inserting data
    header("Location: singleform.php?error=RegistrationError");
    exit();
}

// Close database connection
// $conn->close();
?>
