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
} else {
  // If email is not set in session, redirect to login page
  header("Location: barangay-login.php");
  exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $barangay_name = $_POST['barangay_name'];
  $barangay_purok1 = $_POST['barangay_purok1'];

  // Check if the barangay_purok1 already exists
  $check_query = "SELECT * FROM barangay_purok WHERE barangay_purok1 = '$barangay_purok1' AND session_id ='$session_id' ";

  $check_result = $conn->query($check_query);
  if ($check_result->num_rows > 0) {
      echo "Error: Barangay Purok already exists.";
  } else {
      // Prepare SQL statement to insert data
      $sql1 = "INSERT INTO barangay_purok (barangay_name, barangay_purok1, session_id)
               VALUES ('$barangay_name', '$barangay_purok1', '$session_id')";
      
      // Execute SQL query
      if ($conn->query($sql1) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
      } else {
          echo "Error: " . $sql1 . "<br>" . $conn->error;
        header("Location: ".$_SERVER['PHP_SELF']);

      }
  }
}

// Fetch records from the database where session_id matches
$sql = "SELECT * FROM barangay_purok WHERE session_id = '$email'";
$result1 = $conn->query($sql);

// Close database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Barangay Purok</title>
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
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
    <span class="d-none d-lg-block">Youth Management</span>
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

        <?php

        // Check if email is set in session
        if (isset($_SESSION['email'])) {
          $email = $_SESSION['email'];
          // You can display the email wherever you want on the page
          echo "<span class='d-none d-md-block dropdown-toggle ps-2'>" . $first_name . " " . $last_name . "</span>";

        } else {
          // If email is not set in session, redirect to login page
          header("Location: barangay-login.php");
          exit();
        }
        ?>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

        <hr class="dropdown-divider">
    </li>

    <li>
      <a class="dropdown-item d-flex align-items-center" href="logout.php">
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
    <a class="nav-link collapsed" href="barangay-dashboard.php" class="active" >
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->



  <li class="nav-heading">Management</li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Youth Management</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content " data-bs-parent="#sidebar-nav">
      <li>
        <a href="barangay-management.php">
          <i class="bi bi-circle "></i><span>Add Youth Details</span>
        </a>
      </li>
      <li>
        <a href="youth-list.php">
          <i class="bi bi-circle"></i><span>Youth Resident Lists</span>
        </a>
      </li>
      <li>
        <a href="archive-list.php">
          <i class="bi bi-circle"></i><span>Archive List</span>
        </a>
      </li>

    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Brgy.Officials</span><i
        class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content  " data-bs-parent="#sidebar-nav">
      <li>
        <a href="barangay-official.php">
          <i class="bi bi-circle"></i><span>Add Officials</span>
        </a>
      </li>
      <li>
        <a href="barangay-official-list.php" >
          <i class="bi bi-circle"></i><span>List of Officials</span>
        </a>
      </li>
      <li>
        <a href="archive-barangay-official-list.php" >
          <i class="bi bi-circle"></i><span>Archive List of Officials</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->


  <li class="nav-item">
    <a class="nav-link " href="barangay-dashboard.php" class="active">
      <i class="bi bi-grid"></i>
      <span>Purok</span>
    </a>
  </li><!-- End Purok Nav -->


</ul>

</aside><!-- End Sidebar-->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Manage Purok</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Purok</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">



      <div class="row">
        <div class="col-lg-7">
          <form class="row g-3 needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">General Form </h5>

                <!-- General Form Elements -->
                <div class="row mb-3">
                  <!-- <label class="col-sm-2 col-form-label">Barangay</label> -->
                  <div class="col-sm-10">
                    <input type="hidden" name="barangay_name" class="form-control"
                      value="<?php echo $street . ', ' . $municipal . ', ' . $province; ?>">
                      <br>
                      <label > Barangay <?php echo $street . ', ' . $municipal . ', ' . $province; ?>
                      </label>


                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Purok Name/No.</label>
                  <div class="col-sm-10">
                    <input type="text" name="barangay_purok1" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter Purok Name/No!
                    </div>
                  </div>
                </div> 
                <div class="row mb-2 justify-content-center">
                  <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary btn-block">Add Purok</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-5">

          <div class="card">
            <div class="card-body">


            <table class="table datatable">
                <thead>
                  <tr>
                    <th>Purok</th>
                    <th>Action</th>
                    <th hidden>session_id</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Check if there are any records fetched
                  if ($result1->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result1->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["barangay_purok1"] . "</td>";
                      echo "<td hidden>" . $row["session_id"] . "</td>";
                      // echo "<td><button class=\"btn btn-danger btn-block\" onclick=\"deleteRecord('" . $row["session_id"] . "')\">Delete</button></td>";
                      echo "<td><button  class=\"btn btn-danger btn-block\" onclick=\"deleteRecord('" . $row["id"] . "')\">Delete</button> ";

                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>

              <div id="editForm" style="display: none;">
                <!-- Edit Form will be displayed here -->
              </div>




              <script>
                function deleteRecord(id) {
                  // AJAX request to archive record
                  if (confirm("Are you sure you want to delete this record?")) {
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      // Refresh the page after archiving
                      window.location.reload();
                    }
                  };
                  xhttp.open("GET", "delete-purok.php?id=" + id, true);
                  xhttp.send();
                }}

              </script>


              <script>
                function editRecord(id) {
                  // AJAX request to fetch record details
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("editForm").innerHTML = this.responseText;
                      document.getElementById("editForm").style.display = "block";
                    }
                  };
                  xhttp.open("GET", "edit-youth.php?id=" + id, true);
                  xhttp.send();
                }
                function archiveRecord(id) {
                  // AJAX request to archive record
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                      // Refresh the page after archiving
                      window.location.reload();
                    }
                  };
                  xhttp.open("GET", "archive-youth.php?id=" + id, true);
                  xhttp.send();
                }
              </script>


            </div>
          </div>

        </div>



      </div>
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
  <script src="assets/vendor/simple-datatables/simple-datatables1.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

