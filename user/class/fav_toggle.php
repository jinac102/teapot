<?php
session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

//   $fidx = $_POST['fidx'];
    $clidx=$_POST['clidx'];
    $favtog=$_POST['favtog'];
  $uid = $_SESSION['UID'];
  $date = date('Y-m-d H:i:s');

  if($uid){
    if($favtog == "false"){
        $que = "INSERT INTO lms_favorite (fv_clsnum, fv_uid, regdate) 
        VALUES ('$clidx', '$uid', '$date')";
        $res = $mysqli -> query($que) or die('query error'.$mysqli->error);
        if ($res){
            $resp = array("result" => "ins", "data" => $clidx);
        }else{
            $resp = array("result" => "fail");
        }
    }else{
        $que ="DELETE FROM lms_favorite WHERE fv_clsnum = '$clidx' and fv_uid = '$uid'"; 
        $res = $mysqli -> query($que) or die('query error'.$mysqli->error);
        if ($res){
            $resp = array("result" => "del");
        }else{
            $resp = array("result" => "fail");
        }
    }
  }else{
    $resp = array("result" => "alert");
  }
echo json_encode($resp);
?>