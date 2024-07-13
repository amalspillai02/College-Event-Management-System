<!DOCTYPE html>
<html>
<head>
  <title>Create Announcement</title>
  <link rel="stylesheet" type="text/css" href="announcement.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="..\judges.php">judges</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="..\add_events\add_events.php">Add Events</a>
            </li> -->
            <!-- <li class="nav-item active"> 
					<a class="nav-link" href="../view_schedule.php">View Schedule</a>
				</li> -->
            <li class="nav-item">
                <a class="nav-link" href="..\admin\admindashboard.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="..\admin\adminlogout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
  <h2>Create Announcement</h2>
  <form action="create_announcement.php" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br><br>
    <label for="content">Content:</label><br>
    <textarea name="content" id="content" rows="4" cols="50" required></textarea><br><br>
    <label for="pdf">PDF File:</label>
    <input  type="file" name="pdf" id="pdf"><br><br>
    <input class="btn btn-primary" type="submit" value="Create Announcement">
  </form>
  <hr>
  <h2>Announcements</h2>
  <div class="announcements">
  <?php
    // Fetch and display announcements from the database
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // if ($conn->connect_error) {
    //   die("Connection failed: " . $conn->connect_error);
    // }
        session_start();
        include ('../db_conn.php');
    $sql = "SELECT * FROM announcements ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="announcement">';
        echo '<h3>' . $row["title"] . '</h3>';
        echo '<p>' . $row["content"] . '</p>';
        if (!empty($row["pdf_path"])) {
          echo '<a href="' . $row["pdf_path"] . '" target="_blank">View PDF</a>';
        }
        echo '<div class="actions">';
        echo '<a href="update_announcement.php?id=' . $row["id"] . '">Update</a>';
        echo '<a href="delete_announcement.php?id=' . $row["id"] . '">Delete</a>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo 'No announcements found.';
    }

    $conn->close();
    ?>
    <!-- Display announcements from the database here -->
  </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
