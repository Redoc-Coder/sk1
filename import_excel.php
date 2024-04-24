<?php
session_start(); // Start the session to access session variables

// Check if email is set in session
if (!isset($_SESSION['email'])) {
    // If email is not set in session, redirect to login page
    header("Location: barangay-login.php");
    exit();
}

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

// Handle file upload and import data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['import_excel'])) {
    // Check if a file was uploaded without errors
    if (isset($_FILES["excel_file"]) && $_FILES["excel_file"]["error"] == 0) {
        $file_name = $_FILES["excel_file"]["name"];
        $temp_file = $_FILES["excel_file"]["tmp_name"];

        // Load PHPExcel library
        require 'PHPExcel/Classes/PHPExcel.php';

        // Load the Excel file
        $objPHPExcel = PHPExcel_IOFactory::load($temp_file);

        // Get the first sheet
        $worksheet = $objPHPExcel->getSheet(0);

        // Get the highest row and column numbers
        $highestRow = $worksheet->getHighestDataRow();

        // Start from the second row (assuming the first row is headers)
        for ($row = 2; $row <= $highestRow; $row++) {
            // Retrieve data from each column
            $barangay_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
            $last_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $first_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $middle_name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $gender = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $marital_status = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $contact_no = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $religion = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $birthdate = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            $osy = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
            $ws = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
            $yp = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
            $pwd = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
            $barangay_purok_no = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
            $voters = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
            $recent_act = $last_name . ',' . $first_name . ' add record in Youth Resident';

            // Insert data into the youth_barangay table
            $sql = "INSERT INTO youth_barangay (session_id, barangay_name, last_name, first_name, middle_name, gender, marital_status, contact_no, religion, birthdate, osy, ws, yp, pwd, barangay_purok_no, voters)
                VALUES ('{$_SESSION['email']}', '$barangay_name', '$last_name', '$first_name', '$middle_name', '$gender', '$marital_status', '$contact_no', '$religion', '$birthdate', '$osy', '$ws', '$yp', '$pwd' , '$barangay_purok_no', '$voters' )";

            if ($conn->query($sql) === TRUE) {
                // Insert data into the recent_activity table
                $sql1 = "INSERT INTO recent_activity (session_id, barangay_name, last_name, first_name, middle_name, gender, marital_status, contact_no, religion, birthdate, osy, ws, yp, pwd, recent_act, barangay_purok_no, voters)
                     VALUES ('{$_SESSION['email']}', '$barangay_name', '$last_name', '$first_name', '$middle_name', '$gender', '$marital_status', '$contact_no', '$religion', '$birthdate', '$osy', '$ws', '$yp', '$pwd', '$recent_act', '$barangay_purok_no', '$voters')";

                if ($conn->query($sql1) !== TRUE) {
                    echo "Error inserting recent activity: " . $conn->error;
                }
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }

        // Close database connection
        $conn->close();

        // Set success message in session
        $_SESSION['import_success'] = true;

        // Redirect back to barangay_management.php
        header("Location: barangay-management.php");
        exit();
    } else {
        echo "Error uploading file";
    }
}
?>
