<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
?>
<script src="https://cdn.tiny.cloud/1/gqh4ln9h6t4kj4p3sdrfytsxhn047vp3h815f6ams4i2ou8j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<link rel="stylesheet" href="../css/qna_read.css" />
</head>
<body>
  <?php
    $qidx = $_GET['qidx'];
    $sql = "SELECT * FROM lms_qna WHERE qidx='".$qidx."'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    while($rs = $result->fetch_object()){
      $rsc[]=$rs;
    }
    if(isset($rsc)){ 
      foreach($rsc as $r){
  ?>
  <div id="dashboard">
    <div class="background d-flex flex-column row">
      <div class="qna_reply">
        <h2 class="suit_bold_xl">학습 Q&A</h2>
        <div class="user_question_info">
          <div class="d-flex justify-content-between">
            <p class="classname suit_rg_m"><?php echo $r->qna_lecture;?></p>
            <p class="reply_status suit_rg_m">답변대기</p>
          </div>
          <p class="question_title suit_rg_l"><?php echo $r->qna_title;?></p>
          <div class="reply_info_border">
            <div
              class="reply_info suit_rg_m d-flex align-items-center justify-content-between"
            >
              <div class="d-flex align-items-center gap-5">
                <?php if($rs->user_file == ''){ ?>
                  <img id="profile_admin" src="../img/pabcon.png"/>
                <?php }else{ ?>
                  <img src="<?php echo $rs->user_file?>" alt="" class="adminphoto"/>
                <?php } ?>
                <p class="userid"><?php echo $r->userid;?></p>
              </div>
              <p class="date"><?php echo $r->regdate;?></p>
            </div>
          </div>
        </div>
        <div class="user_question">
          <p class="suit_rg_m">
            <?php echo $r->qna_text;?>
          </p>
        </div>
        <div class="admin_aswer_form">
          <div class="reply_admin_section">
            <div class="admin_reply_title d-flex gap-5 align-items-center">
              <?php if($rs->user_file == ''){ ?>
                <img id="profile_admin" src="../img/pabcon.png"/>
              <?php }else{ ?>
                <img src="<?php echo $rs->user_file?>" alt="" class="adminphoto"/>
              <?php } ?>
              <div class="admin_info">
                <p class="adminid suit_rg_l">관리자</p>
                <p class="date suit_rg_m"><?php echo $r->regdate;?></p>
              </div>
            </div>
            <form action="qna_modify_ok.php?qidx=<?php echo $r->qidx;?>" method="post" onsubmit="return save();" class="tiny">
            <div class="tiny_library"> 
              <input type="hidden" name="qidx" value="<?php echo $qidx; ?>" >
                <textarea id="mytextarea" name="qna_reply"><?php echo $r->qna_reply;?></textarea>
            </div>
            <div class="qna_btn d-flex gap-4 justify-content-end">
              <button type="submit" class="upload btn_s" onclick="location.href='qna_read.php'">등록</button>
              <button type="button" class="cancel btn_s" onclick="location.href='qna_read.php'">취소</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    <?php } } ?>
    <script src="../js/qna.js"></script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php";
?>
