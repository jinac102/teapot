<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/db.php";

    $qidx = $_GET['qidx'];
    $qna_modify_text = $_POST['qna_text'];
    $sql = "UPDATE lms_qna SET qna_text = '".$qna_modify_text."' where qidx=".$qidx;
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    if($result){
        echo "<script>
        alert('질문 수정 성공');
        location.replace('qna_read.php?qidx={$qidx}');
        </script>";
    }else{
        echo "<script>
        alert('질문 수정 실패');
        history.back();
        </script>";
    }
?>