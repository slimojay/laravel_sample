<?php
include('../controller/CMC_controller.php');
if(isset($_GET['cat_id']) && isset($_GET['concern'])){
    $cat_id = $_GET['id'];
    $concern = $_GET['id'];
}
$app = new CMC_controller();
echo $app->fetchCaseCategories($cat_id, $concern);



?>