<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/db.php";
error_reporting(E_ALL);
ini_set( 'display_errors', '1' );

$cno = $_POST['cid'];

// if(!$_SESSION['AUID']){
//     echo "<script>alert('권한이 없습니다.');history.back();</script>";
//     exit;
// }


$coupon_name=$_POST["cc_name"];//쿠폰명
$use_min_price=$_POST["cc_min_price"];//최소사용가능금액
$coupon_type=$_POST["cc_type"];//할인유형
if($coupon_type==1){
    $coupon_price=$_POST["cc_price"];//할인가
    $coupon_ratio="null";//할인율
}else{
    $coupon_price="null";//할인가
    $coupon_ratio=$_POST["cc_ratio"];//할인율
}
$date_limit=$_POST["date_limit"];//기한여부
if($date_limit==1){
    $regdate=$_POST["regdate"];//시작시간
    $duedate=$_POST["duedate"];//마감시간
}else{
    $regdate="null";//시작시간
    $duedate="null";//마감시간
}
$passive=$_POST["cc_passive"];//상태
$status=$_POST["statu"];//상태


$sql = "UPDATE lms_coupon_cat set
cc_name='{$coupon_name}',cc_min_price='{$use_min_price}',cc_type='{$coupon_type}',cc_price={$coupon_price},cc_ratio={$coupon_ratio},date_limit='{$date_limit}',regdate='".$regdate."',duedate='".$duedate."',cc_passive='{$passive}',statu='{$status}'
where cc_idx='{$cno}'";

// print_r($sql);

if ($mysqli->query($sql) === TRUE) {
    echo "<script>
    alert('수정되었습니다.');
    location.href='coupon_list.php';</script>";
} else {
    echo "<script>
    alert('수정 실패');
    location.href = 'coupon_list.php';</script>";
}
    $mysqli->commit();

?>
