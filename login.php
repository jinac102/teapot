<?php
  session_start();
  $_SESSION['TITLE'] = "LOGIN";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="user/css/login.css" />

<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>

  <main class="login_wrapper grid-item mt-5">
    <div class="login_content d-flex align-item-center justify-content-center">
      <div class="login_down d-flex">
        <div class="login_left d-flex justify-content-center">
          <form
            action="login_ok.php"
            method="post"
            class="form_login d-flex flex-column justify-content-center align-items-center"
          >
            <h3 class="login_tt h3 suit_bold_xl">LOGIN</h3>
            <div class="form_login my-3">
              <input
                type="text"
                name="userid"
                id="userid"
                placeholder="ID"
              />
            </div>
            <div class="form_login my-3">
              <input
                type="password"
                name="userpw"
                id="userpw"
                placeholder="PASSWORD"
              />
            </div>
            <ul class="find_wrap m-3">
              <li>
                <a href="/teapot/user/member/findid.php" class="find_text mx-3">ID 찾기</a>
              </li>
              <li>
                <a href="/teapot/user/member/findpw.php" class="find_text mx-3"
                  >Password 찾기</a
                >
              </li>
              <li>
                <a href="/teapot/user/member/join.php" class="find_text mx-3">회원가입</a>
              </li>
            </ul>
            <button type="submit" class="btn_login suit_rg_s">LOG IN</button>
          </form>
        </div>
        <aside
          class="login_right d-flex justify-content-center align-items-center"
        >
        </aside>
      </div>
    </div>
  </main>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/js/login.js"></script>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>