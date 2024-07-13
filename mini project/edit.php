<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection code - Replace with your own
$servername = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "college_events";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's details
$uname = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$uname'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();

// Update user details functionality
$updateSuccess = false;
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $ktuRegNo = $_POST['ktu_regno'];

    $update_sql = "UPDATE users SET name = '$name', dob = '$dob', ktu_regno = '$ktuRegNo' WHERE username = '$uname'";

    if ($conn->query($update_sql) === true) {
        $_SESSION['name'] = $name; // Update the session variable with the new name
        $updateSuccess = true;
    } else {
        echo "Error updating user details: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h1>Edit Details</h1>

    <?php if ($updateSuccess) { ?>
        <div class="alert alert-success" role="alert">
            User details updated successfully.
        </div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>">
        </div>
        <div class="form-group">
            <label for="ktu_regno">KTU Registration Number:</label>
            <input type="text" class="form-control" id="ktu_regno" name="ktu_regno" value="<?php echo $row['ktu_regno']; ?>">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
