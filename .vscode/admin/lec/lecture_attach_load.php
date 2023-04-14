<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $lidx = $request->lidx;

$que = "SELECT * FROM lms_table_file WHERE itemidx='$lidx'AND status=1";
 $raw = $mysqli ->query($que);
 $data = array();
 while ($row = $raw->fetch_object()) {
     $data[] = array(
         'thidx' => $row->thidx,
         'filename' => $row->filename
     );
 }             
echo json_encode($data);
   
  ?>