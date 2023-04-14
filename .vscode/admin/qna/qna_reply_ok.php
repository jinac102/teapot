<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
    
    $qidx = $_POST['qidx'];
    $reply_content = $_POST['qna_reply'];
    $sql = "UPDATE lms_qna SET reply_st=1, qna_reply = '".$reply_content."' where qidx=".$qidx;
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    if($result){
        echo "<script>
        alert('답변 등록 성공');
        location.replace('qna_admin_read.php?qidx={$qidx}');
        </script>";
    }else{
        echo "<script>
        alert('답변 등록 실패');
        history.back();
        </script>";
    }
?>