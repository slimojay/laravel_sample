<?php 
ini_set('display_errors', 0); ini_set('display_startup_errors', 0); //error_reporting(E_ALL);
session_start();
include('../../controller/CMC_controller.php');
$app = new CMC_Controller();
$app->authenticate($_SESSION['role']);
if ($_SESSION['concern'] == 1){
    $concern = "OPD";
}else{
    $concern = "CMC";
}
/*
$areaofpages = array('cc/views/portal/create_case.php', 'cc/model/create_case.php', 'cc/views/portal/entry.php');
$arrofroles = array('super_admin', 'admin', 'user');
if(!in_array($_SESSION['role'], $arrofroles) && !in_array($_SERVER['PHP_SELF'], $arrofpages)){
    $rr  = $_SESSION['role'];
        echo "<script>window.location='create_case';</script>";
 }
 */

 if($_SESSION['concern'] == 1){
            $imgPath =   "../img/mojlogo.png";
          }else if($_SESSION['concern'] == 2){
            $imgPath =   "../img/cmclogo.jpeg";  
          }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <style type='text/css'>
     .sl{
         height:37px !important;
     }
     
     @media screen and (min-width:481px){
         .resetp{
             float:right;
             margin-bottom:40px;
         }
     }
     a:hover{text-decoration:none;}
     #cOutcome {
  
}
#contained, #contained2, #contained3 {
      width: 100%;
      height: 150%;
      margin: 0;
      padding: 0;
    }

 </style>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Case Management App</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        

<!-- v4.0.0-alpha.6 -->
<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/style.css">
<link rel="stylesheet" href="dist/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/et-line-font/et-line-font.css">
<link rel="stylesheet" href="dist/css/themify-icons/themify-icons.css">

<!-- Chartist CSS -->
<link rel="stylesheet" href="dist/plugins/chartist-js/chartist.min.css">
<link rel="stylesheet" href="dist/plugins/chartist-js/chartist-init.css">
<link rel="stylesheet" href="dist/plugins/chartist-js/chartist-plugin-tooltip.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- form wizard -->
<!--<link rel="stylesheet" href="dist/plugins/formwizard/jquery-steps.css">-->
<!--<script src="plugins/jquery-2.1.4.min.js"></script>-->

    <!-- bootstrap for better look example, but not necessary -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css" type="text/css" media="screen, projection">

    <!-- Step Form Wizard plugin -->
    <link rel="stylesheet" href="step-form-wizard/css/step-form-wizard-all.css" type="text/css" media="screen, projection">
    <script src="step-form-wizard/js/step-form-wizard.js"></script>

    <!-- nicer scroll in steps -->
    <link rel="stylesheet" href="plugins/mcustom-scrollbar/jquery.mCustomScrollbar.min.css">
    <script src="plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- validation library http://jqueryvalidation.org/ -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->

<link rel='icon' href='<?php echo $imgPath; ?>'>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <link rel=stylesheet href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .cmc-color{
      background:#339966;
    }

    .content-header h1{
      color: #339966 !important;
    }

    .content-header{
      padding: 10px !important;
    }

    .content-header .sty-one{
      padding: 5px;
      margin-top:5px;
      margin-bottom:7px;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini bg-dark">
<div class="wrapper boxed-wrapper">
  <header class="main-header"> 
    <!-- Logo --> 
    <a href="index.php" class="logo cmc-color"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <!--<span class="logo-mini"><img src="dist/img/logo-n.png" alt=""></span> 
    <!-- logo for regular state and mobile devices -->
    <!--<span class="logo-lg"><img src="dist/img/logo.png" alt=""></span>-->
    <span><b style='font-family:san-serif; font-weight:800; font-size:20px' class='text-white'>Case Manager</b> &nbsp <i class="fa fa-briefcase text-white" aria-hidden="true"></i></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar cmc-color navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <ul class="nav navbar-nav pull-left">
        <li><a class="sidebar-toggle text-white" data-toggle="push-menu" href=""></a> </li>
      </ul>
      <div class="pull-left search-box">
       <!-- <form action="#" method="get" class="search-form">
          <div class="input-group">
            <input name="search" class="form-control" placeholder="Search..." type="text">
            <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> </button>
            </span></div>
        </form>-->
        <!-- search form --> </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
                
              <li class="header">You have 4 new messages</li>
              <li>
                <ul class="menu">
                  <li><a href="#">
                    <div class="pull-left"><img src="dist/img/img1.jpg" class="img-circle" alt="User Image"> <span class="profile-status online pull-right"></span></div>
                    <h4>Alex C. Patton</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">9:30 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="dist/img/img3.jpg" class="img-circle" alt="User Image"> <span class="profile-status offline pull-right"></span></div>
                    <h4>Nikolaj S. Henriksen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">10:15 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="dist/img/img2.jpg" class="img-circle" alt="User Image"> <span class="profile-status away pull-right"></span></div>
                    <h4>Kasper S. Jessen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">8:45 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="dist/img/img4.jpg" class="img-circle" alt="User Image"> <span class="profile-status busy pull-right"></span></div>
                    <h4>Florence S. Kasper</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">12:15 AM</span></p>
                    </a></li>
                </ul>
              </li>
              <li class="footer"><a href="#">View All Messages</a></li>
            </ul>
          </li>-->
          <!-- Notifications: style can be found in dropdown.less -->
          <!--<li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i>-->
          <!--  <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>-->
          <!--  </a>-->
          <!--  <ul class="dropdown-menu">-->
          <!--    <li class="header">Notifications</li>-->
          <!--    <li>-->
          <!--      <ul class="menu">-->
          <!--        <li><a href="#">-->
          <!--          <div class="pull-left icon-circle red"><i class="icon-lightbulb"></i></div>-->
          <!--          <h4>New Notification</h4>-->
          <!--          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit pellentesque.</p>-->
          <!--          <p><span class="time">9:30 AM</span></p>-->
          <!--          </a></li>-->
          <!--        <li><a href="#">-->
          <!--          <div class="pull-left icon-bell-o blue"><i class="fa fa-coffee"></i></div>-->
          <!--          <h4>New Notification 1</h4>-->
          <!--          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit pellentesque.</p>-->
          <!--          <p><span class="time">1:30 AM</span></p>-->
          <!--          </a></li>-->
          <!--        <li><a href="#">-->
          <!--          <div class="pull-left icon-circle green"><i class="fa fa-paperclip"></i></div>-->
          <!--          <h4>New Notification 2</h4>-->
          <!--          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit pellentesque.</p>-->
          <!--          <p><span class="time">9:30 AM</span></p>-->
          <!--          </a></li>-->
          <!--      </ul>-->
          <!--    </li>-->
          <!--    <li class="footer"><a href="#">View All Notifications</a></li>-->
          <!--  </ul>-->
          <!--</li>-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <!--<img src="dist/img/img1.jpg" class="user-image" alt="User Image">--> <i class='fa fa-user text-white' black></i> <span class="hidden-xs text-white"><?php echo ucwords($_SESSION['user']); ?></span> </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><!--<img src="dist/img/img1.jpg" class="img-responsive" alt="User">-->
                <i class='fa fa-user  large bg-dark' style='height:40px; width:40px; color:dodgerblue; padding:10px'></i>
                </div>
                <p class="text-left"><b style='color:dodgerblue'><?php echo ucwords($_SESSION['user']); ?></b> <small><?php echo $_SESSION['email']; ?></small> </p>
                <div class=" text-left"><small>last seen: <?php echo $_SESSION['last_login']; ?> </small></div>
              </li>
              <li><a href="#"><i class="icon-profile-male"></i> My Profile</a></li>
              <li><a href="#"><i class="fa fa-file"></i>Cases & Petitions &nbsp &nbsp <span class='text-danger'>(0)</span></a></li>
              <li role="separator" class="divider"></li>
              <li><a href="edit_profile.php?id=<?php echo $_SESSION['id'] ;?>"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="../logout.php"><i class="fa fa-external-link" aria-hidden="true"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>