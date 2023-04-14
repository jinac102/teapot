<?php
  session_start();
  $_SESSION['TITLE'] = "학습Q&A 수정";
  $uid = $_SESSION['UID'];
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/qna/qna_list.css" />
<link rel="stylesheet" href="../css/qna/qna_read.css" />
<script src="https://cdn.tiny.cloud/1/gqh4ln9h6t4kj4p3sdrfytsxhn047vp3h815f6ams4i2ou8j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>


  <main>
    <div class="banner">
      <div class="title content_container d-flex justify-content-between align-items-center">
          <div class="desc">
            <h2 class="suit_bold_xl">학습 Q&amp;A</h2>
            <p class="suit_rg_m">학습 관련한 궁금한 점은 무엇이든 물어보세요! Teapot이
        해결해드립니다.</p>
          </div>
          <div class="img">
            <img src="../img/qna/Question_banner.png" alt="question_mark" />
          </div>
      </div>
    </div>
    <?php
        //qna 정보 
        $qidx = $_GET['qidx'];
        $now = new DateTime();
        $today = DATE_FORMAT($now,'Y-m-d');
        $date = date('Y-m-d');
    
        $sql = "SELECT * FROM lms_qna WHERE qidx='".$qidx."'";
        $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
        $r = $result->fetch_object();


        //유저정보
        $sqluser = "SELECT * FROM lms_user WHERE userid='".$uid."'";
        $userresult = $mysqli -> query($sqluser) or die("query error => ".$mysqli->error);
        $rsuser = $userresult ->fetch_object();
    ?>
    <div class="user_question_info qna_container">
      <div class="user_info">
        <div class="d-flex justify-content-between suit_rg_s">
          <p class="class_name"><?php echo $r->qna_lecture;?></p>
          <p class="answered">답변완료</p>
        </div>
        <p class="question_title suit_bold_m"><?php echo $r->qna_title;?></p>
        <div class="user d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center suit_rg_s user_profile_name">
          <?php
          if($_SESSION['UID'] == $rsuser->userid){
          ?>
            <div>
              <img src='<?php echo $rsuser->user_file; ?>' alt="profile" />
            </div>
            <p class="username"><?php echo $rsuser->userid;?></p>
          <?php } ?>
          </div>
          <p class="write_date"><?php echo $r->regdate;?></p>
        </div>
      </div>
      <div>
        <!-- tiny library -->
        <form action="qna_modify_ok.php?qidx=<?php echo $r->qidx;?>" method="post" onsubmit="return save();" class="tiny">
          <div class="tiny_library"> 
            <input type="hidden" name="qidx" value="<?php echo $qidx;?>" >
            <textarea id="mytextarea" name="qna_text"><?php echo $r->qna_text;?></textarea>
          </div>
          <div class="qna_btn qna_container d-flex justify-content-end gap-3">
            <button type="submit" class="qna_btn_s_b check suit_rg_s" onclick="location.href='qna_read.php'">등록</button>
            <button type="button"class="btn_s_b cancle suit_rg_s" onclick="location.href='qna_read.php'">취소</button>
          </div>
        </form>
        <!-- //tiny library -->
      </div>
    </div>
  </main>


<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script src="../js/qna.js"></script>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
 ?>
  </body>
</html>
