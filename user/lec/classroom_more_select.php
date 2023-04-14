<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  $clidx = $_POST['clidx'];
  $i = $_POST['j'];
  $request_i = $i*5;

  $que0 = "SELECT COUNT(*) AS cnt FROM lms_lec where lec_clsnum = '$clidx'";
  $res0 = $mysqli->query($que0);
  $row0 = $res0->fetch_assoc();
  $clLength = $row0['cnt'];

  if($clLength == 0){
    $resp['result'] = 'empty';
  }else{
    if($request_i >= $clLength){
      $totalView = $clLength;
      $result = 'full';
    }else{
      $totalView = $request_i;
      $result = 'partly';
    }

    $que = "SELECT * FROM lms_lec where lec_clsnum = '$clidx' ORDER BY lidx ASC LIMIT $totalView";
    $res = $mysqli->query($que);
    
    $resp = array();
    while($obg = $res->fetch_object()){
      $resp[] = array('result'=>$result,
      'title' => $obg->lec_title, 
      'lidx'=>$obg->lidx, 
      'status'=>$obg->lec_st,
      );
    }
  }
  echo json_encode($resp);
?>