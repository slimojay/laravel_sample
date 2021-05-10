<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
include('leftnav.php');


?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 class='' style='color:dodgerblue; font-style:bold; text-alin:center;'><?php echo $app->greetUser($_SESSION['role'], $_SESSION['center']); ?></h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    <div style='padding:10px'>
    <table id="display" class='table table-stripped' border='1px' style='padding:5px; text-transform:capitalize; border:0.75px solid black'>
        <thead style='text-transform:capitalize'>
            <tr>
                <th>#</th>
                <th>first Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Last Login</th>
                <th>category</th>
                <th>center</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SESSION['role'] == 'admin'){echo $app->fetchUsers($_SESSION['concern'], $_SESSION['center']);}else if($_SESSION['role'] == 'super_admin'){
            echo $app->fetchUsers($_SESSION['concern'], '');
            }else{
            echo "<script>window.location='index.php'</script>";
            }
            ?>
        </tbody>
    </table>
    </div>
    
    </div>
    </div>
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
   <!--<script src=' https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js'></script>
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
    </script>
 <?php include('footer.php'); ?>