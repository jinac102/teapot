<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/db.php";
// 입력한 정보 받아오기
$userid = $_POST["userid"];
$email = $_POST["email"];

// 데이터베이스에서 사용자 검색
$sql = "SELECT userid FROM lms_user WHERE userid = '$userid' AND email = '$email'";
$result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
$row = mysqli_fetch_assoc($result);
$userid = $row["userid"];

if(!isset($userid)){
  echo "<script>
    alert('일치하는 정보가 없습니다.');
    history.back();
  </script>";
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
      action="changepw_ok.php"
      method="post"
      class="form_changepw d-flex flex-column justify-content-center align-items-center"
    > 
      <input type="hidden" name="userid" value="<?php echo $userid ?>">
      <h3 class="signup_tt h3 my-5 text-center">비밀번호 찾기</h3>
      <h5 class="find_tt h5 text-center">
        <p class="m-0">비밀번호를 변경해주세요.</p>
        <p>
          다른 아이디나 사이트에서 사용한 적 없는 안전한 비밀번호로 변경해
          주세요.
        </p>
      </h5>
      <div class="form_login suit_bold_s">
        <label for="userpw"><span>*</span>비밀번호</label>
        <input
          type="password"
          name="userpw"
          id="userpw"
          placeholder="PASSWORD" required
        />
      </div>
      <div class="form_login suit_bold_s confirm_pw">
        <label for="userpw"><span>*</span>비밀번호 확인</label>
        <input
          type="password"
          id="confirm_pw"
          data-pass="no"
          placeholder="PASSWORD 확인" required 
        />
      </div>
      <button type="submit" class="btn_login btn_changepw mt-5 suit_rg_s">
        비밀번호 변경
      </button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
    $('.btn_signup').click(function(){
      let confirm_pw = $('#userpw').attr('data-pass');
      let confirm_pwcf = $('#confirm_pw').attr('data-pass');

      if(confirm_pwcf != 'ok'){
        alert('비밀번호 확인 체크를 해주세요');
        return false;
      }
      if(pass == 'ok' && confirm_pwcf == 'ok'){
        $('.form_changepw').submit();
      }
    });

    $('#confirm_pw').change(function(){
      if($('#userpw').val() == $('#confirm_pw').val()){
        $('#confirm_pw').attr('data-pass', 'ok');
        $('.confirm_pw').find('p').hide();
      }else{
        $('#confirm_pw').attr('data-pass', 'no');
        $('.confirm_pw').find('p').remove();
        $('.confirm_pw').append('<p>비밀번호가 일치하지 않습니다.</p>')
      }   
    });
    </script>
  </body>
</html>
