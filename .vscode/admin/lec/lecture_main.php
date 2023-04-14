<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php"; 
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

$clidx = $_GET['clidx'];
$hit = $_GET['hit']??'';

if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
if($hit == 1){
    $order = "ORDER BY lec_hit DESC";
    $hitpage = "&hit=1";
}else{
    $order = "ORDER BY lidx DESC";
    $hitpage = "";
}

$sql2 = "SELECT * FROM lms_class WHERE clidx = '$clidx'";
$result2 = $mysqli -> query($sql2) or die('query error'.$mysqli_error);
$rs2=$result2 -> fetch_object();

//pagenation
$pagesql = "SELECT COUNT(*) as cnt FROM lms_lec WHERE lec_clsnum='$clidx'";
$pageresult = $mysqli -> query($pagesql);
$pagerow = $pageresult->fetch_assoc();

$rownum = $pagerow['cnt']; //전체게시물수

$list = 5; //페이지 출력개수
$block_ct = 5; //페이지네이션 출력개수
$block_num = ceil($page/$block_ct);//page6, 6/5 = 1.2 2
$block_start = (($block_num-1) * $block_ct) + 1; // page1 start1
$block_end = $block_start + $block_ct - 1; // start 1, end 5

$total_page = ceil($rownum/$list); // 총32 7
if($block_end > $total_page) $block_end = $total_page;
$total_block = ceil($total_page/$block_ct);

$start_num = ($page -1) * $list;
// $sql = "SELECT * FROM lms_lec WHERE lec_clsnum='$clidx' ORDER BY lidx DESC limit $start_num ,$list"; 
$sql = "SELECT * FROM lms_lec WHERE lec_clsnum='$clidx'"; 
$limit = " limit $start_num ,$list";
$sol= $sql.$order.$limit;

$result = $mysqli -> query($sol) or die('query error'.$mysqli->error);

$rsc = array();
while($rs=$result -> fetch_object()){
    $rsc[] = $rs;
}

?>
<script src="https://cdn.tiny.cloud/1/sji1jwiod94r5sk3fhqv2se8ar5mjzfo8e6mh9xq4hmmez4l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<link rel="stylesheet" href="../css/lec.css" />
<style>

    </style>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php"; 
?>
        <!-- aside끝 각 컨텐츠작업분 -->
        <section class="ps-5 col-md-10">
            <div class="lec_content">
                <div class="lec_main_head row">
                    <div class="lec_main_lhead col">
                        <h2 class="col-md-4 suit_bold_xl">강의 관리</h2>
                    </div>
                    <div class="lec_main_rhead col d-flex justify-content-end">
                        <a href="lecture_submit.php?clidx=<?= $clidx; ?>" class="btn_l">+ 강의등록</a>
                    </div>
                </div>
                <div class="lec_main_cont">
                    <div class="conhead d-flex justify-content-between">
                        <div class="conhead_title">
                            <h3 class="suit_rg_l">
                            <?= $rs2-> cls_title;?>
                            </h3>
                        </div>
                        <div class="conhead_sort d-flex justify-content-end suit_rg_s">
                            <span>
                                <a href = "?clidx=<?= $clidx; ?>&hit=1">조회수순</a>
                            </span>
                            <span>|</span>
                            <span>
                            <a href = "?clidx=<?= $clidx; ?>">회차순</a></span>
                        </div>
                    </div>
                    <div class="lec_main_conbody">
                        <ul class="conlist">   
                            <?php
                            if($result->num_rows > 0) {
                                foreach($rsc as $r){  
                                ?>
                            <li class="d-flex justify-content-between">
                                <p class="suit_rg_m letl">
                                    <a class="lecture_title" href="lecture_preview.php?lidx=<?= $r->lidx; ?>"><?php     
                                    if(iconv_strlen($r->lec_title)> 40){
                                            echo str_replace($r->lec_title,iconv_substr($r->lec_title,0,40).'...',$r->lec_title);
                                        } else{
                                            echo $r->lec_title;
                                        }?>
                                 </p></a>
                                <p class="suit_bold_s d-flex justify-content-end align-item-center">
                                    <span class="lec_hit suit_rg_s">
                                        조회수 <?= $r->lec_hit;?>
                                    </span>
                                    <span id="modify">
                                        <button type="button" id="<?= $r->lidx; ?>" class="lec_modify suit_bold_s" data-bs-toggle="modal" data-bs-target="#exampleModal">수정</button>
                                    </span>
                                    <span id="delete">
                                    <a href="lecture_delete.php?lidx=<?= $r->lidx ?>&clidx=<?= $clidx; ?>" class="suit_bold_s" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a> 
                                    </span>
                                </p>
                            </li>
                            <?php 
                            } 
                            } ?>
                        </ul>
                        <div class="pagination">
                            <ul class="class_pg d-flex justify-content-center m54 align-items-center">   
                                <?php
                                    if($block_num > 1){
                                        $prev = ($block_num-2)*$list + 1;
                                        echo"<li>
                                        <a class='suit_bold_m' href='?clidx=$clidx&page=$prev'>
                                            <i class='fa-solid fa-angles-left'></i>
                                        </a>
                                        </li>";
                                    }                                        
                                    for($i=$block_start ; $i<=$block_end ; $i++){
                                        if($page == $i){
                                            echo "<li>
                                            <a class='suit_bold_m PG_num click' href='?clidx=$clidx$hitpage&page=$i'>$i</a>
                                            </li>";
                                        }else{
                                            echo "<li>
                                            <a class='suit_bold_m PG_num' href='?clidx=$clidx$hitpage&page=$i'>$i</a>
                                            </li>";
                                        }
                                    }
                                        if($total_block > $block_num){
                                        $next = ($block_num)*$list + 1;
                                        echo"<li>
                                        <a class='suit_bold_m' href='?clidx=$clidx$hitpage&page=$next'>
                                            <i class='fa-solid fa-angles-right'></i>
                                        </a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content p-5 d-flex justify-content-center overflow-auto">
        <form method="post" enctype="multipart/form-data" id="lecture_modify">    
            <input type="hidden" name="lidx" id="lidx" value="">
            <input type="hidden" name="file_table_id" id="file_table_id" value="">
            <div class="submit_upper d-flex">
                <input type="text" placeholder="강좌명" name="title" id="title" value="">
                <div class="select_wrap">
                    <select name="status" id="status" required value="">
                        <option value="" >
                            공개여부
                        </option>
                        <option value="0">
                            무료강의
                        </option>
                        <option value="1">
                            유료강의
                        </option>
                        <option value="2">
                            비공개
                        </option>
                    </select>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
            </div>
            <div class="submit_mid d-flex">
                <div class="upload_link">
                    <h4 class="suit_rg_m">
                        영상 업로드
                    </h4>
                    <div class="link_bottom suit_rg_s">
                        <p>
                            영상의 유튜브 주소를
                            입력해주세요.
                        </p>
                        <div class="input_wrap">
                            <input type="text" name="href" id="href" value="">
                            <i class="fa-solid fa-link"></i>
                        </div>
                    </div>
                </div>
                <div class="upload_attach">
                    <h4 class="suit_rg_m">
                        강의자료
                    </h4>
                    <div id="upload_box" class="d-flex flex-column justify-content-center">

                        <div id="uplist">
                
            
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="submit_bot">
                <textarea id="note" name="note">
                    
                </textarea>
            </div>
            <div class="buttons d-flex justify-content-end">
                <button class="btn_s">수정</button>
                <button type="button" class="btn_s" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">취소</button>
            </div>
        </form>
    </div>
  </div>
</div>
    <script src="../js/lec_modi.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php"; ?>
