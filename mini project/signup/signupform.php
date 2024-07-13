<!DOCTYPE html>
<html>
<head>
    <title>College Event Management System - Signup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="home title.png" type="image/icon type">
    <!-- Bootstrap CDN link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <!-- Navbar -->
    <!-- ... navbar code ... -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="../index.php">College Events</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"> 
					<a class="nav-link" href="../home.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="">Events</a>
				</li>
                <li class="nav-item active"> 
					<a class="nav-link" href="..\view_schedule.php">View Schedule</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="#">Admin</a>
				</li> -->
				<li class="nav-item">
					<a class="nav-link" href="../contact.php">Contact</a>
				</li>
			</ul>
		</div>
	</nav>
    <!-- Signup form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center mb-4">Signup</h3>
                <?php include 'signup.php'; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name as per the ID card">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="ktu_regno">KTU Registration Number</label>
                        <input type="text" class="form-control" id="ktu_regno" name="ktu_regno">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery and Bootstrap JS CDN links -->
    <!-- ... JS CDN links ... -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
                       
