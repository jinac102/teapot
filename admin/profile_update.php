<?php
 $userid = $_POST['userid'];
 $userpw = $_POST['userpw'];
 $userfile = $_POST['file'];

 $sql = "UPDATE lms_user SET userid='{$userid}', userpw='{$userpw}' WHERE userfile='{$userfile}'";
 $result = mysqli_query($conn,$sql);

 if($result->fetch_object()){
    
 }

       
?>