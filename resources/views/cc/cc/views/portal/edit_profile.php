<?php 
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    include('header.php');
    include('leftnav.php'); 
    // session_start();
    // if (!in_array($_SESSION['role'], array('super_admin', 'admin'))){
    //     echo "<script>window.location='index.php'</script>";
    // }
    // if($_SESSION['concern'] == 1){
    //     $who = "Counsel";
    // }else{
    //     $who = "Mediator";
    // }
    //   $id = $_SESSION['id'];
    
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $app->checkUser($id);
           // echo "<script>alert('$id')</script>";
        }
        else {
            echo "<script>swal('NO PROFILE SELECTED !!'); window.location='index.php';</script>";
            
            exit;
        }
       
       $app->fetchUser($id);
 
    
?>

<style>
    select{
        height:38px !important;
    }
</style>


<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1 style="color:dodgerblue; font-style:italics">Edit Your Profile</h1>    
    </div>
    <div class="container row m-t-3">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header bg-blue">
                  <h5 class="text-white m-b-0">User Profile</h5>
                </div>
                <div class="card-body">
                                  
                    <form action="../../model/editProfile.php" method="get">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">First Name<span class="required">*</span></label>
                                <input class="form-control" name="firstname" placeholder="First Name" type="text" value="<?php echo $app->firstname ;?>" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Last Name<span class="required">*</span></label>
                                <input class="form-control" name="lastname" placeholder="Last Name" type="text" value="<?php echo $app->lastname ;?>" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span> 
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Username<span class="required">*</span></label>
                                <input class="form-control" name="username" placeholder="Username" type="text" value="<?php echo $app->username ;?>" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">E-mail<span class="required">*</span></label>
                                <input class="form-control" name="email" placeholder="E-mail" type="text" value="<?php echo $app->email ;?>" required>
                                <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Phone Number<span class="required">*</span></label>
                                <input class="form-control" name="phone" placeholder="Phone Number" type="tel" value="<?php echo $app->phone ;?>" required>
                                <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span> 
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">        
                                    <label class="control-label">Gender<span class="required">*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value="male" <?php if($app->gender == 'male'){echo 'selected';} ?>>male</option>
                                        <option value="female" <?php if($app->gender == 'female'){echo 'selected';} ?>>female</option>
                                    </select>
                                        
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                              <button type="submit" class="btn btn-success" name="submitbtn" id="submitbtn">Update</button>
                            </div>
                        </div>
                    </form>
                         
        
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>
