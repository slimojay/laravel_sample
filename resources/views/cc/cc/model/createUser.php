<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();
    include('../controller/CMC_controller.php');
    
    $app = new CMC_Controller();
    
    function validate($txtInput){
	    $text = trim($txtInput);
		$text = stripslashes($txtInput);
		$text = htmlspecialchars($txtInput);
	  
		return $text;
	}
	
	if(isset($_GET['submitbtn'])){
        if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['firstname']) && isset($_GET['lastname']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['role']) && isset($_GET['center']) && isset($_GET['gender'])){
            if(!ctype_space($_GET['username']) && !ctype_space($_GET['password']) && !ctype_space($_GET['firstname']) && !ctype_space($_GET['lastname']) && !ctype_space($_GET['email']) && !ctype_space($_GET['phone'])){
                
                $username = validate($_GET['username']);
                $password = validate($_GET['password']);
                $firstname = validate($_GET['firstname']);
                $lastname = validate($_GET['lastname']);
                $email = validate($_GET['email']);
                $phone = validate($_GET['phone']);
                $gender = validate($_GET['gender']);
                $role = validate($_GET['role']);
                $center = validate($_GET['center']);

                $sql = "select username from cmc_users where username = '$username'";
            	$result = $app->conn->query($sql);
                if($result->num_rows > 0 ){
                    echo "<script> alert('Username already exists '); window.location.href='../views/portal/create_user.php'; </script>";
                    // header('refresh:1;../views/user_login.php');

                }else{
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);   
                        $sess = $_SESSION['concern'];
                        $query = "insert into cmc_users (username, password,  first_name, last_name, email, phone_number, gender, role, center, concern) 
                                    values ('$username', '$hashedPassword', '$firstname','$lastname','$email', '$phone', '$gender', '$role', '$center', $sess) ";

                        $result = $app->conn->query($query);
                        if($result){
                            echo "<script> alert('Account created'); window.location.href='../views/portal/create_user.php'; </script>";
                            // header('refresh:1;../views/user_login.php');
                        }else{
                            echo json_encode($app->conn->error);
                            // header('refresh:1;../views/user_login.php');
                            exit("<h1> something went wrong</h1>");
                        }
                       
                    }
            }else{ 
                echo "<script> alert('Empty text, error') </script>";
                // header('refresh:1;../views/user_login.php');
            }
        }else{
            echo "<script> alert('something went wrong  Please Try Again....') </script>";
            // header('refresh:1;../views/user_login.php');
        }
    }else{
        echo "<script> alert('something went wrong ...') </script>";
        echo "no session instantiated" ;
       // print_r( $_GET);
        exit;
        // header('refresh:1;../views/user_login.php');
    }
                
?>