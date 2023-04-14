<?php
  session_start();
  $_SESSION['TITLE'] = "EVENT";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/event.css"/>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";

  $sql = "SELECT * from lms_event where status=1 order by ev_idx desc";
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
  while($rs = $result->fetch_object()){
    $rse[]=$rs;
  }
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
            <?php
              foreach($rse as $r){
                $sqlc = "SELECT * from lms_coupon_cat where cc_idx=$r->cc_idx";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                while($rsc = $resultc->fetch_object()){
                  $rsca[]=$rsc;
                }
            ?>
                <div class="content d-flex justify-content-center">
                    <div class="thumb">
                      <a href="/teapot/user/event/event_detail.php?idx=<?php echo $r->ev_idx; ?>">
                        <img src="/teapot/admin/uploads/event/<?php echo $r->ev_thumb;?>">
                      </a>
                    </div>
                    <div class="desc">
                        <h3 class="suit_bold_m go"><a href="/teapot/user/event/event_detail.php?idx=<?php echo $r->ev_idx; ?>">[EVENT] <?php echo $r->ev_title; ?></a></h3>
                        <p>
                          기간: 
                            <?php 
                                if($r->regdate && $r->duedate != NULL){
                                  echo $r->regdate." ~ ".$r->duedate;
                                }else{
                                  echo "무기한";
                                }
                            ?>
                        </p>
                        <p>내용: <?php echo $r->ev_content_text; ?></p>
                        <p class="go"><a href="/teapot/user/event/event_detail.php?idx=<?php echo $r->ev_idx; ?>">자세히보기 <span>→<span></a></p>
                    </div>
                </div>
                <p class="border content_container justify-content-center"></p>
            <?php
            }
            ?> 
            </tbody>
    </div>
  </main>


<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script>
  $(".desc").hover(function(){
    $(this).find("span").css('margin-left','10px')
  },function() {
    $(this).find("span").css('margin-left','0px');
    });
</script>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>