<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  
  $uidx = $_GET['uidx'];
  $user_st = $_POST['user_st'];
  $sql = "UPDATE lms_user SET user_st=0 where uidx=".$uidx;
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);

  if($result){
    echo "<script>
    alert('탈퇴 되었습니다');
    location.replace('../../index.php');
    </script>";
  }else{
    echo "<script>
    alert('탈퇴 실패');
    location.replace('../../login.php');
    </script>";
  }
?>