<?php
session_start();
if (isset($_SESSION['user'])){
        header("location:portal/index.php");
}
include('components.php');



?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/login.css">
        <title>User Login Page</title>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>
   <body>
       <style>
           #fr{
               margin-top:50px;
           }
       </style>
       <center id="fr"><h4 class="text-secondary">Welcome To </h4></center>
       <center id='formholder' class="mx-auto">
           <p><img src="cmclogo.jpeg" style="height:115px; width:210px"></p><br>
           <h5 class="text-secondary">Case Management Platform</h5>
           <p style='color:dodgerblue; font-weight:700; '>Sign in</p>
           <form id='fm' action='../model/login.php' method='post'>
               <span class="error" id="err"></span>
  <div class="input-container ">
    <i class="fa fa-user icon"></i>
    <input class="input-field " type="text" placeholder="Username or Email" required autofocus  id='name' name="username">
  </div>

  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" type="password" placeholder="Password" required name="password" id='pass'>
    <button id="seepwd" type="button"><i id="tt" class="fa fa-eye icon"></i></button>
  </div>

  <button type="submit" class="btn" id='sub' style='border-radius:15px' name='sub'>Login</button><br>
  <button style='margin-top:10px;background:none !important; border:1px solid dodgerblue; color:black; border-radius:15px' class="btn btn-light" id='res' name='reset' href="#">Reset Password</button>
</form></center><br><center><p class="text-black" style=' font-weight:400; font-size:12px'>Lagos State Ministry Of Justice <br> &copy <?php echo date("Y"); ?> All Rights Reserved</p></center>
  <!--<script src='js/login.js'></script>-->
  <script>
      $(document).ready(function(){
          $("#seepwd").click(function(){
            if($("#pass").attr('type') == "text"){
              $("#pass").attr('type','password');
            }else if($("#pass").attr('type') == "password"){
              $("#pass").attr('type','text');

            }
          });
      });
  </script>
   </body>
</html>