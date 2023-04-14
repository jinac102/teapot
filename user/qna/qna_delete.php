<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/user/inc/db.php";

    $qidx = $_GET['qidx'];
    $sql = "DELETE FROM lms_qna where qidx='{$qidx}'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    if($result){
        echo "<script>
        alert('삭제 성공');
        location.replace('qna_list.php');
        </script>";
    }else{
        echo "<script>
            alert('삭제 실패');
            location.replace('qna_read.php');
        </script>";
    }
?>