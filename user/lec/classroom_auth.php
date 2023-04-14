
<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
    $_SESSION['TITLE'] = 'ClassRoom';
    $uid = $_SESSION['UID'];
    $clidx = $_GET['clidx'];
    $que0 = "SELECT COUNT(*) AS cnt FROM lms_sold WHERE sold_uidx= '$uid' AND sold_clidx='$clidx'";
    $res0 = $mysqli->query($que0);
    $row0 = $res0->fetch_assoc();
    $soldcnt = $row0['cnt'];
?>   
<script>
    const getp = new URLSearchParams(window.location.search);
    const clidx = getp.get("clidx");
</script> 
<?php
    if($soldcnt == 0){
        echo "<script>
        alert('잘못된 접근입니다!');
        history.back();</script>";
    }
?>
    <link rel="stylesheet" href="../css/lec.css" />
<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";

    $clidx = $_GET['clidx'];

    $que1 = "SELECT * FROM lms_class where clidx = '$clidx'";
    $res1 = $mysqli->query($que1);
    $row1 = $res1->fetch_assoc();

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
        <div class="lf_wrapper d-flex justify-content-center">
            <section id="curriculum" class="auth">
                <h3 class="suit_bold_l">커리큘럼</h3>
                <ul class="suit_rg_s">

                </ul>
                <div class="more suit_rg_s d-flex justify-content-center" data-id="auth"> + 더보기</div>
            </section>
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
