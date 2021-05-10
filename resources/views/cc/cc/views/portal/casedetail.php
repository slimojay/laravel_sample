<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
  //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include 'header.php';
    include 'leftnav.php';
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET['id'])){
        echo "<script>alert('no case selected'); window.location='index.php'</script>";
    }else{
       $_SESSION['id_case'] = $_GET['id']; 
       $idd = $_SESSION['id_case'];
    }
    }
    
    $app->fetchCaseDetails($_GET['id'], $_SESSION['id_case'] = $_GET['id'], $_SESSION['concern'], $_SESSION['id'], $_SESSION['role'], $_SESSION['center']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $url = "casedetail?id=" . $_SESSION['id_case'];
    $date = $_POST['dt'];
        echo $app->assignToCounsel($_POST['counsel_n'], $_SESSION['id_case'], $date, '', $_SESSION['role'], $_SESSION['center'], $_SESSION['concern']);
    }

?>

<style>
    #contentD{
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 15px;
        color: #666f73;
    }
    
    .card{
        border-radius: 10px !important;
    }
    .card-title{
        
    }
    b{
        color:dimgrey;
        text-transform:capitalize;
    }
</style>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
        <h1 style="color:dodgerblue; font-style:italics">Case Details <span style='float:right; margin-right:5px'><a href="edit_case?id=<?php echo $idd; ?>" class='btn btn-white'>Edit Case</a> &nbsp <button class='btn btn-secondary' style='border:1px solid black' onclick='window.print()'>Print</button> </span></h1>
    </div>
    <div class="content" id="contentD">
        <div class="row m-t-3">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header bg-blue"> <h4>Petitioner</h4></div>
                <div class="card-body row">
                    <div class="col">
                        <p>Name: <b><?php echo $app->pet_name; ?></b> </p>
                        <p>Email: <b><?php echo $app->pet_email; ?> </b></p>
                        <p>Phone No: <b><?php echo $app->pet_con; ?></b> </p>
                        <p>Address: <b><?php echo $app->pet_add; ?></b> </p> 
                    </div>
                    <div class="col">
                        <!--<p>Income: {income of petioner} </p>-->
                        <p style='margin-left:7px'>
                            <b>scanned ID image</b><br>
                                    <?php if($app->file != ";"){ 
                                            echo "<img src='../". $app->file . "' height='120px' width='170px' style='border:1px solid black; border-radius:5px' alt='scanned ID'/>"; 
                                    }else{echo "<h6 style='color:red; text-align:center; padding:20px 2px; border:1px solid black; width:150px; height:50px; '>No Image Uploaded</h6>";}
                                       
                                    ?> 
                            <br>  
                            <b style='text-align:center;'><?php echo $app->mod . " -> " . $app->id_num; ?></b>  </p>    
                    </div>
                  
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header bg-blue"><h4>Parties Involved</h4></div>
                <div class="card-body">
                    <p>Party A: <b><?php echo $app->party_a; ?></b></p>
                    <p>Party A No: <b><?php echo $app->pac; ?></b></p>
                    <p>Party B: <b><?php echo $app->party_b; ?></b></p>
                    <p>Party B No: <b> <?php echo $app->pbc; ?></b></p>
                </div>
              </div>
            </div>
            <div class="col-lg-12 m-t-3">
              <div class="card">
                <div class="card-header bg-blue"><h4>Case Information</h4></div>
                <div class="card-body row">
                    <div class="col">
                        <p> Title: <b><?php echo $app->title; ?></b></p>
                        <p>Type: <b><?php echo $app->getCaseType($app->case_type); ?></b></p>
                        <p>Verdict: <b><?php echo $app->fetchCaseVerdict($_GET['id']); ?></b></p>
                        <p>Center: <b> <?php echo $app->getCenter($app->center); ?> Center</b> </p>
                        
                    </div>
                    <div class="col">
                        <p>Case ID: <b><?php echo $app->unique; ?></b> </p>
                        <?php if ($_SESSION['concern'] == 1) : ?>
                        <p>Category: <b><?php echo $app->cat; ?></b></p>
                        <?php endif; ?>
                        <p>Date Registered: <b><?php echo $app->date_registered; ?></b></p>
                        <p>Referred By: <b><?php echo $app->ref; ?></b></p>
                        <?php if($app->counsel_in_charge >= 1) : ?>
                        <p>Counsel in Charge:  <b><?php echo $app->getCounsel($app->counsel_in_charge); $display = 'none'; //var_dump($app->counsel_in_charge);?></b></p>
                        <?php else : ?>
                        <p>Case Status : <b><?php echo $app->status;  $display = 'block'; ?></b></p>
                        <?php endif; ?>
                    </div>
                    
                </div>
              </div>
            </div>
            <div class="col-lg-12 m-t-3">
                <div class="card">
                    <div class="card-header bg-blue"><h4>Case Brief</h4></div>
                    <div class="card-body" style="padding:10px;"><?php echo $app->desc; ?></div>
                </div>
               
            </div>
            <br><hr>
            
            
                 <?php if ($app->isCaseActionReady($_SESSION['id_case']) == 1) {
               // echo isCaseOutcomeReady($_SESSION['id_case']);
                $actions = $app->fetchCaseActions ($_SESSION['id_case']); $i = 0;
                //echo count($verdicts); array($r['action'], $r['comment'], $r['case_id'], $r['date_of_action'], $r['officer'], $r['signed_by']);
         while ($i < count($actions)){
                    echo "    <div class='col-lg-12 m-t-3'>
                <div class='card'>
                    <div class='card-header bg-secondary'><h4>Case Action " .  ($i + 1) . "</h4></div>
                    <div class='card-body' style='padding:10px;'><p>Case/Matter Outcome: <b>" .  $app->getAction($actions[$i][0], $_SESSION['concern']) . "</b></p></div>
                    <div class='card-body' style='padding:10px;'><p>Note/Comment: <b>" .  $actions[$i][1] . "</b></p></div>
                    <div class='card-body' style='padding:10px;'><p> Officer In Charge: <b>" .  $actions[$i][4] . " </b></p></div>
                    <div class='card-body' style='padding:10px;'><p> Signed By: <b>" .  $actions[$i][5] . " </b></p></div>
                    <div class='card-body' style='padding:10px;'><p> Date Of Action: <b>" .  $actions[$i][3] . " </b></p></div>
                </div>
               
            </div>";
            $i++;
            }
          
            }
            ?>
            
            <?php if ($app->isCaseOutcomeReady($_SESSION['id_case']) == 1) {
               // echo isCaseOutcomeReady($_SESSION['id_case']);
                $verdicts = $app->fetchCaseOutcomes($_SESSION['id_case']); $i = 0;
                //echo count($verdicts);
         while ($i < count($verdicts)){
                    echo "    <div class='col-lg-12 m-t-3'>
                <div class='card'>
                    <div class='card-header bg-dark'><h4>Case Outcome " .  ($i + 1) . "</h4></div>
                    <div class='card-body' style='padding:10px;'><p>Case/Matter Outcome: <b>" .  $app->getOutcome($verdicts[$i][0], $_SESSION['concern']) . "</b></p></div>
                    <div class='card-body' style='padding:10px;'><p>Brief: <b>" .  $verdicts[$i][1] . "</b></p></div>
                    <div class='card-body' style='padding:10px;'><p>" . $verdicts[$i][5] . ": <b>" .  $verdicts[$i][3] . " </b></p></div>
                </div>
               
            </div>";
            $i++;
            }
          
            }
            ?>
            
         
            <br><hr>
            
            
        </div><br>
        <?php if ($_SESSION['role'] !== 'user') : ?>
        <div class="row m-t-3" style="display: <?php echo $display; ?>">
            <div class="col-lg">
                <form class="form-inline float-right" method='post' action=''>
                    <div class='form-group'>
                        <input type='datetime-local' name='dt' placeholder='select date & time' class='form-control'>
                        
                    </div>
                        <select class="form-control" style="height:40px; margin-right:10px" name='counsel_n' required>
                            <?php if ($_SESSION['concern'] == 1) : ?>
                            <option value="" selected>-select counsel-</option>
                            <?php elseif($_SESSION['concern'] == 2): ?>
                            <option value="" selected>-select mediator-</option>
                            <?php endif; ?>
                            <?php 
                            if ($_SESSION['role'] == 'super_admin'){
                                $center_val = null;
                                
                            }else{
                                $center_val = $_SESSION['center'];
                            }
                            echo $app->fetchCounsels($_SESSION['concern'], 'cmc_users', $center_val); ?>
                        </select>
                        <button type="submit" id="btn" class="btn btn-success mb-2" name='assign'>Assign Case</button> 
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
</div>


<?php
   

    include 'footer.php';

?>