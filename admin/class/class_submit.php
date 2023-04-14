<?php
	include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
?>

    <link rel="stylesheet" href="../css/class_main.css" />

<?php
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

    $sql = "SELECT * from lms_class where cls_st = 1";
    $result = $mysqli -> query($sql) or die("query error => ".$mysqli->error);
    $row = $result -> fetch_object();


?>
                <section class="col-10 align-self-center">
                    <div class="class_top d-flex row mbt54">
                        <h2 class="col-md-4 suit_bold_xl">클래스 등록</h2>
                    </div>
                    <form action="class_submit_ok.php" method="post" class="ms-3" onsubmit="return save();" enctype="multipart/form-data" id="cls_upload_img">
                        <input type="hidden" name="file_table_id" id="file_table_id" value="">
                        <input type="hidden" name="contents" id="contents" value="">    
                        <div class="class_subit_mid d-flex mb27">
                            <div class="class_submit_L col-md-6 d-flex row">
                                <div class="DND R_BR col-md-6 text-center">
                                    <h3 class="suit_rg_m mb27">이미지 등록</h3>
                                        <div class="img_DND row" id="box">
                                            <!-- <input type="file" id="cls_thumb" name="thumb[]"  style="display:none;"/>
                                            <div onclick="jQuery('#cls_thumb').click()">
                                                <i class="fa-solid fa-image m27"></i>
                                                <p class="suit_rg_s">
                                                    누르셔서 이미지를 올려서 이미지를
                                                    등록해주세요
                                                </p>
                                            </div> -->
                                            <input type="hidden" name="thumb_url" id="thumb_url">
                                            <div id="drop" class="box">
                                            <i class="fa-solid fa-image m27"></i>
                                                <p class="suit_rg_s">
                                                원하는 이미지를 드래그앤드드롭으로 선 안에 올려주세요
                                                </p>
                                                <div id="thumbnails"></div>
                                            </div>
                                        <div class="thumb_preview"></div>
                                    </div>
                                </div>
                                <div
                                    class="classprice R_BR col-md-6 text-center"
                                >
                                    <h3 class="suit_rg_m mb27">금액</h3>
                                    <ul
                                        class="class_price d-flex justify-content-center"
                                    >
                                        <li class="d-flex">
                                            <input type="radio" name="FNP" id="free" value="0" checked/>
                                            <label for="free" class="suit_rg_s price_btn">무료</label>
                                            <input type="radio"name="FNP"id="paid" value="1"/>
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
                                                value="0" min="0" max="100000" disabled
                                            />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="class_submit_R R_BR col-md-6">
                                <ul>
                                    <li class="mb18">
                                        <div class="mb18">
                                            <h3 class="suit_rg_m mb18">
                                                클래스 정보
                                            </h3>
                                            <input
                                                type="text"
                                                placeholder="클래스명"
                                                class="class_tit c_sub"
                                                name="cls_title"
                                            />
                                        </div>
                                        <div class="select_wrap">
                                            <select
                                                name="cls_cat"
                                                class="c_sub cls_cate_type"
                                                id="class_cate_type"
                                            >
                                                <option value="" disabled selected>
                                                    카테고리
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
                                            <i class="fa-solid fa-caret-down cls_type_i"></i>
                                        </div>
                                    </li>
                                    <li class="mb18">
                                        <h3 class="suit_rg_m mb18">강좌소개</h3>
                                        <div>
                                            <textarea class="sub_detail" name="cls_text"></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <h3 class="suit_rg_m mb18">강좌 상세 설명</h3>
                                        <div>
                                            <textarea id="tiny" name="cls_text_detail"></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="c_submit_btns d-flex justify-content-end">
                            <button class="btn_s" type="submit" id="cls_btn">
                                등록
                            </button>
                            <div class="btn_s cls_del_btn">취소</div>
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
        <script>

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
            <div class="close" data-idx="' + idx + '">X</div> \
            <img src="' + e.target.result + '" /> \
        </div>';
        $("#thumbnails").append(div);
        };
    })(file, idx);
    reader.readAsDataURL(file);
    }
    $("#thumbnails").on("click", ".close", function(e) {
    var $target = $(e.target);
    var idx = $target.attr('data-idx');
    
    file_del(idx);
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

    

    function file_del(imgid){
        if(!confirm('삭제하시겠습니까?')){
            return false;
        }
        let data = {
            imgid : imgid
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
                    $('#f_'+imgid).hide();
                }
            }            
        })
    }
            // 금액
            $(document).ready(function() {
            $('#paid').on('click', function() {
                if ($(this).is(':checked')) {
                $('#price').prop('disabled', false);
                } else {
                $('#price').prop('disabled', true);
                }
            });

            $('#price').on('change', function() {
                $(this).attr('value', $(this).val());
            });
            });

//취소버튼
            $('div.cls_del_btn').click(function() {
                // 확인 메시지를 출력합니다.
                if (confirm('정말로 취소하시겠습니까?')) {
                // 확인 버튼 클릭 시 메인 페이지로 이동합니다.
                location.href='./class_main.php';
                }
            }); 
        </script>
        
        <script src="../js/script.js"></script>
        <script src="../js/class.js"></script>
    </body>
</html>
