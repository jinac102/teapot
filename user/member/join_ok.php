<?php
session_start();
//db 연결
include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";
include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/coupon_lib.php";

//넘어온 값을 변수 지정
$userid = $_POST["userid"];
$userpw = $_POST["userpw"];
$userpw = hash('sha512',$userpw);
$username = $_POST["username"];
$userphone = $_POST["userphone"];
$email = $_POST["email"];
$regdate = date('Y-m-d');
$user_st = 1;
$super = 0;

if($_POST['connect_check'] == 'true'){
  
    $uploaded_file_name_tmp = $_FILES[ 'user_file' ][ 'tmp_name' ];
    $uploaded_file_name = (iconv_strlen($_FILES[ 'user_file' ]) >0 ) ? $_FILES[ 'user_file' ][ 'name' ] : "pabcon.png";
  
    if($_FILES['user_file']['type'] != 'image/png' and $_FILES['user_file']['type'] != 'image/gif' and $_FILES['user_file']['type'] != 'image/jpeg'){
      $return_data = array("result"=>"image");
    }
    
    $upload_folder = $_SERVER['DOCUMENT_ROOT']."/teapot/user/upload/";
    move_uploaded_file( $uploaded_file_name_tmp, $upload_folder . $uploaded_file_name );
    $profile_img = "/teapot/user/upload/".$uploaded_file_name;

 
  //쿼리 작성 실행
  $mysqli->autocommit(FALSE);
  
  try {
    //회원가입
    $query="INSERT INTO lms_user
    (userid, userpw, username, userphone, email, regdate, user_st, super, user_file)
    VALUES('".$userid."'
    , '".$userpw."'
    , '".$username."'
    , '".$userphone."'
    , '".$email."'
    , '".$regdate."'
    , '".$user_st."'
    , '".$super."'
    , '".$profile_img."'
    )";
  
    $rs1=$mysqli->query($query) or die($mysqli->error);
  
    user_coupon($userid, 1, '회원가입환영쿠폰');
        
    $mysqli->commit();//디비에 커밋한다.
  
    echo "<script>alert('회원가입 성공! 회원가입 쿠폰을 발행해 드렸습니다.');
    location.href='/teapot/login.php';</script>";
    exit;
  }catch (Exception $e) {
    $mysqli->rollback();
    echo "<script>alert('회원가입 실패!');history.back();</script>";
    exit;
  }
}else {
  echo "<script>alert('잘못된 접근입니다.');
  location.href='/teapot/index.php';
  </script>";

}

?>