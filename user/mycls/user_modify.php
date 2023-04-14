<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";
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
                  <img src="../img/pabcon.png" style="width:95px; hight:95px;"/>
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
            <a href="http://tgif.dothome.co.kr/teapot/user/mycls/user_modify.php"
              ><i class="fa-solid fa-gear"></i>설정</a
            >
          </li>
        </ul>
      </aside>
      <div>
        <section id="setting" class="content_my p_200">
          <form action="setting_join.php" method="post" enctype="multipart/form-data" novalidate class="form_join">
            <input type="hidden" name="uidx" value="<?php echo $rs->uidx;?>">
            <div>
                <div class="form_set">
                  
                  <?php
                    if($rs->user_file == ''){
                  ?>
                  <div class="profileimg">
                    <img class="profile" src="../img/pabcon.png" style="width:95px; hight:95px;"/>
                  </div>
                  <?php
                  }else{
                  ?>
                  <div class="profileimg">
                    <img class="profile" src="<?php echo $rs->user_file?>" style="width:95px; hight:95px;"/>
                  </div>
                    <?php
                    }
                    ?>

                  <input id="file-input" type="file" name="upfile" value="<?php echo $ms->user_file;?>"/>
                  <div class="form_max">
                  <div class="form">
                      <div class="label_box">
                        <label for="userid">아이디</label>
                      </div>
                      <div class="input_box">
                        <input
                          type="text"
                          name="userid"
                          id="userid"
                          value="<?php echo $rs->userid;?>" placeholder="<?php echo $rs->userid;?>"
                          data-pass="no"
                          readonly
                        />
                      </div>
                      <!-- <div class="add_btn">
                        <button type="button" class="btn_id"  >중복체크</button>
                      </div> -->
                    </div>
                    <div class="form">
                      <div class="label_box">
                        <label for="username">이름</label>
                      </div>
                      <div class="input_box">
                        <input
                          type="text"
                          name="username"
                          id="username"
                          autocomplete="off"
                          value="<?php echo $rs->username;?>" placeholder="<?php echo $rs->username;?>"
                        />
                      </div>
                    </div>
                    <div class="form">
                      <div class="label_box">
                        <label for="useremail">이메일</label>
                      </div>
                      <div class="input_box">
                        <input
                          type="text"
                          name="useremail"
                          id="user_email"
                          autocomplete="off"
                          value="<?php echo $rs->email;?>" placeholder="<?php echo $rs->email;?>"
                        />
                      </div>
                      <span class="email_check">*이메일 형식으로 작성해주세요.</span>
                    </div>
                    <div class="form">
                      <div class="label_box">
                        <label for="userphone">전화번호</label>
                      </div>
                      <div class="input_box">
                        <input
                          type="text"
                          name="userphone"
                          id="user_phone"
                          autocomplete="off"
                          value="<?php echo $rs->userphone;?>" placeholder="<?php echo $rs->userphone;?>"
                        />
                      </div>
                      <span class="phon_check">*전화번호 형식으로 작성해주세요.</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="p-3">
                <input style="margin-left:10px;"  type="button" id="correction" class="correction" value="취소" onClick="location.href='./user_setting.php'">
                <input type="submit" id="correction" class="correction" value="수정">
              </div>
            </div>
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


       $('.email_check').hide();
       $('.phon_check').hide();
      $('aside li').click(function(e){
        $('aside li').find('i').removeClass('active');
        $(this).find('i').addClass('active');
      });
    //이메일 정규식 체크
    $("#user_email").change(function(){
      var email = $("#user_email").val();
      email_check(email);
      console.log(email_check(email));
      function email_check(email) {
        var reg = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
        // return reg.test(email);
        console.log(reg.test(email));
       
        if(reg.test(email) == false){
          $('.email_check').show();
        }else{
          $('.email_check').hide();
        }
      }
    });
    //전화번호 정규식 체크
    $("#user_phone").change(function(){
      var phone = $("#user_phone").val();
      phone_check(phone);
      console.log(email_check(phone));
      function phone_check(phone) {
        var reg = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
        // return reg.test(email);
        console.log(reg.test(phone));
       
        if(reg.test(phone) == false){
          $('.phon_check').show();
        }else{
          $('.phon_check').hide();
        }
      }
    });
      
//이미지 값 바꾸기
let profileImg; 
$('#file-input').change(function(e){
  var files = e.originalEvent.target.files; // Works fine
  console.log(files);
  preview(files[0]);
  profileImg = files[0];
})


function preview(file) {
        var reader = new FileReader();
        reader.onload = (function (f) {
            return function (e) {
              $(".profile").attr('src', e.target.result);

              console.log(e.target.result);
            };
        })(file);
        reader.readAsDataURL(file);
    }


    $("#correction").click(function(){
      // let pass = $('#user_id').attr('data-pass');
      // console.log(pass);
      // if(pass != 'ok'){
      //   alert('id 중복 체크를 해주세요');
      // }else{
      //   $('.form_join').submit();
      // }
     
      let userid = $('#userid').val();
      let userphone = $('#user_phone').val();
      let useremail = $('#user_email').val();
      let username = $('#username').val();
    
    })



    
    
    // let closebutton = $('.close-area');
    //   closeDialogBtn.addEventListener('click',()=>{
    //     dialog.removeAttribute('open');
    //   });
    
  

    
    </script>
    <?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script></script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
