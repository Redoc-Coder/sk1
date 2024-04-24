<?php
session_start(); // Start the session for storing logged-in user data

// Check if the form is submitted and email is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if code has already been sent to this email
    if (isset($_SESSION['code_sent']) && $_SESSION['code_sent'] == $email) {
        echo json_encode(array("success" => false, "message" => "Code has already been sent to this email."));
    } else {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = ""; // Change this to your database password if you have one
        $dbname = "sk_database"; // Change this to your actual database name

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($con->connect_error) {
            echo json_encode(array("success" => false, "message" => "Database connection failed."));
            exit();
        }

        // Check if email exists in database
        $checkEmailQuery = "SELECT * FROM barangay WHERE email = '$email'";
        $checkEmailResult = mysqli_query($con, $checkEmailQuery);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            // Email exists, generate a random password
            $newPassword = generateRandomPassword(8); // Change password length if needed

            // Update user password in the database
            $updatePasswordQuery = "UPDATE barangay SET password = '$newPassword' WHERE email = '$email'";
            $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

            if ($updatePasswordResult) {
                // Send the new password to the email
                $subject = "Your New Password";
                $message = "Your new temporary password is: $newPassword";
                $headers = "From: YourWebsite <noreply@yourwebsite.com>\r\n";
                $headers .= "Reply-To: noreply@yourwebsite.com\r\n";
                $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    // Set session variable to indicate that code has been sent
                    $_SESSION['code_sent'] = $email;
                    echo json_encode(array("success" => true, "message" => "Code sent successfully!"));
                } else {
                    echo json_encode(array("success" => false, "message" => "Failed to send code. Please try again later."));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to update password."));
            }
        } else {
            // Email does not exist in database
            echo json_encode(array("success" => false, "message" => "Email not found in the database!"));
        }
    }
}

// Function to generate a random alphanumeric password
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomPassword;
}
?>
