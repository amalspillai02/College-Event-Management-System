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

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $ktuRegNo = $_POST['ktu_regno'];
    $message = $_POST['message'];

    // Verify the entered username, name, and KTU regno in the users table
    $verifyUserSql = "SELECT * FROM users WHERE username = '$username' AND name = '$name' AND ktu_regno = '$ktuRegNo'";
    $verifyUserResult = $conn->query($verifyUserSql);

    if ($verifyUserResult->num_rows === 0) {
        $errors[] = "Invalid username, name, or KTU regno.";
    }

    // Check if the message exceeds the maximum word limit
    $wordCount = str_word_count($message);
    if ($wordCount > 1000) {
        $errors[] = "The message can contain a maximum of 1000 words.";
    }

    // If no errors, insert the data into the contact table
    if (empty($errors)) {
        $insertSql = "INSERT INTO contact (username, name, ktu_regno, message) VALUES ('$username', '$name', '$ktuRegNo', '$message')";

        if ($conn->query($insertSql) === TRUE) {
            $success = "Your message is successfully send";
        } else {
            $success = "Error storing data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <link rel="stylesheet" type="text/css" href="contact.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="index.php" bg-warning>College Events</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<!-- <li class="nav-item active"> 
					<a class="nav-link" href="#">Home</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="events.php">Events</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="admin\adminlogin.php">Admin</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="home.php">Home</a>
				</li>
			</ul>
		</div>
	</nav>
    <div class="container">
        <h2>Contact Us</h2>
        <?php if (!empty($errors)) { ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <p class="error-message"><?php echo $error; ?></p>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <?php if (isset($success)) { ?>
          <p class="success-message"><?php echo $success; ?></p>
        <?php } ?>
        <form method="POST" action="contact.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="ktu_regno">KTU Reg No:</label>
                <input type="text" name="ktu_regno" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea name="message" rows="5" placeholder="⚠️ The message can contain a maximum of 1000 words" required></textarea>
                <div id="word-count">Words: 0</div>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
    <script>
        window.onload = function() {
            var messageInput = document.getElementsByName('message')[0];
            var wordCount = document.getElementById('word-count');

            messageInput.addEventListener('input', function() {
                var words = this.value.trim().split(/\s+/).filter(function(word) {
                    return word !== '';
                });

                wordCount.innerText = 'Words: ' + words.length;
            });
        };
    </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
