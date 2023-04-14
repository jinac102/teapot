<?php
    session_start();
    if(!$_SESSION['UID']){
        echo "<script>
            alert('로그인 후 이용 가능합니다.');
            location.href='../../login.php'
        </script>";
    };
   
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";

?>
    <link rel="stylesheet" href="../css/my_class.css" />
<?php
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/user/mycls/my_page_all.php";

  //유저 좋아요 정보 + 클래스 정보 가져오기
    $userid = $_SESSION['UID'];
    // $sql = "SELECT lc.* from lms_lec lc join lms_favorite lf where lf.fv_uid='$userid'";
    $sql = "SELECT lc.* from lms_class lc join lms_favorite lf on lf.fv_clsnum=lc.clidx where lf.fv_uid='$userid' order by regdate desc limit 0,4";
    $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
    // $ls = $result -> fetch_object();
    while($ls = $result->fetch_object()){
      $rsc[]=$ls;
    }

 //Q&A
 $sqlanswer = "SELECT * from lms_qna where userid='$username'order by regdate desc limit 0,7";
 $result = $mysqli -> query($sqlanswer) or die("query error =>".$mysqli->error);
 while($an = $result->fetch_object()){
   $anw[]=$an;
 }

  //유저 장바구니 정보 + 클래스 정보 가져오기
  $sqlclass = "SELECT lc.* from lms_class lc join lms_sold ls on ls.sold_clidx=lc.clidx where ls.sold_uidx='$userid' order by regdate desc limit 0,3";
  $result = $mysqli -> query($sqlclass) or die("query error =>".$mysqli->error);
  $clss = array();
  while($ls = $result->fetch_object()){
    $clss[] = $ls;
  }
?>
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
      <aside style="padding-top:200px;">
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
            <a href="./user_setting.php"
              ><i class="fa-solid fa-gear"></i>설정</a
            >
          </li>
        </ul>
      </aside>
      <!-- 나의 클래스 -->
      <div class="grid">
        <section id="user_cls">
          <div class="d-flex justify-content-between">
            <h3 class="font_ml">나의 클래스</h3>
            <?php if($clss == ''){?>
            <a href="../class/class_list.php" class="btn">클래스 가기</a>
            <?php }else{?>
              <a href="./my_class.php" class="btn">+ 더보기</a>
            <?php }?>
          </div>
          <div>
          <?php if($clss == ''){?>
            <div class="d-flex justify-content-center">
            <p>강의 목록이 없습니다.</p>
            </div>
        <?php }else{?>
            <?php
              foreach($clss as $s){
            ?>
            <div class="card">
              <div class="img_wrap">
                <a href="/teapot/user/lec/classroom.php?clidx=<?php echo $s->clidx?>"><img src="<?php echo $s->thumb_url?>" class="card-img-top" alt="..." /></a>
              </div>
              <div
                class="card-body d-flex justify-content-between align-items-center"
              >
                <p class="card-texts suit_rg_xs p-0">
                <?= $s->cls_title;?>
                </p>
                <?php if($s->sold_complet == 0){?>
                <div class="cls_bt"><span>대기중</span></div>
                <?php }else{?>
                  <div class="cls_bt"><span>완료</span></div>
                  <?php }?>
              </div>
            </div>
            <?php } }?>
          </div>
        </section>
        <!-- //나의 클래스 -->
        <!-- 좋아요 -->
        <section id="user_like" class="content_my p_200">
          <div class="d-flex justify-content-between">
            <h3 class="font_ml">좋아요</h3>
            <?php if($rsc == ''){?>
              <a href="../class/class_list.php" class="btn">클래스 가기</a>
              <?php }else{?>
                <a href="./user_like.php" class="btn">+ 더보기</a>
              <?php }?>
          </div>
          <?php if($rsc == ''){?>
            <div class="d-flex justify-content-center">
            <p>좋아요 목록이 없습니다.</p>
            </div>
            <?php }else{?>
          <div class="d-flex justify-content-between">
          <?php
              foreach($rsc as $r){
                // print_r($rsca);
                // foreach($rsca as $c){

            ?>
            <div class="card">
              <span> <i class="fa-solid fa-heart"></i></span>
              <img src="<?php echo $r-> thumb_url?>" class="card-img-top" alt="..." />
              <div class="card-body">
                <?php if($r->cls_price == 0){?>
                <div class="free">
                  <p class="card-text ">무료</p>
                </div>
                <?php }else{?>
                  <div class="d-flex justify-content-between">
                    <div class="sent">
                      <p class="card-text">유료</p>
                    </div>
                    <p class="card-texts num"><?php echo $r->cls_price?> 원</p>
                  </div>
                  <?php }?>
                <h5 class="card-title suit_rg_xs">
                  <?php echo $r-> cls_title?>
                </h5>
                <div class="btns">
                  <button class="btn-primary" onclick="window.open('/teapot/user/lec/classroom.php?clidx=<?php echo $r->clidx?>')">바로가기</button>
                </div>
                <!-- <a href="#" class="btn-primary"></a> -->
              </div>
            </div>
            <?php }?>
          </div>
          <?php }?>
          
        </section>
        <!-- //좋아요 -->
        <!-- Q&A -->
        <section id="user_anwser" class="content_my">
        <div class="d-flex justify-content-between">
            <h3 class="font_ml">Q&A</h3>
            <?php if($anw == ''){?>
              <a href="../qna/qna_list.php" class="btn">질문보러 가기</a>
            <?php }else{?>
              <a href="./user_ answer.php" class="btn">+ 더보기</a>
            <?php }?>
          </div>
          <?php if($anw == ''){?>
            <div class="d-flex justify-content-center">
            <p>Q&A 목록이 없습니다.</p>
            </div>
            <?php }else{?>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">클래스 제목</th>
                <th scope="col">질문 제목</th>
                <th scope="col">질문 내용</th>
                <th scope="col">등록 날짜</th>
                <th scope="col">상태</th>
                <th scope="col">바로가기</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
              foreach($anw as $a){
                $sqlc = "SELECT * from lms_qna where userid='{$a->username}'";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                while($anw = $resultc->fetch_object()){
                  $anws[]=$anw;
                }
            ?>
              <tr>
                <td>
                <?php echo $a->qna_lecture?>
                </td>
                <td>
                <?php 
                if(iconv_strlen($a->qna_title) > 10){
                  print_r($a->qna_title);
                  echo str_replace($a->qna_title,iconv_substr($a->qna_title, 0, 10)."...",$a->qna_title);
                } 
                ?>
                </td>
                <td>
                <?php 
                 if(iconv_strlen($a->qna_text) > 10){
                  echo str_replace($a->qna_text,iconv_substr($a->qna_text, 0, 10)."...",$a->qna_text);
                } 

                ?>
                </td>
                <td><?php echo $a->regdate?></td>
                <td>
                  <?php if($a->reply_st == 0){?>
                  <div><span class="anwser">답변대기</span></div>
                  <?php }else{?>
                    <div><span class="anwser_ok">답변완료</span></div>
                  <?php };?>
                </td>
                <td><button class="anwser_btn" onclick="location.href='../qna/qna_read.php?qidx=<?php echo $a->qidx;?>'">바로가기</button></td>
              </tr>
              <?php } };?>
            </tbody>
          </table>
          
        </section>
      </div>
      <!-- //Q&A -->
    </main>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
      crossorigin="anonymous"
    ></script>
    <script>
      $('aside li').click(function(e){
        $(this).find('i').addClass('active');
        $('aside li').find('i').removeClass('active');
      });
      let num = $('.num');
      console.log(num);
      function addCommas(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      };
    </script>
  <?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script></script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
