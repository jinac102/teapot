<?php
  session_start();
  $_SESSION['TITLE'] = "class list";
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header_head.php";
  $uid =$_SESSION['UID'];
//    error_reporting( E_ALL );
?>
    <link rel="stylesheet" href="../css/class.css" />
    <?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_header.php";
?>

<?php

  // Pagenation
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    
    $pagesql = "SELECT COUNT(*) as clidx from lms_class";
    $page_result = $mysqli->query($pagesql);
    $page_row = $page_result->fetch_assoc();
    //print_r($page_row['qidx']);
    $row_num = $page_row['clidx']; //전체 게시물 수

    $list = 5; //페이지당 출력할 게시물 수
    $block_ct = 5;
    $block_num = ceil($page/$block_ct);//page9,  10/5 2
    $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
    $block_end = $block_start + $block_ct -1; //start 1, end 5
    $total_page = ceil($row_num/$list); //총42, 42/5
    if($block_end > $total_page) $block_end = $total_page;
    $total_block = ceil($total_page/$block_ct);//총32, 2
    $start_num = ($page -1) * $list;
    // echo ($start_num);

        $cls1 = "SELECT * from lms_class order by clidx desc limit $start_num, $list ";
        $result = $mysqli->query($cls1);
        if($result->num_rows > 0) {
            while($rs=$result->fetch_object()) {
                $rsc[]=$rs;
            }
        } 
        $fvque ="SELECT fv_clsnum FROM lms_favorite WHERE fv_uid = '$uid'"; 
        $fvres = $mysqli->query($fvque);
        while($fv=$fvres->fetch_object()) {
            $fvc[]=$fv;
        } 
        // print_r($fvc);
    ?>
<main>
    <div class="banner">
        <div class="title content_container d-flex justify-content-between align-items-center">
            <div class="desc">
              <h2 class="suit_bold_xl">클래스</h2>
              <p class="suit_rg_m">Teapot에서만 들을 수 있는 수업! 지금 신청해보세요.</p>
            </div>
            <div class="img">
              <img src="../img/cls/class_banner.png" alt="클래스 배너 아이콘 이미지">
            </div>
        </div>
    </div>
    <section class="tb150">
        <h2 class="hidden">class</h2>
        <div class="cls_wrap">
            <div class="cls_R_BTN">
                <div
                    class="d-flex justify-content-end"
                >
                    <div class="form-check d-flex">
                        <div
                            class="cls_f_RBTN RBTN suit_bold_s <?= $cls_FP == 0; ?>"
                        ><a href="/teapot/user/class/grade.php?cls_FP=0" class="">무료</a></div>
                        <div
                            class="cls_p_RBTN RBTN suit_bold_s <?= $cls_FP == 1; ?>"
                        ><a href="/teapot/user/class/grade.php?cls_FP=1" class="">유료</a></div>
                    </div>
                </div>
            </div>
            <div
                class="cls_ch_btn d-flex justify-content-end"
            >
                <div class="form-check" data-filter="all">
                    <input
                        class="form-check-input hidden"
                        type="radio"
                        value=" "
                        id="chbtn_all"
                        name="cbn_ch"
                        <?php if($ch_jr){echo "checked";}?>
                    />
                    <label class="form-check-label" for="chbtn_all">
                        전체</label
                    >
                </div>
                <div class="form-check">
                    <input
                        class="hidden"
                        type="radio"
                        value="초급"
                        id="chbtn_jr"
                        name="cbn_ch"
                        <?php if($ch_jr){echo "checked";}?>
                    />
                    <label class="form-check-label" for="chbtn_jr"
                        >초급</label
                    >
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input hidden"
                        type="radio"
                        value="중급"
                        name="cbn_ch"
                        id="chbtn_mid"
                        <?php if($ch_mid){echo "checked";}?>
                    />
                    <label class="form-check-label" for="chbtn_mid"
                        >중급</label
                    >
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input hidden"
                        type="radio"
                        value="고급"
                        id="chbtn_high"
                        name="cbn_ch"
                        <?php if($ch_high){echo "checked";}?>
                    />
                    <label class="form-check-label" for="chbtn_high">
                        고급</label
                    >
                </div>
            </div>
            <ul class="main_contents d-flex flex-wrap">
            <?php
            if( !empty($rsc) ){
                    foreach($rsc as $rs){
                 ?>
                <li class="DP_shadow row" value="<?php echo $rs->cls_st;?>">
                    <div class="cls_tit col-6">
                        <ul class="cls_tit_content">
                            <li class="d-flex catenlike">
                                <p class="cls_cate suit_rg_s">
                                    <?php echo $rs->cls_cat; ?>
                                </p>
                                <div class="sprite like fav" data-idx="<?= $rs->clidx;?>" data-favo="<?php
                                     $fava = $rs->clidx;
                                     $found = false;
                                     foreach ($fvc as $item) {
                                         if ($item->fv_clsnum == $fava) {
                                             $found = true;
                                             break;
                                         }
                                     }
                                     if ($found) {
                                         echo 'true';
                                     } else {
                                         echo 'false';
                                     }
                                    ?>">
                          
                                        <span class="hidden">like</span>
                            </li>
                            <li class="suit_rg_m">
                                <?php echo $rs->cls_title;?>
                            </li>
                            <li class="suit_rg_s">
                                <?php
                                
                                    $cls_text = strip_tags( $rs->cls_text );
                                    if (strlen($cls_text) > 26) {
                                        $cls_txt = iconv_substr($cls_text, 0, 26) . "...";
                                    }
                                    echo $cls_txt;
                                ?>
                            </li>
                            <li class="suit_rg_s btn_s_p">
                                <a href="../lec/classroom.php?clidx=<?php echo $rs->clidx; ?>"> 더보기 &#62; </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 cls_thumb">
                        <img
                            src="<?php echo $rs->thumb_url;?>"
                            alt="클래스 썸네일"
                        />
                    </div>
                </li>
                <?php } }
                ?>
            </ul>
            <div class="pagination justify-content-center">
                <ul class="class_pg d-flex justify-content-center align-items-center gap-5">
                    <?php
                        if($page>1){
                            if($block_num > 1){
                                $prev = ($block_num-2)*$list + 1;
                                echo "<li>
                                <a class='suit_bold_m' href='?page=$prev'
                                ><i class='fa-solid fa-angles-left'></i
                                ></a>
                            </li>";
                            }
                        }
                        for ($i=$block_start;$i<=$block_end;$i++) {
                            if ($i == $page) {
                                echo "<li><a href='?page=$i' class='suit_bold_m PG_num click'>$i</a></li>";
                            } else {
                                echo "<li><a href='?page=$i' class='suit_bold_m PG_num'>$i</a></li>";
                            }
                        }
                        if($page<$total_page){
                            if($total_block > $block_num){
                                $next = $block_num*$list + 1;
                                echo "<li>
                                <a class='suit_bold_m' href='?page=$next'
                                ><i class='fa-solid fa-angles-right'></i
                                ></a>
                            </li>";
                            }
                        }
                        ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<?php 
  include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer.php";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>

<script>

$('.form-check-label').click(function(){
    $(this).addClass('grade_check');
});

$('.form-check-input').change(function(){


    let current_url = "http://tgif.dothome.co.kr/teapot/user/class/class_list.php?";
    let param = $(this).val();
    let new_url = `${current_url}grade=${param}`;
    location.href = new_url;

});


//like_fav
let favIns=document.querySelectorAll('.fav');
    for(favi of favIns){
        let favac = favi.dataset.favo;
        let clidx = favi.dataset.idx;
        if (favac == "true") {
            favi.classList.add("check");
        }
        favi.addEventListener("click", (e) => {
            fetch("fav_toggle.php", {
                method: "post",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "favtog=" + e.target.dataset.favo + "&clidx=" + clidx
            })
            .then((resp) => resp.json())
            .then((resp) => {
                if (resp.result == "ins") {
                    console.log(resp);
                    alert("좋아요를 추가하였습니다.");
                    e.target.classList.add("check");
                    e.target.dataset.favo = 'true';
                } else if (resp.result == "del") {
                    console.log(resp);
                    alert("좋아요를 삭제하였습니다.");
                    e.target.classList.remove("check");
                    e.target.dataset.favo = 'false';
                } else if (resp.result == "alert") {
                    alert("로그인이 필요합니다.");
                }
            });
        });
    }
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/user_footer_tail.php"; ?>