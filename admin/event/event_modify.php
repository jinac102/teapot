<?php
  
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_header.php";

    $eno = $_GET['idx'];
    $sql = "SELECT * from lms_event where ev_idx=$eno"; //idx번호에 맞는 게시글 추출 구문 저장
    $result = $mysqli->query($sql); //게시글 추출 구문 실행
    $row = $result->fetch_assoc(); // 게시글 추출내용을 연관배열로 저장
    print_r($row);
?>
    
    <link rel="stylesheet" href="../css/event.css" />
    <link rel="stylesheet" href="../css/coupon_add.css" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/admin_aside.php";

$sql = "SELECT * from lms_coupon_cat where statu=1";
$result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
    $rsc[]=$rs;
  }

?>

    <main class="p-5 col-md-10">
        <h2 class="suit_bold_xl">이벤트등록</h2>
        <div class="contents d-flex flex-column gap-5">
                    <form method="post" action="event_modify_ok.php" onsubmit="return save()" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                     <input type="hidden" name="eid" value="<?php echo $eno;?>">
                        <p>
                            <label for="ev_thumb">썸네일</label>
                            <input type="file" id="ev_thumb" name="ev_thumb">
                        </p>
                        <p>
                            <label for="ev_title">이벤트명</label>
                            <input type="text" name="ev_title" value="<?php echo $row['ev_title'];?>"/>
                        </p>
                        <p>
                            <label for="ev_cont">이벤트 내용</label>
                            <input type="file" id="ev_content_img" name="ev_content_img">
                        </p>
                        <p>
                            <label for="ev_cont">이벤트 설명</label>
                            <textarea id="ev_content_text" name="ev_content_text" rows=5 cols=30><?php echo $row['ev_content_text'];?></textarea>
                        </p>
                        <div class="d-flex gap-2">
                            <label for="">적용쿠폰</label>
                            <div class="select_wrap">
                                <select name="cc_name" id="cc_name" class="suit_rg_m type" value="1">
                                    <option>선택하기</option>
                                    <?php
                                        foreach($rsc as $r){
                                    ?>
                                    <option value="<?php echo $r->cc_name?>" ><?php echo $r->cc_name?></option>
                                    <?php }?>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="edit d-flex flex-row-reverse gap-4">
                            <button class="btn_s" onclick='history.back()' type='button'">취소</button>
                            <button class="btn_s" type="submit" id="event_add">등록</button>
                        </div>
                    </form>
    </main>
    <script>
        $('textarea').focus(function(){
            $(this).text("");
        })
    </script>