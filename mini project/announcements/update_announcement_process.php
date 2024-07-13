<?php
// Database connection details
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $announcementId = $_POST["id"];
  $title = $_POST["title"];
  $content = $_POST["content"];

  // Handle PDF file upload
  $pdfPath = "";
  if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] === UPLOAD_ERR_OK) {
    $pdfName = $_FILES["pdf"]["name"];
    $pdfTmpName = $_FILES["pdf"]["tmp_name"];
    $pdfPath = "uploads/" . $pdfName;
    move_uploaded_file($pdfTmpName, $pdfPath);
  }

  // Update the announcement in the database
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the previous PDF path
  $sql = "SELECT pdf_path FROM announcements WHERE id = '$announcementId'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $previousPdfPath = $row["pdf_path"];

  // Check if the PDF file needs to be updated or deleted
  if (!empty($pdfPath)) {
    $sql = "UPDATE announcements SET title = '$title', content = '$content', pdf_path = '$pdfPath' WHERE id = '$announcementId'";
    // Delete the previous PDF file if it exists
    if (!empty($previousPdfPath) && file_exists($previousPdfPath)) {
      unlink($previousPdfPath);
    }
  } else {
    $sql = "UPDATE announcements SET title = '$title', content = '$content', pdf_path = NULL WHERE id = '$announcementId'";
    // Delete the previous PDF file
    if (!empty($previousPdfPath) && file_exists($previousPdfPath)) {
      unlink($previousPdfPath);
    }
  }

  if ($conn->query($sql) === TRUE) {
    $success = "Announcement updated successfully.";
  } else {
    $success = "Error updating announcement: " . $conn->error;
  }

  $conn->close();
} else {
  echo "Invalid request.";
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
