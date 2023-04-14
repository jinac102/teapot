<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $lidx = $request->lidx;

$que= "SELECT * FROM lms_lec WHERE lidx='$lidx'";
$raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
if($row = $raw -> fetch_object()){
   $json = array("title"=> $row -> lec_title, "note"=> $row->lec_text, "href"=>$row->lec_href, "status"=>$row->lec_st, "lidx"=>$lidx);
    echo json_encode($json);
}else{
    $response = array(
        'result' => 'error',
        'massage' => '실패',
    );
}
?>