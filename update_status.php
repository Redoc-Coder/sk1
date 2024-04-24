<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if status and id parameters are set
    if (isset($_POST["status"]) && isset($_POST["id"])) {
        // Sanitize input to prevent SQL injection
        $status = $_POST["status"];
        $id = $_POST["id"];

        // Perform database update
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

        // Prepare and execute SQL statement to update status
        $sql = "UPDATE barangay SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        // Close statement and database connection
        $stmt->close();
        $conn->close();

        // Respond to the client-side JavaScript
        echo "Status updated successfully.";
    } else {
        // If parameters are not set, respond with an error message
        echo "Error: Missing parameters.";
    }
} else {
    // If the request method is not POST, respond with an error message
    echo "Error: Invalid request method.";
}
?>