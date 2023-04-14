<?php
  
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";

/*
사용쿠폰의 기한 체크
*/
$sql = "UPDATE lms_coupon_cat set statu=-1 WHERE statu=1 and duedate < NOW() - INTERVAL 1 DAY";//기한 지나면 마감으로 변경 
$result = $mysqli->query($sql);
$sql2 = "UPDATE lms_coupon_cat set statu=1 WHERE statu=0 and regdate = DATE_FORMAT(now(), '%Y-%m-%d')";//기한 시작하면 사용으로 변경 
$result2 = $mysqli->query($sql2);

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??5;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'];

//$row_num = $page_row['qidx']; //전체 게시물 수

$search_keyword=$_GET["search_keyword"]??'';

if($search_keyword){
  $search_where .=" and (cc_name like '%".$search_keyword."%')";
  //like 상품명 또는 상세설명 내용에서 검색
}

$sql = "SELECT * from lms_coupon_cat c where 1=1";//모든 쿠폰 조회
$sql .= $search_where;//검색키워드 조건 추가하여 조회
$order = " order by cc_idx desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;

$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
  $rsc[]=$rs;
}
//전체게시물 수 구하기
$sqlcnt = "SELECT count(*) as cnt from lms_coupon_cat where 1=1";
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
      case -1:$rs="마감";
      break;
      case 0:$rs="대기";
      break;
      case 1:$rs="사용";
      break;
  }
  return $rs;
}

function isIssue($n){

  switch($n){
    case 1:$rs="자동";
    break;
    case 2:$rs="수동";
    break;
  }
  return $rs;
}

?>

    <link rel="stylesheet" href="../css/coupon_list.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";
?>
        <main class="p-5 col-md-10">
          <h2 class="suit_bold_xl">쿠폰관리</h2>
          <div class="edit d-flex flex-row-reverse gap-4 align-items-center">
            <button class="btn_l" onclick="location.href='coupon_add.php'">등록</button>
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
              <th scope="col">쿠폰명</th>
              <th scope="col">최소주문금액</th>
              <th scope="col">할인폭</th>
              <th scope="col">기한</th>
              <th scope="col">발급방식</th>
              <th scope="col">상태</th>
              <th scope="col"></th>
            </thead>
            <tbody class="table-group-divider suit_rg_m">
            <?php
              foreach($rsc as $r){
                $cc_min_price = $r->cc_min_price;
                $cc_price = $r->cc_price;
            ?>
              <tr>
                <td><?php echo $r->cc_name;?></td>
                <td><?php echo number_format($cc_min_price);?></td>
                <td><?php if($r->cc_price) echo number_format($cc_price)."₩"; ?><?php if($r->cc_ratio) echo $r->cc_ratio."%"; ?></td>
                <td><?php
                      if($r->date_limit == 1){
                        echo $r->regdate."~".$r->duedate;
                      }else{
                        echo "무기한";
                      }
                    ?></td>
                <td><?php echo isIssue($r->cc_passive);?></td>
                <td><?php echo isStatus($r->statu); ?></td>
                <td><button class="btn_s modify" onclick="location.href='coupon_modify.php?idx=<?php echo $r->cc_idx?>'">수정</button></td>
              </tr>
              <?php }?> 
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
        
