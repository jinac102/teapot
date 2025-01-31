<?php
  
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??4;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'];

$search_keyword=$_GET["search_keyword"]??'';

if($search_keyword){
  $search_where .=" and (ev_title like '%".$search_keyword."%')";
  //like 상품명 또는 상세설명 내용에서 검색
}

$sql = "SELECT * from lms_event where 1=1";//모든 쿠폰 조회
$sql .= $search_where;//검색키워드 조건 추가하여 조회
$order = " order by ev_idx desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;

$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
  $rsc[]=$rs;
}


//전체게시물 수 구하기
$sqlcnt = "SELECT count(*) as cnt from lms_event where 1=1";
$sqlcnt .= $search_where;
$countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

//$pageCount = 5; //페이지당 출력할 게시물 수
$block_ct = 5; //페이지네이션 한번에 몇개씩 보일지
$block_num = ceil($pageNumber/$block_ct);//page9,  9/5 1.2 2
$block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
$block_end = $block_start + $block_ct -1; //start 1, end 5
$total_block = ceil($totalPage/$block_ct);//총32, 2

if($block_end > $totalPage) $block_end = $totalPage;
//$totalPage = ceil($totalPage/$block_ct);//총32, 2 총 페이지 수

$start_num = ($pageNumber -1) * $pageCount;
// echo ($start_num);

if($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;

function isStatus($n){  //목록에서 상품의 상태를 변경할 때 숫자를 isSatus함수에 전달하여 변경

  switch($n) {           
      case -1:$rs="종료";
      break;
      case 1:$rs="진행";
      break;
  }
  return $rs;
}

?>

    <link rel="stylesheet" href="../css/event.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";
?>
        <main class="p-5 col-md-10">
          <h2 class="suit_bold_xl">이벤트관리</h2>
          <div class="edit d-flex flex-row-reverse gap-4 align-items-center">
            <button class="btn_l" onclick="location.href='event_add.php'">등록</button>
            <form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">    
              <div class="searchs">
                <input type="search" class="search" name="search_keyword" id="search_keyword" value="<?php echo $search_keyword;?>">
                <button class="btn" type="submit">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </form>
          </div>

          <table class="table">
            <thead class="suit_bold_m">
              <th scope="col">썸네일</th>
              <th scope="col">이벤트명</th>
              <th scope="col">기한</th>
              <th scope="col">적용쿠폰</th>
              <th scope="col">상태</th>
              <th scope="col"></th>
            </thead>
            <tbody class="table-group-divider suit_rg_m">
            
            
            <?php
              foreach($rsc as $r){
                $sqlc = "SELECT * from lms_coupon_cat where cc_idx=$r->cc_idx";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                while($rsc = $resultc->fetch_object()){
                  $rsca[]=$rsc;
                }
                // print_r($rsca);
                // foreach($rsca as $c){

            ?>
              <tr>
                <td><img src="/teapot/admin/uploads/event/<?php echo $r->ev_thumb;?>"></td>
                <td><?php echo $r->ev_title; ?></td>
                <td><?php foreach($rsca as $c){echo $c->regdate." ~ ".$c->duedate;} ?></td>
                <td><?php echo $c->cc_name;?></td>
                <td><?php echo isStatus($r->status); ?></td>
                <td class="d-flex flex-column gap-2 align-items-center">
                  <button class="btn_s modify" onclick="location.href='event_modify.php?idx=<?php echo $r->ev_idx?>'">수정</button>
                  <button class="btn_s modify" onclick="location.href='event_modify.php?idx=<?php echo $r->cc_idx?>'">바로가기</button>
                </td>
              </tr>
              <?php
              }
              ?> 
            </tbody>
          </table>
          <div class="pagination">
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
              ?>
            </ul>
          </div>
        </main>
        <?php
  
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php";
  
  ?>