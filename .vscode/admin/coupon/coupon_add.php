<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_header.php";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="../css/coupon_add.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_aside.php";
?>
                <main class="p-5 col-md-10 suit_rg_l">
                    <h2 class="suit_bold_xl">쿠폰등록</h2>
                    <div class="contents d-flex flex-column gap-5">
                    <form method="post" action="coupon_ok.php" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                        <p>
                            <label for="cc_name">쿠폰명</label>
                            <input type="text" name="cc_name" id="cc_name" />
                        </p>
                        <p>
                            <label for="coupon_discount">할인폭</label>
                            <input type="text" name="cc_min_price" />
                            <span class="desc">이상</span>
                        </p>
                        <div class="d-flex gap-2 align-items-center">
                            <label for=""></label>
                            <input type="text" id="discount_choice" disabled placeholder="할인유형을 선택하세요."/>
                            <input type="number" id="cc_price" name="cc_price" class="cc_price" value="0"/>
                            <input type="number" id="cc_ratio" name="cc_ratio" class="cc_ratio" value="0"/>
                            <div class="select_wrap">
                                <select name="cc_type" id="cc_type" class="suit_rg_m discount" value="0">
                                    <option>선택</option>
                                    <option value="1">₩</option>
                                    <option value="2">%</option>
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
                                />
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            ~
                            <span class="date_wrap">
                                <input
                                    type="text"
                                    name="duedate"
                                    class="datepicker"
                                />
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            <input type="checkbox" name="date_limit" class="date_limit"/>
                            <input type="hidden" name="date_limit" id="checked" value='1' checked/>
                            <span class="desc">기한없음</span>
                        </p>
                        <div class="d-flex gap-2">
                            <label for="">발급방식</label>
                            <div class="select_wrap">
                                <select name="cc_passive" id="cc_passive" class="suit_rg_m type" value="1">
                                    <option>선택하기</option>
                                    <option value="1">자동발급</option>
                                    <option value="2">수동발급</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <label for="">상태</label>
                            <div class="select_wrap">
                                <select name="statu" id="statu" class="suit_rg_m type" value="1">
                                    <option>선택하기</option>
                                    <option value="1">사용</option>
                                    <option value="0">대기</option>
                                    <option value="-1">마감</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="edit d-flex flex-row-reverse gap-4">
                        <button class="btn_s" onclick='history.back()' type='button'">취소</button>
                        <button class="btn_s" type="submit">등록</button>
                    </div>
                    </form>
                </div> 
                </main>
            </div>
        </div>
        <?php
            include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/admin_footer.php";
        ?>
            <script src="../js/coupon_add.js"></script>
    </body>
</html>
