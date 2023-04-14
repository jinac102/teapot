<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/db.php";

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
      action="changepw.php"
      method="post"
      class="form_join d-flex flex-column justify-content-center align-items-center"
    >
      <h3 class="signup_tt h3 my-5 text-center">비밀번호 찾기</h3>
      <h5 class="find_tt h5 text-center">
        비밀번호는 가입시 입력하신 ID와 이메일을 통해 찾을 수 있습니다.
      </h5>
      <div class="form_login suit_bold_s">
        <label for="userid"><span>*</span>ID</label>
        <input type="text" name="userid" id="userid" placeholder="ID" />
      </div>
      <div class="form_login suit_bold_s">
        <label for="email"><span>*</span>E-mail</label>
        <input type="email" name="email" id="email" placeholder="email" />
      </div>
      <button type="submit" class="btn_login mt-5 suit_rg_s">
        비밀번호 찾기
      </button>
    </form>
  </body>
</html>
