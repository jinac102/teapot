<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  $clidx = $_POST['clidx'];
  $uid = $_SESSION['UID'];

  $cque = "DELETE FROM lms_favorite WHERE fv_clsnum = '$clidx' and fv_uid = '$uid'"; 
  $cres = $mysqli->query($cque) or die("query_error" . $mysqli->error);
  if ($cres){
    $resp = array("result" => "success");
  }else{
    $resp = array("result" => "fail");
  }
  echo json_encode($resp);
  ?>