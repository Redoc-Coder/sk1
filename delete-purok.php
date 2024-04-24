<?php
session_start(); // Start the session to access session variables

// Check if email is set in session
if (isset($_SESSION['email'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sk_database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if ID parameter is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare and bind statement to avoid SQL injection
        $deleteSql = $conn->prepare("DELETE FROM barangay_purok WHERE id = ?");
        $deleteSql->bind_param("i", $id);

        // Execute the statement
        if ($deleteSql->execute()) {
            echo "Delete Purok successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        // Close the prepared statement
        $deleteSql->close();
    } else {
        echo "ID parameter not set.";
    }

    // Close database connection
    $conn->close();
} else {
    // If email is not set in session, redirect to login page
    header("Location: barangay-login.php");
    exit();
}
?>
