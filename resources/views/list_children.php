<?php
include('header.php');
include('left_nav.php');
 ?>


 <div class="content-wrapper" > 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
    	 <h1 style="color:dodgerblue; font-style:italics"><span>
    	 	
    	 </span></h1>
    </div>
 <div class='content' style='padding:10px; width:100%'>
    <div class='row' style='padding:10px; width:100%'>
        <form action="" method='POST'>

            <fieldset>
            	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <legend style='margin-left:15px'>Filter Report</legend>
            
            <div class='form-group col-lg-6 col-sm-12 col ' >
                <label for='center' style='color:black'>Select Age</label>
                <select class='form-control sl text-dark' name='age' style="height:34px">
                    <option value=''>...</option>
                    <?php for($i = 0; $i <= 6; $i++){
                    	echo "<option value='$i'>$i year(s)</option>";
                    } ?>
                </select>
            </div>
            
            
            <div class='form-group  col-lg-6 col-sm-12 col text-dark'>
                <label for='center' style='color:black'>Select Gender</label>
                <select class='form-control sl text-dark' name='gender' style="height:34px">
                    <option value=''>...</option>
                    <option value='1'>male</option>
                    <option value='2'>female</option>
                </select>
            </div>
            
            <div class='form-group col-lg-6 col-sm-12 col'>
              <label for='center' style='visibility:hidden'>......</label>
            <button type='submit' name='sub' value='search' class='btn form-control text-white' style='background: #191d14'>Search <i class='fa fa-search text-white'></i></button> 
            </div>
             <div class='form-group col-lg-6 col-sm-12 col'>
                  
              <label for='center' style='visibility:hidden'>......</label>
            <a href='' class='btn form-control' style='background:black'>Reset Page <i class='fa fa-refresh'></i></a>
            </div>
            
            </fieldset>
            
        </form>
         
    </div>

    <table class="table table-striped table-hover table-bordered bg-white text-black text-center" id="display" style="width:100%; margin-top:30px; overflow-x: auto">
    <thead class="bg-dark text-white">
    <tr>
    	<th>
    		#
    	</th>
    	<th>
    		Name
    	</th>
    	<th>
    		Age
    	</th>
    	<th>
    		Gender
    	</th>
    	<th>
    		Date Found
    	</th>
    	<th>
    		Action
    	</th>
    </tr>
    </thead>
    <tbody>
    	<?php 
    	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    	foreach ($query as $key) {
    		# code...
    		$count++;
            $route = route('pf', ['id' => $key->id]);
    		echo "<tr><td>$count</td><td>" . ucwords($key->name). "</td><td>$key->age</td><td>$key->gen</td><td>$key->date_found</td><td><a href='$route'><i class='fa fa-eye' style='color:black; font-size:19px; font-weight:100'></i></a></tr>";
    		//$count++;
    	}
    }else{
    	if (isset($query)){
    		foreach ($query as $key) {
    		# code...
    		$count++;
            $route = route('pf', ['id' => $key->id]);
    		echo "<tr><td>$count</td><td>" . ucwords($key->name). "</td><td>$key->age</td><td>$key->gen</td><td>$key->date_found</td><td><a href='$route'><i class='fa fa-eye' style='color:black; font-size:19px; font-weight:100'></i></a></tr>";
    		//$count++;
    	}
    }else{
    	echo $querystr;
    }

    }
    	?>
    </tbody>

    </table>










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
    $(document).ready( function () {
    $('#display').DataTable();

        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
//} );
    </script>
 <?php include('footer.php'); ?>