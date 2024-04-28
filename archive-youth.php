<?php
session_start();

if (isset($_SESSION['email'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sk_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id']) && isset($_GET['reason'])) {
        $id = $_GET['id'];
        $reason = $_GET['reason'];

        $sql = "SELECT * FROM youth_barangay WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $archiveSql = "INSERT INTO archived_youth_records (first_name, middle_name, last_name, gender, contact_no, birthdate, marital_status, religion, osy, ws, yp, pwd, reg_date, session_id, barangay_purok_no, archived_reasons) VALUES ('" . $row['first_name'] . "', '" . $row['middle_name'] . "', '" . $row['last_name'] . "', '" . $row['gender'] . "', '" . $row['contact_no'] . "', '" . $row['birthdate'] . "', '" . $row['marital_status'] . "' , '" . $row['religion'] . "' , '" . $row['osy'] . "' ,'" . $row['ws'] . "' , '" . $row['yp'] . "', '" . $row['pwd'] . "' , '" . $row['reg_date'] . "' , '" . $row['session_id'] . "' , '" . $row['barangay_purok_no'] . "', '" . $reason . "')";

            if ($conn->query($archiveSql) === TRUE) {
                $deleteSql = "DELETE FROM youth_barangay WHERE id = $id";
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
        echo "ID or reason parameter not set.";
    }

    $conn->close();
} else {
    header("Location: barangay-login.php");
    exit();
}
?>
