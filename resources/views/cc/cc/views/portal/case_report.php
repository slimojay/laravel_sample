<?php
//ini_set('display_errors', 0); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
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
        <form action='' method='post'>
            <fieldset>
                <legend style='margin-left:15px'>Select a Filter</legend>
                <?php if ($_SESSION['role'] == 'super_admin') : ?>
            <div class='form-group col-lg-4 col-sm-12 col' >
                <label for='center'>select a center</label>
                <select class='form-control sl' name='center'>
                    <option value=''>All Centers</option>
                    <?php echo $app->fetchCenters($_SESSION['concern']); ?>
                </select>
            </div>
            <?php else : ?>
            
            <input type='hidden' name='center' value='<?php echo $_SESSION['center']; ?>' />
            
            <?php endif; ?>
            
            <div class='form-group  col-lg-4 col-sm-12 col'>
                <label for='center'>select a case type</label>
                <select class='form-control sl' name='type'>
                    <option value=''>All Cases</option>
                    <?php echo $app->fetchCaseTypes($_SESSION['concern']); ?>
                </select>
            </div>
            
            <div class='form-group col-lg-4 col-sm-12 col'>
                <label for='center'>select an outcome</label>
                <select class='form-control sl' name='outcome'>
                    <option value=''>All Outcomes</option>
                    <?php echo $app->fetchOutcomes($_SESSION['concern']); ?>
                </select>
            </div>
            <div class='form-group col-lg-4 col-sm-12 col'>
              <?php if ($_SESSION['role'] == 'admin') : ?>
              <label for='center' style='visibility:hidden'>......</label>
              <?php endif; ?>
            <button type='submit' name='sub' value='search' class='btn btn-primary form-control'>search <i class='fa fa-search text-white'></i></button> 
            </div>
             <div class='form-group col-lg-4 col-sm-12 col'>
                  <?php if ($_SESSION['role'] == 'admin') : ?>
              <label for='center' style='visibility:hidden'>......</label>
              <?php endif; ?>
            <a href='case_report' class='btn btn-info'>Refresh Page <i class='fa fa-refresh'></i></a>
            </div>
            
            </fieldset>
            
        </form>
        
    </div>
    <br>
    
    
    
    <div style='padding:0px; border:0.4px solid lightgrey'>
    <caption><h3 class='text-info-20'><strong>All Cases</strong></h3></caption>
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
                <th>outcome</th>
                <th>date of hearing</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'){if ($_SESSION['role'] == 'user'){
                echo $app->fetchCasesForReport($_SESSION['concern'], $_SESSION['center'], $_SESSION['role'], $_SESSION['id']);}else{
            echo $app->fetchCasesForReport($_SESSION['concern'], $_SESSION['center'], $_SESSION['role'], null);
            }
            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo $app->filterCaseSearch($_SESSION['concern'], $_POST['center'], $_POST['type'], $_POST['outcome']);
            
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