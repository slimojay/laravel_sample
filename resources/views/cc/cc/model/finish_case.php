<?php

//$_GET = json_decode(file_get_contents('php://input'), true);
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], array('super_admin', 'admin') )){
    echo "<script>window.location='../views/index.php'</script>";
}
include('../controller/CMC_controller.php');
$app = new CMC_Controller();

//$title, $party_a, $party_b, $rn, $rnum, $re, $ra, $mid, $id_num, $ct, $cd, $pac, $pbc, $concern, $center
//{title : '$title', party_a : '$partya', party_b : '$partyb', regnum:'$regnum', regname:'$regname', regem : '$regem', regadd : '$ra', 
 //   mid : '$mid', id_num : '$id_num', type : '$ct', desc : '$cd', pac : '$pac', pbc : '$pbc', center : '$center',  pic : '$IDpic'}

echo $app->createCase($_GET['title'], $_GET['party_a'], $_GET['party_b'], $_GET['regname'], $_GET['regnum'], 
        $_GET['regem'], $_GET['regadd'], $_GET['mid'], $_GET['id_num'], $_GET['type'], $_GET['desc'], $_GET['pac'], 
        $_GET['pae'], $_GET['paddr'], $_GET['pbc'], $_GET['pbe'], $_GET['pbaddr'], $_SESSION['concern'], $_GET['center'], 
        $_GET['path'], $_GET['ref'], $_GET['casecat'], $_GET['rn']);


?>