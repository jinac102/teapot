<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  $userid = $_POST["userid"];
  $userpw = $_POST["userpw"];
  $userpw = hash('sha512',$userpw);

  $sql = "SELECT * from lms_user where userid='{$userid}' and userpw='{$userpw}'";
  $result = $mysqli -> query($sql);
  $rs = $result ->fetch_object();

  if($rs){
    $sql = "UPDATE lms_user set last_login=now() where idx = '{$rs->uidx}'";
    $result = $mysqli -> query($sql);

    // rs에 super값이 1이냐 아니냐에 따라 if문 작성
    if($rs->super == 1){
      $_SESSION['AUID'] = $rs->userid;
      $_SESSION['AUNAME'] = $rs->username;
      echo "<script>
          alert('관리자님 어서오세요');
          location.href='/teapot/admin/dashboard/dashboard.php';
      </script>";
      exit;
    }else{
      $_SESSION['UID'] = $rs->userid;
      $_SESSION['UNAME'] = $rs->username;
        echo "<script>
        alert('".$rs->username." 님 어서오세요');
        location.href='/teapot/index.php';
      </script>";
    }
  }else{
    echo "<script>
        alert('아이디 또는 암호가 일치하지 않습니다.');
        history.back();
    </script>";
    exit;
  }
 
?>