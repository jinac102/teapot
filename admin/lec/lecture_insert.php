<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $clidx = $_GET['clidx'];
  $title = $_POST['title'];
  $note = $_POST['note'];
  $status = $_POST['status'];
  $href = $_POST['href'];
  $date = date('Y-m-d H:i:s');
  $file = $_POST['file_table_id'];
  $files = rtrim($file,",");
print_r( $file );

  $que = "INSERT INTO lms_lec (lec_clsnum, lec_title, lec_text, lec_href, regdate, lec_file, lec_hit, lec_st) 
    VALUES ('$clidx','$title','$note','$href','$date', '$files', 0, '$status')";
   $result = $mysqli -> query($que) or die('query error'.$mysqli->error);
  $lidxt = $mysqli->insert_id;
 
  if(!empty($_POST['file_table_id'])){
    $files1 = $_POST['file_table_id'];
    $files2 = rtrim($files,",");
    $daq = "UPDATE lms_table_file SET itemidx = '$lidxt' WHERE thidx IN '$files2'";
    $daraw =  $mysqli -> query($daq) or die('query error'.$mysqli->error);
  }

  if($_REQUEST['stp_minute'] && $stp_second = $_REQUEST['stp_second'] && $stp_desc = $_REQUEST['stp_desc']){
    $stp_minute = $_REQUEST['stp_minute'];
    $stp_second = $_REQUEST['stp_second'];
    $stp_desc = $_REQUEST['stp_desc'];
    $i=0;
    foreach($stp_desc as $sd){
      if($sd){
          $tque = "INSERT INTO lms_timestamp (ts_lecnum, stp_minute, stp_second, stp_desc)
          VALUES ('$lidxt', '{$stp_minute[$i]}', '{$stp_second[$i]}', '{$stp_desc[$i]}')";
          $tresult = $mysqli -> query($tque) or die('query error'.$mysqli->error);
      }
      $i++;
    }
  }
  echo "<script>location.href = 'lecture_preview.php?lidx=$lidxt';</script>";
?>