<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('../../views/portal/header.php');
include('../../views/portal/leftnav.php');

//session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], array('super_admin', 'admin') )){
    echo "<script>window.location='../views/index.php'</script>";
}
//include('../controller/CMC_controller.php');
//$app = new CMC_Controller();
if(isset($_POST['partya'])){
$partya = $_POST['partya']; $partyb = $_POST['partyb']; $pbc = $_POST['partyBno']; $pac = $_POST['partyAno']; $caseCat = $_POST['caseCat']; $ref = $_POST['ref']; $rn = $_POST['refName'];
$title = $_POST['title']; $center = $_POST['center']; $ct = $_POST['caseType']; $cd = $_POST['description']; $regname = $_POST['regName']; $regem = $_POST['regEmail'];
$regnum = $_POST['regPhone']; $regIncome = $_POST['regIncome']; $ra = $_POST['regAddress']; $mid = $_POST['IDtype']; $id_num = $_POST['IDno']; $pae = $_POST['partyAmail']; $padd = $_POST['partyAaddr'];
$pbe = $_POST['partyBmail']; $pbadd = $_POST['partyBaddr'];
}else{
    echo $app->displayErrors("no data received"); exit;
}

if($_FILES['IDpic']['size'] > 0){
    $app->upload('IDpic', '../uploads/documents', true,  array('pdf', 'jpg', 'png'), 0);
}else{
    $app->newname = ';';
}


    if($app->newname !== ''){
     
         echo "<body>
            <div class='content-wrapper' style='margin-top:0px; background-color:white'>" . 
                $app->intelligence($title, $partya, $partyb, $regname, $regnum, $mid, $id_num) . "
            </div>
        </body>" ;
    }
 //}

//$title, $party_a, $party_b, $rn, $rnum, $re, $ra, $mid, $id_num, $ct, $cd, $pac, $pbc, $concern, $center

?>


    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
   <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
   <!-- <script src=' https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.j'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js'></script>-->
    <script>
        $(document).ready(function() {
    $('#display').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
document.getElementById("cc").click();

document.querySelector('#cc').onclick = function(){
    var aj = new XMLHttpRequest();
    aj.onreadystatechange = function(){
        if (aj.readyState == 4){
            console.log(aj.responseText)
          var resp = JSON.parse(this.responseText);
          alert(resp.outcome);
          window.location = resp['url'];
        }
    }
   
   var da = "?title=<?php echo $title; ?>&party_a=<?php echo $partya;?>&party_b=<?php echo $partyb;?>&regnum=<?php echo $regnum; ?>&regname=<?php echo $regname; ?>&regadd=<?php echo $ra; ?>&regem=<?php echo $regem; ?>&mid=<?php echo $mid; ?>&id_num=<?php echo $id_num; ?>&type=<?php echo $ct; ?>&desc=<?php echo $cd; ?>&pac=<?php echo $pac; ?>&pbc=<?php echo $pbc; ?>&center=<?php echo $center; ?>&path=<?php echo $app->newname; ?>&casecat=<?php echo $caseCat; ?>&ref=<?php echo $ref; ?>&rn=<?php echo $rn; ?>&pbe=<?php echo $pbe; ?>
   &pbaddr=<?php echo $pbadd; ?>&pae=<?php echo $pae; ?>&paddr=<?php echo $padd; ?>";
   
     aj.open("GET", "finish_case.php" + da, true); 
    aj.send();

}

document.getElementById('cancel').addEventListener('click', () => {
  history.back();
});

</script>


<?php include('../../views/portal/footer.php'); ?>
