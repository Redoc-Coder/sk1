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
    $barangay_purok_no = $_POST['barangay_purok_no'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $birthdate = $_POST['birthdate'];
    $marital_status = $_POST['marital_status'];

    // Prepare update query
    $sql = "UPDATE youth_barangay SET barangay_purok_no= '$barangay_purok_no', first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', contact_no='$contact_no', birthdate='$birthdate', marital_status='$marital_status' WHERE id=$id";

    // Execute update query
    if ($conn->query($sql) === TRUE) {
        // echo "Record updated successfully";
        header("Location: youth-list.php");

    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
