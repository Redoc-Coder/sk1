<?php
session_start();

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

// Insert data into a table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get session ID
    $session_id = session_id();

    $barangay_name = $_POST['barangay_name'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $contact_no = $_POST['contact_no'];
    $religion = $_POST['religion'];
    $birthdate = $_POST['birthdate'];
    $osy = $_POST['osy'];
    $ws = $_POST['ws'];
    $yp = $_POST['yp'];
    $pwd = $_POST['pwd'];

    $sql = "INSERT INTO youth_barangay (session_id, barangay_name, last_name, first_name, middle_name, gender, marital_status, contact_no, religion, birthdate, osy, ws, yp, pwd)
            VALUES ('$session_id', '$barangay_name', '$last_name', '$first_name', '$middle_name', '$gender', '$marital_status', '$contact_no', '$religion', '$birthdate', '$osy', '$ws', '$yp', '$pwd')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      header("Location: barangay-management.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
