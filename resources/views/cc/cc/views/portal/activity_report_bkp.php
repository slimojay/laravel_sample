<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('header.php'); 
include('leftnav.php');


?>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 style='color:dodgerblue; font-style:bold; text-align:center;'>ACTIVITY REPORT</h1>
    </div>
    
    <!-- Main content -->
    <div class="content"> 
      
        <!-- Main row -->
        <div class="row">
            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Outcome</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cOutcome" height="150"></canvas>
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
                	<canvas id="cType" height="150"></canvas>
               	</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Status</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cStatus" height="150"></canvas>
               	</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box">
                <div class="col-12">
                  <div class="d-flex flex-wrap">
                    <div>
                      <h5>Case Category</h5>
                    </div>
                  </div>
                </div>
                <div>
                	<canvas id="cCenter" height="150"></canvas>
               	</div>
              </div>
            </div>
          
        </div>
    </div>
</div>

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
new Chart(document.getElementById("cOutcome"),{
	type:'pie',
	data:{
		labels:
			['Red','Blue','Yellow'],
		datasets:
			[{'label':'My First Dataset',
		data:
			[300,50,100],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)'],
		}]
},
	options: {
            responsive: true
        }
});


// ======
// Pie chart
// ======
new Chart(document.getElementById("cType"),{
	type:'pie',
	data:{
		labels:
			['Red','Blue','Yellow'],
		datasets:
			[{'label':'My First Dataset',
		data:
			[300,50,100],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)'],
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
	type:'pie',
	data:{
		labels:
			['Red','Blue','Yellow'],
		datasets:
			[{'label':'My First Dataset',
		data:
			[300,50,100],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)'],
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
	type:'pie',
	data:{
		labels:
			['Red','Blue','Yellow'],
		datasets:
			[{'label':'My First Dataset',
		data:
			[300,50,100],
		backgroundColor:
			['rgb(255, 99, 132)',
			'rgb(54, 162, 235)',
			'rgb(255, 205, 86)'],
		}]
},
	options: {
            responsive: true
        }
});




})(jQuery);
    
</script>


<!-- template --> 
<script src="dist/js/niche.js"></script> 

<!-- Chartjs JavaScript --> 
<!--<script src="dist/plugins/chartjs/chart.min.js"></script>-->
<!--<script src="dist/plugins/chartjs/chart-int.php"></script>-->

<?php

include 'footer.php';

?>