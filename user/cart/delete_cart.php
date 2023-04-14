<?php
  session_start();
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";


  $classAll = $_POST['classArry'];
  $classOne = $_POST['clsnum'];


  if($classAll){
    for($i=0; $i<count($classAll); $i++){
      $cls = $classAll[$i];
  
    $sql = "DELETE from lms_cart WHERE cart_clsnum='$cls'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    $return_data = array("result" => "success");
    echo json_encode($return_data); 
    }
  }else{
    $sql = "DELETE from lms_cart WHERE cart_clsnum='$classOne'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    $return_data = array("result" => "success");
    echo json_encode($return_data); 
  }
?>