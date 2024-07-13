<?php
// Start the session
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin'])) {
    header("Location: admindashboard.php"); // Redirect to admin dashboard if already logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the admin credentials are valid
    if ($username === 'admin' && $password === 'admin') {
        // Admin login successful, create a session
        $_SESSION['admin'] = true;
        header("Location: admindashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Invalid admin credentials
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Add your custom stylesheets or Bootstrap CSS here -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="..\index.php" bg-warning>College Events</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<!-- <li class="nav-item active"> 
					<a class="nav-link" href="#">Home</a>
				</li> -->
				<!-- <li class="nav-item">
					<a class="nav-link" href="events.php">Events</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="adminlogin.php">Admin</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="#">Contact</a>
				</li> -->
			</ul>
		</div>
	</nav>
    <div class="container">
    <h1>Admin Login</h1>
    <form action="" method="POST"> 
        <?php if (isset($error)) { ?>
          <p class="error-message"><?php echo $error; ?></p>
        <?php } ?>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <div class="password-container">
            <input type="password" id="password" name="password" id="password" required>
            <i class="fas fa-eye" id="toggle-password"></i>
        </div>
        </div>
        <button type="submit" class="btn-login">Login</button>
    </form>
    
    </div>
    <script src="../script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add your additional content or styling here -->
</body>
</html>
