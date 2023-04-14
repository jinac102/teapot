<?php
include $_SERVER['DOCUMENT_ROOT'] . "/teapot/admin/inc/db.php";

$idx = $_POST['idx'];
// var_dump($_POST);
$que = "SELECT * FROM lms_table_file WHERE thidx='$idx'";
$raw = $mysqli -> query($que) or die("query error =>".$mysqli->error);
$row = $raw -> fetch_object();

$delque = "UPDATE lms_table_file SET status=0 WHERE thidx=".$idx;
$result = $mysqli -> query($delque);

if($result){
    $del_file = $_SERVER['DOCUMENT_ROOT'] . "/teapot/admin/img/attach/". $row->filename;
    if(unlink($del_file)){
        $data = array("result"=>"delete");
        echo json_encode($data);
    } else {
        $error = array(
            'code' => 500,
            'message' => '파일 삭제 에러가 발생하였습니다.',
            'details' => '파일 삭제에 실패하였습니다.'
        );
        echo json_encode($error);
    }
} else {
    $error = array(
        'code' => 500,
        'message' => '데이터베이스 에러가 발생하였습니다.',
        'details' => '데이터베이스 처리에 실패하였습니다.'
    );
    echo json_encode($error);
}  
?>