<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
  include $_SERVER["DOCUMENT_ROOT"]."/teapot/user/inc/db.php";

  include $_SERVER["DOCUMENT_ROOT"]."/teapot/user/mycls/my_page_all.php";

  //Q&A 정보
  $sqlanswer = "SELECT * from lms_qna where userid='$username'";
  $result = $mysqli -> query($sqlanswer) or die("query error =>".$mysqli->error);
  // $ls = $result -> fetch_object();
  while($an = $result->fetch_object()){
    $rsc[]=$an;
  }

  //Q&A 페이지네이션
  $userid = $_SESSION['UID'];
  $sql = "SELECT * from lms_qna where userid='$username'";
  $result = $mysqli->query($sql);
  $row = $result -> fetch_assoc();
  if(isset($_GET['page'])){
   $page = $_GET['page'];
 } else {
   $page = 1;
 }
 $pagesql = "SELECT count(*) as cnt FROM lms_qna where userid = '$username'";
 $page_result = $mysqli->query($pagesql);
 $page_row = $page_result->fetch_assoc();
 $row_num = $page_row['cnt']; //전체 게시물 수
 
 $list = 7; //페이지당 출력할 게시물 수
 $block_ct = 5;
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
      <aside style="padding-top: 200px">
        <ul class="side_menu font_m">
          <li class="page"><a href="./user_my_page.php">My Page</a></li>
          <li>
            <a href="http://tgif.dothome.co.kr/teapot/user/mycls/my_class.php"
              ><i class="fa-solid fa-book-open-reader"></i>나의 클래스</a
            >
          </li>
          <li>
            <a href="./user_like.php"
              ><i class="fa-solid fa-heart"></i>좋아요</a
            >
          </li>
          <li>
            <a href="http://tgif.dothome.co.kr/teapot/user/mycls/user_%20answer.php"
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
        <section id="user_anwser" class="content_my p_200">
        <?php if($rsc == ''){?>
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
              foreach($rsc as $a){
              
                $sqlc = "SELECT * from lms_qna where userid='{$a->username}'";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                while($rsc = $resultc->fetch_object()){
                  $rsca[]=$rsc;
                }

            ?>
              <tr>
                <td>
         
                <?php echo $a->qna_lecture?>
                </td>
                <td>
                <?php 
                if(iconv_strlen($a->qna_title) > 30){
                  echo str_replace($a->qna_title,iconv_substr($a->qna_title, 0, 10)."...",$a->qna_title);
                } 
                 echo $a->qna_title;
                ?>
                </td>
                <td>
                <?php 
                 if(iconv_strlen($a->qna_text) > 30){
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
              <?php };?>
            </tbody>
          </table>
          <div class="pagination d-flex justify-content-center pt-5">
            <ul class="class_pg d-flex justify-content-center m54 align-items-center">
              <?php
                if($pageNumber>1){
                  if($block_num > 1){
                      $prev = ($block_num-2)*$pageCount + 1;
                      echo "<li>
                        <a class='suit_bold_m' href='?pageNumber=$prev'>
                          <i class='fa-solid fa-angles-left'></i>
                        </a>
                      </li>";
                  }
                }


                for($i=$block_start;$i<=$block_end;$i++){
                  if($pageNumber == $i){
                      echo "<li><a href='?pageNumber=$i' class='suit_bold_m PG_num active click'>$i</a></li>";
                  }else{
                      echo "<li><a href='?pageNumber=$i' class='suit_bold_m PG_num'>$i</a></li>";
                  }
                }
                

                if($page<$totalPage){
                  if($total_block > $block_num){
                      $next = $block_num*$pageCount + 1;
                      echo "<li>
                        <a class='suit_bold_m' href='?pageNumber=$next'>
                          <i class='fa-solid fa-angles-right'></i>
                        </a>
                      </li>";
                  }
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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
      crossorigin="anonymous"
    ></script>
    <?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script></script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
