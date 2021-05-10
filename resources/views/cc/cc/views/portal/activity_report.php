<?php
ini_set('display_errors', 0); ini_set('display_startup_errors', 0); //error_reporting(E_ALL);
include('header.php'); 
include('leftnav.php');


?>

 <!-- Content Wrapper. Contains page content -->


<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  
<script>
anychart.onDocumentReady(function () {
      // create pie chart with passed data
   

anychart.onDocumentReady(function () {
      // create pie chart with passed data
      var chart = anychart.pie3d([
        ['LandLord Tenant', 9],
        ['Workplace', 552],
        ['Monetary/debt', 491],
        ['Compensation', 619],
        ['Family', 388],
        ['Local', 405],
        ['Inheritance/Succession', 405],
        ['Land', 405],
        ['Criminal', 405],
      ]);

      // set chart title text settings
      chart
        .title('Case Types')
        // set chart radius
        .radius('120%');

      // set container id for the chart
      chart.container('contained');
      // initiate chart drawing
      chart.draw();
    });


    anychart.onDocumentReady(function () {
      // create pie chart with passed data
      var chart2 = anychart.pie3d([
        ['Letters OF Invitation Sent', 12],
        ['Pre-meetings Noted', 5],
        ['Mediation Parties Joint Meeting Scheduled', 4],
        ['Mediation Adjourned', 6],
        ['Postponed Because One Or More Parties Did Not Attend', 8]
      ]);

      // set chart title text settings
      chart2
        .title('Case Actions')
        // set chart radius
        .radius('120%');

      // set container id for the chart
      chart2.container('contained2');
      // initiate chart drawing
      chart2.draw();
    });

    var chart3 = anychart.pie3d([
        ['Closed - M.O.U Signed', 9],
        ['Closed - No MOU Signed', 5],
        ['Closed - Incomplete Parties', 4],
        ['Closed - No Parties', 6],
        ['Closed - Independently Resolved', 8],
        ['Terminated By Mediator', 5],
      
      ]);

      // set chart title text settings
      chart3
        .title('Case Outcomes')
        // set chart radius
        .radius('120%');

      // set container id for the chart
      chart3.container('contained3');
      // initiate chart drawing
      chart3.draw();
    });


</script>

  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 class='' style='color:dodgerblue; font-style:bold; text-align:center;'><?php echo $app->greetUser($_SESSION['role'], $_SESSION['center']);  ?></h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>-->
    </div>
    
    <?php if ($_SESSION['role'] == 'super_admin') : ?>
    <div class='row' style='padding:10px'>
        <form action='' method='post'>
            <fieldset>
                <legend style='margin-left:15px'>Select a Filter</legend>
                <?php if ($_SESSION['role'] == 'super_admin') : ?>
            <div class='form-group col-lg-4 col-sm-12' >
                <label for='center'>All Centers</label>
                <select class='form-control sl' name='center'>
                    <option value=''>...</option>
                    <?php echo $app->fetchCenters($_SESSION['concern']); ?>
                </select>
            </div>
            <?php else : ?>
            
            <input type='hidden' name='center' value='<?php echo $_SESSION['center']; ?>' />
            
            <?php endif; ?>
            
            <div class='form-group col-lg-4 col-sm-12 '>
              
              <label for='center' style='visibility:hidden'>......</label>
    
            <button type='submit' name='sub' value='search' class='btn btn-primary form-control'>Generate Chart <i class='fa fa-search text-white'></i></button> 
            </div>
             <div class='form-group col-lg-4 col-sm-12 resetp'>
                
              <label for='center' style='visibility:hidden'>......</label>
             
            <a href='activity_report' class='btn btn-info form-control'>Refresh Page <i class='fa fa-refresh'></i></a>
            </div>
            
            </fieldset>
            
        </form>
        
    </div>
    <br>
    <?php endif; ?>
    
    <div class="row">
           <!-- <div class="col-lg-12">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Outcome Chart</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cOutcome" height="150"></canvas>
               	</div>
              </div>
            </div>-->
            <div class="col-lg-12">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      
                    </div>
                  </div>
                </div>
                <div>
            <div id="contained3" style='height:360px; width:100%'></div>
            </div>
              </div>
            </div>
            
            <div class="col-lg-6" style='display:none'>
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Type</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cType" height="180"></canvas>
               	</div>
              </div>
            </div>
            
            
              <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Assignment Status</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cStatus" height="180"></canvas>
               	</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Type</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cCenter" height="180"></canvas>
               	</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      
                    </div>
                  </div>
                </div>
                <div>
            <div id="contained" style='height:360px'></div>
            </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      
                    </div>
                  </div>
                </div>
                <div>
            <div id="contained2" style='height:360px'></div>
            </div>
              </div>
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
    
    
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
         if ($_SESSION['role'] == 'super_admin'){
    $unassigned = $app->getUnAssignedCaseCount($_SESSION['concern']);
    $assigned = $app->getAssignedCaseCount($_SESSION['concern']);
    
    }else if ($_SESSION['role'] == 'admin'){
        $unassigned = $app->getAssignedCaseCountInCenter($_SESSION['concern'], $_SESSION['center']);
        $assigned = $app->getUnAssignedCaseCountInCenter($_SESSION['concern'], $_SESSION['center']);
    }
        
        if($_SESSION['role'] == 'super_admin'){
            $complain = $app->fetchCaseCategoryStats($_SESSION['concern'], null, 'complain');
            $petition = $app->fetchCaseCategoryStats($_SESSION['concern'], null, 'petition');
            $legalrep = $app->fetchCaseCategoryStats($_SESSION['concern'], null, 'legal representation');
        }else if ($_SESSION['role'] == 'admin'){
           $complain = $app->fetchCaseCategoryStats($_SESSION['concern'], $_SESSION['center'], 'complain');
            $petition = $app->fetchCaseCategoryStats($_SESSION['concern'], $_SESSION['center'], 'petition');
            $legalrep = $app->fetchCaseCategoryStats($_SESSION['concern'], $_SESSION['center'], 'legal representation');  
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
         $complain = $app->fetchCaseCategoryStats($_SESSION['concern'], $_POST['center'], 'complain');
            $petition = $app->fetchCaseCategoryStats($_SESSION['concern'], $_POST['center'], 'petition');
            $legalrep = $app->fetchCaseCategoryStats($_SESSION['concern'], $_POST['center'], 'legal representation');
             $unassigned = $app->getAssignedCaseCountInCenter($_SESSION['concern'], $_POST['center']);
        $assigned = $app->getUnAssignedCaseCountInCenter($_SESSION['concern'], $_POST['center']);
       // $cnn = $_POST['center'];
       // echo "<script>alert($cnn) </script>" ;
        
    }
    ?>
    
    <script>
    
    /*
Template Name: Niche
Author: UXLiner
*/
$(function() {
    "use strict";



// ======
// Pie chart
// ======
/*new Chart(document.getElementById("cOutcome"),{
	type:'doughnut',
	data:{
		labels:
			['Closed - M.O.U Signed','Closed - No MOU Signed', 'Closed - incomplete parties', 'Closed - No Parties', 'Closed - independently resolved', 'terminated by mediator'],
		datasets:
			[{'label':'Case Category Chart',
		data:
			[13,3,10,5,7,3],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)',
			'rgb(155, 105, 186)',
			'rgb(055, 105, 255)',
			'rgba(75, 192, 192, 1)'],
		}]
},
	options: {
            responsive: true
        }
});

*/
// ======
// Pie chart
// ======
new Chart(document.getElementById("cType"),{
	type:'bar',
	data:{
		labels:
			['Red','Blue','Yellow','Green', 'Purple', 'Orange'],
		datasets:
			[{'label':'Case Outcome Chart',
		data:
			[12, 19, 3, 5, 5, 3],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)',
			  'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'],
		}]
},
	options: {
            responsive: true
        }
});


// ======
// Pie chart
// ======
new Chart(document.getElementById("cStatus"),{
	type:'doughnut',
	data:{
		labels:
			['Assigned', 'Un-Assigned'],
		datasets:
			[{'label':'...',
		data:
			[<?php echo $assigned; ?> , <?php echo $unassigned; ?>],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)'],
		}]
},
	options: {
            responsive: true
        }
});


// ======
// Pie chart
// ======
new Chart(document.getElementById("cCenter"),{
	type:'doughnut',
	data:{
		labels:
			['Petition','Complain' <?php if ($_SESSION['concern'] == 1)echo "Legal Rep."; ?>],
		datasets:
			[{'label':'...',
		data:
			[<?php echo $petition; ?>, <?php echo $complain; ?>, <?php if ($_SESSION['concern'] == 1)echo $legalrep; ?> ],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)'
			],
		}]
},
	options: {
            responsive: true
        }
});




})(jQuery);
    
</script>

 <?php include('footer.php'); ?>