<?php
// Database connection details
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

// Retrieve the announcements from the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Announcements</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="announcement.css">
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
					<a class="nav-link" href="../home.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="..\events.php">Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="..\admin\adminlogin.php">Admin</a>
				</li>
				<li class="nav-item active"> 
					<a class="nav-link" href="..\view_schedule.php">View Schedule</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="..\contact.php">Contact</a>
				</li>
			</ul>
		</div>
	</nav>
  <h2>Announcements</h2>
  <?php
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<div class="announcement">';
      echo '<h3>' . $row["title"] . '</h3>';
      echo '<p>' . $row["content"] . '</p>';
      if (!empty($row["pdf_path"])) {
        echo '<a href="' . $row["pdf_path"] . '">View File</a>';
      }
      echo '</div>';
    }
  } else {
    echo "No announcements found.";
  }

  $conn->close();
  ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
