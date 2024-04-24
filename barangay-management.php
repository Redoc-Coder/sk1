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
} else {
  // If email is not set in session, redirect to login page
  header("Location: barangay-login.php");
  exit();
}

// Insert data into a table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $barangay_name = $_POST['barangay_name'];
  $last_name = $_POST['last_name'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $gender = $_POST['gender'];
  $marital_status = $_POST['marital_status'];
  $contact_no = $_POST['contact_no'];
  $religion = $_POST['religion'];
  $birthdate = $_POST['birthdate'];
  $osy = $_POST['osy'];
  $ws = $_POST['ws'];
  $yp = $_POST['yp'];
  $pwd = $_POST['pwd'];
  $barangay_purok_no = $_POST['barangay_purok_no'];
  $voters = $_POST['voters'];
  $recent_act = $last_name . ',' . $first_name . ' add record in Youth Resident';

  // Check if a record with the same first name and last name already exists
  $check_sql = "SELECT * FROM youth_barangay WHERE first_name = '$first_name' AND last_name = '$last_name'";
  $check_result = $conn->query($check_sql);

  if ($check_result->num_rows > 0) {
    // Record with the same first name and last name already exists
    echo "Error: A record with the same first name and last name already exists.";
  } else {
    // Insert data into the youth_barangay table
    $sql = "INSERT INTO youth_barangay (session_id, barangay_name, last_name, first_name, middle_name, gender, marital_status, contact_no, religion, birthdate, osy, ws, yp, pwd, barangay_purok_no, voters)
              VALUES ('$email', '$barangay_name', '$last_name', '$first_name', '$middle_name', '$gender', '$marital_status', '$contact_no', '$religion', '$birthdate', '$osy', '$ws', '$yp', '$pwd' , '$barangay_purok_no', '$voters' )";

    if ($conn->query($sql) === TRUE) {
      // Insert data into the recent_activity table
      $sql1 = "INSERT INTO recent_activity (session_id, barangay_name, last_name, first_name, middle_name, gender, marital_status, contact_no, religion, birthdate, osy, ws, yp, pwd, recent_act, barangay_purok_no, voters)
                   VALUES ('$email', '$barangay_name', '$last_name', '$first_name', '$middle_name', '$gender', '$marital_status', '$contact_no', '$religion', '$birthdate', '$osy', '$ws', '$yp', '$pwd', '$recent_act', '$barangay_purok_no', '$voters')";

      if ($conn->query($sql1) === TRUE) {
        echo "New record created successfully";
        echo '<script type="text/javascript">';
        echo 'alert("New record created successfully");';
        echo 'window.location.href = "barangay-management.php";'; // Redirect after showing the alert
        echo '</script>';
      } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
      }
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}


// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Barangay Management</title>
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

 
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="barangay-management.php" class="logo d-flex align-items-center">
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
          </a>

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
    <a class="nav-link collapsed "  href="barangay-dashboard.php" class="active">
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
        <a href="barangay-management.php" class="active">
          <i class="bi bi-circle "></i><span>Add Youth Details</span>
        </a>
      </li>
      <li>
        <a href="youth-list.php"  >
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
    <a class="nav-link collapsed" href="barangay-purok.php">
      <i class="bi bi-grid"></i>
      <span>Purok</span>
    </a>
  </li><!-- End Dashboard Nav -->


</ul>

</aside><!-- End Sidebar-->


  
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Youth Resident</h1>
      <form method="post" enctype="multipart/form-data" action="import_excel.php">
    <input type="file" name="excel_file">
    <button type="submit" name="import_excel">Import Excel</button>
</form>

<?php
if (isset($_SESSION['import_success']) && $_SESSION['import_success'] === true) {
  echo '<p>Data imported successfully.</p>';
  unset($_SESSION['import_success']); // Clear the session variable
}
?>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <!-- <li class="breadcrumb-item">Forms</li> -->
          <li class="breadcrumb-item active">Add Youth Details</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <form class="row g-3 needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>
        <div class="row">
          <div class="col-lg-7">

            <div class="card">
              <div class="card-body">
              <div id="generalSection">
                <h5 class="card-title">General Form Elements</h5>

                <!-- General Form Elements -->
                <div class="row mb-3">
                  <label name="barangay_name" >Barangay <?php echo $street . ', ' . $municipal . ', ' . $province; ?> </label>
                  <div class="col-sm-12">
                    <input type="hidden" name="barangay_name" class="form-control"
                      value="<?php echo $street . ', ' . $municipal . ', ' . $province; ?>">

                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-5 col-form-label">Last Name</label>
                  <div class="col-sm-12">
                    <input type="text" name="last_name" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter Last Name!
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-5 col-form-label">First Name</label>
                  <div class="col-sm-12">
                    <input type="text" name="first_name" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter First Name!
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-5 col-form-label">Middle Name</label>
                  <div class="col-sm-12">
                    <input type="text" name="middle_name" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter Middle Name!
                    </div>
                  </div>
                </div>

                <!-- Registered Voters(?) Selection -->
                <div class="row mb-3">
                  <label class="col-sm-5 col-form-label">Registered Voter?</label>
                  <div class="col-sm-12">
                    <select class="form-select" aria-label="Default select example" name="voters" required>
                      <option disabled selected value="">Choose Yes or No...</option>

                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                      =
                    </select>
                    <div class="invalid-feedback">
                      Please Select Yes or no choices!
                    </div>
                  </div>
                </div>
                <!-- End Gender Selection -->


                <!-- Barangay Purok Selection -->
                <div class="row mb-3">
                  <label class="col-sm-5 col-form-label">Purok</label>
                  <div class="col-sm-12">
                    <select class="form-select" aria-label="Default select example" name="barangay_purok_no" required>
                      <!-- <option disabled selected value="">Choose...</option> -->

                      <!-- Show the other Barangay Purok Option from database -->
                      <?php
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
                      // Get the session ID
                      $session_id = $_SESSION['email'];

                      // Fetch Barangay Purok options from database
                      $sql = "SELECT barangay_purok1 FROM barangay_purok WHERE session_id = '$session_id'";
                      $result = $conn->query($sql);

                      // Check if there are any options
                      if ($result->num_rows > 0) {
                        echo '<option disabled selected value="">Choose...</option>';

                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value="' . $row["barangay_purok1"] . '">' . $row["barangay_purok1"] . '</option>';
                        }
                      } else {
                        echo '<option disabled selected value="">No Purok available</option>';
                      }

                      // Close database connection
                      $conn->close();
                      ?>


                    </select>
                    <div class="invalid-feedback">
                      Please Select Purok! No Purok Available? Add Purok
                    </div>
                  </div>
                </div>
                <!-- End Barangay Purok Selection -->



                <!-- Gender Selection -->
                <div class="row mb-3">
                  <label class="col-sm-5 col-form-label">Gender</label>
                  <div class="col-sm-12">
                    <select class="form-select" aria-label="Default select example" name="gender" required>
                      <option disabled selected value="">Choose...</option>

                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                    <div class="invalid-feedback">
                      Please Select Gender!
                    </div>
                  </div>
                </div>
                <!-- End Gender Selection -->
                <div class="row mb-3">
                  <label class="col-sm-5 col-form-label">Marital Status</label>
                  <div class="col-sm-12">
                    <select class="form-select" aria-label="Marital status" name="marital_status" required>
                      <option disabled selected value="">Choose...</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Divorced">Divorced</option>
                      <option value="Widowed">Widowed</option>
                      <option value="Separated">Separated</option>
                      <option value="Domestic Partnership/Civil Union">Domestic Partnership/Civil Union</option>
                      <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                    <div class="invalid-feedback">
                      Please Select Marital Status!
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-5 col-form-label">Contact No.</label>
                  <div class="col-sm-12">
                    <input type="number" name="contact_no" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter Contact No.!
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-5 col-form-label">Religion</label>
                  <div class="col-sm-12">
                    <input type="text" name="religion" class="form-control" required>
                    <div class="invalid-feedback">
                      Please enter Religion!
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
    <label for="inputText" class="col-sm-5 col-form-label">Birth Date</label>
    <div class="col-sm-12">
        <input type="date" name="birthdate" id="birthdate" class="form-control" onchange="calculateAge()" required max="<?php echo date('Y-m-d'); ?>">
        <div class="invalid-feedback">
            Please enter a valid Birthdate!
        </div>
    </div>
</div>

<div class="row mb-3">
    <label for="inputText" class="col-sm-5 col-form-label">Age</label>
    <div class="col-sm-12">
        <input type="text" name="age" id="age" class="form-control" readonly>
    </div>
</div>

<div class="row mb-2 justify-content-center">
    <div class="col-sm-5">
        <button type="button" class="btn btn-primary btn-block" id="nextButton" onclick="nextSection('additionalSection')">Next</button>
    </div>
</div>

<script>
    function calculateAge() {
        // Get the birthdate value
        var birthdateInput = document.getElementById('birthdate');
        var birthdate = new Date(birthdateInput.value);

        // Get the current date
        var currentDate = new Date();

        // Check if the birthdate is empty
        if (birthdateInput.value === '') {
            birthdateInput.setCustomValidity('Please enter a valid Birthdate.');
            document.getElementById('nextButton').disabled = true; // Disable Next button
            return;
        } else {
            birthdateInput.setCustomValidity('');
        }

        // Check if the selected date is in the future
        if (birthdate > currentDate) {
            birthdateInput.setCustomValidity('Please select a valid Birthdate.');
            document.getElementById('nextButton').disabled = true; // Disable Next button
            return;
        } else {
            birthdateInput.setCustomValidity('');
        }

        // Calculate the age
        var age = currentDate.getFullYear() - birthdate.getFullYear();

        // Check if the birthday hasn't occurred yet this year
        if (currentDate.getMonth() < birthdate.getMonth() || (currentDate.getMonth() === birthdate.getMonth() && currentDate.getDate() < birthdate.getDate())) {
            age--;
        }

        // Update the age textfield
        document.getElementById('age').value = age;

        // Disable Next button if age is below 14
        document.getElementById('nextButton').disabled = age < 15;
    }

    function nextSection(nextSectionId) {
        document.getElementById('generalSection').style.display = 'none';
        document.getElementById(nextSectionId).style.display = 'block';
    }

    function previousSection(prevSectionId) {
        document.getElementById('additionalSection').style.display = 'none';
        document.getElementById(prevSectionId).style.display = 'block';
    }

    // Call calculateAge() initially and on date input change
    document.addEventListener('DOMContentLoaded', function () {
        calculateAge();
        document.getElementById('birthdate').addEventListener('input', calculateAge);
    });
</script>









              </div>
            </div>
                    </div>

          </div>
          <div id="additionalSection" style="display: none;">

          <div class="col-lg-5">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Answer the following Questions:</h5>

                <!-- Advanced Form Elements -->
                <div class="col-12">

                  <label for="yourUsername" class="form-label">Are you enrolled in any school?</label>
                  <div class="row mb-3">
                    <!-- <label class="col-sm-5 col-form-label">Are you enrolled in any school?</label> -->
                    <div class="col-sm-12">
                      <select class="form-select" name="osy" aria-label="Default select example" required>
                        <option disabled selected value="">Choose...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                      <div class="invalid-feedback">
                        Please Answer the Question!
                      </div>
                    </div>
                  </div>
                </div>



                <div class="col-12">

                  <label for="yourUsername" class="form-label">Are you a Working Student?</label>

                  <div class="row mb-3">

                    <div class="col-sm-12">
                      <select class="form-select" aria-label="Default select example" name="ws" required>
                        <option disabled selected value="">Choose...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                      <div class="invalid-feedback">
                        Please Answer the Question!
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">

                  <label for="yourUsername" class="form-label">Are you a Young Parents?</label>

                  <div class="row mb-3">
                    <div class="col-sm-12">
                      <select class="form-select" aria-label="Default select example" name="yp" required>
                        <option disabled selected value="">Choose...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                      <div class="invalid-feedback">
                        Please Answer the Question!
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-12">


                  <label for="yourUsername" class="form-label">Are you a Person with Disability (PWD)?</label>
                  <div class="row mb-3">
                    <div class="col-sm-12">
                      <select class="form-select" aria-label="Default select example" name="pwd" required>
                        <option disabled selected value="">Choose...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                      <div class="invalid-feedback">
                        Please Answer the Question!
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <br>

              <div class="row mb-2 justify-content-center">
        <div class="col-sm-5">
          <button type="button" class="btn btn-primary btn-block" onclick="previousSection('generalSection')">Previous</button>
          <button type="submit" class="btn btn-primary btn-block">Save Record</button>
        </div>
      </div>





            </div>
          </div>
                    </div>

        </div>
        </div>
      </form>

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