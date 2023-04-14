<?php
    // session_start();
    // if(!$_SESSION['AUID']){
    //     echo "<script>
    //         alert('접근 권한이 없습니다.');
    //         history.back();
    //     </script>";
    // };
  include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/db.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_header.php";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_aside.php";

  // 관리자 정보 가져오기
  $sql = "SELECT * from lms_user where super=1";
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
  $rs = $result->fetch_object();

 //유저 정보 가져오기
 $sqlcut = "SELECT count(*) as cnt from lms_user where super=0";
 $countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
 $rscnt = $countresult ->fetch_object();
//  print_r($us) ;

//클래스 정보 가져오기
$sqlcut = "SELECT count(*) as cls from lms_class";
$countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
$aclass = $countresult ->fetch_object();

 //qna 페이저
 $qidx = $_GET['qidx'];
 $sql = "SELECT * FROM lms_qna WHERE qidx='{$qidx}'";
 $result = $mysqli->query($sql);
 $row = $result -> fetch_assoc();
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

$list = 3; //페이지당 출력할 게시물 수
$block_ct = 3;
$block_num = ceil($page/$block_ct);//page9,  9/5 1.2 2
$block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
$block_end = $block_start + $block_ct -1; //start 1, end 5

$total_page = ceil($row_num/$list); //총42, 42/5
if($block_end > $total_page) $block_end = $total_page;
$total_block = ceil($total_page/$block_ct);//총32, 2

$start_num = ($page -1) * $list;

?>
<link rel="stylesheet" href="../css/dashboard.css" />
  <main class="pt-4 col-md-10">
    <div class="contains text-center">
      <div class="row  justify-content-center">
        <!-- profile -->
        <div class="col-4 pt-5">
                <!-- 관리자 프로필 수정 -->
          <form
            action="profile_update.php" method="POST"
            class="d-flex  justify-content-center gap-3">
            <div class="image-upload p-2">
              <label for="file-input">
                <?php
                  if($rs->user_file == ''){
                ?>
                <img id="profile" src="../img/pabcon.png" style="width:95px; hight:95px;"/>
                <?php
                }else{
                ?>
                  <img src="<?php echo $rs->user_file?>" />
                  <?php
                  }
                  ?>
              </label>

              <input id="file-input" multiple type="file" name="upfile[]" value="<?php echo $rs->user_file;?>" style="display: none" />
              <!-- <button id="file-btn"></button> -->
            </div>
            <!-- <input type="file"> -->
            <div class="pro">
              <div class="mb-4">
                <label for="">ID</label>
                <input type="text" id="userid" value="<?php echo $rs->userid;?>" placeholder="<?php echo $rs->userid;?>" />
              </div>
              <div>
                <label for="">NAME</label>
                <input type="text" id="username" value="<?php echo $rs->username;?>" placeholder="<?php echo $rs->username;?>"/>
              </div>
            </div>
          </form>
          <button type="submit" class="p_btn" id="profile_change"><i class="fa-solid fa-gear"></i></button>
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
                    <i class="fa-solid fa-user"></i><?php echo $rscnt->cnt?>
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
        <span class="suit_bold_xl">1,222,333</span>
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
          <tbody class="table-group-divider">
          <?php 
            $sql = "SELECT * FROM lms_qna ORDER BY reply_st,regdate asc limit $start_num,$list";
            $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
            while($qs= $result->fetch_object()){
              $qla[] = $qs; 
            }
            if(isset($qla)){
              foreach($qla as $q){
            ?>
            <tr>
              <td scope="row">
            <?php 
              if(iconv_strlen($q->qna_title) > 5){
                echo str_replace($q->qna_title,iconv_substr($q->qna_title, 0, 5)."...",$q->qna_title);
            } 
            ?>
              </td>
              <td><?php echo $q->userid?></td>
              <td><?php echo $q->regdate?></td>
              <td>
                <?php if($q->reply_st == 0){?>
                <div class="situation">답변대기</div>
                <?php }else{?>
                  <div class="situation">답변완료</div>
                  <?php }?>
              </td>
              <td><button type="button" class="Shortcuts" onclick="location.href='../qna/qna_reply.php?qidx=<?php echo $q->qidx;?>'">바로가기</button></td>
            </tr>
            <?php 
              }
            }else{
              ?>
              <tr>
              <td>미답변 내역이 없습니다.</td>
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
              <div class="col-5">
                <h2 class="suit_bold_m">이벤트 관리</h2>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">이벤트</th>
                      <th scope="col">이벤트 내용</th>
                      <th scope="col">할인</th>
                      <th scope="col">기한</th>
                      <th scope="col">수정</th>
                    </tr>
                  </thead>
                  <tbody class="table-group-divider">
                    <tr>
                      <td scope="row">강의 할인 이벤트</td>
                      <td>bulabulabula</td>
                      <td>20%</td>
                      <td class="event_f">2023.03.16~<br>2023.05.04</td>
                      <td><button class="Shortcuts">수정</button></td>
                    </tr>
                    <tr>
                      <td scope="row">강의 할인 이벤트</td>
                      <td>bulabulabula</td>
                      <td>20%</td>
                      <td class="event_f">2023.03.16~<br>2023.05.04</td>
                      <td><button class="Shortcuts">수정</button></td>
                    </tr>
                    <tr>
                      <td scope="row">강의 할인 이벤트</td>
                      <td>bulabulabula</td>
                      <td>20%</td>
                      <td class="event_f">2023.03.16~<br>2023.05.04</td>
                      <td><button class="Shortcuts">수정</button></td>
                    </tr>
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
      attachFile(profileImg,userid,username);

    })

    function attachFile(file,id,name) {
        // var formData = new FormData();
        // formData.append('savefile', file);
        // //<input name="savefile" value="첨부파일명">
        // console.log(formData);
        let data = {
          file : file,
          id : id,
          name : name
        }
        // console.log(data);

        $.ajax({
            async : false,
            url: 'profile_save_image.php',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            // dataType: 'json',
            beforeSend: function () {}, //product_save_image.php 응답하기전 할일
            error: function () {
              alert('실패');
            }, //product_save_image.php 없으면 할일
            success: function (return_data) { //product_save_image.php 유무
                console.log(return_data);
                //관리자 유무, 어드민아니면 로그인메시지
               if (return_data.result == "error") {
                    alert('첨부실패, 관리자에게 문의하세요');
                    return;
                } else {
                   alert("변경 완료");
                }
            }
        });
    }
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

