<?php
  session_start();
  $_SESSION['TITLE'] = "EVENT";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/event.css"/>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";

  error_reporting(E_ALL);
  ini_set( 'display_errors', '0' );

  $eno = $_GET['idx'];
  $sql = "SELECT * from lms_event where ev_idx=$eno"; //idx번호에 맞는 게시글 추출 구문 저장
  $result = $mysqli->query($sql); //게시글 추출 구문 실행
  $row = $result->fetch_assoc(); // 게시글 추출내용을 연관배열로 저장

?>


<body>
  <main>
  <div class="banner">
        <div class="title content_container d-flex justify-content-between align-items-center">
            <div class="desc">
              <h2 class="suit_bold_xl">이벤트</h2>
              <p class="suit_rg_m">오직 TEAPOT에서만 열리는 이벤트! 다양한 이벤트로 혜택을 누려보세요!</p>
            </div>
            <div class="img">
              <img src="../img/event/event_banner.png" alt="event_banner">
            </div>
        </div>
    </div>
    <div class="contents content_container">
        <h2><?php echo $row['ev_title']?></h2>
        <p>
          <?php 
            if($row['regdate'] && $row['duedate'] != NULL){
              echo $row['regdate']." ~ ".$row['duedate'];
            }else{
              echo "";
            }
          ?>
        </p>
        <div class="content_img">
          <img src="/teapot/admin/uploads/event/<?php echo $row['ev_content_img'];?>" alt="">
        </div>
        <input type="hidden" name="userid" value="<?php echo $_SESSION['AUID']; ?>">
    <button type="button" class="coupon_btn_l_b suit_rg_m" id="couponBtn" value="<?php echo $row['cc_idx'] ?>">
      쿠폰받기
    </button>
    </div>
  </main>

<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $("#couponBtn").click(function(){
  let $eno = $(this).val();
  let cid = $("#couponBtn").attr('value');
  console.log(cid);
  let data = {
    cid : cid
  }
  $.ajax({
    type : 'POST',
    url : 'event_coupon.php',
    data : data,
    dataType:'json',
    success : function($return_data){
      if($return_data.result == "error"){
          alert('로그인이 필요합니다.');
          location.href='/teapot/login.php';
      }else{
        if($return_data.result == "success"){
          alert('쿠폰이 발급되었습니다.');
        }else{
          alert('이미 발급된 쿠폰입니다.');
          }
      }
    }
  });
});
</script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>