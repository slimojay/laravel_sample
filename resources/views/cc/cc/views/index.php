<?php
session_start();
if (!isset($_SESSION['user'])){
header("location:login.php");
}else{
    if($_SESSION['role'] == 'admin'){
        header("location:admin/index.php");
    }else{
        header("location:user/index.php");
    }
}
?>