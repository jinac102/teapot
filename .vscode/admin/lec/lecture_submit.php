<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php"; 
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

$clidx = $_GET['clidx'];

$que= "SELECT cls_title FROM lms_class WHERE clidx='$clidx'";
$raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
$row = $raw -> fetch_object();

// print_r($_POST);
?>

<link rel="stylesheet" href="../css/lec.css" />
<script src="https://cdn.tiny.cloud/1/sji1jwiod94r5sk3fhqv2se8ar5mjzfo8e6mh9xq4hmmez4l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<?php 
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php"; 
?>
        <!-- aside끝 각 컨텐츠작업분 -->
        <section class="ps-5 col-md-10">
            <div class="lec_content">
                <div class="lec_main_lhead">
                    <h2 class="col-md-4 suit_bold_xl">강의 등록</h2>
                </div>
                <div class="lec_submit_wrap p-0">
                    <div class="conhead_title">
                        <h3 class="suit_rg_l"><?= $row -> cls_title;?></h3>
                    </div>
                    <div class="lec_submit_con">
                        <form 
                        action="lecture_insert.php?clidx=<?= $clidx; ?>" 
                        method="post" onsubmit="return save();" enctype="multipart/form-data">
                            <input type="hidden" name="file_table_id" id="file_table_id" value="">

                            <div class="submit_upper d-flex">
                                <input type="text" placeholder="강좌명" name="title" id="title" required>
                                <div class="select_wrap">
                                    <select name="status" id="status" required>
                                        <option value="">
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
                                            <input type="text" name="href" id="href" required>
                                            <i class="fa-solid fa-link"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload_attach">
                                    <h4 class="suit_rg_m">
                                        강의자료
                                    </h4>
                                    <div id="upload_box" class="d-flex flex-column justify-content-center">
                                        <i class="fa-solid fa-file-import"></i>
                                        <p>
                                            해당 영역 안으로
                                            첨부파일을 올려주세요
                                        </p>
                                        <div id="uplist"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit_bot">
                                <textarea id="note" name="note" required>
                                강의소개를 입력해주세요. 
                                </textarea>
                            </div>
                            <div class="buttons d-flex justify-content-end">
                                <button class="btn_s">등록</button>
                                <button type="button" class="btn_s" onclick="return history.back();">취소</button>
                            </div>
                        </form>
                    </div>
                </div>    
            </div>
        </section>
    </div>
</div>

<script src="../js/lec.js"></script>
<script>
tinymce.init({
  selector: "textarea#note",
  content_css: "../css/lec.css",
  width: 987,
  height: 219,
  statusbar: false,
  menubar: false,
  plugins: 'anchor autolink charmap codesample emoticons',
  toolbar:
    "undo redo | fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons",
  tinycomments_mode: "embedded",
  tinycomments_author: "Author name",
  forced_root_block: "",
  mergetags_list: [
    { value: "First.Name", title: "First Name" },
    { value: "Email", title: "Email" },
  ],
  setup: function (editor) {
    editor.on("change", function () {
      editor.save();
    });
  },
});
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_footer.php"; ?>