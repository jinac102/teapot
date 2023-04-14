<?php
  session_start();
  $_SESSION['TITLE'] = "JOIN";
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

  <main class="container grid-item d-flex flex-column justify-content-center g-3">
    <form
      action="join_ok.php"
      method="post"
      enctype="multipart/form-data"
      class="form_join d-flex flex-column justify-content-center align-items-center"
    >
      <h3 class="signup_tt h3 my-5 text-center">SIGN UP</h3>
      <div class="form_login suit_bold_s">
        <label for="userid"><span>*</span>아이디</label>
        <input type="text" name="userid" id="userid" placeholder="ID" data-pass="no" required />
        <button type="button" class="btn_id">ID 중복확인</button>
      </div>
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
      <div class="form_login suit_bold_s">
        <label for="username"><span>*</span>이름</label>
        <input
          type="text"
          name="username"
          id="username"
          placeholder="이름을 입력하세요" required
        />
      </div>
      <div class="form_login suit_bold_s">
        <label for="email"><span>*</span>이메일</label>
        <input
          type="email"
          name="email"
          id="email"
          placeholder="이메일을 입력하세요" required
        />
      </div>
      <div class="form_login suit_bold_s">
        <label for="userphone"><span>*</span>전화번호</label>
        <input
          type="text"
          name="userphone"
          id="userphone"
          placeholder="전화번호를 입력하세요" required
        />
      </div>
      <div class="form_login suit_bold_s">
        <label for="user_file">프로필등록</label>
        <input type="file" name="user_file" value="profile" class="profile_input">
      </div>
      <input type="hidden" name="connect_check" value="true">
      <button type="button" class="btn_login btn_signup mt-5 suit_rg_s">SIGN UP</button>
    </form>
  </main>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>

  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
    integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>
  <script>
    $('.btn_id').click(function(){
      let userid = $('#userid').val();
      console.log(userid);
      var data={
        userid : userid,
      }
      $.ajax({
        async:false,
        type:'post',
        url:'signup_check.php',
        data:data,
        dataType:'json',
        success : function(result){
          if(result.cnt > 0){
            alert('중복된 id가 있습니다, 다시 확인해주세요');
          } else{
            alert('사용가능 id입니다');
            $('#userid').attr('data-pass','ok');
          }
        }
      })
    });
    $('.btn_signup').click(function(){
      let pass = $('#userid').attr('data-pass');
      let confirm_pw = $('#userpw').attr('data-pass');
      let confirm_pwcf = $('#confirm_pw').attr('data-pass');

      if(pass != 'ok'){
        alert('id 중복 체크를 해주세요');
        return false;
      }
      if(confirm_pwcf != 'ok'){
        alert('비밀번호 확인 체크를 해주세요');
        return false;
      }
      if(pass == 'ok' && confirm_pwcf == 'ok'){
        $('.form_join').submit();
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

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
