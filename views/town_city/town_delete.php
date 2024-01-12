<?php
include_once("../../db.php");
include_once("../../town_city.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $towns = new TownCity($db);
    
    if ($towns->delete($id)) {
        echo "Record deleted successfully.";
        header ("Location: town_city.view.php");
    } else {
        echo "Failed to delete the record.";
    }
}
?>
