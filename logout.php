<?php
session_start();
// Perform logout operations here
// For example:
unset($_SESSION['email']); // Unset the logged-in user email

$_SESSION['logout_alert'] = true; // Set the logout alert session variable
header("Location: barangay-login.php");
exit();
?>