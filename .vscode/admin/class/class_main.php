<?php
	include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );

?>
    <link rel="stylesheet" href="../css/class_main.css" />
<?php
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

  

        // Pagenation
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $pagesql = "SELECT COUNT(*) as cnt from lms_class";
        $page_result = $mysqli->query($pagesql);
        $page_row = $page_result->fetch_assoc();
        $row_num = $page_row['cnt']; //전체 게시물 수
        // print_r($row_num);

        $list = 3; //페이지당 출력할 게시물 수
        $block_ct = 3;
        $block_num = ceil($page/$block_ct);//page9,  3/5 1.2 2
        $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
        $block_end = $block_start + $block_ct -1; //start 1, end 5

        $total_page = ceil($row_num/$list); //총42, 42/5
        if($block_end > $total_page) $block_end = $total_page;
        $total_block = ceil($total_page/$block_ct);//총32, 2
        $start_num = ($page -1) * $list;

        $sql = "SELECT * from lms_class order by clidx desc limit $start_num, $list";
        $result = $mysqli->query($sql);

        while($rs=$result->fetch_object()){
            $rsc[]=$rs;
        }

    ?>

                <section class="col-10 align-self-center">
                    <div class="class_top d-flex row">
                        <h2 class="col-md-3 suit_bold_xl">클래스 관리</h2>
                        <div class="class_top_etc col-md-8">
                            <div class="class_R_top d-flex">
                                <form action="./class_result.php" method="GET">
                                    <div class="submit_upper d-flex">
                                        <div class="select_wrap d-flex">
                                            <select id="class_cate" name="cls_cat"
                                                    class="c_sub"
                                                    id="class_cate">
                                                <option value="" disabled selected>제목</option>
                                                <option value="title" >제목</option>
                                                <option value="cate">키워드</option>
                                            </select>
                                            <i class="fa-solid fa-caret-down cls_cate_tit"></i>
                                        </div>
                                        <div class="searchs">
                                            <input type="search" class="search" />
                                            <button class="btn">
                                                <i
                                                    class="fa-solid fa-magnifying-glass"
                                                ></i>
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
                                <button class="btn_l">
                                    <a href="class_submit.php">&#43;클래스등록</a>
                                </button>
                            </div>
                            <ul class="class_R_top m27 d-flex">
                                <li class="select_list">좋아요</li>
                                <li>&#124;</li>
                                <li class="select_list">전체공개강의</li>
                            </ul>
                        </div>
                    </div>
                    <div class="class_mid ms-5">
                        <ul class="d-flex">
                            <?php 
                            
                            foreach($rsc as $r){
                                    $sql2 = "SELECT count(*) as cnt from lms_lec where lec_clsnum=$r->clidx";
                                    $result2 = $mysqli->query($sql2);
                                    $rsc2 = $result2->fetch_object();
                            ?>
                            <li class="class_row d-flex">
                                <div class="thubnail">
                                    <img
                                            src="<?php echo $r->thumb_url;?>"
                                            alt="클래스 썸네일"
                                            />
                                </div>
                                <div class="class_text ms-3">
                                    <div class="tit_top d-flex row mb-3">
                                        <h3 class="suit_rg_m col-md-8">
                                            <?php echo $r->cls_title;?>
                                        </h3>
                                        <ul class="class_rate d-flex col-md-4">
                                        
                                                <li class="d-flex">
                                                    <p class="level">강의수</p>
                                                    <div class="number"><?php echo $rsc2->cnt; ?></div>
                                                </li> 
                                            <li class="d-flex">
                                                <p class="level">
                                                    <?php echo $r->cls_cat; ?>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="txt_bot row">
                                        <div class="sub_tit col-md-5">
                                            <p class="suit_rg_s">
                                                <?php echo $r->cls_text?>
                                            </p>
                                        </div>
                                        <ul class="class_btn d-flex col-md-7">
                                            <li>
                                                <a href="../lec/lecture_main.php?clidx=<?php echo $r->clidx; ?>" class="btn_m"
                                                    >강의관리</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    href="class_modify.php?idx=<?php echo $r->clidx; ?>"
                                                    class="btn_m"
                                                    >수정</a
                                                >
                                            </li>
                                            <li>
                                                <a href="class_delete.php?idx=<?php echo $r->clidx;; ?>" class="btn_m"
                                                    >삭제</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="pagination">
                        <ul
                            class="class_pg d-flex justify-content-center m54 align-items-center">
                        <?php
                         if($page>1){
                           if($block_num > 1){
                               $prev = ($block_num-2)*$block_end + 1;
                               echo "<li>
                                 <a class='suit_bold_m' href='?page=$prev'>
                                   <i class='fa-solid fa-angles-left'></i>
                                 </a>
                               </li>";
                           }
                         }
                         for($i=$block_start;$i<=$block_end;$i++){
                           if($page == $i){
                               echo "<li><a href='?page=$i' class='suit_bold_m PG_num active click'>$i</a></li>";
                           }else{
                               echo "<li><a href='?page=$i' class='suit_bold_m PG_num'>$i</a></li>";
                           }
                         }
                         if($page<$total_page){
                           if($total_block > $block_num){
                               $next = $block_num*$block_end + 1;
                               echo "<li>
                                 <a class='suit_bold_m' href='?page=$next'>
                                   <i class='fa-solid fa-angles-right'></i>
                                 </a>
                               </li>";
                           }
                         }
                       ?>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        <?php



         $mysqli -> close()?>
        <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"
        ></script>
        <script
            type="module"
            src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
        ></script>
        <script
            nomodule
            src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
        ></script>
        <script src="../js/script.js"></script>
        <script src="../js/class.js"></script>
    </body>
</html>
