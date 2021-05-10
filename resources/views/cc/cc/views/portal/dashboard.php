<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
//include('leftnav.php');
 ?>

<style>

  .info-box{
    background: #339966 !important;
  }

</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
     <?php //echo $app->greetUser($_SESSION['role'], $_SESSION['center']); ?>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    
   <?php 
   /*if ($_SESSION['role'] == 'super_admin'){
       echo $app->superAdminDashboard($_SESSION['concern'], null, null);
   }else if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'Admin'){
       echo $app->adminDashboard($_SESSION['concern'], $_SESSION['center']);
   }else{
       $app->getCounselDetails($_SESSION['id'], 'cmc_users', '../login.php', $_SESSION['concern']);
       echo $app->counselDashboard($_SESSION['concern'], $_SESSION['center'], $_SESSION['id']);
   }*/
   
   ?>
    
    </div>
    </div>
 <?php //include('footer.php'); ?>
