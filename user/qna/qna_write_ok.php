<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

    $uname= $_SESSION['UNAME'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $cls_tit = $_POST['cls_tit'];//qna_lecture
    $date = date('Y-m-d');
    $hit = $_POST[''];
    $re = $_POST[''];
    

    $sql = "INSERT INTO lms_qna (userid, qna_title, qna_text, qna_lecture, regdate,  qna_reply, reply_st, qna_hit, qna_recom)
    VALUES ('{$uname}','{$title}', '{$content}', '{$cls_tit}','{$date}', 0, 0, 0, 0)";

    print_r($sql);

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    if($mysqli->query($sql) === true){
        echo "<script>
            alert('Q&A 등록이 완료되었습니다.');
            location.href = 'qna_list.php';</script>";
    }else{
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
?>
