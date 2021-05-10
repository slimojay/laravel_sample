<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include('../controller/CMC_controller.php');
 $app = new CMC_Controller();
 //$data = json_decode(file_get_contents("php://input"), true);
 $username = $_POST['username'];
 $password = $_POST['password'];
 $app->login($username, $password);
?>


