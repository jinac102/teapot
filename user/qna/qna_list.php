<?php
  session_start();
  $_SESSION['TITLE'] = "학습Q&A List";
  $uid = $_SESSION['UID'];
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/qna/qna_list.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>

<!-- pagination -->
<?php
  $qidx = $_GET['qidx'];
  $sql = "SELECT * FROM lms_qna WHERE qidx='{$qidx}'";
  $result = $mysqli->query($sql);
  $row = $result -> fetch_assoc();

  // Pagenation
  if(isset($_GET['page'])){
      $page = $_GET['page'];
  } else {
      $page = 1;
  }

  $category=$_GET["search_type"]??'';
  $keyword=$_GET["search_term"]??'';


  if($keyword){
    $search_where .=" and $category like '%".$keyword."%'";
    //like 상품명 또는 상세설명 내용에서 검색
  }

  $list = 10; //페이지당 출력할 게시물 수
  $block_ct = 5; //한번에 보여지는 페이지네이션 넘버
  $block_num = ceil($page/$block_ct);//page2,  2/2 = 1
  $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
  $block_end = $block_start + $block_ct -1; //start 1, end 5
  $start_num = ($page -1) * $list;

  $sql = "SELECT count(*) as cnt from lms_qna where 1=1";//모든 qna_list 조회
  $pagesql = $sql.$search_where;
  $page_result = $mysqli->query($pagesql);
  $page_row = $page_result->fetch_assoc();
  $row_num = $page_row['cnt']; //전체 게시물 수


  $sql = "SELECT * from lms_qna where 1=1";//모든 qna_list 조회
  $order = " order by reply_st desc, qidx asc, qna_recom asc";//마지막에 등록한걸 먼저 보여줌
  $limit= " limit $start_num,$list";
  $query = $sql.$search_where.$order.$limit;

  $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
  while($rs = $result->fetch_object()){
      $rsc[]=$rs; //검색된 상품 목록 배열에 담기
  }

  $total_page = ceil($row_num/$list); //총42,
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct);//총32, 2
?>
<!-- search_bar -->
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
  <div class="lists qna_container">
    <p>- 학습 Q&amp;A 작성은 강의학습에서 가능합니다.</p>
    <ul>
      <?php if($category){
            if(isset($rsc)){ 
                foreach($rsc as $r){
        ?>
            <li class="list" onclick="location.href='qna_read.php?qidx=<?php echo $r->qidx;?>'">
                <div>
                    <div class="d-flex justify-content-between">
                        <div class="class_name_and_best d-flex gap-2 suit_rg_s">
                            <p class="class_name"><?php echo $r->qna_lecture;?></p>
                        </div>
                        <p class="write_date"><?php echo $r->regdate;?></p>
                    </div>
                    <p class="question_title suit_bold_m">
                        <?php echo $r->qna_title;?>
                    </p>
                    <div class="d-flex justify-content-between suit_rg_s">
                      <div class="d-flex gap-3">
                        <div class="reply_status">
                            <?php if($r->reply_st == 0){ ?>
                                <p class="unanswered">답변대기</p>
                            <?php }else{  ?>
                                <p class="answered">답변완료</p>
                            <?php } ?>
                        </div>
                        <div class="hit d-flex gap-3 suit_rg_s">
                            <div class="views d-flex gap-2">
                                <p class="hit_title">조회수</p>
                                <p class="hit_number"><?php echo $r->qna_hit;?></p>
                            </div>
                            <div class="recommend d-flex gap-2">
                                <p class="hit_title">추천</p>
                                <p class="hit_number"><?php echo $r->qna_recom;?></p>
                            </div>
                        </div>
                      </div>
                        <p class="username"><?php echo $r->userid;?></p>
                    </div>
                </div>
            </li>
        <?php } } ?>
      <?php }else{
        // 추천수를 많이 받은 상위 3개의 질문
          $sql1 = "SELECT * FROM lms_qna ORDER BY qna_recom desc limit 0,3";
          $result1 = $mysqli->query($sql1) or die("query error => ".$mysqli->error);
          while($rs1 = $result1->fetch_object()){
              $rsc1[]=$rs1;
          }
  
          if(isset($rsc1)){ 
              foreach($rsc1 as $r){
        ?>
          <li class="list" onclick="location.href='qna_read.php?qidx=<?php echo $r->qidx;?>'">
              <div>
                  <div class="d-flex justify-content-between">
                      <div class="class_name_and_best d-flex gap-2 suit_rg_s">
                          <p class="class_name"><?php echo $r->qna_lecture;?></p>
                                <p class='best'>BEST!</p>
                      </div>
                      <p class="write_date"><?php echo $r->regdate;?></p>
                  </div>
                  <p class="question_title suit_bold_m">
                      <?php echo $r->qna_title;?>
                  </p>
                  <div class="d-flex justify-content-between suit_rg_s">
                    <div class="d-flex gap-3">
                      <div class="reply_status">
                          <?php if($r->reply_st == 0){ ?>
                              <p class="unanswered">답변대기</p>
                          <?php }else{  ?>
                              <p class="answered">답변완료</p>
                          <?php } ?>
                      </div>
                      <div class="hit d-flex gap-3 suit_rg_s">
                          <div class="views d-flex gap-2">
                              <p class="hit_title">조회수</p>
                              <p class="hit_number"><?php echo $r->qna_hit;?></p>
                          </div>
                          <div class="recommend d-flex gap-2">
                              <p class="hit_title">추천</p>
                              <p class="hit_number"><?php echo $r->qna_recom;?></p>
                          </div>
                      </div>
                    </div>
                      <p class="username"><?php echo $r->userid;?></p>
                  </div>
              </div>
          </li>
      <?php } }
      // 한 페이지에 보이지는 상위 질문 3개를 제외한 7개 질문
          if(isset($rsc)){ 
              foreach($rsc as $r){
          ?>
          <li class="list" onclick="location.href='qna_read.php?qidx=<?php echo $r->qidx;?>'">
              <div>
                  <div class="d-flex justify-content-between">
                      <div class="class_name_and_best d-flex gap-2 suit_rg_s">
                          <p class="class_name"><?php echo $r->qna_lecture;?></p>
                      </div>
                      <p class="write_date"><?php echo $r->regdate;?></p>
                  </div>
                  <p class="question_title suit_bold_m">
                      <?php echo $r->qna_title;?>
                  </p>
                  <div class="d-flex justify-content-between suit_rg_s">
                    <div class="d-flex gap-3">
                      <div class="reply_status">
                          <?php if($r->reply_st == 0){ ?>
                              <p class="unanswered">답변대기</p>
                          <?php }else{  ?>
                              <p class="answered">답변완료</p>
                          <?php } ?>
                      </div>
                      <div class="hit d-flex gap-3 suit_rg_s">
                          <div class="views d-flex gap-2">
                              <p class="hit_title">조회수</p>
                              <p class="hit_number"><?php echo $r->qna_hit;?></p>
                          </div>
                          <div class="recommend d-flex gap-2">
                              <p class="hit_title">추천</p>
                              <p class="hit_number"><?php echo $r->qna_recom;?></p>
                          </div>
                      </div>
                    </div>
                      <p class="username"><?php echo $r->userid;?></p>
                  </div>
              </div>
          </li>
      <?php } } ?>



      <?php } ?>
    </ul>
  </div>



<!-- pagination -->
  <div class="pagination qna_container justify-content-center">
    <ul class="class_pg d-flex justify-content-center align-items-center gap-5">
        <?php
            if($page>1){
                if($block_num > 1){
                    $prev = ($block_num-2)*$block_ct + 1;
                    echo '<li><a class="suit_bold_m" href="?search_type='.urlencode($category).'&search='.urlencode($keyword).'&page='.$prev.'"><i class="fa-solid fa-angles-left"></i></a></li>';
                }
            }
            for($i=$block_start;$i<=$block_end;$i++){
                if($page == $i){
                    echo '<li><a href="?search_type='.urlencode($category).'&search_term='.urlencode($keyword).'&page='.$i.'" class="suit_bold_m PG_num click">'.$i.'</a></li>';
                }else{
                    echo '<li><a href="?search_type='.urlencode($category).'&search_term='.urlencode($keyword).'&page='.$i.'" class="suit_bold_m PG_num">'.$i.'</a></li>';
                }
            }
            if($page<$total_page){
                if($total_block > $block_num){
                    $next = $block_num*$block_ct + 1;
                    echo '<li><a class="suit_bold_m" href="?search_type='.urlencode($category).'&search='.urlencode($keyword).'&page='.$next.'"><i class="fa-solid fa-angles-right"></i></a></li>';
                }
            }
        ?>
    </ul>
  </div>

<!-- search_bar -->
  <div class="search qna_container d-flex justify-content-center">
        <form action="" method="GET">
          <select name="search_type" id="search_type" class="category">
            <option value="qna_title">제목</option>
            <option value="qna_text">내용</option>
            <option value="userid">글쓴이</option>
          </select>
          <input
            type="search"
            name="search_term"
            id="search_term"
            class="search_bar"
            placeholder="검색어를 입력해주세요."
            value=""
            required
          />
          <button class="btn_s_b suit_rg_s" type="submit">검색</button>
        </form>
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