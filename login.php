<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
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

    // Escape user inputs for security
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the provided email and password match a user in the database
    $sql = "SELECT * FROM barangay WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Check if a matching user was found
        if (mysqli_num_rows($result) == 1) {
            // User exists, set session variables and redirect to dashboard or home page
            $_SESSION['email'] = $email;
            mysqli_close($conn); // Close database connection before redirection
            header("Location: barangay_form.html"); // Redirect to dashboard page
            exit(); // Make sure no further output is sent after redirection
        } else {
            // Invalid email or password, show error message
            $error = "Invalid email or password.";
        }
    } else {
        // Error executing query
        $error = "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
