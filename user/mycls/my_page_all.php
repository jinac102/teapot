<?php
//현재 로그인한 유저의 정보 가져오기
$username = $_SESSION['UNAME'];
$userid = $_SESSION['UID'];
$sql = "SELECT * FROM lms_user where userid = '$userid'" ;
$result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
$rs = $result -> fetch_object();

//나의 클래스
$sqlcut = "SELECT count(*) as ct FROM lms_sold where sold_uidx = '$userid'";
$countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
$cls = $countresult ->fetch_object();

//유저 Q&A 정보
$sqlcut = "SELECT count(*) as ct FROM lms_qna where userid='$username'";
$countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
$ans = $countresult ->fetch_object();

//유저 좋아요 갯수
$sqlcut = "SELECT count(*) as cnt FROM lms_favorite where fv_uid = '$userid'";
$countresult = $mysqli -> query($sqlcut) or die("query error => ".$mysqli->error);
$like = $countresult ->fetch_object();

?>