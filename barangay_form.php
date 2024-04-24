<?php
// Start the session
// session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check if the street already exists
    $street = $_POST["street"];
    $check_sql = "SELECT id FROM barangay WHERE street = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $street);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Street already exists. Please enter a unique street name.";
        exit; // Stop execution if street already exists
    }

    // Prepare SQL query
    $sql = "INSERT INTO barangay (street, municipal, province, first_name, middle_name, last_name, contact_no, gender, valid_id, email, password, session_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $street, $municipal, $province, $first_name, $middle_name, $last_name, $contact_no, $gender, $valid_id, $email, $password, $session_id);

    // Set parameters
    $municipal = $_POST["municipal"];
    $province = $_POST["province"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $contact_no = $_POST["contact_no"];
    $gender = $_POST["gender"];
    // Handling file upload for valid_id (Assuming it's stored as a file path)
    $valid_id = "uploads/" . basename($_FILES["valid_id"]["name"]); // You need to handle file uploads securely in a real scenario
    move_uploaded_file($_FILES["valid_id"]["tmp_name"], $valid_id);
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password before storing
    $session_id = $_POST["email"]; // Set session_id to email

    // Execute SQL
    if ($stmt->execute()) {
        echo "New record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statements
    $stmt->close();
    $check_stmt->close();
    // Close connection
    $conn->close();
}
?>
