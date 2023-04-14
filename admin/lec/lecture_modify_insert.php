<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );


  $lidx = $_POST['lidx'];
  $title = $_POST['title'];
  $note = $_POST['note'];
  $status = $_POST['status'];
  $href = $_POST['href'];
  $file = $_POST['file_table_id'];

  $moque ="UPDATE lms_lec SET 
  lec_title ='$title ', 
  lec_text = '$note', 
  lec_st = '$status', 
  lec_href = '$href', lec_file = '$file' WHERE lidx='$lidx'";
  $moraw = $mysqli ->query($moque) or die('query error'.$mysqli->error);

  if (!empty($file)) {
    $daq = "UPDATE lms_table_file SET itemidx = '$lidx' WHERE thidx IN (".$file.")";
    $daraw =  $mysqli -> query($daq) or die('query error'.$mysqli->error);
  }

  if($_REQUEST['stp_minute'] && $stp_second = $_REQUEST['stp_second'] && $stp_desc = $_REQUEST['stp_desc']){
    $stp_minute = $_REQUEST['stp_minute'];
    $stp_second = $_REQUEST['stp_second'];
    $stp_desc = $_REQUEST['stp_desc'];
    
    $dque = "DELETE FROM lms_timestamp WHERE ts_lecnum='$lidx'";
    $mysqli -> query($dque) or die('query error'.$mysqli->error);

    $i=0;
    foreach($stp_desc as $sd){
      if($sd){
          $tque = "INSERT INTO lms_timestamp (ts_lecnum, stp_minute, stp_second, stp_desc)
          VALUES ('$lidx', '{$stp_minute[$i]}', '{$stp_second[$i]}', '{$stp_desc[$i]}')";
          $tresult = $mysqli -> query($tque) or die('query error'.$mysqli->error);
      }
      $i++;
    }
  }


  if($moraw){
    $result = array('status' => 'success', 'message' => 'Lecture updated successfully','lidx' => $lidx);
  } else {
    $result = array('status' => 'error', 'message' => 'Failed to update lecture');
  }
  echo json_encode($result);
  ?>