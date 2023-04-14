<?php

include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

	error_reporting( E_ALL );
	ini_set( "display_errors", 1 );

    $cls_thumb =$_POST['thumb_url'];
    $cls_tit = $_POST['cls_title'];
    $cls_pay = $_POST['cls_price']; 
    $cls_cate = $_POST['class_cate'];
    $cls_txt = $_POST['cls_text'];
    $cls_FNP = $_POST['FNP'];
    $cls_txt_detail = $_POST["cls_text_detail"];

    $clidx = $_POST['clidx'];
    $sql = "UPDATE lms_class set
    thumb_url='{$cls_thumb}',cls_title='{$cls_tit}',cls_price='{$cls_pay}',cls_cat='{$cls_cate}',cls_text='{$cls_txt}',cls_st='{$cls_FNP}',cls_text_detail='{$cls_txt_detail}'
    where clidx=".$clidx; 
    $rs = $mysqli -> query($sql) or die($mysqli -> error);


    if($rs === TRUE){
        echo "<script>alert('수정했습니다.');
        location.href='./class_main.php';</script>";
    }else{
        echo "<script>alert('수정하지 못했습니다. 관리자에게 문의해주십시오.');
        location.href='./class_main.php';</script>";
    }

?>