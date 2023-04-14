<?php
  session_start();
  $_SESSION['TITLE'] = "MAIN";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  error_reporting(E_ALL);
  ini_set( 'display_errors', '1' );
?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
<link rel="stylesheet" href="user/css/index.css" />

<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>
<main>
  <h2 class="visually-hidden">main</h2>
  <!-- <aside class="sidebar_recent">
    <div class="sidebar_wrapper">
      <h2 class="suit_bold_xs text-center my-3">최근 본 강의</h2>
      <ul>
        <li class="recent_lecs">
          <a href=""
            ><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec2.jpg" alt="" /><span
              >[중급] 여행 회화 - 프로 캠퍼를 위한 영어</span
            ></a
          >
        </li>
      </ul>
      <a href="" id="top_btn" class="suit_bold_xs">TOP</a>
    </div>
  </aside> -->
  <section class="main_banner">
    <h2 class="visually-hidden"></h2>
    <div class="swiper swiper_banner">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/event/event_detail.php?idx=7"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec1_banner1.jpg" alt="mainbanner1" /></a>
        </div>
        <div class="swiper-slide">
          <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/event/event_detail.php?idx=2"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec1_banner2.jpg" alt="mainbanner2" /></a>
        </div>
        <div class="swiper-slide">
          <a href=""><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec1_banner3.jpg" alt="mainbanner3" /></a>
        </div>
        <div class="swiper-slide">
          <a href=""><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec1_banner4.jpg" alt="mainbanner4" /></a>
        </div>
        <!-- <div class="swiper-slide">
          <a href=""><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec1_banner5.jpg" alt="mainbanner5" /></a>
        </div> -->

      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </section>
  <section class="main_bestcl content_container d-flex flex-wrap">
    <div class="tt_wrapper py-3 ps-3">
      <h2 class="suit_bold_m text-start">BEST CLASS</h2>
      <p class="suit_rg_s text-start">
        원어민이 영어를 배우는 학습 원리를 바탕으로 만들어진 <br />
        마법 패턴이 한글을 깨우치듯 영어 회화를 입에 익숙해지게 해요
      </p>
    </div>

    <div class="swiper swiper_best_main order-first">
      <div class="swiper-wrapper">
        <?php
        $sql = "SELECT * FROM lms_class ORDER BY cls_hit desc limit 0,6";
        $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
        while($rs = $result->fetch_object()){
          $rsc[]=$rs;
        }
        if(isset($rsc)){ 
          foreach($rsc as $r){
        ?>
          <div class="swiper-slide">
            <div class="img_wrapper">
              <img src="<?php $_SERVER['DOCUMENT_ROOT']?><?php echo $r->thumb_url; ?>" alt="강의" />
            </div>
            <div class="text_wrapper my-5">
              <h3 class="suit_bold_s">
                <?php echo $r->cls_title; ?>
              </h3>
              <p class="suit_rg_s">
                <?php
                  $cls_text = strip_tags( $r->cls_text );
                  if (strlen($cls_text) > 35) {
                    $cls_txt = iconv_substr($cls_text, 0, 35) . "...";
                  }
                  echo $cls_txt;
                ?>
              </p>
              <button type="button" onclick="location.href='<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/lec/classroom.php?clidx=<?php echo $r->clidx; ?>'" class="btn_s_b suit_rg_s btn_lecs">
                강의 바로가기
              </button>
            </div>
          </div>
        <?php } } ?>
      </div>
    </div>
    <div class="swiper swiper_best_thumb">
      <div class="swiper-wrapper">
        <?php
          $sql = "SELECT * FROM lms_class ORDER BY cls_hit desc limit 0,6";
          $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
          while($rs = $result->fetch_object()){
            $rsc[]=$rs;
          }
          if(isset($rsc)){ 
            foreach($rsc as $r){
        ?>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?><?php echo $r->thumb_url; ?>" alt="강의" />
          </div>
        </div>
        <?php } } ?>
      




        <!-- <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec2.jpg" alt="강의1" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec3.jpg" alt="강의1" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec4.jpg" alt="강의1" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec5.jpg" alt="강의1" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec2_lec6.jpg" alt="강의1" />
          </div>
        </div> -->
      </div>
      <div class="control-wrap">
        <div class="swiper-gallery-prev"></div>
        <div class="swiper-gallery-next"></div>
      </div>
    </div>
  </section>
  <section class="main_time content_container text-center">
    <h2 class="suit_bold_m text-center my-5">
      무심코 지나가는 하루 10분, 티팟과 함께
    </h2>
    <div class="swiper swiper_time">
      <div class="swiper-wrapper my-5">
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec3_img1.jpg" alt="sec3_img1" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec3_img2.jpg" alt="sec3_img2" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec3_img3.jpg" alt="sec3_img3" />
          </div>
        </div>
        <div class="swiper-slide">
          <div class="img_wrapper">
            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/main_sec3_img4.jpg" alt="sec3_img4" />
          </div>
        </div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
    <button type="button" class="suit_rg_s btn_time_freecl" onclick="location.href='http://tgif.dothome.co.kr/teapot/user/class/grade.php?cls_FP=0'">
      무료 강의 체험하기<i class="fa-solid fa-chevron-right ms-3"></i>
    </button>
  </section>
  <section class="main_price content_container">
    <h2 class="suit_bold_m text-center my-5">최저가 구매 기회!</h2>
    <p class="suit_rg_s text-center my-5">
      영어 공부를 결심한 순간 작심삼일이 작심 평생이 되는 기회
    </p>
    <div class="price_wrapper d-flex gap-3">
      <div class="price_lists d-flex flex-column justify-content-between">
        <div class="price_main d-flex flex-column">
          <div class="price_info">
            <h3 class="suit_bold_s text-center my-5">초급 패키지</h3>
            <p class="suit_rg_xs text-center my-3">
              매번 다짐만 하는 영어 공부는 그만<br />기초부터 차근차근 티팟과
              시작해봐요
            </p>
            <hr />
            <h3 class="suit_bold_s text-center my-5">49,900원</h3>
          </div>
          <div class="price_desc">
            <ul class="price_desc_list">
              <li>수강기간 : 왕초보 탈출 최적기간 12개월</li>
              <li>패턴으로 구조잡고 확장까지-기초/특화 강의</li>
              <li>듣기부터 복습까지 회화 공략집</li>
              <li>패말문이 트이는 영어 회화 훈련 ai 트레이닝</li>
            </ul>
          </div>
        </div>
        <button type="button" data-clidx="11" id="btn_basic" class="suit_rg_s btn_price_buynow btn_buynow">
          지금 구매하기
        </button>
      </div>
      <div class="price_lists d-flex flex-column justify-content-between">
        <div class="price_main d-flex flex-column">
          <div class="price_info">
            <h3 class="suit_bold_s text-center my-5">중급 패키지</h3>
            <p class="suit_rg_xs text-center my-3">
              올해의 버킷리스트는 무엇인가요?<br />원어민들과 자연스러운
              대화까지 무조건 가능
            </p>
            <hr />
            <h3 class="suit_bold_s text-center my-5">59,900원</h3>
          </div>
          <div class="price_desc">
            <ul class="price_desc_list">
              <li>수강기간 : 왕초보 탈출 최적기간 12개월</li>
              <li>패턴으로 구조잡고 확장까지-기초/특화 강의</li>
              <li>듣기부터 복습까지 회화 공략집</li>
              <li>패말문이 트이는 영어 회화 훈련 ai 트레이닝</li>
            </ul>
            <ul class="price_desc_more">
              <li>
                <i class="fa-solid fa-check"></i>온라인 발음 과외 1:1 보이스케어
              </li>
              <li>
                <i class="fa-solid fa-check"></i>이미지로 쉽게 외우는 영단어 앱
              </li>
              <li>
                <i class="fa-solid fa-check"></i>원어민의 일상 대화 리얼 스피킹
                교재
              </li>
            </ul>
          </div>
        </div>
        <button type="button" data-clidx="2" id="btn_intermediate" class="suit_rg_s btn_price_buynow_r btn_buynow">
          지금 구매하기
        </button>
      </div>
      <div class="price_lists d-flex flex-column justify-content-between">
        <div class="price_main d-flex flex-column">
          <div class="price_info">
            <h3 class="suit_bold_s text-center my-5">고급 패키지</h3>
            <p class="suit_rg_xs text-center my-3">
              천천히 꾸준하게가 목표이신 분들<br />기간 제약 없이 티팟이 평생
              케어 해드릴게요.
            </p>
            <hr />
            <h3 class="suit_bold_s text-center my-5">109,900원</h3>
          </div>
          <div class="price_desc">
            <ul class="price_desc_list">
              <li>수강시간 : 기간 걱정 없이 평생수강</li>
              <li>패턴으로 구조잡고 확장까지-기초/특화 강의</li>
              <li>듣기부터 복습까지 회화 공략집</li>
              <li>패말문이 트이는 영어 회화 훈련 ai 트레이닝</li>
            </ul>
            <ul class="price_desc_more">
              <li>
                <i class="fa-solid fa-check"></i>온라인 발음 과외 1:1 보이스케어
              </li>
              <li>
                <i class="fa-solid fa-check"></i>이미지로 쉽게 외우는 영단어 앱
              </li>
              <li>
                <i class="fa-solid fa-check"></i>원어민의 일상 대화 리얼 스피킹
                교재
              </li>
            </ul>
          </div>
        </div>
        <button type="button" data-clidx="8" id="btn_advanced" class="suit_rg_s btn_price_buynow btn_buynow">
          지금 구매하기
        </button>
      </div>
    </div>
  </section>
</main>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/js/index.js"></script>
<script>
  $('.btn_buynow').click(function(){
    let getdata = $(this).attr('data-clidx');
    let data = {
        clidx:getdata
      } 
        $.ajax({
          async:false,
          type:'post',
          url:'buynow.php',
          data:data,
          dataType:'json',
          error:function(){
            console.log('error');
          },
          success:function(result){    
            console.log(result);
            if(result.result == "alert"){
              alert('로그인 후 이용해주세요');
              location.href = "<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/login.php";
            }else{
              alert('장바구니에 담겼습니다.');
              location.href = "<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/cart/cart.php";
            }
          }
      });
  })
</script>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>
