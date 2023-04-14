<?php
	include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";
	// error_reporting( E_ALL );
	// ini_set( "display_errors", 1 );

// POST로 전송된 데이터 가져오기
$cls_thumb=$_POST["thumb_url"];//이미지 32,33,
$cls_tit = $_POST['cls_title'];
$cls_pay = $_POST['cls_price']; 
$cls_cate = $_POST['cls_cat'];
$cls_txt = $_POST['cls_text'];
$cls_FNP = $_POST["FNP"];
$cls_txt_detail = $_POST["cls_text_detail"];
$date= date('Y-m-d');	

if($file_table_id){//첨부한 이미지 테이블 업데이트
	$upquery="UPDATE lms_table_thumb set itemidx=".$cls_thumb." where thidx in (".$file_table_id.")";
	$fs=$mysqli->query($upquery) or die($mysqli->error);
}

$mysqli->commit();//디비에 커밋한다.


// 무료인 경우 가격을 0으로 설정하고 입력 필드를 비활성화
if ($cls_FNP == 0) {
	$cls_pay = 0;
	$cls_paid_str = "0";//무료
  } else {
	$cls_paid_str = "1";//유료
  }

// MySQL 쿼리 실행
$sql = "INSERT INTO lms_class (cls_title,cls_price,cls_cat,cls_text,regdate,cls_st,thumb_url,cls_text_detail)
VALUES ('{$cls_tit}','{$cls_pay}','{$cls_cate}', '{$cls_txt}','{$date}','{$cls_paid_str}','{$cls_thumb}'.'{$cls_txt_detail}')";
// print_r($sql);

if($mysqli->query($sql) === true){
	echo "<script>
	alert('등록이 완료되었습니다.');location.href='./class_main.php';
	</script>";	
	// echo "<script>alert('등록했습니다.');location.href='./class_main.php';</script>";
	// exit;

}else{
	echo "<script>
	alert('등록이 실패했습니다.');
	</script>";
}


// 데이터베이스 연결 종료
$mysqli -> close();
?>