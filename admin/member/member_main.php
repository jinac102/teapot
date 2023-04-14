<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php"; ?>
    <link rel="stylesheet" href="../css/member.css" />
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

  //pagination
  if(isset($_GET['page'])){
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $pagesql = "SELECT COUNT(*) as uidx from lms_user";
  $page_result = $mysqli->query($pagesql);
  $page_row = $page_result->fetch_assoc();
  $row_num = $page_row['uidx']; //전체 게시물 수

  $list = 5; //페이지당 출력할 게시물 수
  $block_ct = 3;
  $block_num = ceil($page/$block_ct); // 1 = (1/3)
  $block_start = (($block_num -1)*$block_ct) + 1;
  $block_end = $block_start + $block_ct -1; 

  $total_page = ceil($row_num/$list); // 3 = (17/5)
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct); //4

  $start_num = ($page -1) * $list;
  
  $search_keyword=$_GET["search_keyword"]??'';
  
  if($search_keyword){
    $search_where .=" and (userid like '".$search_keyword."')";
    //like 상품명 또는 상세설명 내용에서 검색
  }

?>
    <main class="memberlist col-md-10 p-5">
      <h2 class="suit_bold_xl">회원관리</h2>
      <div class="memeber_bar d-flex justify-content-end mb-5">
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">    
          <div class="searchs">
            <input type="search" class="search" name="search_keyword" id="search_keyword" value="<?php echo $search_keyword;?>">
            <button class="btn" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </form>
      </div>
      <table class="table text-center">
        <thead class="suit_bold_m">
          <tr>
            <th scope="col">회원명</th>
            <th scope="col">회원 ID</th>
            <th scope="col">E-mail</th>
            <th scope="col">전화번호</th>
            <th scope="col">가입한 날짜</th>
            <th scope="col">상태</th>
            <th scope="col">관리</th>
          </tr>
        </thead>
        <tbody class="table-group-divider suit_rg_m">
          <!-- <tr>
            <td>권준호</td>
            <td>juno91</td>
            <td>juno91@abc.com</td>
            <td>01012349191</td>
            <td>2023-01-01</td>
            <td class="suit_rg_s"><p class="status_join">가입</p></td>
          </tr> -->
          <?php
            $sql = "SELECT * FROM lms_user where super=0";
            $sql .= $search_where;
            $order = " ORDER BY user_st asc, uidx desc limit $start_num,$list";
            $query = $sql.$order;
            $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
            while($rs = $result->fetch_object()){
              $rsc[]=$rs;
            }
            if(isset($rsc)){ 
              foreach($rsc as $r){
          ?>
          <tr>
            <td><?php echo $r->username; ?></td>
            <td><?php echo $r->userid; ?></td>
            <td><?php echo $r->email; ?></td>
            <td><?php echo $r->userphone; ?></td>
            <td><?php echo $r->regdate; ?></td>
            <td class="suit_rg_s">
            <?php
            if($r->user_st == 1){
            ?>
              <p class="status_join">가입</p>
            <?php
              }
            ?>
            <?php
            if($r->user_st == 0){
            ?>
              <p class="status_session">탈퇴</p>
            <?php
              }
            ?>
            <?php
            if($r->user_st == 2){
            ?>
              <p class="status_block">차단</p>
            <?php
              }
            ?>
            </td>
            <td class="suit_rg_s">
            <?php
            if($r->user_st == 1){
            ?>
              <button type="button" class="btn_s btn_block" onclick="location.href='member_block.php?uidx=<?php echo $r->uidx;?>'">차단</button>
            <?php
              }
            ?>
            <?php
            if($r->user_st == 2){
            ?>
              <button type="button" class="btn_s btn_block" onclick="location.href='member_unblock.php?uidx=<?php echo $r->uidx;?>'">차단 해제</button>
            <?php
              }
            ?>
            </td>
          </tr>
          <?php  
            } }
          ?>
        </tbody>
      </table>

      <div class="pagination">
        <ul class="class_pg d-flex justify-content-center m54 align-items-center">
          <?php
            if($page>1){
              if($block_num > 1){
                $prev = ($block_num-2)*$block_ct + 1;
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
                $next = $block_num*$block_ct + 1;
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
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php";
  ?>