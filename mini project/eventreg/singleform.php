<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Event Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="regist.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">College Events</a>
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
                    <a class="nav-link" href="../home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3>Single Event Registration</h3>
        
        <?php if(isset($_GET['error'])) { ?>
            <p class="error-message"><?php echo $_GET['error'];?></p>
        <?php } ?>
        
        <form class="registration-form" action="submitsingle.php" method="POST">
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" id="uname" name="uname" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="ktu_regno">KTU Registration Number</label>
                <input type="text" class="form-control" id="ktu_regno" name="ktu_regno" placeholder="Enter your KTU Registration Number" required>
            </div>
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" placeholder="Enter your semester" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="" selected disabled>Select Department</option>
                    <option value="CSE">CSE</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                    <option value="ME">ME</option>
                    <option value="CIVIL">CIVIL</option>
                </select>
            </div>
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <select class="form-control" id="event_name" name="event_name" required>
                    <option value="" selected disabled>Select an event</option>
                    <?php
                            // Fetch events from the database
                            $servername = "p:127.0.0.1:3307";
                            $username = "root";
                            $password = "";
                            $dbname = "college_events";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch events with event_category 'solo'
                            $query = "SELECT * FROM events WHERE event_category = 'solo'";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['event_name'] . '">' . $row['event_name'] . '</option>';
                                }
                            }

                            $conn->close();
                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="event_category">Event Category</label>
                <select class="form-control" id="event_category" name="event_category" required>
                    <option value="single">Single Event</option>
                </select>
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
