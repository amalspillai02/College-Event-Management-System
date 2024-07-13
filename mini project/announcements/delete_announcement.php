<?php
// Database connection details
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

// Check if announcement ID is provided
if (isset($_GET['id'])) {
  $announcementId = $_GET['id'];

  // Delete the announcement from the database
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "DELETE FROM announcements WHERE id = $announcementId";

  if ($conn->query($sql) === TRUE) {
    $success = "Announcement deleted successfully.";
  } else {
    $success = "Error deleting announcement: " . $conn->error;
  }

  $conn->close();
} else {
  echo "Invalid announcement ID.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Account Created</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      text-align: center;
    }
    
    h3 {
      color: #007bff;
      font-size: 24px;
      margin-top: 40px;
    }
    
    a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      font-size: 18px;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 20px;
      transition: background-color 0.3s;
    }
    
    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
  <a href="announcement_form.php">Click here to redirect to announcement</a>
</body>
</html>