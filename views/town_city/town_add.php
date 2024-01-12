<?php
include_once("../../db.php"); // Include the Database class file
include_once("../../student.php"); // Include the Student class file
include_once("../../student_details.php"); // Include the Student class file
include_once("../../town_city.php");
include_once("../../province.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name']
    ];

    $database = new Database();
    $towns = new TownCity($database);
    $towns_id = $towns->create($data);

    if ($towns_id) {
        echo "Record added successfully.";
        header("Location: towns.view.php");
    } else {
        echo "Failed to add the record.";
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
    <?php include('../../templates/towns_header.html'); ?>

    <!-- ======= Sidebar ======= -->
    <?php include('../../includes/towns_sidebar.php'); ?>

    <main id="main" class="main">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 40px;">Add Town</h1>
                    <form action="" method="post" class="row g-3">
                        <!-- Town/City Name -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" placeholder="Town/City Name" name="name" required>
                                <label for="floatingInputGrid">Town/City Name</label>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="text-center">
                                <a href="town.view.php" class="btn btn-info">Cancel</a>
                                <button type="reset" class="btn btn-secondary">
                                    <a href="town_add.php" style="text-decoration: none; color: inherit;">Reset</a>
                                </button>
                                <button type="submit" class="btn btn-primary">Add Town</button>
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