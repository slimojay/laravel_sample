<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
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
        <h1 style="color:dodgerblue; font-style:italics">Create New Case</h1>    
    </div>
<div class="container">
    <div class="site-index">
        <div class="body-content">
            <div class="row">
                <div class="col-md-12">
                    <!--<h1>Validation example with jQuery Validation</h1>-->
                    <form id="wizard_example" action="handle_case.php" method='post' enctype='multipart/form-data'>
                        <fieldset>
                            <legend>Select Matter Type</legend>
                            <?php if ($_SESSION['concern'] == 1) : ?>
                                                        <div class="form-group">
                                <label for= "caseCategory">first time @ <?php echo $app->getConcern($_SESSION['concern']); ?> ? <span class="required">*</span></label>
                                <select class="form-control" name='appearance' required>
                                    <option value="" selected>...</option>
                                   <option>Yes</option>
                                   <option>No</option>
                                </select>
                            </div>
                            
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for= "caseCategory"> Case Category<span class="required">*</span></label>
                                <select class="form-control" name="caseCat" id='casecat' onchange='change()' required>
                                    <option value="" selected>-select Case Category-</option>
                                    <option value="complain">Complain</option>
                                   <?php if ($_SESSION['concern'] == 1) : ?> <option value="legal representation">Legal Representation</option> <?php endif;?>
                                    <option value="petition">Petition</option>
                                </select>
                            </div>
                            
                            
                           
                            <div id='opts' style='visibility:hidden'>
                                
                                 <div class="form-group">
                                <label>Referrals</label>
                                <select class="form-control" name="ref" >
                                    <option value="" selected>-select Referral-</option>
                                   <?php echo $app->fetchRefs(); ?>
                                </select>
                           </div>
                            <div class="form-group">
                                <!--<label class="" for="">Name Of Agency</label>-->
                                <input type="text" class="form-control" id="" placeholder="Name of Referral" name="refName" >
                            </div>
                                
                            </div>
                            

                           
                        </fieldset>
                        <fieldset>
                            <legend>Petitioner/Client Profile</legend>

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
                                                <input type="number" class="form-control" id="" name="regPhone" placeholder="Petitioner's Contact Number" required>
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
                                                <label class="" for="">LGA of Residence<span class="required">*</span> </label>
                                                <select name="lga" id="lga" class="form-control" >
                                                    <option value="">Select Complainants LGA</option>
                                                    <?php echo $app->fetchLGAs(); ?>
                                                    
                                                </select>
                                            </div>
                                            
                                        </div>


                                        <div class="col-md-6">
                                <div class="form-group has-feedback">        
                                    <label class="control-label">Gender<span class="required">*</span></label>
                                    <div class="form-control" style="border:none">
                                        <div class="form-check-inline">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" value="male" required> Male 
                                          </label>
                                        </div>
                                        <div class="form-check-inline">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="gender" value="female" required> Female
                                          </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="" for="">Marital Status<span class="required">*</span> </label>
                                                <select name="ms" id="ms" class="form-control" >
                                                    <option value="">choose marital status</option>
                                                    <option value="male">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="divorced">Divorced</option>
                                                    <option value="widow">Widow</option>
                                                    <option value="widower">Widower</option>
                                                    <option value="others">Others</option>
                                                    
                                                </select>
                                            </div>
                                            
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="" for="">Religion<span class="required">*</span> </label>
                                                <select name="religion" id="religion" class="form-control" >
                                                    <option value="">Select Religion</option>
                                                    <option value="christian">Christian</option>
                                                    <option value="muslim">Muslim</option>
                                                    <option value="traditional">Traditional</option>
                                                    <option value="none">None</option>
                                                </select>
                                            </div>
                                            
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="" for="">Complainant Age Range <span class="required">*</span> </label>
                                                <select name="age-range" id="age-range" class="form-control" >
                                                    <option value="">Select Age Range</option>
                                                    <option value="16-44">16 - 44</option>
                                                    <option value="45-60">45 - 60</option>
                                                    <option value="61-75">61 - 75</option>
                                                    <option value="76 & Above">76 & Above</option>
            
                                                </select>
                                            </div>
                                            
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="" for="">Are You Employed<span class="required">*</span> </label>
                                                <select name="emp-status" id="emp-status" onchange='occ()' class="form-control" >
                                                    <option value="">Select Employment Status</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                            
                                        </div>


                                        <div class="col-lg-6" id='occ-div' style='display:none'>
                                            <div class="form-group">
                                                <label class="" for="">Select Occupation<span class="required">*</span> </label>
                                                <select name="Occupation" id="occupation" class="form-control" >
                                                    <option value="">occupation</option>
                                                    <option value="public sector">Government</option>
                                                    <option value="private sector">private Sector</option>
                                                    <option value="sole trader">Sole Trader</option>
                                                </select>
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
                                                <input type="text" class="form-control" id="idno" name="IDno" placeholder="Enter the ID, NIN or BVN Number" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="" for="">Upload ID Image (** .png, .jpeg **)</label>
                                                <input type="file" accept="image/*" onchange="preview_image(event)" class="form-control" id="" name="IDpic">
                                            </div>
                                        
                                            <div id="iw">
                                                <img id="output_image" />
                                            </div>
                                        </div>
                                    </div>
                                
                                
                        </fieldset>
                        <fieldset>
                            <legend>Parties Information</legend>
                            <div class="form-group">
                                <label for="partyA" class="text">Complainant<span class="required">*</span></label>
                                <input class="form-control" type="text" placeholder="for multiple names separate with ';' " id='partya' name="partya" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="text">Complainant Contact Details<span class="required">*</span></label>
                                <div class="row">
                                    <input class="form-control col" type="number" placeholder="phone number must start with `234`" name="partyAno" required>
                                    <input class="form-control col" type="email" placeholder="E-mail" name="partyAmail"  required>
                                    <input class="form-control col" type="address" placeholder="Home or office Address" name="partyAaddr" required>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="PartyB" class="text">Respondent<span class="required">*</span></label>
                                <input class="form-control" type="text" placeholder="for multiple names separate with ';' " id='partyb' name="partyb" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="text">Party B Contact Details<span class="required">*</span></label><br>
                                <div class="row">
                                    <input class="form-control col" type="number" placeholder="phone number must start with `234`" name="partyBno" required>
                                    <input class="form-control col" type="email" placeholder="E-mail" name="partyBmail">
                                    <input class="form-control col" type="address" placeholder="Home or office Address" name="partyBaddr">
                            
                                </div>
                                
                           </div>
                                
                            <div class="form-group">
                                <label for="title" class="text">Case Title</label>
                                <input class="form-control" type="text" placeholder="e.g mr ggg vs mrs fff" name="title" id='title' required>
                            </div>
                           
                           
                        </fieldset>
                        <fieldset>
                            <legend>Case Details</legend>
                                    <div class="form-group">
                                        <label for="caseType" class="text">Case Category<span class="required">*</span></label>
                                        <select class="form-control " name="caseType" id='typee' required style="height:70px" onchange="">
                                            <option value="">Select Case Type</option>
                                            <?php echo $app->fetchCaseTypes($_SESSION['concern']); ?>
                                        </select>
                                    </div>
                                    <?php if ($_SESSION['concern'] == 1) : ?>
                                     <div class="form-group" >
                                        <label for="caseType" class="text">Case Sub Category<span class="required">*</span></label>
                                        <select class="form-control " name="subCat" id='' required style="height:70px" onchange="">
                                            <option value="">Select Case Sub</option>
                                            <?php echo $app->fetchSubCategories($_SESSION['concern']); ?>
                                        </select>
                                    
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($_SESSION['role']== "super_admin") :  ?>
                                    <div class="form-group">
                                        <label for="caseCenter"><?php echo "$concern Center"; ?><span class="required">*</span></label>
                                        <select class="form-control" name="center" required style="height:70px">
                                            <option value="">Select Case Center</option>
                                            <?php echo $app->fetchCenters($_SESSION['concern']); ?>

                                        </select>
                                    </div>
                                    <?php else : ?>
                                    <div class="form-group">
                                        <input type='hidden' value="<?php echo $_SESSION['center']; ?>" name='center' />
                                    </div>
                                    <?php endif; ?>
                                     <div class="form-group">
                                <label for="description" class="text">Case Brief<span class="required">*</span></label>
                                <textarea class="form-control" placeholder="Brief Case Description" name="description" style='height:50px' required></textarea>
                            </div>
                        </fieldset>
                        <noscript>
                                    <input class="nocsript-finish-btn sf-right nocsript-sf-btn" type="submit" value="Submit" name='sub'/>
                                </noscript>
                    </form>
                </div>
            </div>
          


            
        </div>
    </div>
</div>
</div>
<script>

function fetchSub(){
   // alert(a);
    var a = JSON.parse(document.getElementById('typee').value);
    alert(a)
    var b = "<?php echo $_SESSION['concern']; ?>"
    var select = document.getElementById('selectsub')
    var seldiv = document.getElementById('subcat')
    seldiv.style.display = 'none';
    seldiv.removeChild(seldiv.childNodes[0]);
    var obj = new XMLHttpRequest();
    obj.onreadystatechange = function(){
        if (obj.readyState == 4){
            seldiv.style.display = 'block';
            var newsel = document.createElement("SELECT");
            seldiv.appendChild(obj.responseText)
        }
    }
    obj.open("GET", "../..model/handle_caseCat.php?cat_id=" + a + "&concern=" + b, true);
    obj.send();
}


    $(document).ready(function(){
        var idtypeval = $("#idtype").val();
        $("#idtype").change(function(){
            $("#idlabel").html($("#idtype").val());
            if($("#idtype").val() == "BVN"){
                 $("#idno").attr("maxlength", 10);
            }
            else if($("#idtype").val() == "NIN"){
                 $("#idno").attr("maxlength", 11);
            }else{
                 $("#idno").attr("maxlength", 20);
            }
            
        });
    });
</script>
 <script>
	  
          function change(){
              if (document.getElementById('casecat').value == 'legal representation'){
                  //$('#opts').show(1000);
                  $('#opts').css({"visibility":"visible"});
                  
              }
              else{
                 // $('#opts').hide(1200)
                 $('#opts').css({"visibility" : "hidden"}, 2000);
              }
          }

          function occ(){
                if (document.getElementById("emp-status").value == 'yes'){
                $("#occ-div").show(1000);
            }else{
                $("#occ-div").hide(700);
            }

        }//);
       
          
 
 var text, text2, title;
    text2 ='';
        document.getElementById('partya').onkeyup = function(){
            text = document.getElementById('partya').value;
            document.getElementById('title').value = text + ' vs ' + text2;
            title = document.getElementById('title').value;
            
        }
        document.getElementById('partyb').onkeyup = function(){
            text2 = document.getElementById('partyb').value;
            var n = title.search(text2);
            if (n < 0){
            document.getElementById('title').value = title + " vs " + text2 ;
            }else{
               var str = title.split('vs'); 
                document.getElementById('title').value = str[0] + " vs " + text2;
            }
        }
        var sfw;
        $(document).ready(function () {
            var form = $("#wizard_example");
            form.validate();
            sfw = $("#wizard_example").stepFormWizard({
                theme: 'sky',
                height: 'auto',
                onNext: function() {
                    var valid = form.valid();
                    // if use height: 'auto' call refresh metod after validation, because validation can change content
                    sfw.refresh();
                    return valid;
                },
                onFinish: function() {
                    var valid = form.valid();
                    // if use height: 'auto' call refresh metod after validation, because validation can change content
                    sfw.refresh();
                    console.log(valid);
                    return valid;
                }
            });
        })
        $(window).load(function () {
            /* only if you want use mcustom scrollbar */
            $(".sf-step").mCustomScrollbar({
                theme: "dark-3",
                scrollButtons: {
                    enable: true
                }
            });
        });
        

       
        
    </script>
    

<?php
    include 'footer.php'
?>