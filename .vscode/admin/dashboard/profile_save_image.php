<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  $userid = $_POST['id'];
  $username = $_POST['name'];
  $userfile = $_POST['file'];
  

if($_POST['file']['type'] != 'image/png' and $_POST['file']['type'] != 'image/gif' and $_POST['file']['type'] != 'image/jpeg'){
    $return_data = array("result"=>"image");
    echo json_encode($return_data);  
    exit;
}

$save_dir = $_SERVER['DOCUMENT_ROOT']."/teapot/admin/uploads/"; 
$filename = $_POST['file']['name'];
$ext = pathinfo($filename,PATHINFO_EXTENSION);
$newfilename = date("YmdHis").substr(rand(),0,6);
$savefile =  $newfilename.'.'.$ext; 

if(move_uploaded_file($_POST['file']['tmp_name'], $save_dir.$savefile)){
    $profileImgURL = '/teapot/admin/uploads/'.$savefile;

    $sql = "UPDATE lms_user set userid='".$userid."', username='".$username."',user_file='".$profileImgURL."' where super=1";
    $fs=$mysqli->query($upquery) or die($mysqli->error);       
    $mysqli->commit();
    $return_data = array("result"=>"success");
    echo json_encode($return_data);
    exit;

} else{
    $return_data = array("result"=>"error");
    echo json_encode($return_data);
    exit;
}


?>