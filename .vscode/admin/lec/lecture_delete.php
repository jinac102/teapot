<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $clidx = $_GET['clidx'];
  $lidx = $_GET['lidx'];
  
  //첨부파일 삭제 시작
  $seq = "SELECT * FROM lms_table_file WHERE itemidx='$lidx'";
  $seraw = $mysqli -> query($seq)or die('query error'.$mysqli->error);
  $serow = $seraw -> fetch_object();

  if($serow != null){ 
  $filename = $serow -> filename;
  $del_file = $_SERVER['DOCUMENT_ROOT'] . "/teapot/admin/img/attach/". $filename;
  unlink($del_file);

  $daq = "DELETE FROM lms_table_file WHERE itemidx='$lidx'";
  $daraw = $mysqli -> query($daq) or die('query error'.$mysqli->error);
  }

  $delq ="DELETE FROM lms_lec WHERE lidx='$lidx'";
  $draw = $mysqli -> query($delq) or die('query error'.$mysqli->error);

  echo "<script>location.href = 'lecture_main.php?clidx=$clidx';</script>";
?>