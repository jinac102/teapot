<?php
  session_start();
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";
  $userid = $_SESSION['UID'];
  $classArry = $_POST['classArry'];
  $coupon = $_POST['coupon'];
  
  // if (is_array($list))
  //    $cnt = count($list);
  // for ($i =0; $i < $cnt; $i++ )

  $cnt = 0;
  if(is_array($classArry)){
    $cnt = count($classArry);
  };
  for($i=0; $i<$cnt; $i++){
    $cls = $classArry[$i];
    $sql = "INSERT INTO lms_sold (sold_uidx, sold_clidx) VALUES ('".$userid."', '".$cls."')";
    $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
    // print_r($sql);

    $sql2="DELETE from lms_cart where cart_clsnum=$cls";
    $result2 = $mysqli -> query($sql2) or die("query error =>".$mysqli->error);

    $couponsql = "UPDATE user_coupons set status=-1 where reason='$coupon'";
    $couponrs = $mysqli -> query($couponsql) or die("query error =>".$mysqli->error);
  }
  if($result){
    $return_data = array("result" => "success");
    echo json_encode($return_data);    
  } else{
    $return_data = array("result" => "error");
    echo json_encode($return_data);             
  }
?>