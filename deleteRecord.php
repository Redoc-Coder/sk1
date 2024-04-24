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

  $email = $_SESSION['email'];


  $session_id = $_SESSION['email'];
}
else {
    // If email is not set in session, redirect to login page
    header("Location: barangay-login.php");
    exit();
  }



// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if session_id is set and not empty
    if (isset($_POST["session_id"]) && !empty($_POST["session_id"])) {
        // Sanitize the session_id to prevent SQL injection
        $session_id = filter_var($_POST["session_id"], FILTER_SANITIZE_NUMBER_INT);

        try {
            // Prepare and execute SQL statement to delete record
            $stmt = $pdo->prepare("DELETE FROM barangay_purok WHERE session_id = ?");
            $stmt->execute([$session_id]);

            // Check if the deletion was successful
            if ($stmt->rowCount() > 0) {
                // Return a success message
                echo "Record deleted successfully";
            } else {
                // Return an error message if deletion failed
                echo "Error: No records deleted";
            }
        } catch (PDOException $e) {
            // Return an error message if an exception occurs
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Return an error message if session_id is not set or empty
        echo "Error: Invalid session_id";
    }
} else {
    // Return an error message if request method is not POST
    echo "Error: Invalid request method";
}
?>
