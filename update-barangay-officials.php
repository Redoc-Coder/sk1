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

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $committee = $_POST['committee'];
    $barangay_position = $_POST['barangay_position'];

    // Prepare update query
    $sql = "UPDATE barangay_official SET first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', contact_no='$contact_no', committee='$committee', barangay_position='$barangay_position' WHERE id=$id";

    // Execute update query
    if ($conn->query($sql) === TRUE) {
        // echo "Record updated successfully";
        header("Location: barangay-official-list.php");


    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
