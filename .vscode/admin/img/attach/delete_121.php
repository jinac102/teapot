<?php
    include $_SERVER['DOCUMENT_ROOT']."/bbs/inc/db.php";
    $bno = $_GET['idx'];


    $sql = "DELETE FROM board WHERE idx='$bno'";
    
    if($conn->query($sql) === true){
        echo "<script>location.href('../../index.php'); 
        alert('삭제되었습니다.')</script>";
    }
    
    $conn->close();
?>