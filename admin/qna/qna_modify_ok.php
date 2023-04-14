<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

    $qidx = $_GET['qidx'];
    $reply_content = $_POST['qna_reply'];
    $sql = "UPDATE lms_qna SET qna_reply = '".$reply_content."' where qidx=".$qidx;
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    if($result){
        echo "<script>
        alert('답변 수정 성공');
        location.replace('qna_admin_read.php?qidx={$qidx}');
        </script>";
    }else{
        echo "<script>
        alert('답변 수정 실패');
        history.back();
        </script>";
    }
?>