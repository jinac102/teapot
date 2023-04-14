<?php
  session_start();

  if(!$_SESSION['UID']){
        echo "<script>
            alert('로그인이 필요합니다.');
            location.href='/teapot/login.php';
        </script>";
    };
  $_SESSION['TITLE'] = "장바구니";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
?>
<link rel="stylesheet" href="../css/cart/cart.css" />
<?php

error_reporting(E_ALL);
ini_set( 'display_errors', '1' );

  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
  $userid = $_SESSION['UID'];

  $userSql = "SELECT * from lms_user WHERE userid='$userid'";
  $userResult = $mysqli->query($userSql) or die("query error => ".$mysqli->error);
  $urs = $userResult->fetch_object();
?>





<main>
<div class="banner">
    <div class="cart content_container d-flex justify-content-between align-items-center">
        <div class="about_cart">
            <h1 class="suit_bold_xl">장바구니</h1>
            <p class="suit_rg_m">
            듣고 싶은 수업을 찾았나요? Teapot과 함께라면 영어는 문제없어요! 외국인 앞에서도 자신감 넘치게!
            </p>
        </div>
        <img src="../img/cart/cart_banner.png" alt="question_mark" />
    </div>
</div>
<div class="cart_content content_container d-flex justify-content-between gap-5">
    <div class="cart_content_left">
        <div class="all_select_and_select_delete suit_rg_s d-flex justify-content-between">
            <div>
                <input type="checkbox" id="select_all" name="select_all">
                <label for="select_all" class="select_all_label">전체선택</label>
            </div>
            <p class="delete_all">선택삭제</p>
        </div>
        <?php
            $joinSql = "SELECT class.clidx, class.cls_title, class.cls_text, class.cls_price, class.thumb_url
            FROM  lms_cart cart
            INNER JOIN lms_class class
            ON cart.cart_clsnum = class.clidx
            WHERE cart.cart_uid='$userid'";
            $joinResult = $mysqli -> query($joinSql) or die("query error =>".$mysqli->error);
            if($joinResult->num_rows > 0){
            while($rs = $joinResult->fetch_object()){
              $jrs[]=$rs;
            }
            foreach($jrs as $j){
        ?>
        <div class="list">
            <div class="cart_list d-flex justify-content-between align-items-center">
                <div class="d-flex align-self-center align-items-center">
                    <input type="checkbox" name="select_one" value="<?php echo $j->clidx; ?>">
                    <label for="select_one" class="select_one_label"></label>
                        <!-- <div class="checkbox">
                            <label for="select_one" id="one_checked" class="cart_list_label"></label>
                            <label for="select_one" id="one_unchecked" class="cart_list_label"></label>
                        </div> -->
                    <div class="d-flex align-self-center align-items-center">
                        <img src="<?php echo $j->thumb_url; ?>" alt="">
                        <div>
                            <p class="class_title suit_bold_s"><?php echo $j->cls_title; ?></p>
                            <p class="suit_rg_s"><?php echo $j->cls_text; ?></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-self-center align-items-center">
                    <p class="class_price"><?php echo number_format($j->cls_price)."원"; ?></p>
                    <i class="fa-solid fa-x delete_one" value="<?php echo $j->clidx?>"></i>
                </div>
            </div>
        </div>
        <?php } }else{echo "
            <div class='d-flex gap-5 justify-content-center align-items-center' style='margin:200px 0'>
            <i class='fa-solid fa-basket-shopping' style='font-size:100px'></i>
            <h3>장바구니에 담긴 상품이 없습니다.<h3>
            </div>
            ";}?>
    </div>
    <!-- Aside -->
    <aside id="payment" class="align-self-start">
        <h3>결제정보</h3>
        <div class="payment_wrap">
            <div class="payment_info d-flex">
                <div class="payment_info_title suit_bold_xs d-flex flex-column">
                    <p>결제 ID</p>
                    <p>E-Mail</p>
                    <p>Tel.</p>
                </div>
                <div class="payment_info_content suit_rg_xs flex-column">
                    <p><?php echo $urs->username; ?></p>
                    <p><?php echo $urs->email; ?></p>
                    <p><?php echo $urs->userphone; ?></p>
                </div>
            </div>
            <div class="coupon_select">
                <?php
                    $joinCoupon = "SELECT *
                    FROM  user_coupons uco
                    INNER JOIN lms_coupon_cat lco
                    ON uco.couponid = lco.cc_idx
                    WHERE uco.userid = '$userid' and status=1";
                    $couponResult = $mysqli -> query($joinCoupon) or die("query error =>".$mysqli->error);
                    while($rs = $couponResult->fetch_object()){
                        $crs[]=$rs;
                    }
                    
                ?>
                <select name="search_type" id="search_type" class="category suit_rg_s">
                    <option value="" class="choose_coupon
                    ">쿠폰을 선택해주세요</option>
                    <?php foreach($crs as $c){ ?>
                        <option value="<?php echo $c->reason; ?>" ><?php echo $c->reason; ?></option>
                    <?php }?>
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="d-flex justify-content-between">
                <div class="amount_title d-flex flex-column align-items-start">
                    <p>선택강의 결제액</p>
                    <p>할인금액</p>
                    <p class="total_amount">총 결제금액</p>
                </div>
                <div class="amount_content d-flex flex-column align-items-end">
                    <p class="amount"><span>0</span>원</p>
                    <p class="discount"><span>0</span>원</p>
                    <p class="total_amount"><span>0</span>원</p>
                </div>
            </div>
            <button class="btn_l_p suit_rg_m pay">결제하기</button>
            <p class="cuation">회원 본인은 주문 내용을 확인했으며, 구매조건 및 개인 정보처리 방침과 결제에 동의합니다.</p>
        </div>
        <!-- <div class="pay_wrap d-flex flex-column align-items-center">
            <div class="pay_desc">
                <p class="suit_bold_s">
                    <?= $row1['cls_title']; ?>
                </p>
                <p><?= $row1['cls_cat']; ?></p>
                <p class="suit_rg_s">총 <?= $row2['cnt']; ?>개 강의</p>
            </div>
            <p class="suit_bold_l pay_price"><?= $price; ?> 원</p>
            <a href="" class="btn_l_p">클래스 신청</a>
            <a href="" class="btn_l_b">무료 강의 체험</a>
            <p class="caution">
                이 클래스는 티팟에서만 이용이 가능합니다. 해당
                클래스의 저작권은 본 사이트 티팟에 있습니다.
            </p>
            <div class="pay_icon d-flex justify-content-between">
                <span><i class="fa-regular fa-heart"></i></span>
                <span
                    ><i class="fa-solid fa-share-nodes"></i
                ></span>
                <span
                    ><i class="fa-solid fa-cart-plus"></i
                ></span>
            </div>
        </div> -->
    </aside>
</div>

</main>




<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>

<script src="../js/cart.js"></script>
<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php";
 ?>
  </body>
</html>