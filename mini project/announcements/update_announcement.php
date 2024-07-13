<?php
// Database connection details
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

// Check if announcement ID is provided
if (isset($_GET['id'])) {
  $announcementId = $_GET['id'];

  // Retrieve the announcement from the database
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM announcements WHERE id = $announcementId";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display the update form
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<title>Update Announcement</title>';
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
    echo '<link rel="stylesheet" type="text/css" href="announcement.css">';
    echo '</head>';
    echo '<body>';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>';
    echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
            echo '<span class="navbar-toggler-icon"></span>';
            echo '</button>';
            echo '<div class="collapse navbar-collapse" id="navbarNav">';
            echo '<ul class="navbar-nav ml-auto">';
            // <!-- <li class="nav-item active">
            //     <a class="nav-link" href="..\judges.php">judges</a>
            // </li>
            // <li class="nav-item">
            //     <a class="nav-link" href="..\add_events\add_events.php">Add Events</a>
            // </li> -->
            echo'<li class="nav-item">';
            echo'<a class="nav-link" href="admindashboard.php">Admin</a>';
            echo'</li>';
            echo'<li class="nav-item">';
            echo'<a class="nav-link" href="adminlogout.php">Logout</a>';
            echo'</li>';
            echo'</ul>';
            echo '</div>';
            echo '</nav>';
    echo '<h2>Update Announcement</h2>';
    echo '<form action="update_announcement_process.php" method="post" enctype="multipart/form-data">';
    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
    echo 'Title: <input type="text" name="title" value="' . $row["title"] . '" required><br><br>';
    echo 'Content: <br>';
    echo '<textarea name="content" rows="4" cols="50" required>' . $row["content"] . '</textarea><br><br>';
    echo 'PDF: <input type="file" name="pdf"><br><br>';

    // Display the delete button if a PDF file exists
    if (!empty($row["pdf_path"])) {
      echo 'Uploaded PDF: <a href="' . $row["pdf_path"] . '">View File</a><br><br>';
      echo '<input type="checkbox" name="delete_pdf" value="1"> Delete PDF<br><br>';
    }

    echo '<input type="submit" value="Update Announcement">';
    echo '</form>';
    echo '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>';
    echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
    echo '</body>';
    echo '</html>';
  } else {
    echo "Announcement not found.";
  }

  $conn->close();
} else {
  echo "Invalid announcement ID.";
}
?>
