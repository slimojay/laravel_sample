<?php
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
        <title>create center</title>
    </head>
    <body style='background-color:lightgrey'>
        <div class='content-wrapper' style='text-align:center' id='mn'>
            <br><hr>
        <center><form action='../../model/create_center.php' method='post' >
            <div class='row' style='text-align:center'>
                <div class="input-container col-lg-8 col-sm-12 ">
    <span><i class="fa fa-home icon bg-white" style='color:dodgerblue; border-radius:10px; padding:20px; margin:20px; height:70px; width:80px; font-size:26px'></i></span>
    <input class=" form-control" type="text" placeholder="Enter Center Name " onkeyup='checkIfExists()' required autofocus  id='name' name="center" >
  </div>
            
            </div><br>
            <span id='msg'></span>
            <br>
            <button type='submit' class='btn btn-primary' name='sub'>Create Center</button>
        </form></center>
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