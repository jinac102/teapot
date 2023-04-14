<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

    if($_FILES['savefile']['size']> 10240000){
        $return_data = array("result"=>"size");
        echo json_encode($return_data);  
        exit;
    }

    if($_FILES['savefile']['type'] != 'image/png' and $_FILES['savefile']['type'] != 'image/gif' and $_FILES['savefile']['type'] != 'image/jpeg'){
        $return_data = array("result"=>"image");
        echo json_encode($return_data);  
        exit;
    }

    $save_dir = $_SERVER['DOCUMENT_ROOT']."/teapot/admin/uploads/class_thumb/"; 
    $filename = $_FILES['savefile']['name'];
    $ext = pathinfo($filename,PATHINFO_EXTENSION);
    $newfilename = date("YmdHis").substr(rand(),0,6);
    $savefile =  $newfilename.'.'.$ext; 

    if(move_uploaded_file($_FILES['savefile']['tmp_name'], $save_dir.$savefile)){
   

        $return_data = array("result"=>"success", "imgurl" => '/teapot/admin/uploads/class_thumb/'.$savefile);
        echo json_encode($return_data);
        exit;
    } else{
        $return_data = array("result"=>"error");
        echo json_encode($return_data);
        exit;
    }



