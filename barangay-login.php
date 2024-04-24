<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Barangay Login</title>
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

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Barangay Login</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <?php
                session_start(); // Start the session for storing logged-in user data
                
                // Check if the user has logged out and display the logout alert
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
                  // Fetch the street associated with the entered email
                  $email = $_POST['email'];
                  $password = $_POST['password'];
                  $selected_street = $_POST['barangay'];

                  $sql = "SELECT street FROM barangay WHERE email = '$email'";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $db_street = $row['street'];

                    // Check if the selected street matches the street associated with the email
                    if ($db_street != $selected_street) {
                      echo "<div class='alert alert-danger' role='alert'>Street doesn't match with the email!</div>";
                    } else {
                      // Validate email and password
                      // Add your validation logic here
                
                      // Store email in session
                      $_SESSION['email'] = $email;

                      // For example, you can compare email and password with the database records
                      // If valid credentials, redirect to dashboard or do further processing
                      header("Location: barangay-dashboard.php");
                      exit();
                    }
                  } else {
                    echo "<div class='alert alert-danger' role='alert'>Invalid email!</div>";
                  }
                }
                ?>

                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Barangay Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post"
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Barangay</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">Brgy.</span>
                        <div class="col-sm-10">
                          <select class="form-select" name="barangay" aria-label="Default select example" required>
                            <option disabled selected value="">Choose Barangay...</option>
                            <?php
                            // Fetch barangay data from the database
                            $sql = "SELECT street FROM barangay";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['street'] . "'>" . $row['street'] . "</option>";
                              }
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">Please Select Barangay!</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your Barangay Email.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your Barangay password!</div>
                    </div>
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>

                    </div>
                  </form>
                </div>

                <?php
                // Close database connection
                $conn->close();
                ?>

              </div>

              <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">LSPU 3A WAM</a>
              </div>

              <div class="credits">
                <a href="barangay-add.php">Request Account</a>
              </div>
              <div class="credits">
                <a href="admin-passcode.php">Admin?</a>
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