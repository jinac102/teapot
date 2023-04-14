<?php
session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  $clidx = $_POST['clidx'];
  $uid = $_SESSION['UID'];
  $date = date('Y-m-d H:i:s');

  if($uid){
    $que = "INSERT INTO lms_favorite (fv_clsnum, fv_uid, regdate) 
    VALUES ('$clidx', '$uid', '$date')";
    $res = $mysqli -> query($que) or die('query error'.$mysqli->error);

    if ($res){
        $resp = array("result" => "success");
    }else{
        $resp = array("result" => "fail");
    }
  }else{
    $resp = array("result" => "alert");
  }
echo json_encode($resp);
?>
