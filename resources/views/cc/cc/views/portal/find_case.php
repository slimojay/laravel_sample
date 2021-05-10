<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include('header.php');
include('leftnav.php');

?>


<!DOCTYPE html>
<html>
    <head>
        <style>
            @media screen and (min-width:736px){
                .row{
                    margin-left:250px;
                    
                }
                
            }
        </style>
        <title>Search Case</title>
    </head>
    <body style='background-color:lightgrey'>
        <div class='content-wrapper' style='text-align:center' id='mn'>
        <center><form action='find_case.php' method='post' >
            <div class='row' style='text-align:center'>
                <div class="input-container col-lg-8 col-sm-12 ">
    <span><i class="fa fa-search large bg-white" style='color:dodgerblue; border-radius:10px; padding:20px; margin:20px; height:70px; width:80px; font-size:26px'></i></span>
    <input class=" form-control" type="text" placeholder="Enter Case ID "  required autofocus  id='name' name="case" >
  </div>
            
            </div><br>
            <span id='msg'></span>
            <br>
            <button type='submit' class='btn btn-primary' name='sub'>Search</button>
        </form></center>
        
         <br>
        
        <div style='padding:20px; border:0.4px solid lightgrey'>
    <table id="display" class='table table-stripped table-hover table-bordered' border='1px' style='padding:5px; text-transform:capitalize'>
        <thead class="thead-dark" style='text-transform:capitalize'>
            <tr>
                <th>title</th>
                <th>complainant</th>
                <th>respondent</th>
                <th>status</th>
                <th>case type</th>
                <th>verdict</th>
                <th>center</th>
                <th>Category</th>
                <th>counsel</th>
                <th>Hearing Date</th>
                <th style='padding-left:20px; padding:right:20px; width:170px; text-align:center'>Actions</th>
            </tr>
        </thead>
        <tbody>
        </div>
             <?php
             if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                 $uniqueID = $app->con->real_escape_string(trim($_POST['case']));
             
             if ($_SESSION['role'] == 'super_admin'){
                 $center = null;
             }else{
                 $center = $_SESSION['center'];
             }
             echo $app->findCase($_SESSION['id'], $uniqueID, $center, $_SESSION['concern'], $_SESSION['role']);
             }
             ?>
        </tbody>
    </table>
    </div>
    </div>
        
       
        
        <script>
            function checkIfExists(){
                var field = document.getElementById('name').value;
                var obj = new XMLHttpRequest();
                obj.onreadystatechange = function(){
                    if(obj.readyState == 4){
                        document.getElementById('msg').innerHTML = obj.responseText;
                    }
                }
               
                obj.open('GET', "../../model/create_center.php?center=" + field, true);
                obj.send();
                if (field.length == 0){
                    document.getElementById('msg').innerHTML = '';
                }
                
            }
        </script>
    </body>
</html>

<?php include('footer.php'); ?>