<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/admin/inc/db.php";

  include $_SERVER["DOCUMENT_ROOT"]."/teapot/user/mycls/my_page_all.php";

  //유저 좋아요 정보 + 클래스 정보 가져오기
  // $sql = "SELECT lc.* from lms_lec lc join lms_favorite lf where lf.fv_uid='$userid'";
  $sql = "SELECT lc.* from lms_class lc join lms_favorite lf on lf.fv_clsnum=lc.clidx where lf.fv_uid='$userid'";
  $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
  // $ls = $result -> fetch_object();
  while($ls = $result->fetch_object()){
    $rsc[]=$ls;
  }

  //좋아요 페이지네이션
  $userid = $_SESSION['UID'];
  $sql = "SELECT lc.* from lms_class lc join lms_favorite lf on lf.fv_clsnum=lc.clidx where lf.fv_uid='$userid'";
  $result = $mysqli->query($sql);
  $row = $result -> fetch_assoc();
  if(isset($_GET['page'])){
   $page = $_GET['page'];
 } else {
   $page = 1;
 }
 $pagesql = "SELECT count(*) as cnt FROM lms_favorite where fv_uid = '$userid'";
 $page_result = $mysqli->query($pagesql);
 $page_row = $page_result->fetch_assoc();
 $row_num = $page_row['cnt']; //전체 게시물 수
 
 $list = 8; //페이지당 출력할 게시물 수
 $block_ct = 3;
 $block_num = ceil($page/$block_ct);//page9,  9/5 1.2 2
 $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
 $block_end = $block_start + $block_ct -1; //start 1, end 5
 
 $total_page = ceil($row_num/$list); //총42, 42/5
 if($block_end > $total_page) $block_end = $total_page;
 $total_block = ceil($total_page/$block_ct);//총32, 2
 
 $start_num = ($page -1) * $list;
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
      <aside style="padding-top:200px;">
        <ul class="side_menu font_m">
          <li class="page"><a href="./user_my_page.php">My Page</a></li>
          <li>
            <a href="./my_class.php"
              ><i class="fa-solid fa-book-open-reader"></i>나의 클래스</a
            >
          </li>
          <li>
            <a href="http://tgif.dothome.co.kr/teapot/user/mycls/user_like.php"
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
      <div>
      <section id="user_like" class="content_my p_200">
          <div class="d-flex justify-content-between">
            <h3 class="font_ml">좋아요</h3>
            <a href="./lec/classroom.php" class="btn">클래스 가기</a>
          </div>
          <?php if($rsc == ''){?>
            <div class="d-flex justify-content-center">
            <p>좋아요 목록이 없습니다.</p>
            </div>
            <?php }else{?>
          <div class="d-flex justify-content-between flex-wrap ">
          <?php
              foreach($rsc as $r){
                $sqlc = "SELECT * from lms_class where cls_title='{$r->cls_title}'";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                while($rsc = $resultc->fetch_object()){
                  $rsca[]=$rsc;
                }
                // print_r($rsca);
                // foreach($rsca as $c){

            ?>
            <div class="card mt-4">
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
                  <button class="btn-primary" onclick="window.open('/teapot/user/lec/classroom.php?idx=<?php echo $r->clidx?>')">바로가기</button>
                </div>
                <!-- <a href="#" class="btn-primary"></a> -->
              </div>
            </div>
            <?php }?>
          </div>
          <?php }?>
          <div class="pagination d-flex justify-content-center pt-5">
          <ul class="class_pg d-flex justify-content-center m54 align-items-center">
            <?php
              if($page>1){
                if($block_num > 1){
                    $prev = ($block_num-2)*$list + 1;
                    echo "<li>
                      <a class='suit_bold_m' href='?page=$prev'>
                        <i class='fa-solid fa-angles-left'></i>
                      </a>
                    </li>";
                }
              }
              for($i=$block_start;$i<=$block_end;$i++){
                if($page == $i){
                    echo "<li><a href='?page=$i' class='suit_bold_m PG_num active click'>$i</a></li>";
                }else{
                    echo "<li><a href='?page=$i' class='suit_bold_m PG_num'>$i</a></li>";
                }
              }
              if($page<$total_page){
                if($total_block > $block_num){
                    $next = $block_num*$list + 1;
                    echo "<li>
                      <a class='suit_bold_m' href='?page=$next'>
                        <i class='fa-solid fa-angles-right'></i>
                      </a>
                    </li>";
                }
              }
            ?>
          </ul>
        </div>
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
    </script>
    <?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script></script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
