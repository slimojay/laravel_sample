<?php
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('../controller/CMC_controller.php');
$obj = new CMC_Controller();
$uci = $_GET['case'];
$obj->deleteCase($uci);
?>