<?php
include_once("../../db.php");
include_once("../../student.php");
include_once("../../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
$studentDetails = new StudentDetails($db);

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
    <?php include('../../templates/students_header.html'); ?>

    <!-- ======= Sidebar ======= -->
    <?php include('../../includes/students_sidebar.php'); ?>

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <div class="content">
            <h2>Student Records</h2>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Contact Number</th>
                        <th>Street</th>
                        <th>Town City</th>
                        <th>Province</th>
                        <th>Zip Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- You'll need to dynamically generate these rows with data from your database -->
                    <?php
                    $resultsStudent = $student->displayAll();
                    foreach ($resultsStudent as $resultStudent) {
                        $studentId = $resultStudent['student_id']; // Assuming this is the student's ID
                        $resultDetails = $studentDetails->read($studentId); // You need a method to get details by student ID

                        if ($resultDetails) {
                    ?>
                            <tr>
                                <td><?php echo $resultStudent['student_number']; ?></td>
                                <td><?php echo $resultStudent['first_name']; ?></td>
                                <td><?php echo $resultStudent['middle_name']; ?></td>
                                <td><?php echo $resultStudent['last_name']; ?></td>
                                <td><?php echo ($resultStudent['gender'] == 0) ? 'M' : 'F'; ?></td>
                                <td><?php echo date('M d Y', strtotime($resultStudent['birthday'])); ?></td>
                                <td><?php echo $resultDetails['contact_number']; ?></td>
                                <td><?php echo $resultDetails['street']; ?></td>
                                <td><?php echo $resultDetails['town_city']; ?></td>
                                <td><?php echo $resultDetails['province']; ?></td>
                                <td><?php echo $resultDetails['zip_code']; ?></td>
                                <td>
                                    <a href="student_edit.php?id=<?php echo $studentId; ?>">Edit</a>
                                    |
                                    <a href="student_delete.php?id=<?php echo $studentId; ?>">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody> 


            </table>
            <button class="btn btn-primary">
                <a href="student_add.php" style="text-decoration: none; color: inherit;">Add Student</a>
            </button>

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