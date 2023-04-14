<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <link rel="stylesheet" href="" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="../css/common.css" />
        <link rel="stylesheet" href="../css/lec.css" />
    </head>
    <body>
        <header></header>
        <!-- ============== php ============== -->
        <?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

        $clidx = $_GET['clidx'];

        $que1 = "SELECT * FROM lms_class where clidx = '$clidx'";
        $res1 = $mysqli->query($que1);
        $row1 = $res1->fetch_assoc();

        $que2 = "SELECT COUNT(*) as cnt FROM lms_lec where lec_clsnum = '$clidx'";
        $res2 = $mysqli->query($que2);
        $row2 = $res2->fetch_assoc();

        $rawp = $row1['cls_price'];
        $price = number_format($rawp);
        ?>
        <!-- ============== php ============== -->
        <div class="head_deco">decoration</div>
        <main class="classroom">
            <div class="lecture_wrapper d-flex flex-column">
                <div class="info_wrap d-flex">
                    <div class="info_thumb">
                        <img src="<?= $row1['thumb_url']; ?>" alt="" />
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
                <div class="contents d-flex justify-content-between column-gap-4">
                    <div class="lf_wrapper">
                        <nav class="tabs d-flex">
                            <a href="#detail">상세설명</a>
                            <a href="#curriculum">커리큘럼</a>
                        </nav>
                        <section id="detail">
                            <h3 class="suit_bold_l">상세설명</h3>
                            <p>
                                현지에서 살아남기 위한 영어! 이거 하나만 알면
                                나도 현지인!
                            </p>
                        </section>
                        <section id="curriculum">
                            <h3 class="suit_bold_l">커리큘럼</h3>
                            <ul class="suit_rg_m">

                            </ul>
                            <div class="more suit_rg_m d-flex justify-content-center">
                                + MORE
                            </div>
                        </section>
                    </div>
                    <aside id="payment" class="align-self-start">
                        <h3 class="suit_bold_l">클래스 정보</h3>
                        <div class="pay_wrap d-flex flex-column align-items-center">
                            <div class="pay_desc">
                                <p>
                                    <?= $row1['cls_title']; ?>
                                </p>
                                <p><?= $row1['cls_cat']; ?></p>
                                <p>총 <?= $row2['cnt']; ?>개 강의</p>
                            </div>
                            <p class="suit_bold_l pay_price">
                                <?= $price; ?> 원</p>
                            <a href="" class="btn_l">클래스 신청</a>
                            <a href="" class="btn_l">무료 강의 체험</a>
                            <p class="caution">
                                이 클래스는 티팟에서만 이용이 가능합니다. 해당
                                클래스의 저작권은 본 사이트 티팟에 있습니다.
                            </p>
                            <hr />
                            <div class="pay_icon d-flex justify-content-between">
                                <span><i class="fa-regular fa-heart"></i></span>
                                <span
                                    ><i class="fa-solid fa-share-nodes"></i
                                ></span>
                                <span
                                    ><i class="fa-solid fa-cart-plus"></i
                                ></span>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
        <footer></footer>
        <script src="../js/lec.js"></script>
    </body>
</html>
