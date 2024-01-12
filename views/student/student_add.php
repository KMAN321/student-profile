<?php
include_once("../../db.php"); // Include the Database class file
include_once("../../student.php"); // Include the Student class file
include_once("../../student_details.php"); // Include the Student class file
include_once("../../town_city.php");
include_once("../../province.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    $student = new Student($database);
    $student_id = $student->create($data);

    if ($student_id) {
        // Student record successfully created

        // Retrieve student details from the form
        $studentDetailsData = [
            'student_id' => $student_id, // Use the obtained student ID
            'contact_number' => $_POST['contact_number'],
            'street' => $_POST['street'],
            'zip_code' => $_POST['zip_code'],
            'town_city' => $_POST['town_city'],
            'province' => $_POST['province'],
            // Other student details fields
        ];

        // Create student details linked to the student
        $studentDetails = new StudentDetails($database);

        if ($studentDetails->create($studentDetailsData)) {
            echo "Record inserted successfully.";
            header("Location: students.view.php");
        } else {
            echo "Failed to insert the record.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Students Records</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../../assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include('../../templates/header.html'); ?>

    <!-- ======= Sidebar ======= -->
    <?php include('../../includes/students_sidebar.php'); ?>

    <main id="main" class="main">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 40px;">Add Student Data</h1>
                    <form action="" method="post" class="row g-3">
                        <!-- Student Number -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="student_number" placeholder="Student Number" name="student_number" required>
                                <label for="floatingInputGrid">Student Number</label>
                            </div>
                        </div>
                        <!-- First Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" required>
                                <label for="floatingInputGrid">First Name</label>
                            </div>
                        </div>
                        <!-- Middle Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" name="middle_name">
                                <label for="floatingInputGrid">Middle Name</label>
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" required>
                                <label for="floatingInputGrid">Last Name</label>
                            </div>
                        </div>
                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                                <label for="floatingSelect">Gender</label>
                            </div>
                        </div>
                        <!-- Birthdate -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="birthday" placeholder="Birthdate" name="birthday" required>
                                <label for="floatingInputGrid">Birthdate</label>
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="contact_number" placeholder="Contact Number" name="contact_number" required>
                                <label for="floatingInputGrid">Contact Number</label>
                            </div>
                        </div>
                        <!-- Street -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="street" placeholder="Street" name="street" required>
                                <label for="floatingInputGrid">Street</label>
                            </div>
                        </div>
                        <!-- Town/City -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Town/City" name="town_city" required>
                                    <?php

                                    $database = new Database();
                                    $towns = new TownCity($database);
                                    $results = $towns->getAll();
                                    // echo print_r($results);
                                    foreach ($results as $result) {
                                        echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Town/City</label>
                            </div>
                        </div>
                        <!-- Province -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Province" name="province" required>
                                    <?php

                                    $database = new Database();
                                    $provinces = new Province($database);
                                    $results = $provinces->getAll();
                                    // echo print_r($results);
                                    foreach ($results as $result) {
                                        echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Province</label>
                            </div>
                        </div>
                        <!-- Zip Code -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="zip_code" placeholder="Zip Code" name="zip_code" required>
                                <label for="floatingInputGrid">Zip Code</label>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="text-center">
                                <a href="students.view.php" class="btn btn-info">Cancel</a>
                                <button type="reset" class="btn btn-secondary">
                                    <a href="student_add.php" style="text-decoration: none; color: inherit;">Reset</a>
                                </button>
                                <button type="submit" class="btn btn-primary">Add Student</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('../../templates/footer.html'); ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../../assets/vendor/quill/quill.min.js"></script>
    <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../../assets/js/main.js"></script>

</body>

</html>