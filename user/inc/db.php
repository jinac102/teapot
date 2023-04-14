<?php
    $hostname = 'localhost';
    $dbuserid = 'tgif';
    $dbpasswd = 'qnfrmadlek13!';
    $dbname = 'tgif';

    $mysqli = new mysqli($hostname,$dbuserid, $dbpasswd,$dbname);
    if($mysqli -> connect_errno){
        die('Connect Error:'.$mysqli->connect_error);
    } 
?>