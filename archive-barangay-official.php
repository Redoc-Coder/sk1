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

        // Fetch record details from the database based on the ID
        $sql = "SELECT * FROM barangay_official WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Archive the record by moving it to another table in the database
            $row = $result->fetch_assoc();
            
            // Insert into archived table
            $archiveSql = "INSERT INTO archived_official_records (barangay_name, first_name, middle_name, last_name, gender, contact_no, committee, barangay_position, session_id) VALUES ('" . $row['barangay_name'] . "', '" . $row['first_name'] . "', '" . $row['middle_name'] . "', '" . $row['last_name'] . "', '" . $row['gender'] . "', '" . $row['contact_no'] . "', '" . $row['committee'] . "', '" . $row['barangay_position'] . "' ,  '" . $row['session_id'] . "')";

            if ($conn->query($archiveSql) === TRUE) {
                // After archiving, delete the record from the original table
                $deleteSql = "DELETE FROM barangay_official WHERE id = $id";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "Record archived successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            } else {
                echo "Error archiving record: " . $conn->error;
            }
        } else {
            echo "Record not found.";
        }
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
