<?php
  session_start();
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";

  $name = $_POST['name'];
  $sql = "SELECT * from lms_coupon_cat WHERE cc_name='$name'";
  $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
  $rsc = $result->fetch_object();
  $price = $rsc->cc_price;
  $ratio = $rsc->cc_ratio;
  $minPrice = $rsc->cc_min_price;

  if($price){
    $return_data = array("price" => $price, "minPrice"=>$minPrice);
    echo json_encode($return_data);
  }else{
    $return_data = array("price" => $ratio, "minPrice"=>$minPrice);
    echo json_encode($return_data);
  }

?>