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
                                [중급] 여행 회화 - 프로 여행러들을 위한 원어민
                                회화
                            </h3>
                            <dl>
                                <dt>
                            <span class="info_dt">강의수강료</span>    
                            <span><strong><?= $price; ?>원</strong></span>
                            <br>
                            <span class="info_dt">강의 수</span> 
                            <span><?= $row2['cnt']; ?></span>
                            <?= $row1['cls_text']; ?>
                        </div>
                        <a href="" class="btn_l">무료강의 체험하기</a>
                    </div>
                </div>
                <section id="curriculum">
                    <h3 class="suit_bold_l">커리큘럼</h3>
                    <ul class="suit_rg_m">
                    </ul>
                    <div class="more suit_rg_m d-flex justify-content-center" data-id="auth"> + MORE</div>
                </section>
            </div>
        </main>
        <footer></footer>
        <script src="../js/lec.js"></script>
    </body>
</html>
