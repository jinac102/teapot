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
    $files = $_POST['file_table_id'];
    $files = rtrim($files,",");

    $que = "INSERT INTO lms_lec (lec_clsnum, lec_title, lec_text, lec_href, regdate, lec_file, lec_hit, lec_st) 
    VALUES ('$clidx','$title','$note','$href','$date', '$files', 0, '$status')";

    $result = $mysqli -> query($que) or die('query error'.$mysqli->error);
    $lidxt = $mysqli->insert_id;

    $daq = "UPDATE lms_table_file SET itemidx = '$lidxt' WHERE thidx IN (".$files.")";
    $daraw =  $mysqli -> query($daq) or die('query error'.$mysqli->error);

    echo "<script>location.href = 'lecture_preview.php?lidx=$lidxt';</script>";
    
    ?>