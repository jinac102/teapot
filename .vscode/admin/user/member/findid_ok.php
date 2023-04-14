<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/db.php";
// 입력한 정보 받아오기
$username = $_POST["username"];
$email = $_POST["email"];

// 데이터베이스에서 일치하는 사용자 찾기
$sql = "SELECT userid FROM lms_user WHERE username = '$username' AND email = '$email'";
$result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
$row = mysqli_fetch_assoc($result);
$userid = $row["userid"];

// 일치하는 사용자가 있을 경우
if (isset($row)) {
  // echo "ID는 " . $userid . "입니다.";

} else {
  echo "일치하는 사용자가 없습니다.";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TEAPOT</title>
    <link rel="icon" href="../img/pabcon.png" />
    <link rel="stylesheet" href="../css/reset.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
      integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../css/common.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <link
      href="https://cdn.jsdelivr.net/gh/sunn-us/SUIT/fonts/static/woff2/SUIT.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <form
      action="../findpw_ok.php"
      method="post"
      class="form_join d-flex flex-column justify-content-center align-items-center"
    >
      <h3 class="signup_tt h3 my-5 text-center">ID 찾기</h3>
      <h5 class="find_tt h5 text-center">
        고객님의 정보와 일치하는 ID 목록입니다.
      </h5>
      <div class="form_login suit_bold_s">
        <!-- <label for="userid">ID</label> -->
        <span>ID : " <?php echo $userid ?> " 입니다.</span>
      </div>
      <div class="btns_login d-flex">
        <a href="../../login.php"  class="btn_login_s mt-5 suit_rg_s d-flex justify-content-center align-items-center">LOGIN</a>
        <button type="button" class="btn_login_s mt-5 suit_rg_s">
          비밀번호 찾기
        </button>
      </div>
    </form>
  </body>
</html>
