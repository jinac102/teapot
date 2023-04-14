
<?php
    session_start();
    $_SESSION['TITLE'] = 'ClassRoom';
    $uid = $_SESSION['UID'];
    $clidx = $_GET['clidx'];
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
    $que0 = "SELECT COUNT(*) AS cnt FROM lms_sold WHERE sold_uidx= '$uid' AND sold_clidx='$clidx'";
    $res0 = $mysqli->query($que0);
    $row0 = $res0->fetch_assoc();
    $soldcnt = $row0['cnt'];

    $cookieName = 'recentView';

    if(isset($_COOKIE[$cookieName])){
        $recentView = $_COOKIE[$cookieName];
    }else{
        $recentView = '';
    }
    if(empty($recentView)){
        $recentView = $clidx;
    }else{
        $recentViewArr = explode(',',$recentView);
        $uniqueArr = array_unique($recentViewArr);
        $sliceArr = array_slice($uniqueArr, 0, 2);
        array_unshift($sliceArr,$clidx);
        $recentView = implode(',',$sliceArr);
    }
    setcookie($cookieName, $recentView,0,"/teapot");

?>
<script>
    const getp = new URLSearchParams(window.location.search);
    const clidx = getp.get("clidx");
</script>
<?php
    if($soldcnt >= 1){
        echo "<script>location.href=`classroom_auth.php?clidx=${clidx}`;</script>";
    }
    $que1 = "SELECT * FROM lms_class where clidx = '$clidx'";
    $res1 = $mysqli->query($que1);
    $row1 = $res1->fetch_assoc();
?>
    <meta property="og:title" content=" <?= $row1['cls_title']; ?>">
    <meta property="og:description" content="<?= $row1['cls_text']; ?>">
    <meta property="og:image" content="<?= $row1['thumb_url']; ?>">
    <meta property="og:url" content="http://tgif.dothome.co.kr/teapot/">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="../css/lec.css" />
<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";



    $que2 = "SELECT COUNT(*) as cnt FROM lms_lec where lec_clsnum = '$clidx'";
    $res2 = $mysqli->query($que2);
    $row2 = $res2->fetch_assoc();

    $rawp = $row1['cls_price'];
    $price = number_format($rawp);

    $que3 = "SELECT cls_hit FROM lms_class WHERE clidx = '$clidx'";
    $res3 = $mysqli->query($que3);
    $row3 = $res3->fetch_assoc(); 
    $hitup = $row3['cls_hit'] +1;

    $que4 = "UPDATE lms_class SET cls_hit = '$hitup' WHERE clidx = '$clidx'";
    $res4 = $mysqli->query($que4);

    $favque = "SELECT fidx FROM lms_favorite WHERE fv_uid ='$uid' AND fv_clsnum = '$clidx'";
    $favres = $mysqli -> query($favque);
    $favfet = $favres->fetch_object();
    $fav =  $favfet-> fidx;
   
?>
        <!-- ============== php ============== -->
<div class="head_deco">decoration</div>
<main class="classroom">
    <div class="lecture_wrapper d-flex flex-column">
        <div class="info_wrap d-flex">
            <div class="info_thumb">
                <figure class="class_thumb" style="background-image:url('<?= $row1['thumb_url']; ?>')">thumbnail</figure>
            </div>
            <div class="info_desc d-flex flex-column justify-content-between">
                <div>
                    <div class="info_cat suit_rg_s"><?= $row1['cls_cat']; ?></div>
                    <h3 class="suit_bold_m" >
                        <?= $row1['cls_title']; ?>
                    </h3>
                    <span class="info_dt">강의수강료</span>    
                    <span><strong><?= $price; ?>원</strong></span>
                    <br>
                    <span class="info_dt">강의 수</span> 
                    <span><?= $row2['cnt']; ?></span>
                    <p class="suit_rg_s"><?= $row1['cls_text']; ?></p>
                </div>
            </div>
        </div>
        <div class="contents d-flex justify-content-between">
            <div class="lf_wrapper">
                <nav class="tabs d-flex">
                    <a href="#detail" class="active">상세설명</a>
                    <a href="#curriculum">커리큘럼</a>
                </nav>
                <section id="detail">
                    <div class="introduce">
                        <h3 class="suit_bold_m">상세설명</h3>
                      <div class="intro_wrap d-flex justify-content-between">
                        <div class="intro_title suit_bold_m">                        
                            <?= $row1['cls_cat']; ?>를 끝내면
                                <br>
                            <em> 어떻게 달라질까?</em>                      
                        </div>
                        <div class="intro_desc">
                           <?= $row1['cls_text_detail'];?>
                        </div>
                      </div>
                    </div>
                    <div class="advantage">
                        <h3 class="suit_bold_m"><em>TEAPOT</em>에서만 느낄 수 있는 점</h3>
                        <div class="step_wrap">
                            <div class="step">
                                <div>
                                    <h4>step.01</h4>
                                    <p>미묘한 표현, 발음까지 한번에 배울 수 있어요!</p>
                                </div>
                            </div>
                            <div class="step">
                                <div> 
                                    <h4>step.02</h4>
                                    <p>내 스케쥴에 맞춘 영어수업! 버스, 지하철, 비행기 안에서도 가능해요! </p>
                                </div>
                            </div>
                            <div class="step">
                                <div>
                                    <h4>step.03</h4>
                                    <p>단어, 문법이 아닌 문장으로 배웁니다. 문장 자체를 활용할 수 있게 도와드려요!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="curriculum">
                    <ul class="suit_rg_s">
                    <!-- 리스트 불러오기 -->
                    </ul>
                    <div class="more suit_rg_s d-flex justify-content-center">
                        + 더보기
                    </div>
                </section>
            </div>
            <aside id="payment" class="align-self-start">
                <h3>클래스정보</h3>
                <div class="pay_wrap d-flex flex-column align-items-center">
                    <div class="pay_desc">
                        <p class="suit_bold_s">
                            <?= $row1['cls_title']; ?>
                        </p>
                        <p><?= $row1['cls_cat']; ?></p>
                        <p class="suit_rg_s">총 <?= $row2['cnt']; ?>개 강의</p>
                    </div>
                    <p class="suit_bold_l pay_price"><?= $price; ?> 원</p>
                    <button id="cart-a" class="btn_l_p suit_rg_m">클래스신청</button>
                    <?php 
                        $flque = "SELECT lidx FROM lms_lec WHERE lec_st=0 AND lec_clsnum='$clidx'" ;
                        $flres = $mysqli->query($flque);
                        $flrow = $flres->fetch_assoc();  
                        
                        if($flrow){
                    ?>
                        <button id="free_rec" 
                        class="btn_l_b suit_rg_m" 
                        onclick="location.href=`../class/lec_main.php?clidx=${clidx}&lidx=<?= $flrow['lidx']; ?>;`">
                    
                    <?php }else{
                    ?>
                        <button id="free_rec" 
                        class="btn_l_b suit_rg_m" 
                        onclick="alert('무료강의가 없습니다.');">
                    <?php
                    }
                    ?>
                    무료강의체험
                    </button>
                    
                    <p class="caution">
                        이 클래스는 티팟에서만 이용이 가능합니다. 해당
                        클래스의 저작권은 본 사이트 티팟에 있습니다.
                    </p>
                    <div class="pay_icon d-flex justify-content-between">
                        <span class="fav-ins funct" data-idx="<?php if($fav){ echo $fav;}else{ echo '0';}; ?>"><i class="fa-regular fa-heart"></i></span>
                        <span id="share" class="funct"><i class="fa-solid fa-share-nodes"></i></span>
                        <?php 
                        $cque = "SELECT count(*) AS cnt FROM lms_cart WHERE cart_clsnum = '$clidx' and cart_uid = '$uid'"; 
                        $cres = $mysqli->query($cque) or die("query_error" . $mysqli->error);
                        $craw =  $cres->fetch_object();
                        $cnt = $craw->cnt;
                        if($cnt == 0){
                        ?>
                            <span id="cart-ins" class="funct"><i class="fa-solid fa-cart-plus"></i></span>
                        <?php } else {?>
                            <span id="cart-ins" class="funct inserted"><i class="fa-solid fa-cart-plus"></i></span>
                        <?php }?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
    <script src="../js/lec.js"></script>
<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
?>