<?php
    // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include 'header.php';
    include 'leftnav.php';
    
?>
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
   
    <style>
       
        .error {color: #c7254e;}
        .form-control{height:40px !important;}
        legend{color: dodgerblue; font-style:italics}
        #imgPreview{
            padding:10px;
            background:#ccc;
            content:'image preview';
            border-radius:20px;
            
        }
        #output_image{
         width:200px;
         height:100px;
         margin:10px 20px;
         border:none;
        }
        ::placeholder {
          color: rgba(120, 120, 120, 0.1);
        }
        
        :-ms-input-placeholder {
          color: dodgerblue;
          opacity: 0.05;
        }
        
        ::-ms-input-placeholder {
          color: lightgray;
          opacity: 0.05;
        }
        
        span.required{
            color:red;
        }
        input.col{
            margin:10px;
            padding-right:5px;
        }
        
    </style>
<div class="content-wrapper">
     <div class="content-header sty-one">
        <h1 style="color:dodgerblue; font-style:italics">Create New Client</h1>    
    </div>
    <div class="container">
    
        <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Name<span class="required">*</span></label>
                <input type="text" class="form-control" id="" placeholder="who brought the case to the center" name="regName" required>
            </div>
            
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Email</label>
                <input type="email" class="form-control" id="" name="regEmail" placeholder="Petitioner's Email">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Phone Number<span class="required">*</span></label>
                <input type="tel" class="form-control" id="" name="regPhone" placeholder="Petitioner's Contact Number" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Address<span class="required">*</span></label>
                <input type="text" class="form-control" id="" name="regAddress" placeholder="Petitioner's Address" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Income</label>
                <input type="text" class="form-control" id="" name="regIncome" placeholder="e.g '50 - 80k monthly'">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Type of ID <span class="required">*</span> </label>
                <select name="IDtype" id="idtype" class="form-control" >
                    <option value="" selected>Select ID Type</option>
                    <option value="Voters card">Voters card</option>
                    <option value="NIN">National Identity Card</option>
                    <option value="Driver License">Drivers License</option>
                    <option value="International Passport">International Passport</option>
                    <option value="BVN">BVN</option>
                </select>
            </div>
            
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for=""><span id="idlabel"> ID </span> Number <span class="required">*</span></label>
                <input type="text" class="form-control" id="idno" name="IDno" placeholder="enter the number on the ID" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="" for="">Upload ID Image</label>
                <input type="file"  onchange="preview_image(event)" class="form-control" id="" name="IDpic">
            </div>
        
            <div id="iw">
                <img id="output_image" />
            </div>
        </div>
    </div>
    </div>
</div>


<?php
    include 'footer.php'
?>