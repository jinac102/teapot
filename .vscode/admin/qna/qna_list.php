<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";
?>

<link rel="stylesheet" href="../css/qna_list.css" />

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
  $pagesql = "SELECT COUNT(*) as qidx from lms_qna";
  $page_result = $mysqli->query($pagesql);
  $page_row = $page_result->fetch_assoc();
  //print_r($page_row['qidx']);
  $row_num = $page_row['qidx']; //전체 게시물 수

  $list = 5; //페이지당 출력할 게시물 수
  $block_ct = 5;
  $block_num = ceil($page/$block_ct);//page9,  9/5 1.2 2
  $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
  $block_end = $block_start + $block_ct -1; //start 1, end 5

  $total_page = ceil($row_num/$list); //총42, 42/5
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct);//총32, 2

  $start_num = ($page -1) * $list;
  // echo ($start_num);
?>
    

    <main class="p-5 col-md-10">
      <h2 class="suit_bold_xl">학습 Q&A</h2>
      <table class="table text-center">
        <thead class="suit_bold_m">
          <tr>
            <th scope="col">Q&A 내용</th>
            <th scope="col">아이디</th>
            <th scope="col">날짜</th>
            <th scope="col">상태</th>
            <th scope="col">바로가기</th>
          </tr>
        </thead>
        <tbody class="table-group-divider suit_rg_m">
          <?php
            $sql = "SELECT * FROM lms_qna ORDER BY reply_st asc, qidx desc limit $start_num,$list";
            $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
            while($rs = $result->fetch_object()){
                $rsc[]=$rs;
            }
            
            if(isset($rsc)){ 
              foreach($rsc as $r){
          ?>
          <tr>
            <td>
              <?php
                if(iconv_strlen($r->qna_title) > 10){
                  echo str_replace($r->qna_title,iconv_substr($r->qna_title, 0, 10)."...",$r->qna_title);
                }else{
                  echo $r->qna_title;
                }
              ?>
            </td>
            <td><?php echo $r->userid;?></td>
            <td><?php echo $r->regdate;?></td>
            <td>
              <?php if($r->reply_st == 0){ ?>
                <div class="reply_status answer_wait">답변대기</div>
              <?php }else{ ?>
                <div class="reply_status answer_complete">답변완료</div>
              <?php } ?>
            </td>
            <td>
              <button
                type="button"
                class="shortcuts btn_m"
                onclick="location.href='qna_admin_read.php?qidx=<?php echo $r->qidx;?>'"
              >
                바로가기
              </button>
            </td>
          </tr>
          <?php } } ?>
        </tbody>
      </table>

      <div class="pagination">
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
    </main>


<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
?>