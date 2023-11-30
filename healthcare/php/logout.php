<?php
// Start or resume the session
session_start();

// Destroy the session data
session_destroy();

// Redirect to the login page (or any other page as needed)
header("Location: ../admin.php"); // Replace with the actual login page URL
exit();
?>
