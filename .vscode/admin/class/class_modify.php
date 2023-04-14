<?php
	include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
?>

    <link rel="stylesheet" href="../css/class_main.css" />

<?php
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

    $clidx = $_GET['idx'];

    $sql= "SELECT * FROM lms_class where clidx='$clidx'";
    $result = $mysqli ->query($sql) or die("query_error".$mysqli->error);
    $rs = $result ->fetch_assoc();


?>
                <section class="col-10 align-self-center">
                    <div class="class_top d-flex row mbt54">
                        <h2 class="col-md-4 suit_bold_xl">클래스 수정</h2>
                    </div>
                    <form action="class_modify_ok.php" method="post" class="ms-3" onsubmit="return save();" enctype="multipart/form-data" id="cls_upload_img">
                        <input type="hidden" name="clidx" value="<?php echo $clidx; ?>">
                        <div class="class_subit_mid d-flex mb27">
                            <div class="class_submit_L col-md-6 d-flex row">
                                <div
                                    class="DND R_BR col-md-6 text-center class_modi"
                                >
                                    <h3 class="suit_rg_m mb27">이미지 등록</h3>
                                    <div class="img_DND row" id="box">
                                        <img id="box_img" src="<?php echo $rs['thumb_url'];
                                                    ?>" alt="">
                                            <input type="hidden" name="thumb_url" id="thumb_url" value="<?php echo $rs['thumb_url']; ?>">
                                            <div id="drop" class="box">
                                                <div id="thumbnails">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="c_submit_btns d-flex justify-content-end mt-3 me-4">
                                        <!-- <button class="btn_s">
                                            <a  onclick="jQuery('#upfile').click()" href="class_save_thumb.php">수정</a>
                                        </button> -->
                                        <button type="button" class="btn_s close" id="thumb_del" data-id="<?php echo $clidx; ?>">
                                            삭제
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="classprice R_BR col-md-6 text-center"
                                >
                                    <h3 class="suit_rg_m mb27">금액</h3>
                                    <ul
                                        class="class_price d-flex justify-content-center"
                                    >
                                    <?php
                                        // 체크박스 상태를 설정
                                        if ($rs["cls_st"] === "0") {
                                        $checked1 = "checked";
                                        $checked2 = "";
                                        }else if($rs["cls_st"] === "1") {
                                        $checked1 = "";
                                        $checked2 = "checked";
                                        }                   
                                    ?>
                                    <li class="d-flex">
                                            <input type="radio" name="FNP" id="free" value="0" <?php echo $checked1 ?>/>
                                            <label for="free" class="suit_rg_s price_btn">무료</label>
                                            <input type="radio"name="FNP"id="paid" value="1" <?php echo $checked2 ?>/>
                                            <label for="paid"
                                                class="suit_rg_s price_btn"
                                                >유료</label>
                                        </li>
                                        <li>
                                            <p class="suit_rg_s price_C_G price_free">
                                                원
                                            </p>
                                            <input
                                                type="number"
                                                name="cls_price"
                                                id="price"
                                                class="class_p_txt"
                                                value="<?php echo $rs['cls_price']; ?>" min="0" max="10000000" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="class_submit_R R_BR col-md-6">
                                <ul>
                                    <li class="mb18">
                                        <div class=" mb18">
                                            <h3 class="suit_rg_m mb18">
                                                클래스 정보
                                            </h3>
                                            <input
                                                type="text"
                                                placeholder="클래스명"
                                                class="class_tit c_sub"
                                                value="<?php echo $rs['cls_title']; ?>"
                                                name="cls_title"
                                            />
                                        </div>
                                        <select
                                            name="class_cate"
                                            class="c_sub"
                                            id="class_cate"
                                            
                                        >
                                            <option value="" disabled selected>
                                                <?php echo $rs['cls_cat']; ?>
                                                <i
                                                    class="fa-solid fa-caret-down"
                                                ></i>
                                            </option>
                                            <option value="초급_일상회화">
                                                    초급_일상회화
                                                </option>
                                                <option value="중급_일상회화">
                                                    중급_일상회화
                                                </option>
                                                <option value="고급_일상회화">
                                                    고급_일상회화
                                                </option>
                                                <option value="초급_여행회화">
                                                    초급_여행회화
                                                </option>
                                                <option value="중급_여행회화">
                                                    중급_여행회화
                                                </option>
                                                <option value="고급_여행회화">
                                                    고급_여행회화
                                                </option>
                                                <option value="초급_비지니스회화">
                                                    초급_비지니스회화
                                                </option>
                                                <option
                                                    value="중급_비지니스회화"
                                                >
                                                    중급_비지니스회화
                                                </option>
                                                <option value="고급_비니지스회화">
                                                    고급_비니지스회화
                                                </option>
                                                <option value="초급_SNS회화">
                                                    초급_SNS회화
                                                </option>
                                                <option value="중급_SNS회화">
                                                    중급_SNS회화
                                                </option>
                                                <option value="고급_SNS회화">
                                                    고급_SNS회화
                                                </option>
                                        </select>
                                    </li>
                                    <li>
                                        <h3 class="suit_rg_m mb18">강좌소개</h3>
                                        <div>
                                            <textarea class="sub_detail" name="cls_text"><?php echo $rs['cls_text']; ?></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <h3 class="suit_rg_m mb18">강좌 상세 설명</h3>
                                        <div>
                                            <textarea id="tiny" name="cls_text_detail"><?php echo $rs['cls_text_detail']; ?></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="c_submit_btns d-flex justify-content-end">
                            <button class="btn_s" type="submit">수정
                            </button> 
                            <a class="btn_s" href="class_main.php">취소
                            </a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
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
        <script
            src="https://cdn.tiny.cloud/1/p6o8j0wimrfigyl87k6yzi7ip85hzbk03a21g4vu4y52h9vi/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"
        ></script>
        <script src="../js/script.js"></script>
        <script src="../js/class.js"></script>
        <script>
            // const cls_cate = 0; // 예시로 cls_cate를 0으로 설정
            // const checkbox1 = document.querySelector('input[value="0"]');
            // const checkbox2 = document.querySelector('input[value="1"]');

            // if (cls_cate === 0) {
            // checkbox1.checked = true;
            // } else {
            // checkbox2.checked = true;
            // }

            var uploadFiles = [];

    var $drop = $("#drop");
    $drop.on("dragenter", function(e) {  //드래그 요소가 들어왔을떄
    $(this).addClass('drag-over');
    }).on("dragleave", function(e) {  //드래그 요소가 나갔을때
    $(this).removeClass('drag-over');
    }).on("dragover", function(e) {
    e.stopPropagation();
    e.preventDefault();
    
    }).on('drop', function(e) {  //드래그한 항목을 떨어뜨렸을때
    e.preventDefault();
    $(this).removeClass('drag-over');
    var files = e.originalEvent.dataTransfer.files;  //드래그&드랍 항목
        console.log(files);
    for(var i = 0; i < files.length; i++) {
        var file = files[i];
        var size = uploadFiles.push(file);  //업로드 목록에 추가
        attachFile(files[i]);
        
    }  
    });
    function preview(file, idx) {
    console.log(idx);
    var reader = new FileReader();
    reader.onload = (function(f, idx) {
        return function(e) {
        var div = '<div class="thumb" id="f_' + idx + '"> \
            <button type="button" class="close" data-idx="' + idx + '">X</button> \
            <img src="' + e.target.result + '" /> \
        </div>';
        $("#thumbnails").append(div);
        };
    })(file, idx);
    reader.readAsDataURL(file);
    }
    $("#thumbnails").on("click", ".close", function() {
        $('#thumb_url').val('');
        $('#thumbnails').find('.thumb').hide();
        alert('삭제');
    });

    function attachFile(file){
        var formData = new FormData();                  
        formData.append('savefile', file);
        //<input name="savefile" value="첨부파일명">
        console.log(formData);
                              
        $.ajax({
                url: 'class_save_thumb.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,                         
                type: 'post',
                dataType:'json',
                beforeSend: function(){},//product_save_image.php 응답하기전 할일
                error:function(){
                    alert("error");
                },//product_save_image.php 없으면 할일
                success: function(return_data){ //product_save_image.php 유무
                    console.log(return_data);
                    console.log(return_data.result);
                    //관리자 유무, 어드민아니면 로그인메시지
                    if(return_data.result == "size"){
                        alert('10메가 이하만 첨부할 수 있습니다.');
                        return;                    
                    } else if(return_data.result == "image"){
                        alert('이미지만 첨부할 수 있습니다.');
                        return;
                    } else if(return_data.result == "error"){
                        alert('첨부실패, 관리자에게 문의하세요');
                        return;
                    } else{
                        $("#thumb_url").val(return_data.imgurl);
                        preview(file, return_data.imgid); 
                        alert('이미지 등록');
                    }   
                }
        });
    }

    function file_del2(){

    }

    function file_del(imgid){
        if(!confirm('삭제하시겠습니까?')){
            return false;
        }
        let data = {
            clidx : imgid
        }

        $.ajax({
            async:false, //응답결과 있으면 실행,
            url:'class_delete_thumb.php',
            type:'post',
            data: data,
            // dataType:'text',
            success:function(return_data){
                console.log(typeof return_data);
                if(return_data.result == "member"){
                        alert('관리자로 로그인하세요');
                        return;
                } else if(return_data.result == "my"){
                    alert('본인이 작성한 제품의 이미지만 삭제할 수 있습니다.');
                    return;                    
                } else if(return_data.result == "no"){
                    alert('삭제실패, 관리자에게 문의하세요');
                    return;
                } else{
                    $('#box_img').hide();
                }
            }            
        })
    }

    $('#thumb_del').click(function(){
        let id = $(this).attr('data-id');
        file_del(id);
    });


        </script>
    </body>
</html>

