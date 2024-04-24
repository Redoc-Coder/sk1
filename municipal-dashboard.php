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


    // Query to fetch totals for each category
    $sql_piechart = "SELECT 
SUM(CASE WHEN osy = 'No' THEN 1 ELSE 0 END) AS osy_total,
SUM(CASE WHEN ws = 'Yes' THEN 1 ELSE 0 END) AS ws_total,
SUM(CASE WHEN yp = 'Yes' THEN 1 ELSE 0 END) AS yp_total,
SUM(CASE WHEN pwd = 'Yes' THEN 1 ELSE 0 END) AS pwd_total
FROM youth_barangay WHERE session_id='$email' ";
    $result_piechart = $conn->query($sql_piechart);

    $osy_total = 0;
    $ws_total = 0;
    $yp_total = 0;
    $pwd_total = 0;

    if ($result->num_rows > 0) {
        // Fetch totals
        $row_piechart = $result_piechart->fetch_assoc();
        $osy_total = $row_piechart['osy_total'];
        $ws_total = $row_piechart['ws_total'];
        $yp_total = $row_piechart['yp_total'];
        $pwd_total = $row_piechart['pwd_total'];
    }


    $email2 = $_SESSION['email'];


    $sql2 = "SELECT * FROM barangay_official WHERE session_id = '$email2'";
    $result2 = $conn->query($sql2);




    // Bar Chart PHP CODE


    //   OSY
    // Fetch barangay names and corresponding counts of "Yes" in osy column
    $sql = "SELECT barangay_name, COUNT(CASE WHEN osy = 'Yes' THEN 1 END) AS osy_count FROM youth_barangay GROUP BY barangay_name";
    $result = $conn->query($sql);

    // Arrays to store barangay names and corresponding osy counts
    $barangay_names = [];
    $osy_counts = [];

    // Fetch data and populate arrays
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $barangay_names[] = $row['barangay_name'];
            $osy_counts[] = $row['osy_count'];
        }
    }
    // END OF OSY




    // Fetch barangay names and corresponding counts of "Yes" in osy column
    $sql5 = "SELECT barangay_name, COUNT(CASE WHEN ws = 'Yes' THEN 1 END) AS ws_count FROM youth_barangay GROUP BY barangay_name";
    $result5 = $conn->query($sql5);

    // Arrays to store barangay names and corresponding osy counts
    $barangay_names = [];
    $ws_counts = [];

    // Fetch data and populate arrays
    if ($result5->num_rows > 0) {
        while ($row = $result5->fetch_assoc()) {
            $barangay_names[] = $row['barangay_name'];
            $ws_counts[] = $row['ws_count'];
        }
    }
    // END WS
// Fetch barangay names and corresponding counts of "Yes" in osy column
    $sql6 = "SELECT barangay_name, COUNT(CASE WHEN yp = 'Yes' THEN 1 END) AS yp_count FROM youth_barangay GROUP BY barangay_name";
    $result6 = $conn->query($sql6);

    // Arrays to store barangay names and corresponding osy counts
    $barangay_names = [];
    $yp_counts = [];

    // Fetch data and populate arrays
    if ($result6->num_rows > 0) {
        while ($row = $result6->fetch_assoc()) {
            $barangay_names[] = $row['barangay_name'];
            $yp_counts[] = $row['yp_count'];
        }
    }

    // END YP

    // Fetch barangay names and corresponding counts of "Yes" in osy column
    $sql7 = "SELECT barangay_name, COUNT(CASE WHEN pwd = 'Yes' THEN 1 END) AS pwd_count FROM youth_barangay GROUP BY barangay_name";
    $result7 = $conn->query($sql7);

    // Arrays to store barangay names and corresponding osy counts
    $barangay_names = [];
    $pwd_counts = [];

    // Fetch data and populate arrays
    if ($result7->num_rows > 0) {
        while ($row = $result7->fetch_assoc()) {
            $barangay_names[] = $row['barangay_name'];
            $pwd_counts[] = $row['pwd_count'];
        }
    }

    // END pwd






    // Close database connection
    $conn->close();
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

    <title>ADMIN DASHBOARD</title>
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

                        <?php

                        // Check if email is set in session
                        if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];
                            // You can display the email wherever you want on the page
                            echo "<span class='d-none d-md-block dropdown-toggle ps-2'>" . $email . "</span>";

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
                <a class="nav-link " href="municipal-dashboard.php" class="active">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <!-- <li class="nav-heading">Management</li> -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="municipal-account.php">
                    <i class="bi bi-question-circle"></i>
                    <span>Manage Account</span>
                </a>
            </li><!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="municipal-request.php">
                    <i class="bi bi-question-circle"></i>
                    <span>Request Account</span>
                </a>
            </li><!-- End Request ACCOUNT Page Nav -->



        </ul>

    </aside><!-- End Sidebar-->




    <main id="main" class="main">


        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-5">
                    <div class="row">

                        <!-- Resident Card -->
                        <div class="col-xxl-6 col-md-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Residents </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-account-circle-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
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

                                                // Get the session ID
                                                $session_id = $_SESSION['email'];

                                                // Query to count the total "Yes" values in the voters column
                                                $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $total_yes_voters = $row['total_yes_voters'];

                                                    // Display the total "Yes" voters
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>' . $total_yes_voters . '</h6>';
                                                    echo '</div>';
                                                } else {
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>No "Yes" voters found</h6>';
                                                    echo '</div>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                            } else {
                                                // If email is not set in session, display an error message
                                                echo '<div class="ps-3">';
                                                echo '<h6>Error: Session ID not found</h6>';
                                                echo '</div>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--End  Resident Card -->

                        <!-- Registered Voters Card -->
                        <div class="col-xxl-6 col-md-3">
                            <div class="card info-card revenue-card">



                                <div class="card-body">
                                    <h5 class="card-title">Barangay Accounts</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <?php
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

                                            // Get the session ID
                                            $session_id = $_SESSION['email'];

                                            // Query to count the total "Yes" values in the voters column
                                            $sql = "SELECT COUNT(*) AS total_yes_voters FROM barangay";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $total_yes_voters = $row['total_yes_voters'];

                                                // Display the total "Yes" voters
                                                echo '<div class="ps-3">';
                                                echo '<h6>' . $total_yes_voters . '</h6>';
                                                echo '</div>';
                                            } else {
                                                echo '<div class="ps-3">';
                                                echo '<h6>No "Yes" voters found</h6>';
                                                echo '</div>';
                                            }

                                            // Close database connection
                                            $conn->close();
                                        } else {
                                            // If email is not set in session, display an error message
                                            echo '<div class="ps-3">';
                                            echo '<h6>Error: Session ID not found</h6>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Registered Voters Card -->


                        <!-- Registered Voters Card -->
                        <div class="col-xxl-6 col-md-3">
                            <div class="card info-card revenue-card">



                                <div class="card-body">
                                    <h5 class="card-title">Registered Voters</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <?php
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

                                            // Get the session ID
                                            $session_id = $_SESSION['email'];

                                            // Query to count the total "Yes" values in the voters column
                                            $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay WHERE voters = 'Yes'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $total_yes_voters = $row['total_yes_voters'];

                                                // Display the total "Yes" voters
                                                echo '<div class="ps-3">';
                                                echo '<h6>' . $total_yes_voters . '</h6>';
                                                echo '</div>';
                                            } else {
                                                echo '<div class="ps-3">';
                                                echo '<h6>No "Yes" voters found</h6>';
                                                echo '</div>';
                                            }

                                            // Close database connection
                                            $conn->close();
                                        } else {
                                            // If email is not set in session, display an error message
                                            echo '<div class="ps-3">';
                                            echo '<h6>Error: Session ID not found</h6>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Registered Voters Card -->



                        <!-- not-registered Voters Card -->
                        <div class="col-xxl-6 col-md-3">
                            <div class="card info-card revenue-card">



                                <div class="card-body">
                                    <h5 class="card-title">Not Registered</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <?php
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

                                            // Get the session ID
                                            $session_id = $_SESSION['email'];

                                            // Query to count the total "Yes" values in the voters column
                                            $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay WHERE voters = 'No'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $total_yes_voters = $row['total_yes_voters'];

                                                // Display the total "Yes" voters
                                                echo '<div class="ps-3">';
                                                echo '<h6>' . $total_yes_voters . '</h6>';
                                                echo '</div>';
                                            } else {
                                                echo '<div class="ps-3">';
                                                echo '<h6>No "Yes" voters found</h6>';
                                                echo '</div>';
                                            }

                                            // Close database connection
                                            $conn->close();
                                        } else {
                                            // If email is not set in session, display an error message
                                            echo '<div class="ps-3">';
                                            echo '<h6>Error: Session ID not found</h6>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->





                        <!-- Customers Card -->
                        <div class="col-xxl-6 col-xl-4">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title">Male</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bx bx-male"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
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

                                                // Get the session ID
                                                $session_id = $_SESSION['email'];

                                                // Query to count the total "Yes" values in the voters column
                                                $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay WHERE Gender = 'Male'";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $total_yes_voters = $row['total_yes_voters'];

                                                    // Display the total "Yes" voters
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>' . $total_yes_voters . '</h6>';
                                                    echo '</div>';
                                                } else {
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>No "Yes" voters found</h6>';
                                                    echo '</div>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                            } else {
                                                // If email is not set in session, display an error message
                                                echo '<div class="ps-3">';
                                                echo '<h6>Error: Session ID not found</h6>';
                                                echo '</div>';
                                            }
                                            ?>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <!-- Female Card -->
                        <div class="col-xxl-6 col-xl-4">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Female </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bx bx-female"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
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

                                                // Get the session ID
                                                $session_id = $_SESSION['email'];

                                                // Query to count the total "Yes" values in the voters column
                                                $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay WHERE Gender = 'Female'";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $total_yes_voters = $row['total_yes_voters'];

                                                    // Display the total "Yes" voters
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>' . $total_yes_voters . '</h6>';
                                                    echo '</div>';
                                                } else {
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>No "Yes" voters found</h6>';
                                                    echo '</div>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                            } else {
                                                // If email is not set in session, display an error message
                                                echo '<div class="ps-3">';
                                                echo '<h6>Error: Session ID not found</h6>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->


                        <!-- Female Card -->
                        <div class="col-xxl-6 col-xl-4">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">OTHERS </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bx bxs-group"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
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

                                                // Get the session ID
                                                $session_id = $_SESSION['email'];

                                                // Query to count the total "Yes" values in the voters column
                                                $sql = "SELECT COUNT(*) AS total_yes_voters FROM youth_barangay WHERE Gender = 'Prefer not to say'";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $total_yes_voters = $row['total_yes_voters'];

                                                    // Display the total "Yes" voters
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>' . $total_yes_voters . '</h6>';
                                                    echo '</div>';
                                                } else {
                                                    echo '<div class="ps-3">';
                                                    echo '<h6>No "Yes" voters found</h6>';
                                                    echo '</div>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                            } else {
                                                // If email is not set in session, display an error message
                                                echo '<div class="ps-3">';
                                                echo '<h6>Error: Session ID not found</h6>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

 <!-- Recent Activity -->
 <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activity </h5>

                            <div class="activity">

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

                                // Fetch recent activity records based on session_id
                                $session_id = $_SESSION['email']; // Assuming session_id is stored in $_SESSION['email']
                                $sql = "SELECT * FROM recent_activity WHERE session_id = '$session_id' ORDER by id DESC LIMIT 10";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='activity-item d-flex'>";
                                        echo "<div class='activite-label'>" . $row["reg_date"] . "</div>"; // Assuming 'created_at' contains the time created
                                        echo "<i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>";
                                        echo "<div class='activity-content'>" . $row["recent_act"] . "</div>"; // Assuming 'activity_content' contains the activity content
                                        echo "</div><!-- End activity item-->";
                                    }
                                } else {
                                    echo "<p>No recent activity.</p>";
                                }

                                // Close database connection
                                $conn->close();
                                ?>

                            </div>

                        </div>

                    </div><!-- End Recent Activity -->

                    <!-- Budget Report -->
                    <div class="card">


                        <div class="card-body pb-0">
                            <h5 class="card-title">Purok List</h5>


                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Purok No.</th>
                                        <th>Total Residents</th>
                                    </tr>
                                </thead>
                                <tbody>
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

                                    $session_id = $_SESSION['email'];

                                    // Fetch all unique barangay_purok1 values from barangay_purok table where session_id matches
                                    $sql_purok1 = "SELECT DISTINCT barangay_purok1 FROM barangay_purok";
                                    $result_purok1 = $conn->query($sql_purok1);


                                    // Check if there are any purok1 values found
                                    if ($result_purok1->num_rows > 0) {
                                        // Output data of each purok1
                                        while ($row_purok1 = $result_purok1->fetch_assoc()) {
                                            $barangay_purok1 = $row_purok1["barangay_purok1"];

                                            // Query to count total residents for each barangay_purok1
                                            $sql_residents = "SELECT COUNT(*) AS total_residents FROM youth_barangay WHERE barangay_purok_no='$barangay_purok1'";
                                            $result_residents = $conn->query($sql_residents);
                                            $row_residents = $result_residents->fetch_assoc();
                                            $total_residents = $row_residents["total_residents"];

                                            // Display purok1 and total residents
                                            echo "<tr>";
                                            echo "<td>" . $barangay_purok1 . "</td>";
                                            echo "<td>" . $total_residents . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No records found</td></tr>";
                                    }

                                    // Close database connection
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>











                        </div>
                    </div><!-- End Budget Report -->

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

                    // Fetch recent activity records based on session_id
                    $session_id = $_SESSION['email']; // Assuming session_id is stored in $_SESSION['email']
                    
                    $sql3 = "SELECT 
            SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS male_count,
            SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS female_count,
            SUM(CASE WHEN gender NOT IN ('Male', 'Female') THEN 1 ELSE 0 END) AS others_count
        FROM youth_barangay";

                    $result3 = $conn->query($sql3);
                    if ($result3->num_rows > 0) {
                        $row = $result3->fetch_assoc();
                        $male_count = $row['male_count'];
                        $female_count = $row['female_count'];
                        $others_count = $row['others_count'];
                    } else {
                        $male_count = 0;
                        $female_count = 0;
                        $others_count = 0;
                    }
                    ?>


                    <div class="card">


                        <div class="card-body pb-0">
                            <h5 class="card-title">Registered Voters <span>| Youth Edition</span></h5>

                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    var male_count = <?php echo $male_count; ?>;
                                    var female_count = <?php echo $female_count; ?>;
                                    var others_count = <?php echo $others_count; ?>;

                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            top: '5%',
                                            left: 'center'
                                        },
                                        series: [{
                                            name: 'Access From',
                                            type: 'pie',
                                            radius: ['40%', '70%'],
                                            avoidLabelOverlap: false,
                                            label: {
                                                show: false,
                                                position: 'center'
                                            },
                                            emphasis: {
                                                label: {
                                                    show: true,
                                                    fontSize: '18',
                                                    fontWeight: 'bold'
                                                }
                                            },
                                            labelLine: {
                                                show: false
                                            },
                                            data: [{
                                                value: <?php echo $male_count; ?>,
                                                name: 'Male'
                                            },
                                            {
                                                value: <?php echo $female_count; ?>,
                                                name: 'Female'
                                            },
                                            {
                                                value: <?php echo $others_count; ?>,
                                                name: 'Others'
                                            }
                                            ]
                                        }]
                                    });
                                });
                            </script>

                        </div>
                    </div><!-- End Website Traffic -->







                    </div>






                </div><!-- End Left side columns -->



                <!-- Right side columns -->
                <div class="col-lg-7">
                    <!-- Recent Brgy. Officials -->
                    <!-- End Recent Sales -->

                    <!-- OSY CHART -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TOTAL OF ALL BARANGAY OUT OF SCHOOL YEAR</h5>

                                <!-- Bar Chart -->
                                <div id="barChart1"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#barChart1"), {
                                            series: [{
                                                data: <?php echo json_encode($osy_counts); ?> // Use the osy counts data
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 4,
                                                    horizontal: true,
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            xaxis: {
                                                categories: <?php echo json_encode($barangay_names); ?> // Use the barangay names as categories
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Bar Chart -->s

                            </div>
                        </div>
                    </div>
                    <!-- END OSY CHART -->


                    <!-- WS CHART -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TOTAL OF ALL BARANGAY WORKING STUDENT</h5>

                                <!-- Bar Chart -->
                                <div id="barChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#barChart"), {
                                            series: [{
                                                data: <?php echo json_encode($ws_counts); ?> // Use the osy counts data
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 4,
                                                    horizontal: true,
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            xaxis: {
                                                categories: <?php echo json_encode($barangay_names); ?> // Use the barangay names as categories
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Bar Chart -->s

                            </div>
                        </div>
                    </div>
                    <!--END  WS CHART -->





                    <!-- YP CHART -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TOTAL OF ALL BARANGAY YOUNG PARENTS</h5>

                                <!-- Bar Chart -->
                                <div id="barChart2"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#barChart2"), {
                                            series: [{
                                                data: <?php echo json_encode($yp_counts); ?> // Use the osy counts data
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 4,
                                                    horizontal: true,
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            xaxis: {
                                                categories: <?php echo json_encode($barangay_names); ?> // Use the barangay names as categories
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Bar Chart -->s

                            </div>
                        </div>
                    </div>

                    <!-- END YP CHART -->

                    <!-- PWD CHART -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">TOTAL OF ALL BARANGAY PERSON WITH DISABILITY</h5>

                                <!-- Bar Chart -->
                                <div id="barChart3"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#barChart3"), {
                                            series: [{
                                                data: <?php echo json_encode($pwd_counts); ?> // Use the osy counts data
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 4,
                                                    horizontal: true,
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            xaxis: {
                                                categories: <?php echo json_encode($barangay_names); ?> // Use the barangay names as categories
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Bar Chart -->

                            </div>
                        </div>
                    </div>

                    <!--END  PWD CHART -->


                   

                    <!-- <php
                  // Check if there are any records fetched
                  if ($result3->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result3->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["barangay_purok"] . "</td>";
                      echo "<td>" . $row["committee"] . "</td>";
                      echo "<td hidden>" . $row["session_id"] . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='6'>No purok found</td></tr>";
                  }
                  ?> -->
                    <!-- Website Traffic -->


                   

                </div><!-- End Right side columns -->

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