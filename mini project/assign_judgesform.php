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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $judgeId = $_POST['judge_id'];
    $eventName = $_POST['event_name'];

    // Check if the judge is already assigned to the event
    $checkQuery = "SELECT COUNT(*) AS count FROM assign_judges 
                INNER JOIN events ON assign_judges.event_name = events.event_name 
                WHERE assign_judges.judge_id = '$judgeId' 
                AND events.event_time = (SELECT event_time FROM events WHERE event_name = '$eventName')";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $assignedJudgesCount = $row['count'];

        if ($assignedJudgesCount > 0) {
            $error = "Error: Judge is already assigned to another event at the same time!";
        } elseif ($assignedJudgesCount >= 3) {
            $error = "Error: Maximum number of judges assigned to the event!";
        } else {
            // Rest of the code to assign the judge to the event
            // Retrieve event details from the events table
            $eventQuery = "SELECT * FROM events WHERE event_name = '$eventName'";
            $eventResult = $conn->query($eventQuery);

            if ($eventResult && $eventResult->num_rows > 0) {
                $eventRow = $eventResult->fetch_assoc();
                $eventId = $eventRow['event_id'];
                $eventTime = $eventRow['event_time'];
                $eventDate = $eventRow['event_date'];
                $eventLocation = $eventRow['event_location'];
                $eventCategory = $eventRow['event_category'];

                // Retrieve judge details from the judges table
                $judgeQuery = "SELECT * FROM judges WHERE judge_id = '$judgeId'";
                $judgeResult = $conn->query($judgeQuery);

                if ($judgeResult && $judgeResult->num_rows > 0) {
                    $judgeRow = $judgeResult->fetch_assoc();
                    $judgeName = $judgeRow['judge_name'];

                    // Insert the assignment into the assign_judges table
                    $insertQuery = "INSERT INTO assign_judges (judge_id, judge_name, event_id, event_name, event_time, event_date, event_location, event_category) VALUES ('$judgeId', '$judgeName', '$eventId', '$eventName', '$eventTime','$eventDate', '$eventLocation', '$eventCategory')";

                    if ($conn->query($insertQuery) === TRUE) {
                        $success = "Judge assigned successfully!";
                    } else {
                        $error = "Error assigning judge: " . $conn->error;
                    }
                } else {
                    $error = "Error: Judge not found!";
                }
            } else {
                $error = "Error: Event not found!";
            }
        }
    } else {
        $error = "Error checking assigned judges: " . $conn->error;
    }
}

// Retrieve the list of judges
$judgesQuery = "SELECT * FROM judges";
$judgesResult = $conn->query($judgesQuery);

// Retrieve the list of events
$eventsQuery = "SELECT * FROM events";
$eventsResult = $conn->query($eventsQuery);

// Delete assigned judge
if (isset($_GET['delete_id']) && isset($_GET['event_id'])) {
    $deleteId = $_GET['delete_id'];
    $eventId = $_GET['event_id'];
    
    $deleteQuery = "DELETE FROM assign_judges WHERE judge_id = '$deleteId' AND event_id = '$eventId'";
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: assign_judgesform.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve the assigned judges
$assignedJudgesQuery = "SELECT * FROM assign_judges";
$assignedJudgesResult = $conn->query($assignedJudgesQuery);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Judges</title>
    <link rel="stylesheet" type="text/css" href="judges.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"> 
                <a class="nav-link" href="admin\admindashboard.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin\adminlogout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2>Assign Judges</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="judge_id">Judge ID:</label>
            <select class="form-control" id="judge_id" name="judge_id" required>
                <option value="">Select Judge</option>
                <?php if ($judgesResult && $judgesResult->num_rows > 0): ?>
                    <?php while ($judgeRow = $judgesResult->fetch_assoc()): ?>
                        <option value="<?php echo $judgeRow['judge_id']; ?>"><?php echo $judgeRow['judge_id']; ?></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="judge_name">Judge Name:</label>
            <input type="text" class="form-control" id="judge_name" name="judge_name" readonly>
        </div>
        <div class="form-group">
            <label for="event_name">Event Name:</label>
            <select class="form-control" id="event_name" name="event_name" required>
                <option value="">Select Event</option>
                <?php if ($eventsResult && $eventsResult->num_rows > 0): ?>
                    <?php while ($eventRow = $eventsResult->fetch_assoc()): ?>
                        <option value="<?php echo $eventRow['event_name']; ?>"><?php echo $eventRow['event_name']; ?></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="event_id">Event ID:</label>
            <input type="text" class="form-control" id="event_id" name="event_id" readonly>
        </div>
        <div class="form-group">
            <label for="event_time">Event Time:</label>
            <input type="text" class="form-control" id="event_time" name="event_time" readonly>
        </div>
        <div class="form-group">
            <label for="event_date">Event Date:</label>
            <input type="text" class="form-control" id="event_date" name="event_date" readonly>
        </div>
        <div class="form-group">
            <label for="event_location">Event Location:</label>
            <input type="text" class="form-control" id="event_location" name="event_location" readonly>
        </div>
        <div class="form-group">
            <label for="event_category">Event Category:</label>
            <input type="text" class="form-control" id="event_category" name="event_category" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Assign Judge</button>
    </form>
</div>

<div class="container mt-5">
<h3>Assigned Judges</h3>
        <?php if ($assignedJudgesResult && $assignedJudgesResult->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Judge ID</th>
                        <th>Judge Name</th>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Event Time</th>
                        <th>Event Date</th>
                        <th>Event Location</th>
                        <th>Event Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $assignedJudgesResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['judge_id']; ?></td>
                            <td><?php echo $row['judge_name']; ?></td>
                            <td><?php echo $row['event_id']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_time']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['event_location']; ?></td>
                            <td><?php echo $row['event_category']; ?></td>
                            <td>
                            <a href="?delete_id=<?php echo $row['judge_id']; ?>&event_id=<?php echo $row['event_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No assigned judges found.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Fetch judge name based on judge ID
        $('#judge_id').change(function() {
            var judgeId = $(this).val();
            if (judgeId !== '') {
                $.ajax({
                    url: 'fetch_judge_name.php',
                    type: 'POST',
                    data: {judge_id: judgeId},                    
                    success: function(response) {
                        $('#judge_name').val(response);
                    }
                });
            } else {
                $('#judge_name').val('');
            }
        });

        // Fetch event details based on event Name
        $('#event_name').change(function() {
    var eventName = $(this).val();
    if (eventName !== '') {
        $.ajax({
            url: 'fetch_event_details.php',
            type: 'POST',
            data: { event_name: eventName },
            success: function(response) {
                var eventDetails = JSON.parse(response);
                $('#event_id').val(eventDetails.event_id);
                $('#event_time').val(eventDetails.event_time);
                $('#event_date').val(eventDetails.event_date);
                $('#event_location').val(eventDetails.event_location);
                $('#event_category').val(eventDetails.event_category);
            }
        });
    } else {
        $('#event_id').val('');
        $('#event_time').val('');
        $('#event_date').val('');
        $('#event_location').val('');
        $('#event_category').val('');
    }
});

    });
</script>
</body>
</html>
