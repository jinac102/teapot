<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  $lidx = $_POST['lidx'];

  $que = "SELECT * FROM lms_timestamp WHERE ts_lecnum ='$lidx'";
  $res = $mysqli->query($que) or die("query_error".$mysqli->error);
  // print_r($res);
  // $obg = $res->fetch_assoc();
  // print_r($obg);
  $resp = array();
  while($obg = $res->fetch_object()){
    $resp[] =  array('lidx' => $obg->ts_lecnum, 'mn'=>$obg->stp_minute, 'sc'=>$obg->stp_second,'ds'=>$obg->stp_desc);
  }
  echo json_encode($resp);
?> 