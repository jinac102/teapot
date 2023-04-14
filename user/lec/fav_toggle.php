<?php
session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

//   $fidx = $_POST['fidx'];
    $clidx=$_POST['clidx'];
  $uid = $_SESSION['UID'];
  $date = date('Y-m-d H:i:s');

  if($uid){
    $favque = "SELECT count(*) AS cnt FROM lms_favorite WHERE fv_uid ='$uid' AND fv_clsnum = '$clidx'";
    $favres = $mysqli -> query($favque);
    $favfet = $favres->fetch_object();
    $fav =  $favfet-> cnt;
    if($fav == 0){
        $que = "INSERT INTO lms_favorite (fv_clsnum, fv_uid, regdate) 
        VALUES ('$clidx', '$uid', '$date')";
        $res = $mysqli -> query($que) or die('query error'.$mysqli->error);
        if ($res){
            $resp = array("result" => "ins");
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