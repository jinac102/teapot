<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php"; 
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

$lidx = $_GET['lidx'];
$que = "SELECT * FROM lms_lec WHERE lidx='$lidx'";
$raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
$row = $raw -> fetch_object();

$que1 = "UPDATE lms_lec SET lec_hit = lec_hit + 1 WHERE lidx='$lidx'";
$raw1 = $mysqli->query($que1) or die("query_error".$mysqli->error);

$que2 = "SELECT * FROM lms_class WHERE clidx =" .(int)$row -> lec_clsnum;
$raw2 = $mysqli ->query($que2) or die("query_error".$mysqli->error);
$row2 = $raw2 -> fetch_object();
?>

<link rel="stylesheet" href="../css/lec.css" />

<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php"; 
?>

        <!-- aside끝 각 컨텐츠작업분 -->
        <section class="ps-5 col-md-10">
            <div class="lec_preview">
            <h2 class="suit_bold_xl"><?= $row2-> cls_title; ?></h2>
            <div class="submit_embed mb-3">
                <div class="row">
                    <div id="video-wrapper">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= $row -> lec_href; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                    </div>
                </div>
            </div>
                <div class="submit_upper d-flex justify-content-between">
                    <div class="preview_box">
                        <h4 class="suit_rg_m">강의명</h4>
                        <p class="suit_el_m">
                            <?= $row -> lec_title; ?>
                        </p>
                    </div>
                    <div class="preview_box">
                        <h4 class="suit_rg_m">등록일</h4>
                        <p class="suit_el_m">
                            <?= $row -> regdate; ?>
                        </p>
                    </div>
                </div>
                <div class="submit_mid d-flex d-flex justify-content-between">
                    <div class="preview_box">
                    <h4 class="suit_rg_m">조회수</h4>
                    <p class="suit_el_m">
                        <?= $row -> lec_hit; ?>
                    </p>
                    </div>
                    <div class="preview_box">
                    <h4 class="suit_rg_m">강의자료</h4>
                    <p class="suit_el_m">
                    <?php 
                        $flque = "SELECT filename FROM lms_table_file WHERE itemidx='$lidx' AND status=1";
                        $flraw = $mysqli -> query($flque) or die($mysqli->error);
                        $fr = array(); 
                        while($flrow = $flraw -> fetch_object()){
                            $fr[] = $flrow;
                        }
                        if(!empty($fr)) {
                            foreach($fr as $f){
                    ?>
                                <a href="../img/attach/<?= $f->filename; ?>" class="suit_el_s" target="blank"><?= $f->filename; ?></a>&nbsp;
                    <?php 
                            }
                        } else {
                            echo "첨부 파일이 없습니다.";
                        }
                    ?>
                    </p>
                    </div>
                </div>
                <div class="submit_text">
                <h4 class="suit_rg_m">강의설명</h4>
                <?= $row -> lec_text; ?>                
                </div>
            </div>
        </section>
    </div>
</div>
<script src="../js/lec.js"></script>

<?php include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php"; ?>