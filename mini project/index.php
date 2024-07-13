<!DOCTYPE html>
<html>
<head>
	<title>College Event Management System</title>
	<link rel="icon" href="images/home title.png" type="image/icon type">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
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
					<a class="nav-link" href="events.php">Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="admin\adminlogin.php">Admin</a>
				</li>
				<li class="nav-item active"> 
					<a class="nav-link" href="view_schedule.php">View Schedule</a>
				</li>
				<li class="nav-item active"> 
					<a class="nav-link" href="announcements\view_announcements.php">Announcements</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid">
	<!-- content goes here -->
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-4">
				<h3 class="text-center mb-4">Login</h3>
				<?php if(isset($_GET['error'])) { ?>
					<p class="error"><?php echo $_GET['error'];?></p>
				<?php } ?>
				<form class="login" action="login.php" method="POST">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="uname"  required>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<div class="password-container">
							<input type="password" name="password" id="password" required>
							<i class="fas fa-eye" id="toggle-password"></i>
						</div>
					</div>

					<button type="submit" class="btn btn-success btn-block">Submit</button>
					<hr class="line">
					<a href="signup/signupform.php">Create an account</a>
				</form>
			</div>
		</div>
	</div>
</div>

	<script src="script.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
