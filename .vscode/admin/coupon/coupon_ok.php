<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."/teapot/inc/db.php";
ini_set( 'display_errors', '0' );




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
// print_r("기한여부:".$date_limit);
if($date_limit==1){
    $regdate=$_POST["regdate"];//시작시간
    $duedate=$_POST["duedate"];//마감시간
}else{
    $regdate="null";//시작시간
    $duedate="null";//마감시간
}
$passive=$_POST["cc_passive"];//상태
$status=$_POST["statu"];//상태



$mysqli->autocommit(FALSE);//커밋이 안되도록 지정

    $query="INSERT INTO lms_coupon_cat
    (cc_name, cc_min_price, cc_type, cc_price, cc_ratio, regdate, duedate, date_limit, userid, cc_passive, statu)
    VALUES('".$coupon_name."'
    , '".$use_min_price."'
    , '".$coupon_type."'
    , {$coupon_price}
    , {$coupon_ratio}
    , '".$regdate."'
    , '".$duedate."'
    , '".$date_limit."'
    , '".$_SESSION['AUID']."'
    , '".$passive."'
    , '".$status."'
    )";
//print_r($query);
    
    $rs=$mysqli->query($query) or die($mysqli->error);
    $pid = $mysqli -> insert_id;
    
    $mysqli->commit();//디비에 커밋한다.


    echo "<script>alert('등록했습니다.');location.href='coupon_list.php';</script>";
    exit;

?>
