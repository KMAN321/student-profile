<?php
include_once("../../db.php");
include_once("../../province.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $province = new Province($db);
    
    if ($province->delete($id)) {
        echo "Record deleted successfully.";
        header ("Location: province.view.php");
    } else {
        echo "Failed to delete the record.";
    }
}
?>
