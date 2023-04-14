<?php
    // session_start();
    // if(!$_SESSION['AUID']){
    //     echo "<script>
    //         alert('접근 권한이 없습니다.');
    //         history.back();
    //     </script>";
    // };
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

  // 관리자 정보 가져오기
  $sql = "SELECT * from lms_user where super=1";
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
  $ms = $result->fetch_object();

 //유저 정보 가져오기
 $sqlcuts = "SELECT count(*) as cnt from lms_user where super=0";
 $countresults = $mysqli -> query($sqlcuts) or die("query error => ".$mysqli->error);
 $rscnts = $countresults ->fetch_object();

//클래스 정보 가져오기
$sqlcut = "SELECT count(*) as cls from lms_class";
$countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
$aclass = $countresult ->fetch_object();

 //qna 페이저
 // 페이지네이션 처리를 위한 초기값 설정
// $per_page = 10; // 한 페이지당 보여줄 게시물 수
// $page = 1; // 현재 페이지
// if (isset($_GET['page'])) {
//   $page = $_GET['page']; // 현재 페이지가 지정된 경우
// }
// $start = ($page - 1) * $per_page; // 시작 게시물 번호

 $qidx = $_GET['qidx']?? 1;
  $sqlqna = "SELECT * FROM lms_qna WHERE qidx='".$qidx."'";
  $results = $mysqli->query($sqlqna);
  $row = $results -> fetch_assoc();

  // Pagenation
  if(isset($_GET['page'])){
      $page = $_GET['page'];
  } else {
      $page = 1;
  }
  $pagesql = "SELECT COUNT(*) as qidx from lms_qna";
  $page_result = $mysqli->query($pagesql);
  $page_row = $page_result->fetch_assoc();
  // print_r($page_row['qidx']);
  $row_num = $page_row['qidx']; //전체 게시물 수 41

  $list = 3; //페이지당 출력할 게시물 수
  $block_ct = 3;
  $block_num = ceil($page/$block_ct);//1
  // print_r($block_num); 1
  $block_start = (($block_num -1)*$block_ct) + 1;
  // print_r($block_start); 1
  $block_end = $block_start + $block_ct -1; //start 1, end 5
  // print_r($block_end); 3

  $total_page = ceil($row_num/$list); //총42, 42/5
  // print_r($total_page);  14
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct);//총32, 2

  $start_num = ($page -1) * $list;
  // echo ($start_num);

//이벤트 정보 불러오기
$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??2;//페이지당 몇개씩 보여줄지, 없으면 10
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
foreach($rsc as $r){
  $cc_name = $r->cc_name;
  $ccquery = "SELECT * from lms_coupon_cat where cc_name='{$cc_name}'";
  // print_r($ccquery);
  $result = $mysqli->query($ccquery) or die("query error => ".$mysqli->error);
  $row = $result->fetch_object();
  $orgname = $row->cc_name;
  $orgreg = $row->regdate;
  $orgdue = $row->duedate;
  $orgstat = $row->statu;
  $cc_idx = $row->cc_idx;
  $evUpdate = "UPDATE lms_event set cc_name='{$orgname}', regdate='{$orgreg}', duedate='{$orgdue}', status='{$orgstat}' where cc_idx=$cc_idx";
  $evResult = $mysqli->query($evUpdate);
  // print_r($evUpdate);
}


//전체게시물 수 구하기
$sqlcnt = "SELECT count(*) as cnt from lms_event where 1=1";
$sqlcnt .= $search_where;
$countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

$pageCount = 3; //페이지당 출력할 게시물 수
$block_ct = 3; //페이지네이션 한번에 몇개씩 보일지
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

//월 수익 
$today = date("Y-m-d");
$sqldate = "SELECT lc.* from lms_class lc join lms_sold ls on ls.sold_clidx=lc.clidx where ls.solddate >= DATE_SUB('$today', INTERVAL 1 MONTH)";
$contentdate = $mysqli -> query($sqldate) or die("query error => ".$mysqli->error);
while($alldate = $contentdate ->fetch_object()){
  $datas[]=$alldate;
};
$sum = 0;
foreach($datas as $data){
  $sum =  $sum + (int)$data->cls_price;
}
?> 
<link rel="stylesheet" href="../css/dashboard.css" />
  <main class="pt-4 col-md-10">
    <div class="contains text-center">
      <div class="row  justify-content-center">
        <!-- profile -->
        <div class="col-4 pt-4">
                <!-- 관리자 프로필 수정 -->
          <form
            action="profile_save_image.php" method="POST"
            class="d-flex  justify-content-center gap-3 align-items-center">
            <div class="image-upload p-2">
              <label for="file-input">
              <?php
                  if($ms->user_file == ''){
                ?>
                <img src="/teapot/admin/img/pabcon.png" style="width:95px; hight:95px;"/>
                <?php
                }else{
                ?>
                <div class="profileimg">
                  <img id="profile" src="<?php echo $ms->user_file?>" />
                </div>
                  <?php
                  }
                  ?>
              </label>

              <input id="file-input" type="file" name="upfile" value="<?php echo $ms->user_file;?>" style="display: none" />
              <!-- <button id="file-btn"></button> -->
            </div>
            <!-- <input type="file"> -->
            <div class="pro">
              <div class="mb-4">
                <label for="">ID</label>
                <input type="text" id="userid" name="userid" value="<?php echo $ms->userid;?>" placeholder="<?php echo $ms->userid;?>" />
              </div>
              <div>
                <label for="">NAME</label>
                <input type="text" id="username" name="username" value="<?php echo $ms->username;?>" placeholder="<?php echo $ms->username;?>"/>
              </div>
            </div>
            <div>    
              <button type="submit" class="p_btn" id="profile_change"><i class="fa-solid fa-gear"></i></button>
            </div>
          </form>
        </div>
        <!-- class -->
        <div class="col-6">
          <div class="room">
            <p>summary of the month</p>
            <div class="d-flex align-items-center justify-content-center gap-5 p-4">
              <div class="roclass">
                <p class="suit_bold_s">all class</p>
                <div class="con">
                  <p class="suit_bold_m">
                    <i class="fa-regular fa-calendar"></i><?php echo $aclass->cls?>
                  </p>
                </div>
              </div>
              <div class="roclass">
                <p class="suit_bold_s">all user</p>
                <div class="con">
                  <p class="suit_bold_m">
                    <i class="fa-regular fa-calendar"></i><?php echo $rscnts->cnt?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- //profile -->
    <!-- //class -->
  <div class="row  justify-content-center">
    <!-- price -->
    <div class="col-4">
      <div
        class="morny d-flex justify-content-between align-items-center"
      >
        <div><i class="fa-solid fa-sack-dollar"></i></div>
        <span class="suit_bold_xl"><?php echo number_format($sum)?></span>
      </div>
    </div>
    <!-- //price -->
    <div class="col-6"> 
      <canvas id="myChart"></canvas>
    </div>
  </div>
    <div class="row justify-content-center">
      <div class="col-5">
        <h2 class="suit_bold_m">Q&A</h2>
        <table class="table">
          <thead>
            <tr class="text-center">
              <th scope="col">Q&A 내용</th>
              <th scope="col">아이디</th>
              <th scope="col">날짜</th>
              <th scope="col">상태</th>
              <th scope="col">바로가기</th>
            </tr>
          </thead>
          <?php if($q->reply_st == '1'){?>
            <div><p>미답변 내역이 없습니다.</p></div>
            <?php }else{?>
              <tbody class="table-group-divider suits">
          <?php
            $sql = "SELECT * FROM lms_qna ORDER BY reply_st asc, qidx desc limit $start_num,$list";
            $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
            while($qn = $result->fetch_object()){
                $qna[]=$qn;
            }
            
            if(isset($qna)){ 
              foreach($qna as $q){
          ?>
          <tr>
            <td>
              <?php
                if(iconv_strlen($q->qna_title) > 10){
                  echo str_replace($q->qna_title,iconv_substr($q->qna_title, 0, 10)."...",$q->qna_title);
                }else{
                  echo $q->qna_title;
                }
              ?>
            </td>
            <td><?php echo $q->userid;?></td> 
            <td><?php echo $q->regdate;?></td>
            <td>
              <?php if($q->reply_st == 0){ ?>
                <div class="situation">답변대기</div>
              <?php }else{ ?>
                <div class="answer">답변완료</div>
              <?php } ?>
            </td>
            <td>
              <button
                type="button"
                class="Shortcuts"
                onclick="location.href='../../user/qna/qna_read.php?qidx=<?php echo $q->qidx;?>'"
              >
                바로가기
              </button>
            </td>
          </tr>
          <?php } } ?>
        </tbody>
            <?php } ?>
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
              </div>
              <div class="col-5">
                <h2 class="suit_bold_m">이벤트 관리</h2>
                 <table class="table">
                <thead class="suit_bold_s" style="font-size:15px;">
                  <th width="2%" scope="col" >썸네일</th>
                  <th width="5%" scope="col">이벤트명</th>
                  <th width="5%" scope="col">기한</th>
                  <th width="5%" scope="col">적용쿠폰</th>
                  <th width="4%" scope="col">상태</th>
                  <th width="4%" scope="col"></th>
                </thead>
                <tbody class="table-group-divider suit_rg_m">
            
            
            <?php
              foreach($rsc as $r){
            ?>
              <tr>
                <td><img src="/teapot/admin/uploads/event/<?php echo $r->ev_thumb;?>" style="width: 100px;"></td>
                
                <td style="font-size:15px;">   
                <?php echo $r->ev_title?>
                  <!-- <?php 
                  if(iconv_strlen($r->ev_title) > 5){
                    echo str_replace($r->ev_title,iconv_substr($r->ev_title, 0, 5)."",$r->ev_title);
                  } 
                  ?> -->
                </td>
                <td style="font-size:15px;">
                <?php 
                    if($r->regdate && $r->duedate){
                      echo $r->regdate." ~ ".$r->duedate;
                    }else{
                      echo "무기한";
                    }  
                ?></td>
                <td style="font-size:15px;"><?php
                  echo $r->cc_name;
                ?></td>
                <td style="font-size:12px;"><?php echo isStatus($r->status); ?></td>
                <td class="event_btn">
                  <div>
                    <button class="Shortcuts" onclick="location.href='../event/event_modify.php?idx=<?php echo $r->ev_idx?>'">수정</button>
                  </div>
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
        </div>

      </div>
    </div>
  </main>
  
  
<script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"
></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 let profileImg; 
$('#file-input').change(function(e){
  var files = e.originalEvent.target.files; // Works fine
  console.log(files);
  preview(files[0]);
  profileImg = files[0];
})


function preview(file) {
        var reader = new FileReader();
        reader.onload = (function (f) {
            return function (e) {
              $("#profile").attr('src', e.target.result);
              console.log(e.target.result);
            };
        })(file);
        reader.readAsDataURL(file);
    }


    $("#profile_change").click(function(){
      let userid = $('#userid').val();
      let username = $('#username').val();
      // console.log(userid);
      // attachFile(profileImg,userid,username);
    })

    // function attachFile(file,id,name) {
    //     let data = {
    //       file : file,
    //       id : id,
    //       name : name
    //     }
    //     console.log(data);

    //     $.ajax({
    //         async: false,
    //         url: 'profile_save_image.php',
    //         dataType : "json",
    //         // contentType: "application/json; charset=utf-8",
    //         data : JSON.stringify(data),
    //         type: 'POST',               
    //         error: function () {
    //             alert('실패');
    //         },
    //         success: function (return_data) {
    //             console.log(return_data);
    //             alert('성공');
    //         }
    //     });
    // }
//chart js
const ctx = document.getElementById("myChart");
console.log(ctx);

new Chart(ctx, {
  type: "line",
  data: {
    labels: [
      "1월",
      "2월",
      "3월",
      "4월",
      "5월",
      "6월",
      "7월",
      "8월",
      "9월",
      "10월",
      "11월",
      "12월",
    ],
    datasets: [
      {
        label: "월 수익",
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 3,
        backgroundColor: "#ffbebb",
        borderColor: "#ff534b",
        pointBackgroundColor: "#ff534b",
        fill: true,
      },
    ],
  },
  options: {
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

</script>

