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
    }
    }
    
    $app->fetchCaseDetails($_GET['id'], $_SESSION['id_case'] = $_GET['id'], $_SESSION['concern'], $_SESSION['id'], $_SESSION['role'], $_SESSION['center']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $url = "casedetail.php?id=" . $_SESSION['id_case'];
    $date = $_POST['dt'];
        echo $app->assignToCounsel($_POST['counsel_n'], $_SESSION['id_case'], $date, '', $_SESSION['role'], $_SESSION['center'], $_SESSION['concern']);
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['sub'])){
            
        }
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
        margin-top:-50px;
    }
    
    .card{
        border-radius: 10px !important;
    }
    .card-title{
        
    }
    b{
        color:black;
        text-transform:capitalize;
    }
</style>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
        <h1 style="color:dodgerblue; font-style:italics">Case Details</h1>
    </div>
   <div class="content" id="contentD">
        <div class="row m-t-3">
          
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
                        <p>Case ID: <b><?php echo $app->unique; ?></b></p>
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
        </div><br>
        
        
        <div class="row m-t-3 form-inline float-right" style='margin-right:15px'>
            <from action='' method='post' id='fm' >
            <input type='hidden' name='case_id' value="<?php echo $_GET['id']; ?>" />
             <div class='form-group'>
            <input type='submit' name='sub' value='Delete Case' class='form-control btn btn-danger'/>
            </div>
            </from>
           
            
        </div>
     
        
    </div>
    
</div>


<?php
   

    include 'footer.php';

?>

   <script>
           document.querySelector('#fm').onclick = function(e){
                e.preventDefault();
                swal({
  title: "Are you sure?",
  text: "You Are About To Delete : <?php echo $app->title; ?>",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      var aj = new XMLHttpRequest();
      aj.onreadystatechange = function(){
          if (aj.readyState == 4){
              if(aj.responseText == 'case successfully deleted'){
              swal(aj.responseText, {
      icon: "success",
    }); 
    window.location='cases'
                  
              }else{
                swal(aj.responseText, {
      icon: "danger",
    }); 
    window.location='cases'  
              }
          }
      }
      aj.open("GET", "../../model/delete_case.php?case=<?php echo $app->unique ?>", true);
      aj.send();
  } else {
    swal("process halted, file is safe");
  }
});
                document.querySelector('#fm').action = '../../model/delete_case.php'
                document.querySelector('#fm').method = 'post';
                
            }
          
        </script>