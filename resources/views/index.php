<?php
include('header.php');
include('left_nav.php');
 ?>
<style>
  @media screen and (min-width:500px){
fieldset{margin-left:40px; max-width:100%; padding:10px}

  }
  label{color:black}
</style>
  

<script type='text/javascript'>
    function preview_image(event) 
    {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output_image');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1 style='color:black'>Dashboard</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Dashboard</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content"> 
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-darkblue" style='background-color:black !important'> <span class="info-box-icon bg-transparent"><i class="fa fa-users text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Children</h6>
              <h1 class="text-white"><?php echo $all; ?></h1>
              <span class="progress-description text-white"> Total Count Of Children </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green text-white" style='background-color:black !important'> <span class="info-box-icon bg-transparent"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Male</h6>
              <h1 class="text-white"><?php echo $male; ?></h1>
              <span class="progress-description text-white" style='visibility:hidden'> Male</span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua" style='background-color:black !important'> <span class="info-box-icon bg-transparent"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Female</h6>
              <h1 class="text-white"><?php echo $female; ?></h1>
              <span class="progress-description text-white" style='visibility:hidden'> ....  </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-orange" style='background-color:#191d14 !important'> <span class="info-box-icon bg-transparent"><i class="fa fa-card"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Requests</h6>
              <h1 class="text-white"><?php echo $offers; ?></h1>
              <span class="progress-description text-white">Requests From Potential Adoptors </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col --> 
      </div>

    <div class='row'>

    <form action="/" method="POST" enctype="multipart/form-data">
    
      <fieldset>
        <legend>Enroll Child</legend>
     <input type='hidden' name="_token" value="<?php echo csrf_token(); ?>" > 

     <div class="form-group col-lg-6 col-sm-12 col">
       <label>Name Of Child</label>
        <input type='text' name='name' id='name' required minlength='2' class='form-control' placeholder="e.g Sumaya">

      </div>

      

      <div class="form-group col-lg-6 col-sm-12">
      <label>Age</label>
        <select name="age" required class="form-control" style='height:34px'>
          <option value=""></option>
          <?php for($i = 0; $i <= 5; $i++){
            echo "<option value='$i'> $i year(s)</option>";
          }

          ?>

        </select>

      </div>


      <div class="form-group col-lg-6 col-sm-12">
      <label>Date Found</label>
        <input type='date' name='df' id='df' minlength='2' class='form-control'  format="yyyy/mm/dd"required > 

      </div>

      <div class="form-group col-lg-6 col-sm-12">
      <label>Time Found</label>
        <input type='time' name='tf' id='tf' minlength='2' class='form-control'>

      </div>
      <div class="form-group col-lg-6 col-sm-12">
      <label>Gender</label>
      <select name="gender" required class="form-control" style='height:34px'>
          <option value="">...</option>
          <option value="1">Male</option>
          <option value="2">Female</option>
        </select>
      </div>
      <div class="form-group col-lg-6 col-sm-12">
      <label class="" for="">Upload ID Image (** .png, .jpeg **)</label>
      <input type="file" accept="image/*" onchange="preview_image(event)" class="form-control" id="" name="IDpic">
        </div>
      <div id="iw">
      <img id="output_image" />
       </div>

      <div class="form-group col-lg-6 col-sm-12" style="margin-top:30px">
      <button type='submit' name='sub' class='btn  btn-lg' style='background-color:#191d14'>Enroll</button>
</div>
      </fieldset>
      </form>

</div>
</div></div>


      <!-- /.row --> 
      <!-- Main row -->
      <!--
      <div class="row">
        <div class="col-lg-7 col-xlg-9">
          <div class="info-box">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Analytics Overview</h4>
              </div>
              <div class="ml-auto">
                <ul class="list-inline">
                  <li class="text-info"> <i class="fa fa-circle"></i> Sales</li> <li class="text-blue"> <i class="fa fa-circle"></i> Earning</li>
                </ul>
              </div>
            </div>
            <div>
              <canvas id="line-chart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-xlg-3">
          <div class="info-box">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Our Visitors</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="pie-chart" height="210"></canvas>
            </div>
          </div>
        </div>
    <!--  
      <div class="row">
      <div class="col-lg-4">
        <div class="soci-wid-box bg-twitter m-b-3">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-twitter-alt"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-twitter-alt"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-twitter-alt"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="soci-wid-box bg-facebook m-b-3">
          <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-facebook"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-facebook"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-facebook"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="soci-wid-box bg-google-plus m-b-3">
          <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-google"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-google"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="col-lg-12 text-center">
                  <div class="sco-icon"><i class="ti-google"></i></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante.</p>
                  <p class="text-italic pt-1">- John Doe -</p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
        </div>
      </div>
    </div>
    <!-- /.content 
  </div>
  <!-- /.content-wrapper -->
 
<?php include('footer.php'); ?>
</body>
</html>
