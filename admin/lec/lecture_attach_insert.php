<?php
include $_SERVER['DOCUMENT_ROOT'] . "/teapot/admin/inc/db.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_FILES['savefile']) && $_FILES['savefile']['size'] >  5000 * 1024) {
    $response = array("result"=>"size");
    echo json_encode($response);
    exit;
};

if (isset($_FILES['savefile'])) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT']."/teapot/admin/img/attach/";
    $file_name = $_FILES['savefile']['name'];
    $raw = substr($file_name, 0, strrpos($file_name, ".")); 
    $ext = pathinfo($file_name,PATHINFO_EXTENSION);
    $newfilename =$raw.'_'.substr(rand(),0,3);
    $savefile = $newfilename .'.'.$ext;

    if (move_uploaded_file($_FILES['savefile']['tmp_name'], $upload_dir.$savefile)) {
        $que = "INSERT INTO lms_table_file (filename) VALUE ('$savefile')";
        $result = $mysqli->query($que);
        $thidx = $mysqli->insert_id;
        $response = array(
            "result"=>"success",
            "thidx" => $thidx, 
            "file_name" => $savefile);
        echo json_encode($response);
    } else {
        $response = array(
            'result' => 'error',
            'message' => 'upload fail'
        );
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'result' => 'error',
        'message' => 'post transfer fail'
    );
    echo json_encode($response);
    exit();
}
?>
