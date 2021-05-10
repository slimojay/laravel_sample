<?php

include('header.php'); 
include('leftnav.php');


?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 class='' style='color:dodgerblue; font-style:bold; text-alin:center;'><?php echo ucwords($_SESSION['role']) . " Dashboard"; ?></h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    <div style='padding:10px'>
    <table id="display" class='table table-stripped' border='1px' style='padding:5px'>
        <thead style='text-transform:capitalize'>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>party a</th>
                <th>party b</th>
                <th>description</th>
                <th>case type</th>
                <th>verdict</th>
                <th>center</th>
                <th>Counsel</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $app->fetchAssignedCases($_SESSION['concern'], $_SESSION['center'], $_SESSION['role']); ?>
        </tbody>
    </table>
    </div>
    
    </div>
    </div>
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