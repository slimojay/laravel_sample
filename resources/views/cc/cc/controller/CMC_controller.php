<?php
//Created By Ojiodu Joachim 
//@LCIS
//ojiodujoachim@gmail.com
//commenced on : 16th Feb 2021
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Firebase\JWT\JWT;
//session_start();
include('BaseClass.php');
//include('../procedures/procedures.php');
class CMC_Controller extends BaseClass{
  public $conn; public $title; public $party_a, $party_b, $verdict, $descrition; 
  public $counselCenter, $counselActivity, $counselEmail, $counselName, $unAssignedAndConcluded, $assignedAndOngoing;
 
 /* public function connecti(){
      $user = 'root'; $pass=''; $db = 'lsmojcom_production';
      $this->coni = new mysqli("localhost", "root", " ", "lsmojcom_production");
  }*/
  public function __construct(){
      
       require 'PhpMailer/PHPMailer.php';
        require 'PhpMailer/Exception.php';
        require 'PhpMailer/SMTP.php';
      
      $conn = new mysqli("localhost", "root", "", "lsmojcom_production") or die("error");
      $this->conn = $conn;
      $this->con = $this->conn;
  }

  public function login($email, $password){
      try{

        $sql = $this->conn->prepare("SELECT * FROM cmc_users WHERE email = ? OR username = ? And concern = 2");
        $sql->bind_param("ss", $email, $email);
        $sql->execute();
        $res = $sql->get_result();
        if($res->num_rows == 0){
            $this->displayErrors("account does not exist");
            exit;
        }else{
            while($r = $res->fetch_assoc()){
            //$r = $res->fetch_assoc();
            if(password_verify($password, trim($r['password']))){
                $this->updateLastLogin($r['id']);
                        $this->handleLogin($r['id'], $r['email'], $r['username'], $r['role'], $r['last_login'], $r['concern'], $r['center']);
                   
            }else{
                $this->displayErrors("wrong login credentials " . $password);
                exit;
            }
        }
        }
      }catch(Exception $e){
          echo $e ;
      }
        
  }

  public function displayErrors($err){
      $error = "<center style='margin-top:10%;'><p class='text-danger'>$err</p></center>";
      echo $error;
  }

  public function handleLogin($id, $email, $on, $role, $ll, $con, $cen){
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['user'] = $on;
        $_SESSION['role'] = $role;
        $_SESSION['last_login'] = $ll;
        $_SESSION['concern'] = $con;
        $_SESSION['center'] = $cen;
        if ($role == 'pro'){
            echo "<script>window.location='../views/portal/create_case.php'</script>";
        }else{
        echo "<script>window.location='../views/portal/index.php'</script>";
        }
  }

  public function handleAdmin($id, $role, $email, $user, $ll, $con){
      $_SESSION['id'] = $id;
      $_SESSION['role'] = $role;
      $_SESSION['user'] = $user;
      $_SESSION['email'] = $email;
      $_SESSION['last_login'] = $ll;
      $_SESSION['concern'] = $con;
      echo "<script>window.location='../views/portal/index.php'</script>";
  }

  public function createCenter($name, $concern, $url){
        if(strlen($name) < 3){
            $this->displayErrors('center name looks invalid'); 
            exit;
        }
        if(strlen($name) <= 4){
            $abbr = $name;
        }else{
            $arr = str_split($name);
            $abbr = strtoupper($arr[0].$arr[1].$arr[3]);
            
        }
        $sql = "INSERT INTO centers (name, concern, abbr) VALUES (?, ?, ?)";
        $d = $this->conn->prepare($sql);
        $d->bind_param("sis", $name, $concern, $abbr);
        
        if($d->execute()){
            echo "<script>alert('operation successful'); window.location='$url'</script>";
        }else{
            $this->displayErrors("operation failed \n could not create $name center");
        }
  }
  
  
  public function updateLastLogin($id){
      $upd = $this->conn->query("UPDATE cmc_users SET last_login = CURRENT_TIMESTAMP WHERE id = '$id'");
      if(!$upd){
          die($this->conn->error);
      }
  
  }
  
   public function authenticate($x){
      if(!isset($x)){
          echo "<script>window.location='http://uche.lsmoj.com.ng/cc/views/login.php'</script>";
      }
   }
   
   public function checkIfExists($txt, $tbl, $col, $condition, $value, $concern){
       $str = '';
       $txt2 = $txt . $value;
       $sql = "SELECT * FROM $tbl WHERE $col $condition ? AND concern = ? ";
       //echo $sql;
       $sel =  $this->conn->prepare($sql);
       $sel->bind_param("ss", $txt2, $concern);
       $sel->execute();
       $res = $sel->get_result();
     
       if($res->num_rows > 0){
             if ($res->num_rows > 1){
           $match = "matches";
       }else{
           $match = "match";
       }
           $str .= $res->num_rows . " $match <br>";
           while($r = $res->fetch_assoc()){
              $str .= "<span class='text-primary'>" . ucwords($r['name']) . "</span> has been created <br>";
           }
           return $str;
       }else{
           return "Click the button below <i class='fa fa-arrow-circle-o-down text-primary'></i> to complete process <br>";
       }
   }
   
  public function preventIfExists($txt, $tbl, $col){
       $sql = "SELECT * FROM $tbl WHERE $col = '$txt' ";
       $sel = $this->con->prepare($sql);
       $sel->bind_param("s", $txt); 
       $sel->execute();
       $r = $sel->get_result();
       if ($r->num_rows > 0){
           $this->displayErrors("$txt, already exists");
           exit;
       }
  }
  public function fetchCenters($concern){
       $str = '';
       $sel = $this->conn->query("SELECT * FROM centers WHERE concern = '$concern' ");
       
       if($sel->num_rows > 0){
           while($r = $sel->fetch_assoc()){
               $str .= "<option value='" . $r['id'] . "'>". ucwords($r['name']) . "</option>";
           }
           return $str;
       }else{
           return "<option>no centers available</option>";
       }
  }

  public function fetchLGAs(){
    $str = '';
    $sel = $this->conn->query("SELECT * FROM local_govs");
    
    if($sel->num_rows > 0){
        while($r = $sel->fetch_assoc()){
            $str .= "<option value='" . $r['id'] . "'>". ucwords($r['name']) . "</option>";
        }
        return $str;
    }else{
        return "<option>no LGAs available</option>";
    }
}
   
  /* public function createUser(){
        $sql = "select username from cmc_users where username = '$username'";
            	$result = $this->con->query($sql);
                if($result->num_rows > 0 ){
                    echo "<script> alert('Username already exists '); window.location.href='../views/portal/create_user.php'; </script>";
                    // header('refresh:1;../views/user_login.php');

                }else{
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);   

                        $query = "insert into cmc_users (username, password,  first_name, last_name, email, phone_number, gender, role, center) 
                                    values ('$username', $hashedPassword, '$firstname','$lastname','$email', '$phone', '$gender', '$role', '$center') ";

                        $result = $this->con->query($query);
                        if($result){
                            echo "<script> alert('Account created'); window.location.href='../views/portal/create_user.php'; </script>";
                            // header('refresh:1;../views/user_login.php');
                        }else{
                            echo json_encode($this->con->error);
                            // header('refresh:1;../views/user_login.php');
                            exit("<h1> something went wrong</h1>");
                        }
                       
                    }
   } */
   
   /** admin and super admin stats section */
   public function getCenterCount($x){
       $count = $this->conn->query("SELECT id FROM centers WHERE concern = '$x' ");
       return $count->num_rows;
   }

   public function getUserCount($x){
    $count = $this->conn->query("SELECT id FROM cmc_users WHERE concern = '$x' ");
     return $count->num_rows;
}

 public function getCounselCount($x){
    $count = $this->conn->query("SELECT id FROM cmc_users WHERE concern = '$x' AND role = 'user' ");
     return $count->num_rows;
    }
    
     public function getCounselCountInCenter($x, $y){
    $count = $this->conn->query("SELECT id FROM cmc_users WHERE concern = '$x' AND role = 'user' AND center = '$y' ");
     return $count->num_rows;
    }
    
public function getUserCountInCenter($x, $y){
    $count = $this->conn->query("SELECT id FROM cmc_users WHERE concern = '$x' AND center = '$y' ");
    return $count->num_rows;
}

public function getCaseCount($x){
    $count = $this->conn->query("SELECT id FROM cases WHERE concern = '$x' "); 
     return $count->num_rows;
}

public function getCaseCountInCenter($x, $y){
    $count = $this->conn->query("SELECT id FROM cases WHERE concern = '$x' AND center = '$y' "); 
     return $count->num_rows;
}

public function getUnAssignedCaseCount($x){
    $count = $this->conn->query("SELECT id FROM cases WHERE status = 'unassigned' AND concern = '$x' ");
     return $count->num_rows;
}

public function getAssignedCaseCount($x){
    $count = $this->conn->query("SELECT id FROM cases WHERE status = 'assigned' AND concern = '$x' ");
     return $count->num_rows;
}

public function getAssignedCaseCountInCenter($x, $y){
    $count = $this->conn->query("SELECT id FROM cases WHERE status = 'assigned' AND concern = '$x' AND center = '$y' ");
     return $count->num_rows;
}

public function getUnAssignedCaseCountInCenter($x, $y){
    $count = $this->conn->query("SELECT id FROM cases WHERE status = 'unassigned' AND concern = '$x' AND center = '$y' ");
     return $count->num_rows;
}
    public function myCenter($id){
        //$id is the center session value;
      $getCenter = $this->conn->query("SELECT * FROM centers WHERE id = '$id' ");
      $r = $getCenter->fetch_assoc();
          return ucwords($r['name']);
  
    }


/**end of user admin stats section */
/**user/counsel stats section */
public function getCounselCaseCount($x){
    $count = $this->conn->query("SELECT id FROM cases WHERE counsel_in_charge = '$x' ");
     return $count->num_rows;
}

public function getUpcomingCases($x){
    $sql = "SELECT cases.id, case_verdict.* FROM cases INNER JOIN case_verdict ON cases.id = case_verdict.case_id WHERE cases.counsel_in_charge = '$x' AND case_verdict.verdict IS NULL";
    $count = $this->conn->query($sql);
     return $count->num_rows;
}


public function getPreviousCases($x){
    $sql = "SELECT cases.id, case_verdict.* FROM cases INNER JOIN case_verdict ON cases.id = case_verdict.case_id WHERE cases.counsel_in_charge = '$x' AND case_verdict.verdict IS NOT NULL";
    $count = $this->conn->query($sql);
    return $count->num_rows;
}

public function getCounselDetails($id, $tbl, $url, $concern){
    $sql = "SELECT * FROM $tbl WHERE role='user' AND id = '$id' AND concern = '$concern'";
    $sel = $this->con->query($sql);
    if ($sel->num_rows == 0){
        echo "<script>window.location='$url'</script>";
    }else{
   while( $r = $sel->fetch_assoc()){
    $this->counselNAme = $r['first_name'] . ' ' . $r['last_name'];
    $this->counselCenter = $this->getCenter($r['center']);
    $this->counselActivity = $r['last_login'];
    $this->creationDate = $r['registered_on'];
    $this->counselEmail = $r['email'];
   // echo $this->CounselNAme;
   }
}
}

/**end of user/counsel stats section */

/** Dynamic Dashboard for users, admins and super admin*/
public function loadDynamicDashboard(){
    
}


public function superAdminDashboard($concern, $center, $counsel){
    $str = '';
    $str .= '

  <!-- Main content -->
    <div class="content"> 
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="cases.php">
          <div class="info-box bg-darkblue"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Assigned Cases</h6>
              <h1 class="text-white">' . $this->getAssignedCaseCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total count of assigned cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="cases.php">
          <div class="info-box bg-primary text-white"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-info"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Unassigned Cases</h6>
              <h1 class="text-white">' . $this->getUnAssignedCaseCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total count of unassigned cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="cases.php">
          <div class="info-box bg-aqua"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-default"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Cases/Matters</h6>
              <h1 class="text-white">' . $this->getCaseCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total count of cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        
        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="closed.php">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-gavel"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Concluded Matters</h6>
              <h1 class="text-white">' . $this->getConcludedCaseCount($center, $concern, $counsel) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> concluded cases/matters </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 

        </div>
        

        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="ongoing.php">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-gavel"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Ongoing Matters</h6>
              <h1 class="text-white">' . $this->getOngoingCaseCount($center, $concern, $counsel). '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> ongoing cases/matters </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-info"> <span class="info-box-icon bg-transparent"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Counsels</h6>
              <h1 class="text-white">'. $this->getCounselCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase;visibility:hidden"> Total Counsels Created </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="users.php">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-users text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Users</h6>
              <h1 class="text-white">' . $this->getUserCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> Total Users Created </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>


        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-orange"> <span class="info-box-icon bg-transparent"><i class="fa fa-home"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Units</h6>
              <h1 class="text-white">' . $this->getCenterCount($concern) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> All Locations Covered </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <!--end of report cards -->
      
      <div class="row">
        <div class="col-lg-6 col-xlg-9">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Entry Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="line-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xlg-3">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Status Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="pie-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        
        </div>
      ';
      return $str;
    
}


public function adminDashboard($concern, $center){
    $str = '';
    $str .= '

  <!-- Main content -->
    <div class="content"> 
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-darkblue"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Assigned Cases</h6>
              <h1 class="text-white">' . $this->getAssignedCaseCountInCenter($concern, $center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase;; visibility:hidden"> total count of assigned cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="cases.php">
          <div class="info-box bg-primary text-white"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-info"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Unassigned Cases</h6>
              <h1 class="text-white">' . $this->getUnAssignedCaseCountIncenter($concern, $center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total count of unassigned cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-default"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Cases</h6>
              <h1 class="text-white">' . $this->getCaseCountInCenter($concern, $center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total count of cases & petitions </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-gavel"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Concluded</h6>
              <h1 class="text-white">0</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> concluded cases/matters </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 

        </div>
        

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-gavel"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Ongoing</h6>
              <h1 class="text-white">0</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> ongoing cases/matters </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-info"> <span class="info-box-icon bg-transparent"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Counsels</h6>
              <h1 class="text-white">'. $this->getCounselCountInCenter($concern, $center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> Total Counsels Created </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
        <a href="users.php">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-users text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Users</h6>
              <h1 class="text-white">' . $this->getUserCountInCenter($concern, $center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> Total Users Created </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>


        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-orange"> <span class="info-box-icon bg-transparent"><i class="fa fa-home"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">My Unit</h6>
              <h1 class="text-white">' . $this->myCenter($center) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> OFFICE </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <!--end of report cards -->
      
  
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <!--end of report cards -->
      
      <div class="row">
        <div class="col-lg-6 col-xlg-9">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Entry Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="line-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xlg-3">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Status Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="pie-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        
        </div>
      ';
      return $str;
    
}



public function counselDashboard($concern, $center, $id){
    $str = '';
    $str .= '

  <!-- Main content -->
    <div class="content"> 
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-darkblue"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Concluded Cases</h6>
              <h1 class="text-white">' . $this->getPreviousCases($id) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total cases i have attended to </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary text-white"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-info"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Upcoming Cases</h6>
              <h1 class="text-white">' . $this->getUpcomingCases($id) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> total upcoming cases assigned to me </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua"> <span class="info-box-icon bg-transparent"><i class="fa fa-briefcase text-default"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Total Cases</h6>
              <h1 class="text-white">' . $this->getCounselCaseCount($id) . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> Cases assigned to me </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>
        <!-- /.col -->
        
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-home"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">My Unit</h6>
              <h1 class="text-white">' . $this->counselCenter . '</h1>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden">' . $this->getCenter($center) . ' Center</span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 

        </div>
        

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">welcome</h6>
              <h3 class="text-white">' . $this->counselNAme . '</h3>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden">' . $this->counselCenter . ' Counsel </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-info"> <span class="info-box-icon bg-transparent"><i class="fa fa-envelope-o"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">My Email</h6>
              <h4 class="text-white">'. $this->counselEmail . '</h4>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden">  official email </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box bg-primary"> <span class="info-box-icon bg-transparent"><i class="fa fa-users text-white"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Last Login</h6>
              <h3 class="text-white">' . $this->counselActivity . '</h3>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden">  </span> </div>
            <!-- /.info-box-content --> 
          </div>
          <!-- /.info-box --> 
        </div>


        <div class="col-lg-3 col-sm-6 col-xs-12">
          <a href="edit_profile.php"><div class="info-box bg-orange"> <span class="info-box-icon bg-transparent"><i class="fa fa-edit"></i></span>
            <div class="info-box-content">
              <h6 class="info-box-text text-white">Update</h6>
              <h3 class="text-white">Edit Profile</h3>
              <span class="progress-description text-white" style="text-transform:uppercase; visibility:hidden"> email, password, ... </span> </div>
            <!-- /.info-box-content --> 
          </div>
          </a>
          <!-- /.info-box --> 
        </div>
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <!--end of report cards -->
      
        <!-- /.col --> 
      </div>
      <!-- /.row --> 
      <!--end of report cards -->
      
      <div class="row">
        <div class="col-lg-6 col-xlg-9">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Assignment Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="line-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xlg-3">
          <div class="info-box" style="background:white !important">
            <div class="d-flex flex-wrap">
              <div>
                <h4 class="text-black">Case Distribution Chart</h4>
              </div>
            </div>
            <div class="m-t-2">
            	<canvas id="pie-chart" height="210"></canvas>
            </div>
          </div>
        </div>
        
        </div>
      ';
      return $str;
    
}


public function fetchCaseTypes($concern){
    $str = '';
    $sql = "SELECT id, name FROM case_type WHERE concern ='$concern' ";
    $go = $this->conn->query($sql);
    while ($r = $go->fetch_assoc()){
        $str .= "<option value='" . $r['id'] ."'>" . ucwords($r['name']) . "</option>";
    }
    return $str;
}


public function getCaseType($id){
    $str = '';
    $sql = "SELECT * FROM case_type WHERE id = '$id' ORDER BY id ASC LIMIT 1";
    $go = $this->conn->query($sql);
    $r = $go->fetch_assoc();
    return $r['name'];
     
}

public function fetchCaseVerdict($id){
    $str = '';
    $sql = "SELECT * FROM case_verdict WHERE case_id = '$id' ORDER BY id DESC LIMIT 1";
  $go = $this->conn->query($sql);
  if ($go->num_rows == 0){
      return "Not Available";
  }else{
  $r = $go->fetch_assoc();
  if (!empty($r['verdict'])){
  return $r['verdict'];
  }else{
      return "No Verdict Given";
  }
}
     
}


public function getCounsel($x){
    $sql = "SELECT * FROM cmc_users WHERE id = '$x' AND role = 'user'";
    $sel = $this->conn->query($sql);
    $get = $sel->fetch_assoc();
    return $get['first_name'] . ' ' . $get['last_name'];
}

public function fetchCases($concern, $center, $role, $counsel){
    $str = '';
    $sql = "SELECT  c.*, c.id AS cid, cv.* FROM cases AS c LEFT JOIN case_verdict AS cv ON c.id = cv.case_id WHERE c.concern = '$concern'";
    //$concern tracks either opd or cmc 
    //$center tracks the admin center 
    //$role is a session var to determine the level of the account
    if ($role == 'admin'){
        $sql .= " AND c.center = '$center' ";
    }
    if ($counsel != null){
        $sql .= " AND counsel_in_charge = '$counsel' ";
    }
    $sql .= " ORDER BY cid DESC";
    $go = $this->conn->query($sql) or die($this->conn->error);
    if ($go->num_rows == 0){
        
        //$str .= "<span class='error text-info'> No Data To Display </span> <hr>";
    }else{
       
        $count = 1;
        while ($r = $go->fetch_assoc()){
            
             if (!empty($r['counsel_in_charge'])){
        $counsel = $this->getCounsel($r['counsel_in_charge']);
        }else{
            $counsel = 'None';
        }
            if(empty($r['verdict'])){
                
                $ver = "<b class='text-dark'>no outcome</b>";
            }else{
                $ver = "<b class='text-success'>" . $this->getOutcome($r['verdict'], $concern) . "</b>";
            }
            if ($r['status'] == 'assaigned'){
                $status = "<span class='text-success' style='padding:10px;'>" . $r['status'] . "</span>";
            }else{
                 $status = "<span class='text-danger' style='padding:10px;'>" . $r['status'] . "</span>";
            }
            $id = $r['cid']; 
            
            if($role != 'user'){
              $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }
            
            $str .= "<tr><td><b>" . $r['title'] . "</b></td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $status . "</td><td class='text-warning' >" . $this->getCaseType($r['case_type'])
            . "</td><td>" . $counsel . "</td><td style='color:dodgerblue'>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $ver . "</td><td>$s </td></tr>";
            $count++;
        }
    }
    return $str;
    
}

public function createCase($title, $party_a, $party_b, $rn, $rnum, $re, $ra, $mid, $id_num, $ct, $cd, $pac, $pae, $padd, $pbc, $pbe, $pbadd, $concern, $center, $path, $ref, $caseCat, $ref_name){
    $keys = array('title', 'party_a', 'party_b', 'petitioner_name', 'petitioner_number', 'petitioner_email', 'petitioner_address', 'means_of_id', 'id_number', 'case_type', 'case_description', 'counsel_in_charge','unique_case_id', 'party_a_contact','party_a_email', 'party_a_address', 'party_b_contact', 'party_b_email', 'party_b_address', 'status', 'concern', 'center', 'case_category', 'ref', 'ref_name', 'file'); 
    $title = $this->conn->real_escape_string(strip_tags(trim($title)));
    $party_a = $this->conn->real_escape_string(strip_tags(trim($party_a)));
    $party_b = $this->conn->real_escape_string(strip_tags(trim($party_b)));
    $rn = $this->conn->real_escape_string(strip_tags(trim($rn)));
    $rnum = $this->conn->real_escape_string(strip_tags(trim($rnum)));
    $re = $this->conn->real_escape_string(strip_tags(trim($re)));
    $ra = $this->conn->real_escape_string(strip_tags(trim($ra)));
    $mid = $this->conn->real_escape_string(strip_tags(trim($mid))); 
    $id_num = $this->conn->real_escape_string(strip_tags(trim($id_num)));
    $ct = $this->conn->real_escape_string(strip_tags(trim($ct)));
    $cd = $this->conn->real_escape_string(strip_tags(trim($cd)));
    $pac = $this->conn->real_escape_string(strip_tags(trim($pac)));
    $pbc = $this->conn->real_escape_string(strip_tags(trim($pbc)));
    $rn = $this->conn->real_escape_string(strip_tags(trim($rn)));//*/
    //find the last id inserted;
    $sel = $this->conn->query("SELECT id FROM cases ORDER BY id DESC LIMIT 1");
    $s = $sel->fetch_assoc();
    $rd = rand(00, 9999);
    $status = 'unassigned';
    $cic = 0;
    $abbr = $this->getCenter($center);
    $unique = "LSMOJ/" . $this->getConcern($concern) . "/"  . $this->abbr  .  "/". date('Y')."/" . $rd . "/" . ($s['id'] + 1); 
    $vals = array($title, $party_a, $party_b, $rn, $rnum, $re, $ra, $mid, $id_num, $ct, $cd, $cic, $unique, $pac, $pae, $padd, $pbc, $pbe, $pbadd, $status, $concern, $center, $caseCat, $ref, $ref_name, $path);
    //$this->con->query("INSERT INTO cases (title, party_a, party_b, petitioner_name, petitioner_number, petitioner_email, petitioner_address, means_of_id, id_number, case_type, case_description, counsel_in_charge, unique_case_id, party_a_contact, party_b_contact, status, concern, center, file) VALUES ('$title', '$party_a', '$party_b', '$rn', '$rnum', '$re', '$ra', '$mid', '$id_num', '$ct', '$cd', '$cic', '$unique', '$pac', '$pbc', '$status', '$concern', '$center', '$path')");
    $this->insert('cases', $keys, $vals);
    $id = $this->output['Query_Id'];
    $arr = array();
    $keys2 = array('name', 'number', 'email', 'address', 'means_of_id', 'id_num', 'center', 'file', 'concern');
    $vals2 = array($rn, $rnum, $re, $ra, $mid, $id_num, $center, $path, $concern);
    $this->insert('clients', $keys2, $vals2);
    if ($this->output['outcome'] == 'data inserted'){
        
        $arr['outcome'] = 'case has been created for ' . $title;
        $arr['url'] = "../portal/create_case.php";
       echo json_encode($arr);
        //echo "<script>alert('Case Has Been Created'); window.location='../views/portal/casedetail.php?id=$id'</script>";
    }else{
        //$this->displayErrors('Operation Failed, <br> Pls Try Again Or Contact Support');
        //exit;
         $arr['outcome'] = "failed to create case";
        $arr['url'] = '../views/portal/create_case.php';
        echo json_encode($arr);
    }
}


public function intelligence($title, $partya, $partyb, $pet_name, $pet_con, $id_type, $id_num){
  $str ='';
  $sql = "SELECT * FROM cases WHERE title = '$title' OR (party_a = '$partya' AND party_b = '$partyb') OR (party_b = '$partya' AND party_a = '$partyb') OR petitioner_name = '$pet_name' OR petitioner_number = '$pet_con' OR (means_of_id = '$id_type' AND id_number = '$id_num') ";
  $count = 1;
  $run = $this->conn->query($sql);
  if ($run->num_rows > 0){
      $str .= "<h3 class='text-center' style='font-size:15px; margin-top:15px'>

       Possible Matches Or Duplicate Entries Found ($run->num_rows) </h3><table class='container table table-hover table-stripped table-bordered ' id='display'style='margin-top:-5px'><thead> 
       
       <center><span style='font-size:17px; text-transform:capitalize; color:blue'>Kindly Review the below list before you proceed </span></center><br>      
       <tr>
                      <th>#</th>
                      <th class='bg bg-dark text-center text-white'>Case Title</th>
                      <th class='bg bg-dark text-center text-white'>Complainant</th>
                      <th class='bg bg-dark text-center text-white'>Respondent</th>
                      <th class='bg bg-dark text-center text-white'>Case Type</th>
                      <th class='bg bg-dark text-center text-white'>Center</th>
                      <th class='bg bg-dark text-white'>Petitioner Contact</th>
                      <th class='bg bg-dark text-warning'>Action</th>
                  </tr>
              </thead>
              <tbody >";
      while($row = $run->fetch_assoc()){
          $id = $row['id']; 
            $str .=  "<tr><td>" . $count ."</td><td class='text-secondary text-center' style='font-size:16px'>" . $row['title'] ."</td>
      <td class='text-success text-center'>".$row['party_a']."</td>
      <td class='text-primary text-center'>".$row['party_b']."</td>
      <td class='text-secondary text-center' style='text-transform:capitalize'>". $this->getCaseType($row['case_type']) ."</td>
      <th class='bg text-center' style='text-transform:capitalize; background-color:lightgrey'>" . $this->getCenter($row['center']) . "</th>
      
      <td>".$row['petitioner_number']."</td>
      <td><a href='casedetail.php?id=$id' target='_blank'>View or Edit</a></td>
                     </tr>"; 
                     $count++;
      }
      $str .= "</tbody></table><h3 class='text-center' style='font-size:15px; margin-bottom:15px'>Possible Matches Or Duplicate Entries Found ($run->num_rows) </h3> <br>
      <center style='text-transform:lowercase'>Not a Duplicate Entry ?  <button class='btn btn-info' style='background-color:dodgerblue; color:black; padding:6px; width:100px; 
      border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer;' id='cc'>Submit</button>  or
      If it's a duplicate Entry  <a href='../portal/index.php' id='cancel' style='color:black; padding:6px;border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer; background-color:lightgrey'>Cancel</a> 
      or click  <button id='cancel' style='color:black; padding:6px;border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer; background-color:lightgrey' onclick='history.back()'>Here</button> To add a new case</center> ";
      return $str;
  }else{
      $this->displayErrors("No Match Found for $partya vs $partyb <button class='btn btn-info' id='cc' style='background-color:dodgerblue; color:white; padding:6px; width:100px; 
      border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer;' id='cc'>Submit</button> OR <button id='cancel' style='color:white; padding:6px; border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer; background-color:maroon' onclick='history.back()'>Add New Case</button>");
      
  }
}

/*
public function intelligence($title, $partya, $partyb, $pet_name, $pet_con, $id_type, $id_num){
    $str ='';
    $sql = "SELECT * FROM cases WHERE title = '$title' OR (party_a = '$partya' AND party_b = '$partyb') OR (party_b = '$partya' AND party_a = '$partyb') OR petitioner_name = '$pet_name' OR petitioner_number = '$pet_con' OR (means_of_id = '$id_type' AND id_number = '$id_num') ";
    $count = 1;
    $run = $this->conn->query($sql);
    if ($run->num_rows > 0){
        $str .= "<h3 class='text-center'>Possible Matches - $run->num_rows </h3> <hr><table class='container table table-hover table-stripped table-bordered ' id='display'style='margin-top:-5px'><thead> 
                    <tr>
                        <th>#</th>
                        <th class='bg bg-dark text-center text-white'>Case Title</th>
                        <th class='bg bg-dark text-center text-white'>Complainant</th>
                        <th class='bg bg-dark text-center text-white'>Respondent</th>
                        <th class='bg bg-dark text-center text-white'>Case Type</th>
                        <th class='bg bg-dark text-center text-white'>Center</th>
                        <th class='bg bg-dark text-white'>Petitioner Email</th>
                        <th class='bg bg-dark text-warning'>View</th>
                    </tr>
                </thead>
                <tbody >";
        while($row = $run->fetch_assoc()){
            $id = $row['id']; 
              $str .=  "<tr><td>" . $count ."</td><td class='text-secondary text-center' style='font-size:16px'>" . $row['title'] ."</td>
        <td class='text-success text-center'>".$row['party_a']."</td>
        <td class='text-primary text-center'>".$row['party_b']."</td>
        <td class='text-info text-center' style='text-transform:capitalize'>". $this->getCaseType($row['case_type']) ."</td>
        <th class='bg bg-info text-center' style='text-transform:capitalize'>" . $this->getCenter($row['center']) . "</th>
        
        <td>".$row['petitioner_email']."</td>
        <td><a href='../views/portal/casedetail.php?id=$id' target='_blank'>View</a></td>
                       </tr>"; 
                       $count++;
        }
        $str .= "</tbody></table> <br><hr><center><button class='btn btn-info' style='background-color:dodgerblue; color:white; padding:6px; width:100px; 
        border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer;' id='cc'>Proceed</button> OR <button id='cancel' style='color:white; padding:6px; width:100px;border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer; background-color:maroon' onclick='history.back'>Go Back</button></center><br><br>";
        return $str;
    }else{
        $this->displayErrors("No Match Found for $partya vs $partyb <button class='btn btn-info' id='cc' style='background-color:dodgerblue; color:white; padding:6px; width:100px; 
        border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer;' id='cc'>PROCEED</button> OR <button id='cancel' style='color:white; padding:6px; width:100px;border:1px solid black; border-radius:8px; text-align:center; font-family:times new roman; cursor:pointer; background-color:maroon' onclick='history.back'>Go Back</button>");
        
    }
}*/


public function fetchUsers($concern, $center){
    $sql = ''; $count = 1; $str ='';
    $sql = "SELECT * FROM cmc_users WHERE concern = '$concern'";
    if($center != null){
        $sql .= " AND center = '$center'";
    }
    $sel = $this->con->query($sql);
    while($r = $sel->fetch_assoc()){
        /*     
           <th>first Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Last Login</th>
                <th>Gender</th>
                <th>category</th>
                <th>center</th>
                
        */
         $str .= "<tr><td>$count</td><td>" . $r['first_name'] . "</td><td>" . $r['last_name'] . "</td><td>" . $r['username'] . "</td><td>" . $r['email'] . "</td><td>" . $r['gender'] . "</td><td>" . $r['last_login']
            . "</td><td>" . $r['role'] . "</td><td>" . $this->getCenter($r['center']) . "</td></tr>";
            $count++;
    }
    return $str;
}

/*
public function fetchCens($concern){
    $sql = ''; $count = 1; $str ='';
    $sql = "SELECT * FROM centers WHERE concern = '$concern'";
    if($center != null){
        $sql .= " AND center = '$center'";
    }
    $sel = $this->con->query($sql);
    while($r = $sel->fetch_assoc()){
        /*     
           <th>first Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Last Login</th>
                <th>Gender</th>
                <th>category</th>
                <th>center</th>
                
        *
         $str .= "<tr><td>$count</td><td>" . $r['first_name'] . "</td><td>" . $r['last_name'] . "</td><td>" . $r['username'] . "</td><td>" . $r['email'] . "</td><td>" . $r['gender'] . "</td><td>" . $r['last_login']
            . "</td><td>" . $r['role'] . "</td><td>" . $this->getCenter($r['center']) . "</td></tr>";
            $count++;
    }
    return $str;
}*/

public function getCenter($id){
    $str = '';
    $sql = "SELECT * FROM centers WHERE id = '$id' ORDER BY id ASC LIMIT 1";
    $go = $this->conn->query($sql);
    $r = $go->fetch_assoc();
    $this->abbr = $r['abbr'];
    return strtoupper($r['name']); 
}

public function getConcern($id){
    $str = '';
    $sql = "SELECT * FROM concern WHERE id = '$id' ORDER BY id ASC LIMIT 1";
    $go = $this->conn->query($sql);
    $r = $go->fetch_assoc();
    return strtoupper($r['name']); 
}


 public function fetchRefs(){
       $str = '';
       $sel = $this->conn->query("SELECT * FROM referrals ");
       if($sel->num_rows > 0){
           while($r = $sel->fetch_assoc()){
               $str .= "<option style='text-transform:uppercase' value='" . $r['name'] . "'>". ucwords($r['name']) . "</option>";
           }
           return $str;
       }else{
           return "<option>no centers available</option>";
       }
   }
   
 
 
 public function fetchCaseDetails($id, $id_case, $concern, $counsel_id, $role, $center){
     //first check if the case belongs to the specified concern
     $id = intval($id);
     $q = "SELECT * FROM cases WHERE id = '$id' AND concern = '$concern'";
     if ($role != 'super_admin'){
         if ($role == 'admin'){
             $q .= " AND center = $center";
         }else if ($role == 'user'){
            $q .= " AND counsel_in_charge = $counsel_id";
             
         }
     }
     $go = $this->con->query($q);
     if ($go->num_rows == 0){
         echo "<script>alert('no case found '); window.location='index.php'</script>";
     }
     while($r = $go->fetch_assoc()){
         if ($r['concern'] != $concern){
            echo "<script>alert('permission denied'); window.location='index.php'</script>";
         }
         $this->title = $r['title'];
         $this->party_a = $r['party_a'];
         $this->party_b = $r['party_b'];
         $this->email = $r['petitioner_email'];
         $this->pet_name = $r['petitioner_name'];
         $this->pet_add = $r['petitioner_address'];
         $this->pet_con = $r['petitioner_number'];
         $this->pet_email = $r['petitioner_email'];
         $this->pac = $r['party_a_contact'];
         $this->pae = $r['party_a_email'];
         $this->paa = $r['party_a_address'];
         $this->pbc = $r['party_b_contact'];
         $this->pbe = $r['party_b_email'];
         $this->pba = $r['party_b_address'];
         $this->desc = $r['case_description'];
         $this->counsel_in_charge = intval($r['counsel_in_charge']);
         $this->center = $r['center'];
         $this->id_num = $r['id_number'];
         $this->date_registered = $r['date_registered'];
         $this->mod = $r['means_of_id'];
         $this->file = $r['file'];
         $this->ref = $r['ref'];
         $this->ref_name = $r['ref_name'];
         $this->unique = $r['unique_case_id'];
         $this->case_type = $r['case_type'];
         $this->cat = $r['case_category'];
         $this->status = $r['status'];
         $this->Concern = $r['concern'];
     }
 }
 
 
 public function fetchCounsels($concern, $tbl, $center){
     $str = '';
 $sql = "SELECT * FROM $tbl WHERE role = 'user' AND concern = '$concern'";
 if ($center != null){
     $sql .=" AND center = '$center'";
 }//*/
 $sel = $this->conn->query($sql);
 if($sel->num_rows == 0){
    $str .= "<option>no counsel created</option>";
 }else{
     while ($r = $sel->fetch_assoc()){
     $str .= "<option value='" . $r['id'] . "'>". $r['first_name'] . " " . $r['last_name'] . "</option>";
 }
 }
    return $str . $sel->num_rows;
}

 public function fetchCounselSS($concern, $tbl, $center, $counsel_id){
     $str = '';
 $sql = "SELECT * FROM $tbl WHERE role = 'user' AND concern = '$concern'";
 if ($center != null){
     $sql .=" AND center = '$center'";
 }//*/
 $sel = $this->conn->query($sql);
 if($sel->num_rows == 0){
    $str .= "<option>..</option>";
 }else{
     while ($r = $sel->fetch_assoc()){
        if ($r['id'] == $counsel_id){
            $str .= "<option value='" . $r['id'] . "' selected>". $r['first_name'] . " " . $r['last_name'] . "</option>"; 
         }else{
             $str .= "<option value='" . $r['id'] . "'>". $r['first_name'] . " " . $r['last_name'] . "</option>";
         }
 }
 }
    return $str;
}

public function getMailAdd($id){
    $sql = "SELECT * FROM cmc_users WHERE id = '$id' ";
    $go = $this->con->query($sql);
    $r = $go->fetch_assoc();
    return $r['email'];
}

private function sendMail($title, $center, $date_for_hearing, $concern, $counsel_id, $category){
    $counsel_name = $this->getCounsel($counsel_id);
    $counsel_email = $this->getMailAdd($counsel_id);
//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

//From email address and name
$mail->SetFrom("info@lsmoj.com.ng" , $this->Concern );
$mail->AddReplyTo( "no-reply@lsmoj.com.ng" , $this->Concern);

//To address and name

$mail->addAddress($counsel_email, $counsel_name);
$mail->addAddress("ojiodujoachim@gmail.com", "Dev Jay");
$mail->addAddress("Sleath1000@gmail.com", "Hassan Toheeb");
//Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("info@lsmoj.com.ng", "no-reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = $this->getConcern($concern) . " Hearing Notice";
$mail->Body = $this->generateCounselMail($title, $center, $date_for_hearing, $concern, $counsel_id, $category);
//$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo; exit;
}
}

public function assignToCounsel($counsel_id, $case_id, $date, $url, $role, $center, $concern){
    $this->fetchCaseDetails($case_id, $case_id, $concern, $counsel_id, $role, $center);
    $Concern = $this->getConcern($concern);
    $Center = $this->getCenter($center);
    $keys = array('case_id', 'hearing_date');
    $vals = array($case_id, $date);
    $this->insert('case_verdict', $keys, $vals);
    if($this->output['outcome'] != 'data inserted'){
        echo "data inserted";
        exit;
    }
    
    $update = $this->con->query("UPDATE cases SET counsel_in_charge = '$counsel_id', status = 'assigned' WHERE id = '$case_id'") or die('error');
    if($update){
        //send mail to counsel
        echo $this->sendMail($this->title, $this->center, $date, $this->Concern, $counsel_id, $this->cat);
        echo "<script>alert('Case successfully Assigned'); </script>";
    }else{
        echo "<script>alert('Operation Failed'); window.location='$url' </script>"; 
    }
    //case_id	verdict	brief	hearing_date	updated_on
    
}
public function greetUser($user, $center){
    if ($_SESSION['concern'] == 1){
        $concern = "OPD";
    }else{
        $concern = "CMC";
    }
    // return "<center>$concern DASHBOARD</center>";
    if ($_SERVER['PHP_SELF'] == '/cc/cc/views/portal/dashboard.php' || $_SERVER['PHP_SELF'] == '/cc/cc/views/portal/dashboard.php'){
    $greet = "<center><div style='font-family:san-serif; font-weight:bolder !important;'><h2 style='color:#339966'>CITIZEN'S MEDIATION CENTER</h2> <h4 style='color:black'>CASE MANAGEMENT PLATFORM</h4>
    <h5 style='color:black;'>ACTIVITY DASHBOARD</h5></div></center>";
    }else{
      $greet = "<center><div style='font-family:san-serif; font-weight:bolder !important;'><h2 style='color:#339966'>CITIZEN'S MEDIATION CENTER</h2><h4 style='color:black'><strong>CASE MANAGEMENT PLATFORM</strong></h4></center>"; 
    }
    return $greet;
}


public function verdictName($verdict_no){
    $sql = $this->con->query("SELECT * FROM case_outcome WHERE id = '$verdict_no'");
    $res = $sql->fetch_assoc();
    return $res['name'];
}

//public function 
 
public function getVerdict($case_id){
    $sel = $this->conn->query("SELECT cv.*, co.* FROM case_verdict AS cv LEFT JOIN case_outcome AS co ON cv.verdict = co.id WHERE cv.case_id = '$case_id'");
    if($sel->num_rows > 0){
        $rec = $sel->fetch_assoc();
        return $rec['name'];
    }else{
        return "Not Available";
    }
}

private function generateCounselMail($title, $center, $date_for_hearing, $concern, $counsel_id, $category){
    $dfh = explode("T", $date_for_hearing);
    $date = $dfh[0];
    $time = $dfh[1];
    $str = "<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, minimum-scale=1, maximum-scale=1' />
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

<!-- v4.0.0-alpha.6 --><!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>

<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

<!-- Latest compiled JavaScript -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>

<!-- Google Font -->
<link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>

<!-- Theme style -->
<link rel='stylesheet' href='dist/css/style.css'>
<link rel='stylesheet' href='dist/css/font-awesome/css/font-awesome.min.css'>
    <style>
	#main{
		border:0.15px solid lightgrey;
		padding:10px;
		max-width:500px;
		margin:auto;
		border-radius:15px;
		margin-top:10px
	}
	#container{
	
	padding:20px;
	margin: 0 auto;
	text-transform:capitalize;
	font-family:san-serif;
	border:0.25px solid lightgrey;
	border-radius:10px;
	}
	@media screen and (max-width:500px)
	</style>
    <title>$title</title>
</head>
<body>
	<div id='main' style='text-transform:Capitalize; color:black'>
    <center class='text-info' style='color:black; font-size:17px;'><b>" . $this->getConcern($concern) . " Hearing Notice</b></center>
	<div id='container'>
		<p>The case  <span style='color:dodgerblue'> $title </span> has been assigned to you, the details are listed below </p>
		<p>case title : <span style='color:dodgerblue'>$title</span> <br> Case Type : $category <br> date : $date <br>
		time : $time hrs <br> Location : " . $this->getConcern($concern) . "  " . $this->getCenter($center) . " Center <br> counsel in charge : " . $this->getCounsel($counsel_id) . "  </p>
		<hr>
		<p style='color:dodgerblue;'>For Further Enquiries or Complaints, Kindly Reach Us On info@opd.com, 08127110728 </p>
	
	<hr>
	</div></div>
</body>
</html>";
return $str;
    
}


private function generatePartiesMail($title, $center, $date_for_hearing, $concern, $counsel_id, $category){
    $dfh = explode("T", $date_for_hearing);
    $date = $dfh[0];
    $time = $dfh[1];
    $str = "<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, minimum-scale=1, maximum-scale=1' />
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

<!-- v4.0.0-alpha.6 --><!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>

<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

<!-- Latest compiled JavaScript -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>

<!-- Google Font -->
<link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>

<!-- Theme style -->
<link rel='stylesheet' href='dist/css/style.css'>
<link rel='stylesheet' href='dist/css/font-awesome/css/font-awesome.min.css'>
    <style>
	#main{
		border:0.15px solid lightgrey;
		padding:10px;
		max-width:500px;
		margin:auto;
		border-radius:15px;
		margin-top:10px
	}
	#container{
	
	padding:20px;
	margin: 0 auto;
	text-transform:capitalize;
	font-family:san-serif;
	border:0.25px solid lightgrey;
	border-radius:10px;
	}
	@media screen and (max-width:500px)
	</style>
    <title>$title</title>
</head>
<body>
	<div id='main'>
    <center class='text-info'><b>" . $this->getConcern($concern) . " Hearing Notice</b></center>
	<div id='container'>
		<p>The case  <span class='text-info'> $title </span> has been assigned to you, the details are listed below </p>
		<p>case title : <span style='color:dodgerblue'>$title</span> <br> Case Type : $category <br> date : $date <br>
		time : $time hrs <br> Location : " . $this->getConcern($concern) . "  " . $this->getCenter($center) . " Center <br> counsel in charge : " . $this->getCounsel($counsel_id) . "  </p>
		<hr>
		<p style='color:dodgerblue'>For Further Enquiries or Complaints, Kindly Reach Us On info@opd.com, 08127110728 </p>
	
	<hr>
	</div></div>
</body>
</html>";
return $str;
    
}

/*
  <th>title</th>
                <th>complainant</th>
                <th>respondent</th>
                <th>status</th>
                <th>case type</th>
                <th>verdict</th>
                <th>center</th>
                <th>Category</th>
                <th>counsel</th>
                <th>Date of Hearing</th>
*/

public function findCase($userid, $uniqueID, $center, $concern, $role){
    $sql = "SELECT c.*, cv.*, c.id AS cid FROM cases AS c LEFT JOIN case_verdict AS cv ON c.id = cv.case_id WHERE unique_case_id = '$uniqueID' AND concern = '$concern'";
    if ($role == 'admin'){
        $sql .= " AND center = '$center'";
    }
    else if ($role == 'user'){
        $sql .= " AND counsel_in_charge = '$userid'";
    }
    $sel = $this->con->query($sql);
    if ($sel->num_rows == 0){
        return "<center>no case found</center>";
    }else{
        $r = $sel->fetch_assoc();
        $id = $r['cid'];
        if($role != 'user'){
            
              $s = "<a href='casedetail.php?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail.php?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }
        
        $str = "<tr><td>" . $r['title'] . "</td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $r['status'] . "</td><td>".  $this->getCaseType($r['case_type']) . "</td><td>" .
        $r['verdict']. "</td><td>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $this->getCounsel($r['counsel_in_charge']) . "</td><td>" . $r['hearing_date'] . "</td><td>" . $s . "</td></tr>";  
        return $str;
        
    }

}
public function deleteCase($unique_id){
    $sql = "DELETE FROM cases WHERE unique_case_id = '$unique_id' ";
    $del = $this->con->query($sql);
    if ($del){
        echo "case successfully deleted";
    }else{
        echo "operation failed... could not delete case"; 
    }
}

public function fetchOutcomes($concern){
        $str ='';
        $sel = $this->con->query("SELECT * FROM case_outcome WHERE concern = '$concern'");
        if($sel->num_rows > 0){
            while($r = $sel->fetch_assoc()){
            $str .= "<option value='" . $r['id'] . "'>" . ucwords($r['name']) . "</option>";
            }
        }
        else{
            $no_data = "No data returned";
           $str .= "<option value='" . $r['id'] . "'>" . $no_data . "</option>"; 
        }
        return $str;
}

public function filterCaseSearch($concern, $center, $type, $outcome){
    $str ='';
    $sql = "SELECT  c.*, c.id AS cid, cv.* FROM cases AS c LEFT JOIN case_verdict AS cv ON c.id = cv.case_id WHERE c.concern = '$concern'";
    if (!empty($center)){
        $sql .= " AND c.center = '$center'";
    }
    if (!empty($type)){
        $sql .= " AND c.case_type = '$type'";
    }
    if(!empty($outcome)){
        $sql .= " AND cv.verdict = '$outcome'";
    }
   // echo $sql;
    
    $go = $this->con->query($sql);
    if($go->num_rows == 0){
      $str .= "<span class='error text-info'> No Data To Display </span> <hr>";  
    }else{
        $count = 1;
        while ($r = $go->fetch_assoc()){
            
             if (!empty($r['counsel_in_charge'])){
        $counsel = $this->getCounsel($r['counsel_in_charge']);
        }else{
            $counsel = 'None';
        }
            if(empty($r['verdict'])){
                
                $ver = 'None';
            }else{
                $ver = "<b class='text-success'>" . $this->getOutcome($r['verdict'], $concern) . "</b>";
            }
            if ($r['status'] == 'assaigned'){
                $status = "<span class='text-success' style='padding:10px;'>" . $r['status'] . "</span>";
            }else{
                 $status = "<span class='text-danger' style='padding:10px;'>" . $r['status'] . "</span>";
            }
            $id = $r['cid']; 
            
           /* if($role != 'user'){
              $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }*/
            $date = explode('T', $r['hearing_date']);
            $str .= "<tr><td><b>" . $r['title'] . "</b></td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $status . "</td><td class='text-warning' >" . $this->getCaseType($r['case_type'])
            . "</td><td>" . $counsel . "</td><td style='color:dodgerblue'>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $ver . "</td><td>" . $date[0] . "</td></tr>";
            $count++;
        }
    }
    return $str;
    }
    
    

public function fetchCasesForReport($concern, $center, $role, $counsel){
    $str = '';
    $sql = "SELECT c.*, c.id AS cid, cv.* FROM cases AS c LEFT JOIN case_verdict AS cv ON c.id = cv.case_id WHERE c.concern = '$concern'";
    //$concern tracks either opd or cmc 
    //$center tracks the admin center 
    //$role is a session var to determine the level of the account
    if ($role == 'admin'){
        $sql .= " AND c.center = '$center' ";
    }
    if ($counsel != null){
        $sql .= " AND counsel_in_charge = '$counsel' ";
    }
    $sql .= " ORDER BY cid DESC";
    $go = $this->conn->query($sql) or die($this->conn->error);
    if ($go->num_rows == 0){
        
        //$str .= "<span class='error text-info'> No Data To Display </span> <hr>";
    }else{
       
        $count = 1;
        while ($r = $go->fetch_assoc()){
            
             if (!empty($r['counsel_in_charge'])){
        $counsel = $this->getCounsel($r['counsel_in_charge']);
        }else{
            $counsel = 'none';
        }
        if (!empty($r['verdict'])){
        $ver = "<b class='text-success'>" . $this->getOutcome($r['verdict'], $concern) . "</b>";
        }else{
                 $ver = "<b class='text-dark'>no outcome</b>";
            }
            if ($r['status'] == 'assigned'){
                $status = "<span class='text-success' style='padding:10px;'>" . $r['status'] . "</span>";
            }else{
                 $status = "<span class='text-danger' style='padding:10px;'>" . $r['status'] . "</span>";
            }
            $id = $r['cid']; 
            
          /*  if($role != 'user'){
              $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }
            */
            $case_type = explode(";", $r['case_type']);
           // echo $r['case_type'] . "<br>";
            $date = explode('T', $r['hearing_date']);
            $str .= "<tr><td><b>" . $r['title'] . "</b></td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $status . "</td><td class='text-warning' >" . $this->getCaseType($case_type[0])
            . "</td><td>" . $counsel . "</td><td style='color:dodgerblue'>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $ver . "</td><td>" . $date[0] . "</td></tr>";
            $count++;
        }
    }
    return $str;
    
}

/** Generate Stats **/


public function getStats($concern, $center, $outcome_type){
    //fetch case outcome count
    
}


public function fetchCaseCategoryStats($concern, $center, $cat_type){
    $sql = "SELECT * FROM cases WHERE case_category = '$cat_type' AND concern = '$concern'";
    if ($center != null){
        $sql .= " AND center = '$center' ";
    }
    $go = $this->con->query($sql);
    if ($go->num_rows > 0){
        return $go->num_rows;
    }else{
        return 0;
    }
}

public function fetchCaseOutcome($concern, $center, $outcome){
    $sql = "SELECT c.id, cv.id FROM cases AS c LEFT JOIN case_verdict AS cv ON c.id = cv.case_id AND concern = '$concern' AND verdict = '$outcome'";
    if ($center != null){
        $sql .= " AND center = '$center' ";
    }
    $sel = $this->con->query($sql);
    if($sel->num_rows > 0){
        return $sel->num_rows;
    }else{
        return 0;
    }
}


/** End OF Stats **/
 
 
 public function isCaseOutcomeReady($case_id){
    $sql = "select * from case_verdict WHERE case_id = '$case_id' ";
    $sel = $this->con->query($sql);
    if ($sel->num_rows > 0){
        return 1;
    }else{
        return 0;
    }
}
 public function isCaseActionReady($case_id){
    $sql = "select * from case_actions WHERE case_id = '$case_id' ";
    $sel = $this->con->query($sql);
    if ($sel->num_rows > 0){
        return 1;
    }else{
        return 0;
    }
}

public function fetchCaseOutcomes($case_id){
    $mainArray = array();
   // $count = 0;
    $sql = "select * ,
    CASE 'hearing_date'
    WHEN DATE(hearing_date) < curdate() THEN 'previous hearing date'
    WHEN DATE(hearing_date) > curdate() THEN 'next hearing date'
    ELSE 'hearing date'
    END AS label
    from case_verdict 
    WHERE case_id = '$case_id' ORDER BY id DESC";
    $sel = $this->con->query($sql) or die($this->con->error);
    while ($r = $sel->fetch_assoc()){
        $unitArray = array($r['verdict'], $r['brief'], $r['case_id'], $r['hearing_date'], $r['updated_on'], $r['label']);
        array_push($mainArray, $unitArray);
        //$count++;
    }
    array_push($mainArray);
    return $mainArray;
}

public function UpdateCaseOutcome($case_id, $verdict, $brief, $hearing_date, $url){
    $keys = array('case_id', 'verdict', 'brief', 'hearing_date');
    $vals = array($case_id, $verdict, $brief, $hearing_date);
    $this->insert('case_verdict', $keys, $vals);
    if ($this->output['outcome'] == 'data inserted'){
        echo "<script>alert('case outcome updated'); window.location='$url'</script>";
    }else{
        echo "<script>alert('operation failed'); window.location='$url'</script>";
    }
}

public function updatedCaseAction($case_id, $action, $comment, $officer, $signed_by, $date_of_action, $url){
    
        $keys = array('case_id', 'action', 'comment', 'officer', 'signed_by', 'date_of_action');
    $vals = array($case_id, $action, $comment, $officer, $signed_by, $date_of_action);
    $this->insert('case_actions', $keys, $vals);
    if ($this->output['outcome'] == 'data inserted'){
        echo "<script>alert('case outcome updated'); window.location='$url'</script>";
    }else{
        echo "<script>alert('operation failed'); window.location='$url'</script>";
    }
    
}

public function fetchCaseActions($case_id){
    
      $mainArray = array();
   // $count = 0;
    $sql = "select *
    from case_actions WHERE case_id = '$case_id' ORDER BY id DESC";
    $sel = $this->con->query($sql) or die($this->con->error);
    while ($r = $sel->fetch_assoc()){
        $unitArray = array($r['action'], $r['comment'], $r['case_id'], $r['date_of_action'], $r['officer'], $r['signed_by']);
        array_push($mainArray, $unitArray);
        //$count++;
    }
    array_push($mainArray);
    return $mainArray;
        
}

public function fetchActions($concern){
    
      $str ='';
        $sel = $this->con->query("SELECT * FROM actions WHERE concern = '$concern'");
        if($sel->num_rows > 0){
            while($r = $sel->fetch_assoc()){
            $str .= "<option value='" . $r['id'] . "'>" . ucwords($r['name']) . "</option>";
            }
        }
        else{
            $no_data = "No data returned";
           $str .= "<option value='" . $r['id'] . "'>" . $no_data . "</option>"; 
        }
        return $str;
    
}

public function getAction($case_id, $concern){
    
     $str = '';
    $sql = "SELECT * FROM actions WHERE id = '$case_id' AND concern = '$concern' ORDER BY id ASC LIMIT 1";
    $go = $this->conn->query($sql);
    $r = $go->fetch_assoc();
    return ucwords($r['name']);    
}

public function getOutcome($case_id, $concern){
    $str = '';
    $sql = "SELECT * FROM case_outcome WHERE id = '$case_id' AND concern = '$concern' ORDER BY id ASC LIMIT 1";
    $go = $this->conn->query($sql);
    $r = $go->fetch_assoc();
    return ucwords($r['name']); 
}

public function fetchClients($concern){
    $str = '';
    $sql = "SELECT * FROM clients WHERE concern = '$concern'";
    $sel = $this->con->query($sql);
    if ($sel->num_rows > 0){
        $i = 1;
    while($r = $sel->fetch_assoc()){
        $str .= "<tr><td>" . $i . "</td><td>" . $r['name'] . "</td><td>" . $r['number'] . "</td><td>" . $r['email'] . "</td><td>" . $r['address' ] . "</td><td>" . $r['means_of_id'] . "</td><td>" . $r['id_num'] .
        "</td><td>" . $this->getCenter($r['center']) . " </td><td>" . $r['date_added'] .
        "</td></tr>";
        $i++;
    }
    return $str;
    }else{
       return $this->displayErrors("no clients registered"); 
    }
    
    
    //}
    
}

public function getConcludedCaseCount($center, $concern, $counsel){
    $sql = "SELECT cv.verdict, c.id FROM case_verdict AS cv LEFT JOIN cases AS c ON cv.case_id = c.id WHERE cv.verdict != '' ";
    if ($center != null){
        $sql .= " and c.center = '$center'";
    }
    if ($counsel != null){
        $sql .= " and c.counsel_in_charge = '$counsel' ";
    }
    $sql .= " and c.concern = '$concern'";
    $res = $this->con->query($sql) or die($this->con->error);
    $this->unAssignedAndConcluded = $res->num_rows;
    return $res->num_rows;
}

public function getOngoingCaseCount($center, $concern, $counsel){
    $sql = "SELECT cv.verdict, c.id FROM case_verdict AS cv RIGHT JOIN cases AS c ON cv.case_id = c.id WHERE cv.verdict = '' ";
    if ($center != null){
        $sql .= " and c.center = '$center'";
    }
    if ($counsel != null){
        $sql .= " and c.counsel_in_charge = '$counsel' ";
    }
    $sql .= " and cv.concern = '$concern'";
    $res = $this->con->query($sql);
    $this->assignedAndOngoing = $res->num_rows;
    return $res->num_rows;
}

public function retOngoing(){
  return $this->assignedAndOngoing;  
}

public function editCase($idd, $cCenter, $cCounsel, $PA, $PAN, $PAE, $PAA, $PB, $PBN, $PBE, $PBA, $rName, $rEmail, $rPhone, $rAddr){
    
    /*UPDATE `cases` SET `id`=[value-1],`title`=[value-2],`party_a`=[value-3],`party_b`=[value-4],`petitioner_name`=[value-5],`petitioner_number`=[value-6],
    `petitioner_email`=[value-7],`petitioner_address`=[value-8],`means_of_id`=[value-9],`id_number`=[value-10],`case_type`=[value-11],`case_description`=[value-12],`counsel_in_charge`=[value-13],
    `unique_case_id`=[value-14],`party_a_contact`=[value-15],`party_a_email`=[value-16],`party_a_address`=[value-17],`party_b_contact`=[value-18],`party_b_email`=[value-19],`party_b_address`=[value-20],`status`=[value-21],
    `concern`=[value-22],`center`=[value-23],`case_category`=[value-24],`ref`=[value-25],`ref_name`=[value-26],`file`=[value-27],`date_registered`=[value-28] WHERE 1 */
    
    
    
    if($_FILES['file0']['size'] > 0){
            $this->upload('file0', '../../uploads/documents', true,  array('pdf', 'doc', 'docx', 'txt', 'jpg', 'png','jpeg'), 0);
            $file0 = $this->newname .";";
    }else{$file0 = "";}
    
    if($_FILES['file1']['size'] > 0){
            $this->upload('file1', '../../uploads/documents', true,  array('pdf', 'doc', 'docx', 'txt', 'jpg', 'png','jpeg'), 0);
            $file1 = $this->newname .";";
    }else{$file1 = "";}
    
    if($_FILES['file2']['size'] > 0){
            $this->upload('file2', '../../uploads/documents', true,  array('pdf', 'doc', 'docx', 'txt', 'jpg', 'png','jpeg'), 0);
            $file2 = $this->newname .";";
    }else{$file2 = "";}
    
    if($_FILES['file3']['size'] > 0){
            $app->upload('file3', '../../uploads/documents', true,  array('pdf', 'doc', 'docx', 'txt', 'jpg', 'png','jpeg'), 0);
            $file3 = $this->newname .";";
    }else{$file3 = "";}
    
    $sql = "select * from cases where id=$idd";
    $res = $this->con->query($sql);
    if($res->num_rows > 0){
        while($row = $res->fetch_Assoc()){
            $doc = $row['docs'];
        }
    }else{echo $this->con-error;}
    
    $query = "update cases set center='$cCenter', counsel_in_charge='$cCounsel', party_a='$PA', party_a_contact='$PAN', party_a_email='$PAE', party_a_address='$PAA', party_b='$PB', 
              party_b_contact='$PBN', party_b_email='$PBE', party_b_address='$PBA', petitioner_name='$rName', petitioner_email='$rEmail', 
              petitioner_number='$rPhone', petitioner_address='$rAddr', docs='$doc$file0$file1$file2$file3' where id=$idd";
              
    $result = $this->con->query($query) or die($this->con->error);
    if($result){
        echo "<script> alert('Case: ".json_encode($this->title)." Edited succesfully') </script>";
        echo "<script>window.location = '../portal/edit_case.php?id=$idd'</script>";
    }else{
        echo "<script>alert('could not update')</script>";
        
    }
    
}


public function fetchOngoingCase($center, $concern, $counsel){
    $str = '';
    $sql = "SELECT cv.*, c.*, c.id AS cid FROM case_verdict AS cv RIGHT JOIN cases AS c ON cv.case_id = c.id WHERE cv.verdict = '' ";
    if ($center != null){
        $sql .= " and c.center = '$center'";
    }
    if ($counsel != null){
        $sql .= " and c.counsel_in_charge = '$counsel' ";
    }
    $sql .= " and cv.concern = '$concern'";
    $res = $this->con->query($sql);
    if ($res->num_rows == 0){
        
        $str .= "<span class='error text-info'> No Data To Display </span> <hr>";
    }else{
       
        $count = 1;
        while ($r = $res->fetch_assoc()){
            
             if (!empty($r['counsel_in_charge'])){
        $counsel = $this->getCounsel($r['counsel_in_charge']);
        }else{
            $counsel = 'none';
        }
        if (!empty($r['verdict'])){
        $ver = "<b class='text-success'>" . $this->getOutcome($r['verdict'], $concern) . "</b>";
        }else{
                 $ver = "<b class='text-dark'>no outcome</b>";
            }
            if ($r['status'] == 'assigned'){
                $status = "<span class='text-success' style='padding:10px;'>" . $r['status'] . "</span>";
            }else{
                 $status = "<span class='text-danger' style='padding:10px;'>" . $r['status'] . "</span>";
            }
            $id = $r['cid']; 
            
          /*  if($role != 'user'){
              $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }
            */
            $date = explode('T', $r['hearing_date']);
            $str .= "<tr><td><b>" . $r['title'] . "</b></td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $status . "</td><td class='text-warning' >" . $this->getCaseType($r['case_type'])
            . "</td><td>" . $counsel . "</td><td style='color:dodgerblue'>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $date[0] . "</td></tr>";
            $count++;
        }
    }
    return $str;
    
    
}


public function fetchConcludedCase($center, $concern, $counsel){
    $str = '';
       $sql = "SELECT cv.*, c.*, c.id AS cid FROM case_verdict AS cv LEFT JOIN cases AS c ON cv.case_id = c.id WHERE cv.verdict != '' ";
    if ($center != null){
        $sql .= " and c.center = '$center'";
    }
    if ($counsel != null){
        $sql .= " and c.counsel_in_charge = '$counsel' ";
    }
    $sql .= " and c.concern = '$concern'";
    $res = $this->con->query($sql) or die($this->con->error);
   
    if ($res->num_rows == 0){
        
        $str .= "<span class='error text-info'> No Data To Display </span> <hr>";
    }else{
       
        $count = 1;
        while ($r = $res->fetch_assoc()){
            
             if (!empty($r['counsel_in_charge'])){
        $counsel = $this->getCounsel($r['counsel_in_charge']);
        }else{
            $counsel = 'none';
        }
        if (!empty($r['verdict'])){
        $ver = "<b class='text-success'>" . $this->getOutcome($r['verdict'], $concern) . "</b>";
        }else{
                 $ver = "<b class='text-dark'>no outcome</b>";
            }
            if ($r['status'] == 'assigned'){
                $status = "<span class='text-success' style='padding:10px;'>" . $r['status'] . "</span>";
            }else{
                 $status = "<span class='text-danger' style='padding:10px;'>" . $r['status'] . "</span>";
            }
            $id = $r['cid']; 
            
          /*  if($role != 'user'){
              $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a>  <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>  <a href='delete_case.php?id=" . $id . "' class=' btn btn-danger'><i class='fa fa-times'></i></a>";
            }else{
             $s = "<a href='casedetail?id=" . $id . "' class='text-primary'><i class='fa fa-eye btn btn-default'></i></a> &nbsp <a href='edit_case.php?id=" . $id . "' class=' btn btn-success'><i class='fa fa-edit'></i></a>";
            }
            */
            $date = explode('T', $r['hearing_date']);
            $str .= "<tr><td><b>" . $r['title'] . "</b></td><td>" . $r['party_a'] . "</td><td>" . $r['party_b'] . "</td><td>" . $status . "</td><td class='text-warning' >" . $this->getCaseType($r['case_type'])
            . "</td><td>" . $counsel . "</td><td style='color:dodgerblue'>" . $this->getCenter($r['center']) . "</td><td>" . $r['case_category'] . "</td><td>" . $date[0] . "</td></tr>";
            $count++;
        }
    }
    return $str;
    
    
}

public function fetchSubCategories($concern){
    // $str = "<select name='subcat' id='selectdiv'><label for='caseType' class='text'>Case Sub Category<span class='required'>*</span></label>";
     $str .= '';
       $sel = $this->conn->query("SELECT * FROM sub_category WHERE concern = '$concern' ");
       
       if($sel->num_rows > 0){
           while($r = $sel->fetch_assoc()){
               $str .= "<option value='" . $r['id'] . "'>". ucwords($r['name']) . "</option>";
           }
           //$str .= "</select>";
           return $str;
       }else{
           return "<option value='0'>no subcategories attached</option>";
       }
       
}


public function editProfile($id, $username, $firstname, $lastname, $email, $phone, $gender){
    
    $sql = "update cmc_users set username='$username', first_name='$firstname', last_name='$lastname', gender='$gender', phone_number='$phone' where id=$id";
    $result = $this->con->query($sql);
    if($result){
        echo "<script>alert('Profile successfully Updated'); window.location='../views/portal/edit_profile.php?id=$id';</script>";
        
    }else{
        echo "<script>alert('UNexpected error, could not update profile ---- ".json_encode($this->con->error)."')</script>";
    }

    
}

public function checkUser($id){
    $sql = "select id from cmc_users where id=$id";
    $result = $this->con->query($sql);
    if($result->num_rows != 1){
        echo "<script>alert('NO PROFILE SELECTED !!'); window.location='index.php';</script>";
            
            exit;
    }
    
}

public function fetchUser($id){

    $sql = "select * from cmc_users where id=$id";
    $result = $this->con->query($sql);
    if($result->num_rows == 1){
        while($r = $result->fetch_assoc()){
            $id = $r['id'];
            $this->email = $r['email'];
            $this->username = $r['username']; 
            $this->role = $r['role']; 
            $this->center = $r['center'];
            $this->firstname = $r['first_name'];
            $this->lastname = $r['last_name'];
            $this->gender = $r['gender'];
            $this->phone = $r['phone_number'];
        }
    }
    
    
}

 
    
}

?>