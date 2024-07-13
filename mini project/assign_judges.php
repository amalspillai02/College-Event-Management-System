<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values
    $judge_id = $_POST['judge'];
    $event_name = $_POST['event_name'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];
    $event_category = $_POST['event_category'];

    // Database connection details
    $servername = "p:127.0.0.1:3307"; // replace with your server name if different
    $username = "root"; // replace with your database username
    $password = ""; // replace with your database password
    $dbname = "college_events"; // replace with your database name

    // Create database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        // Insert assigned judges into the database
        $query = "INSERT INTO assign_judges (judge_id, judge_name, event_name, event_time, event_location, event_category) VALUES ('$judge_id', (SELECT judge_name FROM judges WHERE judge_id = '$judge_id'), '$event_name', '$event_time', '$event_location', '$event_category')";
    
        if (mysqli_query($conn, $query)) {
            // Assignment successful
            echo "Judges assigned successfully.";
        } else {
            // Error in assigning judges
            echo "Error assigning judges: " . mysqli_error($conn);
        }
    
        // Close database connection
        mysqli_close($conn);
    }
    
