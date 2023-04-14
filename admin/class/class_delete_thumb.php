<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

    if(!$_SESSION['AUID']){
        $return_data = array("result"=>"member");
        echo json_encode($return_data); 
        exit;       
    };
    
    $imgid = $_POST['clidx'];
    $result = $mysqli -> query("SELECT * from lms_class where clidx=".$imgid)
     or die("query error => ".$mysqli->error);
    ;
    $rs = $result -> fetch_object();

    if($rs->userid  != $_SESSION['AUID']){
        $return_data = array("result" => "my");
        echo json_encode($return_data); 
        exit;       
    }
    $sql = "UPDATE lms_class set status=0 where clidx='{$imgid}'";
    $result = $mysqli -> query($sql);


    if($result){
        $delete_file = $_SERVER['DOCUMENT_ROOT'].'/admin/img/class_thumb/'.$rs->filename;
        unlink($delete_file); //파일 삭제
        $return_data = array("result" => "ok");
        echo json_encode($return_data);    
    } else{
        $return_data = array("result" => "no");
        echo json_encode($return_data);             
    }


?>