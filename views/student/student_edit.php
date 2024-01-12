<?php
include_once("../../db.php");
include_once("../../student.php");
include_once("../../student_details.php");
include_once("../../town_city.php");
include_once("../../province.php");

// Check if student ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch student data by ID from the database
    $db = new Database();
    $student = new Student($db);
    $details = new StudentDetails($db);
    $town = new TownCity($db);
    $province = new Province($db);

    $data = $student->read($id);
    $detailsData = $details->read($id);

    if ($data && $detailsData) {
        echo "Student found with ID: " . $id;
        // Do something with the data
    } else {
        echo "No student found with ID: " . $id;
    }
} else {
    echo "No student ID provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $detailsData = [
        'student_id' => $id,
        'contact_number' => $_POST['contact_number'],
        'street' => $_POST['street'],
        'town_city' => $_POST['town_city'],
        'province' => $_POST['province'],
        'zip_code' => $_POST['zip_code']
    ];

    $data = [
        'id' => $id,
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
        'student_id' => $detailsData['student_id'],
        'contact_number' => $detailsData['contact_number'],
        'street' => $detailsData['street'],
        'zip_code' => $detailsData['zip_code'],
        'town_city' => $detailsData['town_city'],
        'province' => $detailsData['province'],
    ];

    // Use a single database connection instance
    $db = new Database();
    $student = new Student($db);

    if ($student->update($id, $data)) {
        echo "Record updated successfully.";
        header("Location: students.view.php");
    } else {
        echo "Failed to update the record.";
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
    <?php include('../../templates/students_header.html'); ?>

    <!-- ======= Sidebar ======= -->
    <?php include('../../includes/students_sidebar.php'); ?>

    <main id="main" class="main">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title" style="font-size: 40px;">Edit Student Data</h1>
                    <form action="" method="post" class="row g-3">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <!-- Student Number -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="student_number" placeholder="Student Number" name="student_number" value="<?php echo $data['student_number']; ?>" required>
                                <label for="floatingInputGrid">Student Number</label>
                            </div>
                        </div>
                        <!-- First Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo $data['first_name']; ?>" required>
                                <label for="floatingInputGrid">First Name</label>
                            </div>
                        </div>
                        <!-- Middle Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" name="middle_name" value="<?php echo $data['middle_name']; ?>">
                                <label for="floatingInputGrid">Middle Name</label>
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo $data['last_name']; ?>" required>
                                <label for="floatingInputGrid">Last Name</label>
                            </div>
                        </div>
                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="0" <?php echo ($data['gender'] == 0) ? 'selected' : ''; ?>>Male</option>
                                    <option value="1" <?php echo ($data['gender'] == 1) ? 'selected' : ''; ?>>Female</option>
                                </select>
                                <label for="floatingSelect">Gender</label>
                            </div>
                        </div>
                        <!-- Birthdate -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="birthday" placeholder="Birthdate" name="birthday" value="<?php echo $data['birthday']; ?>" required>
                                <label for="floatingInputGrid">Birthdate</label>
                            </div>
                        </div>
                        <!-- Student ID -->
                        <input type="hidden" name="student_id" value="<?php echo isset($detailsData['id']) ? $detailsData['id'] : ''; ?>">
                        <!-- Contact Number -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="contact_number" placeholder="Contact Number" name="contact_number" value="<?php echo $detailsData['contact_number']; ?>" required>
                                <label for="floatingInputGrid">Contact Number</label>
                            </div>
                        </div>
                        <!-- Street -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="street" placeholder="Street" name="street" value="<?php echo $detailsData['street']; ?>" required>
                                <label for="floatingInputGrid">Street</label>
                            </div>
                        </div>
                        <!-- Town/City -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="town_city" name="town_city" required>
                                    <?php
                                    $results = $town->getAll();
                                    foreach ($results as $result) {
                                    ?>
                                        <option value="<?php echo $result['id']; ?>" <?php echo ($detailsData['town_city'] == $result['id']) ? 'selected' : ''; ?>><?php echo $result['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="floatingSelect">Town/City</label>
                            </div>
                        </div>
                        <!-- Province -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="province" name="province" required>
                                    <?php
                                    $results = $province->getAll();
                                    foreach ($results as $result) {
                                    ?>
                                        <option value="<?php echo $result['id']; ?>" <?php echo ($detailsData['province'] == $result['id']) ? 'selected' : ''; ?>><?php echo $result['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="floatingSelect">Province</label>
                            </div>
                        </div>
                        <!-- Zip Code -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="zip_code" placeholder="Zip Code" name="zip_code" value="<?php echo $detailsData['zip_code']; ?>" required>
                                <label for="floatingInputGrid">Zip Code</label>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="cancel" class="btn btn-info">
                                    <a href="students.view.php" style="text-decoration: none; color: inherit;">Cancel</a>
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <a href="student_edit.php?id=<?php echo $data['id']; ?>" style="text-decoration: none; color: inherit;">Reset</a>
                                </button>
                                <button type="submit" class="btn btn-primary">Update</button>
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