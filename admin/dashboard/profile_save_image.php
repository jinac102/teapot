<?php
session_start();
//db 연결
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

//넘어온 값을 변수 지정
$userid = $_POST["userid"];
$username = $_POST["username"];
$userfile = $_FILES["upfile"];

echo "가나다";
print_r($userid);
print_r($username);
print_r($userfile);

if ( iconv_strlen($_FILES[ 'upfile' ][ 'name' ]) > 0 ) {
  $uploaded_file_name_tmp = $_FILES[ 'upfile' ][ 'tmp_name' ];
  $uploaded_file_name = $_FILES[ 'upfile' ][ 'name' ];
  // print_r($uploaded_file_name);

  $upload_folder =$_SERVER['DOCUMENT_ROOT']."/teapot/user/upload/";
  move_uploaded_file( $uploaded_file_name_tmp, "$upload_folder/$uploaded_file_name");

  // 파일명이 중복되는 경우 파일명 뒤에 현재 시간을 추가하여 중복을 방지
  // $profile_img_name = time() . '_' . $uploaded_file_name;
  // move_uploaded_file($uploaded_file_name_tmp, "$upload_folder/$profile_img_name");


  $profile_img = "/teapot/user/upload/".$uploaded_file_name;
  $sql = "UPDATE lms_user set 
  userid='{$userid}', username='{$username}', user_file='{$profile_img}', userphone='{$userphone}', email='{$email}' where super=1";
}else{
  $sql = "UPDATE lms_user set 
  userid='{$userid}', username='{$username}', userphone='{$userphone}', email='{$email}' where super=1";
}


 
  $fs=$mysqli->query($sql) or die($mysqli->error);
  if($fs){
   echo "<script>
    alert('수정 되었습니다.');
    location.href='./dashboard.php';
    </script>";
  };

?>