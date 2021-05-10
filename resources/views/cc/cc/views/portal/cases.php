<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
include('leftnav.php');


?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 class='' style='color:dodgerblue; font-style:bold; text-alin:center;'><?php echo $app->greetUser($_SESSION['role'], $_SESSION['center']);  ?></h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    <div style='padding:0px; border:0.4px solid lightgrey'>
    <table id="display" class='table table-stripped table-hover table-bordered' border='1px' style='padding:1px; text-transform:capitalize'>
        <thead class="thead-dark" style='text-transform:capitalize'>
            <tr>
                <th style=''>case title</th>
                <th>compla <span style='text-transform:lowercase'>inant(s)</span></th>
                <th>respo <span style='text-transform:lowercase'>ndent(s)</span></th>
                <th>status</th>
                <th>type</th>
                <th style='width:30px'>counsel</th>
                <th>center</th>
                <th>Category</th>
                <th>Outcome</th>
                <?php if ($_SESSION['role'] != 'user') : ?>
                <th style='padding-left:0px; padding-right:0px; width:150px; text-align:center'>Actions</th>
                <?php else : ?>
                <th style='padding-left:0px; padding-right:0px; width:120px; text-align:center'>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SESSION['role'] == 'user'){echo $app->fetchCases($_SESSION['concern'], $_SESSION['center'], $_SESSION['role'], $_SESSION['id']);}else{
            echo $app->fetchCases($_SESSION['concern'], $_SESSION['center'], $_SESSION['role'], null);
            }?>
        </tbody>
    </table>
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
        $(document).ready(function () {
         $('#display').DataTable({
             dom: 'Bfrtip',
             buttons: [
                 'copyHtml5',
                 'excelHtml5',
                 'csvHtml5',
                 'pdfHtml5',
                 'print'
             ]
         });
     });
    </script>
 <?php include('footer.php'); ?>