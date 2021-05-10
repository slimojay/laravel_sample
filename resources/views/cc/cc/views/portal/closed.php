<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
include('leftnav.php');


?>

 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 class='' style='color:dodgerblue; font-style:bold; text-align:center;'><?php echo $app->greetUser($_SESSION['role'], $_SESSION['center']);  ?></h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    <div class='content'>
    <div class='row' style='padding:10px'>
        
    </div>
    <br>
    
    
    
    <div style='padding:0px; border:0.4px solid lightgrey'>
    <caption><h3 class='text-info-20'><strong>List of Closed Matters</strong></h3></caption>
    <table id="display" class='table table-stripped table-hover table-bordered' border='1px' style='padding:1px; text-transform:capitalize'>
        <thead class="thead-dark" style='text-transform:capitalize'>
            <tr>
                <th style=''>case title</th>
                <th>complainant(s)</th>
                <th>respondent(s)</th>
                <th>status</th>
                <th>type</th>
                <th style=''>counsel</th>
                <th>center</th>
                <th>Category</th>
                <th>date of hearing</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'){
                if ($_SESSION['role'] == 'admin'){
                echo $app->fetchConcludedCase($_SESSION['center'], $_SESSION['concern'], null);}else{
            echo $app->fetchConcludedCase(null, $_SESSION['concern'], null);
            }
            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // echo $app->filterCaseSearch($_SESSION['concern'], $_POST['center'], $_POST['type'], $_POST['outcome']);
            
            }?>
        </tbody>
    </table>
    </div>
    
    </div>
    </div>
    </div>
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
   <script src=' https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.j'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js'></script>
    <script src='https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js'></script>
    <script>
        $(document).ready(function() {
    $('#display').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    </script>
 <?php include('footer.php'); ?>