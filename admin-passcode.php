<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin Verification</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Admin Login</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                            <?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Redirect to the dashboard page
    header("Location: municipal-dashboard.php");
    exit();
}

if (isset($_SESSION['logout_alert'])) {
    echo "<div class='alert alert-success' role='alert'>You have been logged out successfully!</div>";
    unset($_SESSION['logout_alert']); // Remove the logout alert session variable
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the passcode from the form
    $passcode = $_POST['passcode'];

    // SQL query to check if the passcode exists in the admin_passcode table
    $sql = "SELECT * FROM admin_passcode WHERE passcode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $passcode);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there is a result and the number of rows returned is greater than 0
    if ($result && $result->num_rows > 0) {
        // Passcode is correct, set passcode in session and redirect to the login page
        $_SESSION['passcode'] = $passcode;
        header("Location: municipality-login.php");
        exit();
    } else {
        // Invalid passcode, show error message
        $error_message = "Invalid Passcode!";
    }
    $stmt->close();
}

$conn->close();
?>

    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Enter your Admin Passcode</h5>
        </div>

        <form class="row g-3 needs-validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
            <div class="col-12">
                <label for="yourPasscode" class="form-label">Passcode</label>
                <div class="input-group has-validation">
                    <input type="text" name="passcode" class="form-control" id="yourPasscode" required>
                    <div class="invalid-feedback">Please enter your Admin Passcode.</div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Submit</button>
            </div>
        </form>
    </div>

    <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">LSPU 3A WAM</a>
    </div>
</div>

                        </div>
                    </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>