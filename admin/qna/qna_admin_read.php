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
?>
<script src="https://cdn.tiny.cloud/1/gqh4ln9h6t4kj4p3sdrfytsxhn047vp3h815f6ams4i2ou8j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<link rel="stylesheet" href="../css/qna_read.css" />
</head>
  <body>
    <?php
      $qidx = $_GET['qidx'];
      $now = new DateTime();
      $today = DATE_FORMAT($now,'Y-m-d');
      // $date = date('Y-m-d');
      // $sql = "UPDATE lms_qna SET regdate = '".$date."' where qidx=".$qidx;
      $sql = "SELECT * FROM lms_qna WHERE qidx='".$qidx."'";
      $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
      $qr = $result->fetch_object();
      // while($rs = $result->fetch_object()){
      //   $rsc[]=$rs;
      // }
      // if(isset($rsc)){ 
      //   foreach($rsc as $r){
    ?>
    <div id="dashboard">
      <div class="background d-flex flex-column row">
        <div class="qna_check">
          <h2 class="suit_bold_xl">학습 Q&A</h2>
          <div class="user_question_info">
            <div class="d-flex justify-content-between">
              <p class="classname suit_rg_m"><?php echo $qr->qna_lecture;?></p>
              <?php if($qr->reply_st == 0){ ?>
                <div class="reply_status answer_wait suit_rg_m">답변대기</div>
              <?php }else{ ?>
                <div class="reply_status answer_complete suit_rg_m">답변완료</div>
              <?php } ?>
            </div>
            <p class="question_title suit_rg_l"><?php echo $qr->qna_title;?></p>
            <div class="reply_info_border">
              <div
                class="reply_info suit_rg_m d-flex align-self-center align-items-center justify-content-between"
              >
                <div class="d-flex align-items-center gap-4">
                  <?php if($rs->user_file == ''){ ?>
                      <img id="profile" src="../img/pabcon.png"/>
                  <?php }else{ ?>
                      <img src="<?php echo $rs->user_file?>" alt="" class="userphoto"/>
                  <?php } ?>
                  <p class="userid"><?php echo $qr->userid;?></p>
                </div>
                <p class="date"><?php echo $qr->regdate;?></p>
              </div>
            </div>
          </div>
          <div class="user_question">
            <p class="suit_rg_m">
              <?php echo $qr->qna_text;?>
            </p>
          </div>
          <div class="admin_aswer_form">
            <div class="reply_admin_section">
              <div class="admin_reply_title d-flex gap-4 align-items-center">
                <?php if($rs->user_file == ''){ ?>
                    <img id="profile_admin" src="../img/pabcon.png"/>
                <?php }else{ ?>
                    <img src="<?php echo $rs->user_file?>" alt="" class="adminphoto"/>
                <?php } ?>  
                <div class="admin_info">
                  <p class="adminid suit_rg_l">관리자<?php echo $rs->userid;?></p>
                  <p class="date suit_rg_m"><?php echo $today;?></p>
                </div>
              </div>
              <!-- if구문 -->
              <?php if($qr->reply_st == 0){ ?> <!-- 답변의 상태가 0이라면(답변대기) -->

                <div class="reply_status answer_wait">
                  <form action="qna_reply_ok.php" method="post" onsubmit="return save();" class="tiny">
                    <div class="tiny_library d-flex align-items-center justify-content-center"> 
                      <input type="hidden" name="qidx" value="<?php echo $qidx; ?>">
                      <textarea id="mytextarea" name="qna_reply"></textarea>
                    </div>
                    <div class="qna_btn d-flex gap-4 justify-content-end">
                      <button type="submit" class="upload btn_s" name="upload" onclick="location.href='qna_read.php'">등록</button>
                      <button type="button" class="cancel btn_s" onclick="location.href='qna_list.php'">취소</button>
                    </div>
                  </form>
                </div>

              <?php }else if($qr->reply_st == 1){ ?> <!-- 답변의 상태가 1이라면(답변완료) -->
                

                <div class="reply_status answer_complete">
                  <div class="reply suit_rg_m">
                    <?php echo $qr->qna_reply;?>
                  </div>
                  <div class="qna_btn d-flex gap-4 justify-content-end">
                    <button type="submit" class="list btn_s" onclick="location.href='qna_list.php'">목록</button>
                    <button type="submit" class="modify btn_s" onclick="location.href='qna_modify.php?qidx=<?php echo $qr->qidx;?>'">수정</button>
                    <button type="button" class="delete btn_s" onclick="location.href='qna_reply_del.php?qidx=<?php echo $qr->qidx;?>'">삭제</button>
                  </div>
                </div>

              <?php } ?>
              <!-- //if구문 -->
            </div>
          </div>
        </div>
      </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="../js/qna.js"></script>
  </body>
</html>
