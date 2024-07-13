<?php
// Database connection details
$servername = "p:127.0.0.1:3307"; // replace with your server name if different
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "college_events"; // replace with your database name

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve schedule data from the events table
$sql = "SELECT * FROM events";
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
    <title>Event Schedule</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style> -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="index.php" bg-warning>College Events</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
            <li class="nav-item">
					<a class="nav-link" href="home.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="events.php">Events</a>
				</li>			
				<li class="nav-item active"> 
					<a class="nav-link" href="announcements\view_announcements.php">Announcements</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
                <li class="nav-item">
					<a class="nav-link" href="admin\adminlogin.php">Admin</a>
				</li>
			</ul>
		</div>
	</nav>
    <h2>Event Schedule</h2>
    <table>
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Event Category</th>
            <th>Event Time</th>
            <th>Event Date</th>
            <th>Event Location</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["event_id"] . "</td>";
                echo "<td>" . $row["event_name"] . "</td>";
                echo "<td>" . $row["event_category"] . "</td>";
                echo "<td>" . $row["event_time"] . "</td>";
                echo "<td>" . $row["event_date"] . "</td>";
                echo "<td>" . $row["event_location"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No events scheduled.</td></tr>";
        }
        ?>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
