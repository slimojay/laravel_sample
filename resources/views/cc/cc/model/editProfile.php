<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();
    include('../controller/CMC_controller.php');
    echo '<head> <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> </head>';

    $app = new CMC_Controller();
    
    $id = $_SESSION['id'];
    	
    function validate($txtInput){
	    $text = trim($txtInput);
		$text = stripslashes($txtInput);
		$text = htmlspecialchars($txtInput);
	  
		return $text;
	}
	
	if(isset($_GET['submitbtn'])){
            if(!ctype_space($_GET['username']) && !ctype_space($_GET['firstname']) && !ctype_space($_GET['lastname']) && !ctype_space($_GET['email']) && !ctype_space($_GET['phone'])){
                
                $username = validate($_GET['username']);
                $firstname = validate($_GET['firstname']);
                $lastname = validate($_GET['lastname']);
                $email = validate($_GET['email']);
                $phone = validate($_GET['phone']);
                $gender = validate($_GET['gender']);

                $app->editProfile($id, $username, $firstname, $lastname, $email, $phone, $gender);
                
            }else{ 
                echo "<script> swal('', 'Empty text', 'error') </script>";
            }
    }else{
        echo "<script> alert('something went wrong ...') </script>";
        echo "no session instantiated" ;
        exit;
    }
                
?>