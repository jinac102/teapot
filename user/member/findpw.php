<?php
  session_start();
  $_SESSION['TITLE'] = "FINDPW";
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
  <main class="login_wrapper grid-item">
    <form
      action="changepw.php"
      method="post"
      class="form_join d-flex flex-column justify-content-center align-items-center">
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
  </main>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
