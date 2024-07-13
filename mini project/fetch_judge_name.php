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

// Check if the judge_id is provided
if (isset($_POST['judge_id'])) {
    $judgeId = $_POST['judge_id'];

    // Fetch the judge name based on the judge_id
    $query = "SELECT judge_name FROM judges WHERE judge_id = '$judgeId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $judgeRow = $result->fetch_assoc();
        $judgeName = $judgeRow['judge_name'];
        echo $judgeName;
    } else {
        echo "Unknown Judge";
    }
} else {
    echo "Invalid Request";
}

// Close the database connection
$conn->close();
?>
