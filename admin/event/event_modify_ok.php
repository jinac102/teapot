<?php session_start();
include "../inc/db.php";
error_reporting(E_ALL);
ini_set( 'display_errors', '1' );

$eno = $_POST['eid'];

// if(!$_SESSION['AUID']){
//     echo "<script>alert('권한이 없습니다.');history.back();</script>";
//     exit;
// }

// $ev_thumb=$_file['ev_thumb'];//썸네일이미지
$ev_title=$_POST['ev_title'];
// $ev_content_img=$_file['ev_content_img'];//본문이미지
$ev_content_text=rawurldecode($_POST['ev_content_text']);
$cc_name=$_POST['cc_name'];

$ccquery = "SELECT * from lms_coupon_cat where cc_name='{$cc_name}'";
$result = $mysqli->query($ccquery);
$row = $result->fetch_object();

// var_dump($ccquery);

$save_dir = $_SERVER['DOCUMENT_ROOT']."/teapot/admin/uploads/event/"; 
$filename1 = $_FILES["ev_thumb"]["name"];
$filename2 = $_FILES["ev_content_img"]["name"];
$ext1 = pathinfo($filename1,PATHINFO_EXTENSION);//확장자 구하기
$ext2 = pathinfo($filename2,PATHINFO_EXTENSION);//확장자 구하기
$newfilename = date("YmdHis").substr(rand(),0,6);
$upfile1 = $newfilename."_thumb.".$ext1;//새로운 파일이름과 확장자를 합친다
$upfile2 = $newfilename."_content.".$ext2."";//새로운 파일이름과 확장자를 합친다
$ev_idx = $mysqli -> insert_id;
$status = $row->statu;
$date_limit = $row->date_limit;
if($date_limit==1){
    $regdate=$row->regdate;;//시작시간
    $duedate=$row->duedate;;//마감시간
}else{
    $regdate=0;//시작시간
    $duedate=0;//마감시간
}

// print_r($status);

if(move_uploaded_file($_FILES["ev_thumb"]["tmp_name"], $save_dir.$upfile1)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="INSERT INTO lms_event_img_thumb
    (ev_idx, userid, filename)
    VALUES(".$ev_idx.", '".$_SESSION['AUID']."', '".$upfile1."')";
    $result=$mysqli->query($sql) or die($mysqli->error);
    // print_r($sql);
}
if(move_uploaded_file($_FILES["ev_content_img"]["tmp_name"], $save_dir.$upfile2)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="INSERT INTO lms_event_img_cont
    (ev_idx, userid, filename)
    VALUES(".$ev_idx.", '".$_SESSION['AUID']."', '".$upfile2."')";
    $result=$mysqli->query($sql) or die($mysqli->error);
    // print_r($sql);
}

$query = "UPDATE lms_event set
ev_thumb='{$upfile1}',ev_title='{$ev_title}',regdate='{$regdate}', duedate='{$duedate}',ev_content_img='{$upfile2}',ev_content_text='{$ev_content_text}',cc_name='{$cc_name}',status={$status}
where ev_idx={$eno}";

// print_r($query);

$rs=$mysqli->query($query) or die($mysqli->error);

$mysqli->commit();//디비에 커밋한다.


echo "<script>alert('등록했습니다.');location.href='event_list.php';</script>";
exit;

?>