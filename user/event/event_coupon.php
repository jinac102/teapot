<?php
  session_start();


  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";

  
  error_reporting(E_ALL);
  ini_set( 'display_errors', '0' );

  $userid = $_SESSION['UID'];
  $cid = $_POST['cid'];
  // print_r($userid);

    $sql = "SELECT * from user_coupons where userid='$userid'";
    $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
    while($rs = $result->fetch_object()){
      $rsu[]=$rs;
    }
    // print_r($rsu);
    $sqlc = "SELECT * FROM lms_event WHERE cc_idx=$cid";
    $resultc = $mysqli -> query($sqlc) or die("query error =>".$mysqli->error);
    $rs = $resultc->fetch_object();
    $eno = $rs->ev_idx;
    $issued = 0;
    // print_r("초기값:.$issued");
    foreach($rsu as $u){
      if($u->couponid == $cid){ //해당 쿠폰이 있는지 없는지 확인
        $issued = 1;
        // print_r($issued);
        break;
      }
    }
    // print_r($issued);
    

    if(!$userid){
      $return_data = array("result" => "error");
      echo json_encode($return_data); 
    }else{
      if($issued === 1) { //쿠폰이 있다
          $return_data = array("result" => "have");
          echo json_encode($return_data); 
          return false;
        }else{ //쿠폰이 없다.
          // print_r("없을때:$issued");
          $sqlc = "SELECT * FROM lms_coupon_cat WHERE cc_idx=$cid";
          $resultc = $mysqli -> query($sqlc) or die("query error =>".$mysqli->error);
          $rs = $resultc->fetch_object();
          // print_r($rsc);
          $status = $rs->statu;
          $duedate = $rs->duedate;
          $cname = $rs->cc_name;
          
          $sql2="INSERT INTO user_coupons
          (couponid, userid, status, use_max_date, regdate, reason)
          VALUES({$cid}
          , '".$userid."'
          , {$status}
          , '".$duedate."'
          , now()
          , '".$cname."'
          )";
          $rsu = $mysqli -> query($sql2) or die("query error:".$mysqli->error);

          if($rsu){
            $return_data = array("result" => "success");
            echo json_encode($return_data);    
          }else{
            $return_data = array("result" => "error");
            echo json_encode($return_data); 
          }
        }
    }
?>