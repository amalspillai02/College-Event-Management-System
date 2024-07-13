<?php
// Database connection details
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

// Create a new announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $content = $_POST["content"];
  $pdfPath = "";

  // Upload PDF file if selected
  if ($_FILES["pdf"]["size"] > 0) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["pdf"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if file is a PDF
    if($pdfFileType != "pdf") {
      echo "Only PDF files are allowed.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
      echo "File already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["pdf"]["size"] > 500000) {
      echo "File size should not exceed 500KB.";
      $uploadOk = 0;
    }

    // Upload file if everything is fine
    if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFile)) {
        $pdfPath = $targetFile;
      } else {
        echo "Failed to upload file.";
      }
    }
  }

  // Save the announcement in the database
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO announcements (title, content, created_at, pdf_path)
          VALUES ('$title', '$content', NOW(), '$pdfPath')";

  if ($conn->query($sql) === TRUE) {
    $success = "Announcement created successfully.";
  } else {
    $success = "Error creating announcement: " . $conn->error;
  }

  $conn->close();
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