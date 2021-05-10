<?php

include 'header.php';

?>

<style>

    #login{
        border: 1px solid #aa9166 !important;
        border-radius: 20px;
        text-align:center;
         margin-top: 40px;
        padding: 20px;
        /* width: 40%; */
    }
    #email{
        /* border:2px solid lightgray; */
        /* border-right: 5px solid black; */
    }
    form i.fas{
        color:#aa9166;
    }
    .input-group-text{
        background-color:black !important;
    }
    .form-group{
        /* margin:20px; */
    }

</style> 

<div id='login' class="container w-50">
    <form action="" method="post">
        <h2 class="text-center">LOGIN</h2>
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
            </div>
            <input type="email" class="form-control" name="email" id="email" placeholder="email" required>
        </div>
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-user-lock"></i> </span>
            </div>
            <input type="password" class="form-control" name="password" id="pasword" placeholder="password" required>
        </div>
        <div style="text-align:left">
            <input type="submit" class="btn" value="Login" style="background:#aa9166; color:black; padding:10px 30px">
        </div>
    </form>

    <p> Don't have an Account? <a href="#" class="btn btn-dark">sign Up</a></p>
    

</div>

<?php
    include 'footer.php';
?>