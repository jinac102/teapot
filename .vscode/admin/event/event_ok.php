<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
ini_set( 'display_errors', '0' );

// $ev_thumb=$_file['ev_thumb'];//썸네일이미지
$ev_title=$_POST['ev_title'];
// $ev_content_img=$_file['ev_content_img'];//본문이미지
$ev_content_text=rawurldecode($_POST['ev_content_text']);
$cc_idx=$_POST['cc_idx'];

$ccquery = "SELECT * from lms_coupon_cat where cc_idx='{$cc_idx}'";
$result = $mysqli->query($ccquery) or die("query error => ".$mysqli->error);
$row = $result->fetch_object();

print_r($ccquery);
print_r($result);
print_r($row);

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
print_r($status);

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

$query="INSERT INTO lms_event
(ev_thumb, ev_title, ev_content_img, ev_content_text, cc_idx,status)
VALUES('".$upfile1."'
, '".$ev_title."'
, '".$upfile2."'
, '".$ev_content_text."'
, '".$cc_idx."'
, '".$status."'
)";

// print_r($sql);
    
// if($mysqli->query($sql) === true){
//     echo "<script>
//     alert('등록되었습니다.');
//     location.href='./event_list.php';
//     </script>";	
//     }else{
//         echo "<script>
//         alert('등록 실패');
//         </script>";
//     }
// $mysqli -> close();

$rs=$mysqli->query($query) or die($mysqli->error);

$mysqli->commit();//디비에 커밋한다.


echo "<script>alert('등록했습니다.');location.href='event_list.php';</script>";
exit;

?>