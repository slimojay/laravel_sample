<?php 
    include('header.php');
    include('leftnav.php'); 
    if (!in_array($_SESSION['role'], array('super_admin', 'admin'))){
        echo "<script>window.location='index.php'</script>";
    }
    if($_SESSION['concern'] == 1){
        $who = "Counsel";
    }else{
        $who = "Mediator";
    }
?>

<style>
    select{
        height:38px !important;
    }
</style>

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1 style="color:dodgerblue; font-style:italics">Create New User</h1>    
    </div>
    <div class="row m-t-3">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header bg-blue">
                  <h5 class="text-white m-b-0">User Profile</h5>
                </div>
                <div class="card-body">
                                  
                    <form action="../../model/createUser.php" method="get">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">First Name<span class="required">*</span></label>
                                <input class="form-control" name="firstname" placeholder="First Name" type="text" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Last Name<span class="required">*</span></label>
                                <input class="form-control" name="lastname" placeholder="Last Name" type="text" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span> 
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Username<span class="required">*</span></label>
                                <input class="form-control" name="username" placeholder="Username" type="text" required>
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">E-mail<span class="required">*</span></label>
                                <input class="form-control" name="email" placeholder="E-mail" type="text" required>
                                <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Phone Number<span class="required">*</span></label>
                                <input class="form-control" name="phone" placeholder="Phone Number" type="tel" required>
                                <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span> 
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">        
                                    <label class="control-label">Gender<span class="required">*</span></label>
                                    <div class="form-control" style="border:none">
                                        <div class="form-check-inline">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" value="male" required> Male 
                                          </label>
                                        </div>
                                        <div class="form-check-inline">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" value="female" required> Female
                                          </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Role<span class="required">*</span></label>
                                <select class="form-control" name="role" placeholder="Role">
                                    <option value="" selected>-select Role- </option>
                                    <option value="admin">Unit Head</option>
                                    <option value="user"><?php echo $who; ?></option>
                                    <option value="pro">Front Desk Officer</option>
                                </select>
                              </div>
                            </div>
                            <?php if($_SESSION['role'] == 'super_admin') : ?>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Center<span class="required">*</span></label>
                                <select class="form-control custom-select" name="center" placeholder="Role" required>
                                    <option value="" selected>-Select Center- </option>
                                       <?php echo $app->fetchCenters($_SESSION['concern']); ?>
                                </select>
                              </div>
                            </div>
                            <?php else : ?>
                            <div class="form-check-inline">
                                <input class="form-control" name="center" type="hidden" value="<?php echo $_SESSION['center']; ?>">
                                </div>
                            <?php endif; ?>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Password<span class="required">*</span></label>
                                <input class="form-control" name="password" id="password1" placeholder="Password" type="password" required>
                                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group has-feedback">
                                <label class="control-label">Confirm Password<span class="required">*</span></label>
                                <input class="form-control" name="cpassword" id="password2" placeholder="Confirm Pasword" type="password" required>
                                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                              </div>
                            </div>
                            <div class="col-md-12"><p id="pwdchk"></p></div>
                           
                            <div class="col-md-12">
                              <button type="submit" class="btn btn-success" name="submitbtn" id="submitbtn">Submit</button>
                            </div>
                        </div>
                    </form>
                         
        
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#password2").keyup(function(){
            if($('#password2').val() !== $('#password1').val()){
                $('#pwdchk').html('<p class="alert alert-danger"><span> <i class="fa fa-thumbs-down" style="color:red; font-size: 20px"></i> Passwords does not match!</span></p>');
                $('#submitbtn').prop('disabled',true);

            }else{
                $('#pwdchk').html('<p class="alert alert-success"><span> <i class="fa fa-thumbs-up" style="color:green; font-size: 20px"></i> passwords match! </span></p>');
                $('#submitbtn').prop('disabled',false);

            }
        });
    });
</script>

<?php include('footer.php'); ?>
