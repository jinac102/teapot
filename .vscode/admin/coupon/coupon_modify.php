<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_header.php";

    $bno = $_GET['idx'];
    $sql = "SELECT * from lms_coupon_cat where cc_idx=$bno"; //idx번호에 맞는 게시글 추출 구문 저장
    $result = $mysqli->query($sql); //게시글 추출 구문 실행
    $row = $result->fetch_assoc(); // 게시글 추출내용을 연관배열로 저장
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="../css/coupon_add.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_aside.php";
?>
                <main class="p-5 col-md-10 suit_rg_l">
                    <h2 class="suit_bold_xl">쿠폰수정</h2>
                    <div class="contents d-flex flex-column gap-5">
                    <form method="post" action="coupon_modify_ok.php" onsubmit="return save()" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                     <input type="hidden" name="cid" value="<?php echo $bno;?>">
                        <p>
                            <label for="cc_name">쿠폰명</label>
                            <input type="text" name="cc_name" id="cc_name" value="<?php echo $row['cc_name'];?>"/>
                        </p>
                        <p>
                            <label for="coupon_discount">할인폭</label>
                            <input type="text" name="cc_min_price" value="<?php echo $row['cc_min_price'];?>">
                            <span class="desc">이상</span>
                        </p>
                        <div class="d-flex gap-2">
                            <label for=""></label>
                            <input type="text" id="discount_choice" disabled placeholder="할인유형을 선택하세요."/>
                            <input type="number" id="cc_price" name="cc_price" class="cc_price" value="<?php echo $row['cc_price'];?>"/>
                            <input type="number" id="cc_ratio" name="cc_ratio" class="cc_ratio" value="<?php echo $row['cc_ratio'];?>"/>
                            <div class="select_wrap">
                                <select name="cc_type" id="cc_type" class="suit_rg_m discount">
                                    <option>선택</option>
                                    <option value="1"<?php if($row['cc_type']==1){echo "selected='selected'";}?>>₩</option>
                                    <option value="2"<?php if($row['cc_type']==2){echo "selected='selected'";}?>>%</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <p class="small d-flex align-items-center gap-2">
                            <label for="coupon_deadline">쿠폰기한</label>
                            <span class="date_wrap">
                                <input
                                    type="text"
                                    name="regdate"
                                    class="datepicker"
                                    value="<?php echo $row['regdate'];?>"
                                />
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            ~
                            <span class="date_wrap">
                                <input
                                    type="text"
                                    name="duedate"
                                    class="datepicker"
                                    value="<?php echo $row['duedate'];?>"
                                />
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            <input type="checkbox" name="date_limit" class="date_limit" value="<?php echo $row['date_limit'] ?>" <?php if($row['date_limit']==0) echo "checked" ?> />
                            <?php if($row['date_limit']==0) echo "<input type='hidden' name='date_limit' id='checked' value='1'/>" ?>
                            <?php if($row['date_limit']==1) echo "<input type='hidden' name='date_limit' id='checked' value='1' checked/>" ?>
                            <span class="desc">기한없음</span>
                        </p>
                        <div class="d-flex gap-2">
                            <label for="">발급방식</label>
                            <div class="select_wrap">
                                <select name="cc_passive" id="cc_passive" class="suit_rg_m type" value="<?php echo $row['cc_passive'];?>">
                                    <option>선택하기</option>
                                    <option value="1"<?php if($row['cc_passive']==1){echo "selected='selected'";}?>>자동발급</option>
                                    <option value="2"<?php if($row['cc_passive']==2){echo "selected='selected'";}?>>수동발급</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <label for="">상태</label>
                            <div class="select_wrap">
                                <select name="statu" id="statu" class="suit_rg_m type" value="<?php echo $row['statu'];?>">
                                    <option>선택하기</option>
                                    <option value="1"<?php if($row['statu']==1){echo "selected='selected'";}?>>사용</option>
                                    <option value="0"<?php if($row['statu']==0){echo "selected='selected'";}?>>대기</option>
                                    <option value="-1"<?php if($row['statu']==-1){echo "selected='selected'";}?>>마감</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="edit d-flex flex-row-reverse gap-4">
                        <button class="btn_s" onclick='history.back()' type='button'">취소</button>
                        <button class="btn_s" type="submit">수정</button>
                    </div>
                    </form>
                </main>
            </div>
        </div>
        <?php
            include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_footer.php";
        ?>
            <script src="../js/coupon_add.js"></script>
    </body>
</html>
