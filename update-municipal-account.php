<?php
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

// Check if form is submitted and ID parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Escape user inputs for security
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    

    // Update record in database
    $sql = "UPDATE barangay SET first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', contact_no='$contact_no' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // echo "Record updated successfully";
        header("Location:municipal-account.php");

    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

// Close database connection
$conn->close();
?>