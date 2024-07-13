<?php
// Start the session
session_start();

// Destroy the admin session
session_destroy();

header("Location: adminlogin.php"); // Redirect to admin login page
exit();
?>
