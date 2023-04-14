<?php 
    include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/db.php";

    $userid = $_POST['userid'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date('Y-m-d');

    $sql = "INSERT INTO lms_qna (userid, qna_title, qna_text, regdate, qna_lecture, qna_reply, reply_st)
    VALUES ('{$userid}','{$title}', '{$content}','{$date}', 0, 0, 0)";

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
