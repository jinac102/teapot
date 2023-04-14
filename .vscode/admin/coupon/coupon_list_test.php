<?php
  
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_header.php";

if(isset($_GET['page'])){ //주소 표시줄에 page 파라미터로 숫자가 있으면
  $page = $_GET['page'];
}else{
  $page = 1; //page 파마미터 값이 없으면 1
}

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??10;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'];
$search_keyword=$_GET["search_keyword"];

$sql = "select * from lms_coupon_cat c where 1=1";//모든 쿠폰 조회
$sql .= $search_where;//검색키워드 조건 추가하여 조회
$order = " order by cc_idx desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;
//echo "query=>".$query."<br>";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
  $rsc[]=$rs;
}


//전체게시물 수 구하기
$sqlcnt = "select count(*) as cnt from lms_coupon_cat where 1=1";
$sqlcnt .= $search_where;
$countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.


if($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;


?>

    <link rel="stylesheet" href="../css/coupon_list.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_aside.php";
?>
        <main class="p-5 col-md-10">
          <h2 class="suit_bold_xl">쿠폰관리</h2>
          <div class="edit d-flex flex-row-reverse gap-4">
            <button class="btn_m" onclick="location.href='coupon_add.php'">등록</button>
          </div>
          <table>
            <thead class="suit_bold_m">
              <td>체크</td>
              <th>쿠폰명</th>
              <th>최소할인</th>
              <th>할인폭</th>
              <th>기한</th>
              <th>발급방식</th>
              <th>상태</th>
              <th></th>
            </thead>
            <tbody class="suit_rg_m">
            <?php
              foreach($rsc as $r){
            ?>
              <tr>
                <td><input type="checkbox" /></td>
                <td><?php echo $r->cc_name;?></td>
                <td><?php echo $r->cc_min_price;?></td>
                <td><?php echo $r->cc_price; ?>₩/<?php echo $r->cc_ratio; ?>%</td>
                <td><?php echo $r->regdate;?> ~ <?php echo $r->duedate;?></td>
                <td><?php echo $r->cc_passive;?></td>
                <td><button class="btn_s"><?php echo $r->statu;?></button></td>
                <td><button class="btn_s" onclick="location.href='coupon_modify.php'">수정</button></td>
              </tr>
              <?php }?> 
            </tbody>
          </table>
          <div class="pagination">
            <ul
                class="class_pg d-flex justify-content-center m54 align-items-center"
            >
                <li>
                    <a class="suit_bold_m" href=""
                        ><i class="fa-solid fa-angles-left"></i
                    ></a>
                </li>
                <li class>
                    <a class="suit_bold_m PG_num click" href=""
                        >1</a
                    >
                </li>
                <li><a class="suit_bold_m PG_num" href="">2</a></li>
                <li><a class="suit_bold_m PG_num" href="">3</a></li>
                <li>
                    <a class="suit_bold_m" href=""
                        ><i class="fa-solid fa-angles-right"></i
                    ></a>
                </li>
            </ul>
        </div>     
        </main>
    </div>
    <script
      src="https://code.jquery.com/jquery-3.6.3.min.js"
      integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <script src="../js/script.js"></script>
  </body>
</html>
