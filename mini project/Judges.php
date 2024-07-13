<?php

// Database connection settings
$host = "p:127.0.0.1:3307";
$username = "root";
$password = "";
$database = "college_events";

// Create a new MySQLi instance
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $judgeName = trim($_POST['judge_name']);

    // Check if judge already exists
    $query = "SELECT * FROM judges WHERE judge_name = '$judgeName'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $error = "Error: Judge already exists!";
    } else {
        // Insert the judge into the database
        $sql = "INSERT INTO judges (judge_name) VALUES ('$judgeName')";

        if ($conn->query($sql) === TRUE) {
            $success = "Judge added successfully!";
        } else {
            $success = "Error adding judge: " . $conn->error;
        }
    }
}

// Delete judge if requested
if (isset($_POST['delete'])) {
    $judgeId = $_POST['judge_id'];
    $deleteSql = "DELETE FROM judges WHERE judge_id = '$judgeId'";

    if ($conn->query($deleteSql) === TRUE) {
        $deleteSuccess = "Judge deleted successfully!";
    } else {
        $deleteError = "Error deleting judge: " . $conn->error;
    }
}

// Retrieve the judges from the database
$searchJudge = isset($_GET['search_judge']) ? $_GET['search_judge'] : '';
$query = "SELECT * FROM judges";

// Add search condition if a judge name is provided
if (!empty($searchJudge)) {
    $searchJudge = $conn->real_escape_string($searchJudge);
    $query .= " WHERE judge_name LIKE '%$searchJudge%'";
}

$result = $conn->query($query);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Judge</title>
    <link rel="stylesheet" type="text/css" href="judges.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php" bg-warning>College Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="assign_judgesform.php">Assign Judges</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="admin\admindashboard.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin\adminlogout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<h2>Add Judge</h2>
<div class="container">

    <form method="POST" action="Judges.php">
        <?php if (isset($error)) { ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <p class="success-message"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($deleteSuccess)) { ?>
            <p class="success-message"><?php echo $deleteSuccess; ?></p>
        <?php } ?>
        <?php if (isset($deleteError)) { ?>
            <p class="error-message"><?php echo $deleteError; ?></p>
        <?php } ?>
        <div class="form-group">
            <label for="judge_name">Judge Name:</label>
            <input type="text" name="judge_name" required>
            <br>
        </div>
        <input type="submit" value="Add Judge" class="btn-submit">
    </form>
    
    <!-- Search Bar -->
    <form method="GET" action="Judges.php" class="search-form">
        <div class="form-group">
            <label for="search_judge">Search Judge:</label>
            <input type="text" name="search_judge" id="search_judge" placeholder="Enter judge name">
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </form>

    <?php if ($result->num_rows > 0) { ?>
        <h3>Added Judges:</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judge Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['judge_name']; ?></td>
                        <td>
                            <form method="POST" action="Judges.php">
                                <input type="hidden" name="judge_id" value="<?php echo $row['judge_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
    <?php if (!empty($searchJudge)) { ?>
        echo '<p>No judges found for the given search query.</p>';
    <?php } else { ?>
       echo '<p>No judges added yet.</p>';
    <?php } ?>
<?php } ?>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
