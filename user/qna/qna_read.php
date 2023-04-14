<?php
  session_start();
  $_SESSION['TITLE'] = "학습Q&A 질문확인";
  $uid = $_SESSION['UID'];
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/qna/qna_list.css" />
<link rel="stylesheet" href="../css/qna/qna_read.css" />
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
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
    // 관리자 정보 가져오기
    $sql = "SELECT * from lms_user where super=1";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    $rs = $result->fetch_object();

    //유저 정보 가져오기
    $sqlcut = "SELECT count(*) as cnt from lms_user where super=0";
    $countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
    $rscnt = $countresult ->fetch_object();

    $sqluser = "SELECT * FROM lms_user WHERE userid='".$uid."'";
    $userresult = $mysqli -> query($sqluser) or die("query error => ".$mysqli->error);
    $rsuser = $userresult ->fetch_object();

    //qna 정보 
    $qidx = $_GET['qidx'];
    $prev_qidx = $qidx-1;
    $next_qidx = $qidx+1;
    $qidx = $_GET['qidx'];
    $now = new DateTime();
    $today = DATE_FORMAT($now,'Y-m-d');
    $date = date('Y-m-d');

    $sql = "SELECT * FROM lms_qna WHERE qidx='".$qidx."'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    $r = $result->fetch_object();

    $newhit = $r->qna_hit + 1;
    $sql = "UPDATE lms_qna set qna_hit = '{$newhit}' where qidx='{$qidx}'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error); 

    $sql1 = "SELECT qidx FROM lms_qna ORDER BY qidx desc";
    $result1 = $mysqli->query($sql1) or die("query error => ".$mysqli->error);
    while($rs1 = $result1->fetch_assoc()){
        $rsc1[]=$rs1;
    }
  
    foreach($rsc1 as $rs){
      $rsc[]=$rs['qidx'];
    }

    $qna_current_idx = array_search($qidx,$rsc);
    $prev_qidx = $rsc[$qna_current_idx+1];
    $next_qidx = $rsc[$qna_current_idx-1];
    
  ?>
  <div class="user_question_info qna_container">
    <div class="user_info">
      <div class="d-flex justify-content-between suit_rg_s">
        <p class="class_name"><?php echo $r->qna_lecture;?></p>
        <?php if($r->reply_st == 0){ ?>
          <p class="unanswered">답변대기</p>
        <?php }else{ ?>
          <p class="answered">답변완료</p>
        <?php } ?>
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
    <p class="user_question suit_rg_s">
      <?php echo $r->qna_text;?>
    </p>
  </div>
    <!-- if구문 -->
    <?php if($r->reply_st == 1){ ?><!-- if(답변완료라면, 답변의 상태가 1이라면) -->
      <div class="admin_reply_section qna_container">
        <div class="admin_info d-flex align-items-center">
          <div class="profile_admin">
            <?php if($r->user_file == ''){ ?>
                <img id="profile_admin" src="../img/pabcon.png"/>
            <?php }else{ ?>
                <img src="<?php echo $rsuser->user_file; ?>" alt="" class="adminphoto"/>
            <?php } ?>
          </div>
          <div>
            <p class="admin_id suit_rg_s">teapot<?php echo $rs->userid;?></p>
            <p class="write_date suit_rg_xs"><?php echo $r->regdate;?></p>
          </div>
        </div>
        <div class="admin_reply">
          <p class="suit_rg_xs">
            <?php echo $r->qna_reply;?>
          </p>
        </div>
      </div>
      <div class="recommend qna_container suit_rg_s d-flex justify-content-end align-items-center gap-2">
        <?php
        $qrsql = "SELECT count(*) AS cnt from lms_qna_recommend where qr_qidx='{$qidx}' and uid='{$uid}'";
        $qr_result = $mysqli->query($qrsql) or die("query_error" . $mysqli->error);
        $qr_r = $qr_result->fetch_object();
        $cnt = $qr_r->cnt
        ?>

        <button type="button" onclick="recommend()" class="d-flex gap-2 align-items-center" id="recom_btn">
            <i class="fa-regular fa-heart" style="color: #ff534b;"></i>
            <p class="suit_rg_s">추천</p>
            <p class="hit_number hit_recom"><?php echo $r->qna_recom;?></p>
        </button>

        <div class="view suit_rg_s d-flex gap-2">
          <p class="hit_title">조회수</p>
          <p class="hit_number"><?php echo $r->qna_hit;?></p>
        </div>
      </div>
      <div class="btns d-flex justify-content-center align-items-center"> <!-- 이전, 목록, 다음 버튼 -->
      <?php
          if(isset($prev_qidx)){
              echo "<a href='qna_read.php?qidx=$prev_qidx' class='prev_btn suit_rg_s'>
              <i class='fa-solid fa-chevron-left'></i>
              이전
            </a>";
          }
        ?>
          <button class="btn_l_b suit_rg_m" onclick="location.href='qna_list.php'">목록보기</button>
        <?php
          if(isset($next_qidx)){
              echo "<a href='qna_read.php?qidx=$next_qidx' class='next_btn suit_rg_s'>
              다음
              <i class='fa-solid fa-chevron-right'></i>
            </a>";
          }
        ?>
      </div>
    <?php }else if($r->reply_st == 0){ ?><!-- else(답변대기라면, 답변의 상태가 0이라면) -->
      <div class="recommend qna_container suit_rg_s d-flex justify-content-end align-items-center gap-2">
        <button type="button" onclick="recommend()" class="d-flex gap-2 align-items-center" id="recom_btn">
            <i class="fa-regular fa-heart" style="color: #ff534b;"></i>
            <p class="suit_rg_s">추천</p>
            <p class="hit_number hit_recom"><?php echo $r->qna_recom;?></p>
        </button>

        <div class="view suit_rg_s d-flex gap-2">
          <p class="hit_title">조회수</p>
          <p class="hit_number"><?php echo $r->qna_hit;?></p>
        </div>
      </div>

      <?php
          if($_SESSION['UID'] == $rsuser->userid){
      ?>
        <div class="unanswered_btns qna_container d-flex justify-content-end gap-3">
          <button class="qna_btn_s_b suit_rg_s" onclick="location.href='qna_list.php'">목록</button>
          <button class="btn_s_b suit_rg_s" onclick="location.href='qna_modify.php?qidx=<?php echo $r->qidx;?>'">수정</button>
          <button class="btn_s_b suit_rg_s"onclick="location.href='qna_delete.php?qidx=<?php echo $r->qidx;?>'">삭제</button>
        </div>
      <?php } ?>

      <!-- <div class="unanswered_btns qna_container d-flex justify-content-end gap-3">
        <button class="qna_btn_s_b suit_rg_s" onclick="location.href='qna_list.php'">목록</button>
        <button class="btn_s_b suit_rg_s" onclick="location.href='qna_modify.php?qidx=<?php echo $r->qidx;?>'">수정</button>
        <button class="btn_s_b suit_rg_s"onclick="location.href='qna_delete.php?qidx=<?php echo $r->qidx;?>'">삭제</button>
      </div> -->
      <div class="btns d-flex justify-content-center align-items-center"> <!-- 이전, 목록, 다음 버튼 -->
        <?php
          if(isset($prev_qidx)){
              echo "<a href='qna_read.php?qidx=$prev_qidx' class='prev_btn suit_rg_s'>
              <i class='fa-solid fa-chevron-left'></i>
              이전
            </a>";
          }
        ?>
          <button class="btn_l_b suit_rg_m" onclick="location.href='qna_list.php'">목록보기</button>
        <?php
          if(isset($next_qidx)){
              echo "<a href='qna_read.php?qidx=$next_qidx' class='next_btn suit_rg_s'>
              다음
              <i class='fa-solid fa-chevron-right'></i>
            </a>";
          }
        ?>
    <?php } ?>
</main>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="../js/qna.js"></script>
<?php
      $sql = "SELECT count(*) AS cnt from lms_qna_recommend where qr_qidx='{$qidx}' and uid='{$uid}'";
      $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
      $r = $result->fetch_object();

      if($r->cnt>0){
        echo "<script>$('#recom_btn').addClass('full_heart');</script>";
      }
?>
<script>
  function recommend(){
    if($('#recom_btn').hasClass('full_heart')){
      let data = {
      qidx:<?php echo $qidx ?>,
      uid:'<?php echo $uid ?>'
      } 
        $.ajax({
          async:false,
          type:'post',
          url:'qna_unrecommend.php',
          data:data,
          dataType:'json',
          error:function(){
              console.log('error');
          },
          success:function(result){    
            console.log(result);          
              if(result.result =='ok'){
                  alert("추천이 취소 되었습니다.");
                  $('.hit_recom').text(result.recommend);
                  $('.fa-heart').removeClass('fa-solid').addClass('fa-regular');
                  $('#recom_btn').removeClass('full_heart');
              }
          }
      });
    }else{
      let data = {
        qidx:<?php echo $qidx ?>,
        uid:'<?php echo $uid ?>'
      } 
        $.ajax({
          async:false,
          type:'post',
          url:'qna_recommend.php',
          data:data,
          dataType:'json',
          error:function(){
              console.log('error');
          },
          success:function(result){    
            console.log(result);          
              if(result.result =='ok'){
                  alert("추천되었습니다.");
                  $('.hit_recom').text(result.recommend);
                  $('.fa-heart').removeClass('fa-regular').addClass('fa-solid');
                  $('#recom_btn').addClass('full_heart');
              }
          }
      });
    }
  }
</script> 
<?php
    $qrsql = "SELECT count(*) AS cnt from lms_qna_recommend where qr_qidx='{$qidx}' and uid='{$uid}'";
    $qr_result = $mysqli->query($qrsql) or die("query_error" . $mysqli->error);
    $qr_r = $qr_result->fetch_object();
    $cnt = $qr_r->cnt;

    if($cnt != 0){
        echo "<script>
        $('#recom_btn i').removeClass('fa-regular');
        $('#recom_btn i').addClass('fa-solid');
        </script>";
    }else{
      echo "<script>
      $('#recom_btn i').removeClass('fa-solid');
      $('#recom_btn i').addClass('fa-regular');
      </script>";
    }
  ?>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
 ?>

  </body>
</html>
