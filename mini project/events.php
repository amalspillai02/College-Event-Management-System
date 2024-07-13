<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="events.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">College Events</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Admin</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item active"> 
					<a class="nav-link" href="view_schedule.php">View Schedule</a>
				</li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="event">
            <img src="images\single.jpg" alt="Event 1" class="event-image">
            <div class="event-description">
                <h2>Single Events</h2>
                <p>Register you events</p>
                <a  class="btn-register" href="eventreg\singleform.php">Register</a>
            </div>
        </div>
        <div class="event">
            <img src="images\group.jpg" alt="Event 2" class="event-image">
            <div class="event-description">
                <h2>Group Events</h2>
                <p>Register your events</p>
                <a href="eventreg\groupform.php" class="btn-register">Register</a>
            </div>
        </div>
        <!-- Add more events here -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
