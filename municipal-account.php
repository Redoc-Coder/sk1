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

  // Fetch additional information based on the email
  $sql = "SELECT street, municipal, province, first_name, middle_name, last_name FROM barangay WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $street = $row['street'];
    $municipal = $row['municipal'];
    $province = $row['province'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $last_name = $row['last_name'];
  }


  // Select with valid_id from database

  $sql = "SELECT * FROM barangay";
  $result2 = $conn->query($sql);

  // end  Select with valid_id from database



} else {
  // If email is not set in session, redirect to login page
  header("Location: barangay-login.php");
  exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Municipal Management Account</title>
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

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="municipal-dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Admin Management</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">


          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

            <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="municipal-logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link collapsed" href="municipal-dashboard.php">
        <i class="bi bi-grid"></i>

          <span>Dashboard</span>
        </a>
      </li><!-- End Request ACCOUNT Page Nav -->

      <!-- <li class="nav-heading">Management</li> -->



      <li class="nav-item">
        <a class="nav-link " href="municipal-account.php" class="active">
          <i class="bi bi-grid"></i>
          <span>Manage Account</span>
        </a>
      </li>
      <!-- End MANAGE ACCOUNT Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="municipal-request.php">
        <i class="bi bi-grid"></i>

          <span>Request Account</span>
        </a>
      </li><!-- End Request ACCOUNT Page Nav -->



    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Barangay Account List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="municipal-dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Manage Account</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Barangay Account List</h5>


              <table class="table datatable">
    <thead>
        <tr>
            <th>Barangay</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Contact No.</th>
            <th>ValidId</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Check if there are any records fetched
        if ($result2->num_rows > 0) {
            // Output data of each row
            while ($row = $result2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["street"] . " " . $row["municipal"] . "," . $row["province"] . "</td>";
                echo "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["contact_no"] . "</td>";
                // Display image
                echo '<td><img src="uploads/' . $row["valid_id"] . '" alt="Valid ID" class="valid-id-img" style="max-width: 100px; max-height: 100px;"></td>';
                echo "<td>" . $row["status"] . "</td>";
                echo "<td><button onclick=\"editRecord('" . $row["id"] . "')\">Edit</button> </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
    // JavaScript to scale up the image on hover
    const validIdImages = document.querySelectorAll('.valid-id-img');
    validIdImages.forEach(image => {
        image.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(5)';
            this.style.transition = 'transform 0.5s';
            this.style.zIndex = '99999';
        });
        image.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.transition = 'transform 0.5s';
        });
    });
</script>


            </div>
          </div>

        </div>
      </div>


      <script>
        function editRecord(id) {
    window.location.href = 'edit-municipal-account.php?id=' + id;
}

      </script>


      
    </section>

  </main><!-- End #main -->

  
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>LSPU BSIT- 3A_WAM</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="#">3A WAM</a>
    </div>
  </footer><!-- End Footer -->

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