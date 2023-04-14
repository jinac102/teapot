<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";


  include $_SERVER["DOCUMENT_ROOT"]."/teapot/user/mycls/my_page_all.php";
?>
    <link rel="stylesheet" href="../css/my_class.css" />
    <!-- 마이페이지 환영 문구 -->
    <div id="user_profile">
      <div class="bg">
        <div class="mypage d-flex align-items-center justify-content-between">
          <div class="profile d-flex">
            <div class="profile_werp">
            <?php
                  if($rs->user_file == ''){
                ?>
                <div class="profileimg">
                  <img id="profile" src="../img/pabcon.png" style="width:95px; hight:95px;"/>
                </div>
                <?php
                }else{
                ?>
                <div class="profileimg">
                  <img src="<?php echo $rs->user_file?>" />
                </div>
                  <?php
                  }
                  ?>
            </div>
            <div class="profile_title">
              <h2><span class="suit_bold_l"><?php echo $rs->username?></span> 님</h2>
              <p>오늘도 티팟과 함께 화이팅!!</p>
            </div>
          </div>
          <div class="d-flex class_setting">
            <div class="cl_st">
              <div class="icon_text">
                <div class="icon"><i class="fa-solid fa-book-open"></i></div>
                <p>클래스 수강</p>
                <p><?php echo $cls->ct?></p>
              </div>
            </div>
            <div class="cl_st">
              <div class="icon_text">
                <div class="icon"><i class="fa-solid fa-q"></i></div>
                <p>질문</p>
                <p><?php echo $ans->ct?></p>
              </div>
            </div>
            <div class="cl_st">
              <div class="icon_text">
                <div class="icon"><i class="fa-solid fa-heart"></i></div>
                <p>좋아요</p>
                <p><?php echo $like->cnt?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <main class="d-flex align-items-start justify-content-center">
      <aside style="padding-top: 200px">
        <ul class="side_menu font_m">
          <li class="page"><a href="./user_my_page.php">My Page</a></li>
          <li>
            <a href="./my_class.php"
              ><i class="fa-solid fa-book-open-reader"></i>나의 클래스</a
            >
          </li>
          <li>
            <a href="./user_like.php"
              ><i class="fa-solid fa-heart"></i>좋아요</a
            >
          </li>
          <li>
            <a href="./user_ answer.php"
              ><i class="fa-regular fa-circle-question"></i>Q&A</a
            >
          </li>
          <li>
            <a href="http://tgif.dothome.co.kr/teapot/user/mycls/user_setting.php"
              ><i class="fa-solid fa-gear"></i>설정</a
            >
          </li>
        </ul>
      </aside>
      <div>
        <section id="setting" class="content_my p_200">
          <form action="./user_modify.php">
            <div>
              <input
                type="button"
                action=""
                class="correction"
                id="block"
                value="회원탈퇴"
                onclick="location.href='../../login.php'"
              />
              <div class="form_set">
                <div class="profileimg">
                <?php
                  if($rs->user_file == ''){
                ?>
                <img id="profile" src="../img/pabcon.png" style="width:95px; hight:95px;"/>
                <?php
                }else{
                ?>
                  <img src="<?php echo $rs->user_file?>" />
                  <?php
                  }
                  ?>
                </div>
                <div class="input_box">
                  <label for="">아이디</label>
                  <input type="text" disabled value="<?php echo $rs->userid;?>" placeholder="<?php echo$rs->userid;?>"/>
                </div>
                <div class="input_box">
                  <label for="">이름</label>
                  <input type="text" disabled value="<?php echo $rs->username;?>" placeholder="<?php echo $rs->username;?>" />
                </div>
                <div class="input_box">
                  <label for="">이메일</label>
                  <input type="text" disabled value="<?php echo $rs->email;?>" placeholder="<?php echo $rs->email;?>"/>
                </div>
                <div class="input_box">
                  <label for="">전화번호</label>
                  <input type="text" disabled value="<?php echo $rs->userphone;?>" placeholder="<?php echo $rs->userphone;?>"/>
                </div>
              </div>
              <input type="button" action=""  onClick="location.href='./user_modify.php'" class="correction" value="수정" />
            </div>
          </form>
        </section>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
      crossorigin="anonymous"
    ></script>
    <script>
     var currentUrl = window.location.href;
      console.log(currentUrl);

      $('.side_menu a').each(function() {
        var linkUrl = $(this).attr('href');
        console.log(linkUrl == currentUrl);
        if (currentUrl === linkUrl) {
          $('i', this).addClass('active');
        }
      });

    $('.side_menu a').click(function(e) {
      // e.preventDefault();
      $('i', this).addClass('active');
      setTimeout(function() { // 'active' 클래스를 추가한 뒤 페이지 이동
        window.location.href = $(e.currentTarget).attr('href');
      }, 200);
    });

      //탈퇴
      // $('#block').click(function(){
      //   let userval = $('#block').val();
      //   console.log(userval);
      //   var data={
      //     userval : userval,
      //   }
      //   console.log(data);
      //   $.ajax({
      //       async : false,
      //       url: 'user_block.php',
      //       cache: false,
      //       contentType: false,
      //       processData: false,
      //       data: data,
      //       type: 'post',
      //       // dataType: 'json',
      //       beforeSend: function () {}, //product_save_image.php 응답하기전 할일
      //       error: function () {
      //         alert('실패');
      //       }, //product_save_image.php 없으면 할일
      //       success: function (return_data) { //product_save_image.php 유무
      //           console.log(return_data);
      //           //관리자 유무, 어드민아니면 로그인메시지
      //          if (return_data.result == "error") {
      //               alert('첨부실패, 관리자에게 문의하세요');
      //               return;
      //           } else {
      //             $('#modal').css('display', 'block');
      //           }
      //       }
      //   });
      // })
    </script>
    <?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script></script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
