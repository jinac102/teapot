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
  echo "<script>
  alert('일치하는 정보가 없습니다.');
  history.back();
  </script>";
}

?>
<?php
  session_start();
  $_SESSION['TITLE'] = "FINDID";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/css/login.css" />

<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>
  <form
    action="../findpw_ok.php"
    method="post"
    class="form_join d-flex flex-column justify-content-center align-items-center">
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
      <a href="./findpw.php"  class="btn_login_s mt-5 suit_rg_s d-flex justify-content-center align-items-center">비밀번호 찾기</a>
    </div>
  </form>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>