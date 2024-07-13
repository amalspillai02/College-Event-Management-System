<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values
    $name = $_POST['name'];
    $uname = $_POST['username'];
    $ktu_regno = $_POST['ktu_regno'];
    $dob = $_POST['dob'];
    $pass = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Perform form validation
    $errors = [];

    // Check if required fields are empty
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($uname)) {
        $errors[] = "Username is required.";
    }

    if (empty($ktu_regno)) {
        $errors[] = "KTU Registration Number is required.";
    }

    if (empty($dob)) {
        $errors[] = "Date of Birth is required.";
    }

    if (empty($pass)) {
        $errors[] = "Password is required.";
    }

    if (empty($confirm_password)) {
        $errors[] = "Confirm Password is required.";
    }

    // Check if password and confirm password match
    if ($pass !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if there are any errors
    if (empty($errors)) {
        // Database connection code
        $conn = mysqli_connect("p:127.0.0.1:3307", "root", "", "college_events");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if username is already present in the table
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username already exists
            $errors[] = "Username already exists.";
        }

        // Check if ktu_regno is already present in the table
        $stmt = $conn->prepare("SELECT * FROM users WHERE ktu_regno = ?");
        $stmt->bind_param("s", $ktu_regno);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // KTU Reg No already exists
            $errors[] = "KTU Reg No already exists.";
        }

        if (empty($errors)) {
            // Save data in the database
            $stmt = $conn->prepare("INSERT INTO users (name, username, ktu_regno, dob, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $uname, $ktu_regno, $dob, $pass);
            $stmt->execute();

            // Close the statement and connection
            $stmt->close();
            mysqli_close($conn);

            // Redirect to success page or perform other actions
            header("Location:redirectpage.php");
            exit();
        }

        // Close the statement and connection
        $stmt->close();
        mysqli_close($conn);
    }
}

// Display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>
