<?php 
	include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

    $bno = $_GET['idx'];
    $sql = "DELETE from lms_class where clidx='$bno'"; //idx에 맞는 게시글 삭제

    if($mysqli -> query($sql) === true){
        echo "<script>
            alert('삭제되었습니다');
            location.href='class_main.php';
        </script>";
    }else{
        echo "<script>
            alert('삭제실패했습니다.');
            location.href='class_main.php';
        </script>";
    }

    $mysqli->close();
?>
