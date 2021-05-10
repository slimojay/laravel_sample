<?php 
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
//include('leftnav.php');
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user'){
    echo "<script>window.location='dashboard.php'</script>";
}
    echo "<script>window.location='dashboard.php'</script>";

 ?>
  <!--<head>-->
  <!--      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
  <!--       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
  <!--</head>-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
        <h1 class=' text-center' style='color:dodgerblue; font-style:bold'><i class='fa fa-help text-primary'></i> How May I Help You?
          <?php 
            // if($_SESSION['role'] !== 'user'){
            //     echo ucwords($_SESSION['role']) . " Dashboard"; 
                
            // }else{
            //     echo ucwords('Counsel') . " Dashboard"; 
            // } ?>
        </h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    <style>
        .info-box{
            background:#5867dd !important;
            /*height:170px !important;*/
            text-align:center !important;
            width:75%;
        }
        .info-box-content{padding-top:30px !important;text-decoration:none;}
        /*.info-box-content a{*/
        /*    color: white !important;*/
            /*display:block !important;*/
        /*    text-decoration:none !important;*/
        /*}*/
        
        a{text-decoration:none !important;}
        .info-box-content h2:hover, {text-decoration:none !important;}
        
    </style>
    
     <!-- Main content -->
    <div class="content"> 
      <!-- Small boxes (Stat box) -->
        <div class="row mx-auto" style="padding-left:30px;">
            <div class="col-lg-6 col-sm-6 col-xs-12"> <a href="create_user.php">
              <div class="info-box bg-success "> <span class="info-box-icon bg-transparent"><i class="fa fa-users text-white"></i></span>
                <div class="info-box-content">
                  <h4 class="text-white">Add A New Client</h4>
                </div> 
                <!-- /.info-box-content --> 
              </div> </a>
              <!-- /.info-box --> 
            </div>
            <!-- /.col -->
            <a href="">
            <div class="col-lg-6 col-sm-6 col-xs-12"> <a href="cases.php">
              <div class="info-box bg-success text-white"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-white"></i></span>
                <div class="info-box-content">
                  <h4 class="text-white"> Edit Case</h4>
                </div>
                <!-- /.info-box-content --> 
              </div></a>
              <!-- /.info-box --> 
            </div>
            <!-- /.col -->
            <div class="col-lg-6 col-sm-6 col-xs-12"><a href="create_case.php">
              <div class="info-box bg-aqua"> <span class="info-box-icon bg-transparent"><i class="fa fa-edit text-white"></i></span>
                <div class="info-box-content">
                  <h4>Add Petition/Complain</h4>
                </div>
                <!-- /.info-box-content --> 
              </div></a>
              <!-- /.info-box --> 
            </div>
            <!-- /.col -->
            <div class="col-lg-6 col-sm-6 col-xs-12"> <a href="create_case.php">
              <div class="info-box bg-aqua"> <span class="info-box-icon bg-transparent"><i class="fa fa-edit text-white"></i></span>
                <div class="info-box-content">
                  <h4 class="text-white">Add Legal Representative Request</h4>
                </div>
                <!-- /.info-box-content --> 
              </div></a>
              <!-- /.info-box --> 
            </div>
        </div>
    </div>
   <?php 
//   if ($_SESSION['role'] == 'super_admin'){
//       echo $app->superAdminDashboard($_SESSION['concern']);
//   }else if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'Admin'){
//       echo $app->adminDashboard($_SESSION['concern'], $_SESSION['center']);
//   }else{
//       $app->getCounselDetails($_SESSION['id'], 'cmc_users', '../login', $_SESSION['concern']);
//       echo $app->counselDashboard($_SESSION['concern'], $_SESSION['center'], $_SESSION['id']);
//   }
   
   ?>
    
    </div>
    </div>
 <?php include('footer.php'); ?>
