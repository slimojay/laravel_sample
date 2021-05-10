<?php
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('../controller/CMC_controller.php');
$obj = new CMC_Controller();
if (isset($_GET['center'])){
   echo $obj->checkIfExists($_GET['center'], 'centers', 'name', 'LIKE', '%', $_SESSION['concern']); 
}
if (isset($_POST['sub'])){
    $center = $_POST['center'];
    $obj->createCenter($center, $_SESSION['concern'], '../views/portal/create_center.php');
}

?>