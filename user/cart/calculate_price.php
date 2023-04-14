<?php
  session_start();
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";

  $class = $_POST['classArry'];
  $price = '';

  for($i=0; $i<count($class); $i++){
    $cls = $class[$i];

    $sql = "SELECT cls_price FROM lms_class WHERE clidx='$cls'";
    $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
    $rsc = $result->fetch_object();
    $price = $rsc->cls_price;
    $classPrice += (int)$price;

  }
  
  // print_r((int)$classPrice);

  $return_data = array("price" => $classPrice);
  echo json_encode($return_data);
  // print_r($return_data);

  // for(i=0; i<$class.length; i++){
  //   $cls = $class[i];
  // };
?>