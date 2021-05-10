<?php 
  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include 'header.php';
    include 'leftnav.php';

    if (!isset($_GET['id'])){
        echo "<script>alert('no case selected'); window.location='index.php'</script>";
    }
    else{
        $id = $_GET['id'];
        $_SESSION['id_case'] = $_GET['id'];
        $idd = $_SESSION['id_case'];
    }
     $app->fetchCaseDetails($_GET['id'], $_SESSION['id_case'] = $_GET['id'], $_SESSION['concern'], $_SESSION['id'], $_SESSION['role'], $_SESSION['center']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['suboutcome'])){
            $cDate = $app->con->real_escape_string($_POST['cDate']);
            $cInfo = $app->con->real_escape_string($_POST['cInfo']);
            $cOutcome = $app->con->real_escape_string($_POST['cOutcome']);
            echo $app->UpdateCaseOutcome($idd, $cOutcome, $cInfo, $cDate, "edit_case.php?id=$idd");
        }
        
        
        if (isset($_POST['subaction'])){
            $cDate = $app->con->real_escape_string($_POST['aDate']);
            $comment = $app->con->real_escape_string($_POST['comment']);
            $action = $app->con->real_escape_string($_POST['cAction']);
            $officer = $app->con->real_escape_string($_POST['officer']);
            $signed_by = $app->con->real_escape_string($_POST['signed_by']);
            echo $app->updatedCaseAction($idd, $action, $comment, $officer, $signed_by, $cDate, "edit_case.php?id=$idd");
        }
        
        if(isset($_POST['submitCase'])){
            
            $cCenter = $app->con->real_escape_string($_POST['caseCenter']);
            $cCounsel = $app->con->real_escape_string($_POST['caseCounsel']);
            $PA = $app->con->real_escape_string($_POST['partyA']);
            $PAN = $app->con->real_escape_string($_POST['partyAno']);
            $PAE= $app->con->real_escape_string($_POST['partyAmail']);
            $PAA= $app->con->real_escape_string($_POST['partyAaddr']);
            $PB = $app->con->real_escape_string($_POST['partyB']);
            $PBN = $app->con->real_escape_string($_POST['partyBno']);
            $PBE = $app->con->real_escape_string($_POST['partyBmail']);
            $PBA = $app->con->real_escape_string($_POST['partyBaddr']);
            $rName = $app->con->real_escape_string($_POST['regName']);
            $rEmail = $app->con->real_escape_string($_POST['regEmail']);
            $rPhone = $app->con->real_escape_string($_POST['regPhone']);
            $rAddr = $app->con->real_escape_string($_POST['regAddress']);
            
            $app->editCase($idd, $cCenter, $cCounsel, $PA, $PAN, $PAN, $PAE, $PAA, $PB, $PBN, $PBE, $PBA, $rName, $rEmail, $rPhone, $rAddr);
            
        }
    } 
     
     
?>
<style>
    /*#contentD{*/
    /*    font-family: 'Poppins', sans-serif;*/
    /*    font-weight: 400;*/
    /*    overflow-x: hidden;*/
    /*    overflow-y: auto;*/
    /*    font-size: 15px;*/
    /*    color: #666f73;*/
    /*}*/
    select{
        height:35px !important;
    }
    h5{
        font-weight:bolder !important;
    }
     input.col{
            margin:10px;
            padding-right:5px;
        }
</style>

<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
        <h3 style="color:dodgerblue; font-style:italics"><?php echo $app->title /*. /*" (" . $app->unique . ")" */; ?> &nbsp <a href="casedetail?id=<?php echo $idd; ?>" class='btn btn-dark'>View Case Details</a> </h3>
    </div>
    
     <div class="content" id="">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-outline">
            <div class="card-header bg-secondary">
              <h5 class="text-white m-b-0">Update Case Action</h5>
            </div>
            <div class="card-body">
              <form action="" method="post">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group has-feedback">
                    <label class="control-label">Action Comment</label>
                    <textarea class="form-control" id="placeTextarea" rows="3" placeholder="Brief Information on Case Outcome" name='comment'></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Case Action</label>
                    <select class="form-control" name="cAction" placeholder="Case Action">
                        <option value="">select Case Action</option>
                        <?php echo $app->fetchActions($_SESSION['concern']) ;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Date Of Action</label>
                    <input type="date" class="form-control" name='aDate'>
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Officer In Charge</label></label>
                    <input type="text" class="form-control" name='officer'>
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Signed By!</label>
                    <input type="type" class="form-control" name='signed_by'>
                    
                  </div>
                </div>
              </div>
              
              <button type="submit" class="btn btn-success" name='subaction' value='update'>Update</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    
    <br><hr>
    
    <!-- case outcome section -->
    <div class="content" id="contentD">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-outline">
            <div class="card-header bg-dark">
              <h5 class="text-white m-b-0">Update Case Outcome</h5>
            </div>
            <div class="card-body">
              <form action="" method="post">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group has-feedback">
                    <label class="control-label">Case Outcome Information</label>
                    <textarea class="form-control" id="placeTextarea" rows="3" placeholder="Brief Information on Case Outcome" name='cInfo'></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Case outcome</label>
                    <select class="form-control" name="cOutcome" onchange="nextHearing()"placeholder="Case Outcome" id="cOutcome">
                        <option value="">---</option>
                        <?php echo $app->fetchOutcomes($_SESSION['concern']) ;?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6" id="nexthearing" style='display:none'>
                  <div class="form-group has-feedback">
                    <label class="control-label">Next Hearing Date</label>
                    <input type="date" class="form-control" name='cDate'>
                    
                  </div>
                </div>
              </div>
              
              <button type="submit" class="btn btn-success" name='suboutcome' value='update'>Update</button>
            </form>
            </div>
          </div>
        </div>
      </div>
      
     <br><hr>
      
     <?php if ($_SESSION['role'] != 'user') : ?>
       <form action="" method="post" enctype="multipart/form-data">
        <div class="row m-t-3">
        <div class="col-lg-12">
          <div class="card card-outline">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Case Details</h5>
            </div>
            <div class="card-body row">
                <?php if($_SESSION['role']=="super_admin"){?>
                
                <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Case Center</label>
                        <select class="form-control" name="caseCenter">
                            <option value="">select Center</option>
                            <option value="<?php echo $app->center ;?>" selected><?php echo $app->getCenter($app->center) ;?></option>
                            <?php echo $app->fetchCenters($_SESSION['concern']); ?>
                        </select>
                     </div>
                  </div>
                 <?php } ?>
                <div class="col-lg-6">
                     <div class="form-group">  
                        <label for=""><?php $str = $_SESSION['concern'] == 1 ?  "Counsel in Charge" :  "Mediator"; echo $str ;?></label>
                        <select class="form-control" name="caseCounsel">
                            <option value="">select <?php echo $str; ?></option>
                            <!--<option value="<?php //echo $app->counsel_in_charge ;?>" selected><?php //echo $app->getCounsel($app->counsel_in_charge ) ;?> </option>-->
                            <?php
                            if ($_SESSION['role'] == 'super_admin'){
                                $center = null;
                            }
                            else{
                                $center = $app->center;
                            }
                            echo $app->fetchCounselSS($_SESSION['concern'], 'cmc_users', $center, $app->counsel_in_charge) ;?>
                        </select>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">  
                        <label for=""><?php $str = $_SESSION['concern'] == 1 ?  "Counsel in Charge" :  "Mediator"; echo "Case/Matter Type" ;?></label>
                        <select class="form-control" name="caseCounsel" required>
                            <option value="">select <?php echo "...."; ?></option>
                            <!--<option value="<?php //echo $app->counsel_in_charge ;?>" selected><?php //echo $app->getCounsel($app->counsel_in_charge ) ;?> </option>-->
                            <?php
                            if ($_SESSION['role'] == 'super_admin'){
                                $center = null;
                            }
                            else{
                                $center = $app->center;
                            }
                            echo $app->fetchCaseTypes($_SESSION['concern']) ;?>
                        </select>
                     </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-t-3">
        <div class="col-lg-12">
          <div class="card ">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Party Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="partyA" class="text">Party A<span class="required">*</span></label>
                    <input class="form-control" type="text" placeholder="for multiple names separate with ';' " id='partya' value="<?php echo $app->party_a ;?>"  name="partyA" required>
                </div>
                <div class="form-group">
                    <label for="" class="text">Party A Contact Details<span class="required">*</span></label>
                    <div class="row">
                        <input class="form-control col" type="number" placeholder="phone number must start with `234`" value="<?php echo $app->pac ;?>" name="partyAno" required>
                        <input class="form-control col" type="email" placeholder="E-mail" name="partyAmail" value="<?php echo $app->pae ;?>" >
                        <input class="form-control col" type="address" placeholder="Home or office Address" name="partyAaddr" value="<?php echo $app->paa ;?>" >
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="PartyB" class="text">Party B<span class="required">*</span></label>
                    <input class="form-control" type="text" placeholder="for multiple names separate with ';' " id='partyb' value="<?php echo $app->party_b ;?>"   name="partyB" required>
                </div>
                <div class="form-group">
                        <label for="" class="text">Party B Contact Details<span class="required">*</span></label><br>
                        <div class="row">
                            <input class="form-control col" type="number" placeholder="phone number must start with `234`" value="<?php echo $app->pbc ;?>" name="partyBno" required>
                            <input class="form-control col" type="email" placeholder="E-mail" name="partyBmail" value="<?php echo $app->pbe ;?>">
                            <input class="form-control col" type="address" placeholder="Home or office Address" name="partyBaddr" value="<?php echo $app->pba ;?>">
                    
                        </div>
                   </div>
                
            </div>
          </div>
        </div>
      </div>
      <div class="row m-t-3">
        <div class="col-lg-12">
          <div class="card ">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Petioner/Client Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="" for="">Name<span class="required">*</span></label>
                            <input type="text" class="form-control" id="" placeholder="who brought the case to the center" value="<?php echo $app->pet_name ;?>" name="regName" required>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="" for="">Email</label>
                            <input type="email" class="form-control" id="" name="regEmail" placeholder="Petitioner's Email" value="<?php echo $app->pet_email ;?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="" for="">Phone Number<span class="required">*</span></label>
                            <input type="tel" class="form-control" id="" name="regPhone" placeholder="Petitioner's Contact Number" value="<?php echo $app->pet_con ;?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="" for="">Address<span class="required">*</span></label>
                            <input type="text" class="form-control" id="" name="regAddress" placeholder="Petitioner's Address" value="<?php echo $app->pet_add ;?>" required>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-t-3">
          <div class="col-lg-12">
            <div class="card ">
                <div class="card-header bg-blue"> <h5 class="text-white m-b-0">Additional Documents</h5></div>
                <div class="card-body">
                    <div class="col-lg-12 fileContainer">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control" type="file" accept=".png, .jpg, .jpeg, .docx, .pdf, .doc" name="file0">
                            </div>
                        </div>
                    </div>  
                    <button type="button" id="add" class="btn btn-info">Add More Document </button>
                </div>          
            </div>
          </div>
      </div>
      <div class="row m-t-3">
          <div class="col-md-12">
                 <button type="submit" name="submitCase" class="btn btn-success">Update</button>
          </div>
      </div>
      </form>
        
        <?php endif; ?>
    </div>
    
</div>

<script>

function nextHearing(){
  if (document.getElementById('nexthearing').value == 5){
    $("#nexthearing").show(800);

  }else{
    $("#nexthearing").hide(600);
  }
}

$(document).ready(function() {
    var maxInput = 5;
    var x = 1;
//    var htmls = '<div class="col-lg-6 gg"> <div class="form-group"> <input class="form-control file" type="file" id="file"'+x+'  accept=".png, .jpg, .jpeg, .docx, .pdf, .doc"><a href="javascript:void(0);" class="rmvInpt text-danger">remove</a></div>  </div>';
    $("#add").click(function(){
        if(x <= 3){
    var htmls = '<div class="col-lg-6 gg"> <div class="form-group"> <input class="form-control file" type="file" id="file'+ x+ '" accept=".png, .jpg, .jpeg, .docx, .pdf, .doc"><a href="javascript:void(0);" class="rmvInpt text-danger">remove</a></div>  </div>';
            $(".fileContainer").append(htmls);
            
            $("#file"+x).attr({"name": "file"+x});
            console.log(x);
            var name = $(".file").attr("name");
            var ids = $(".file").attr('id');
            console.log(ids);
            console.log(name);
             x++;
            //  console.log(x);
        }else{
            $("#add").hide(500);
        }
       
    });
    
    $(".fileContainer").on('click', '.rmvInpt', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    
	
});

</script>

<?php

    include 'footer.php';

?>