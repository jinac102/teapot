<?php
    $uid = $_SESSION['UID'];
    if($uid){
        $acque = "SELECT sold_seen,sold_complet FROM lms_sold WHERE sold_uidx = '$uid' AND sold_clidx = '$clidx'";
        $acres = $mysqli -> query($acque);
        $acrow = $acres -> fetch_assoc();
        $acComp = $acrow['sold_complet'];
        $seen = $acrow['sold_seen'];
        if(!empty($acrow)){
            if($acComp == 0){
                $seenArr = explode(',',$seen);
                if($seen == 0){
                    $lxque = "UPDATE lms_sold SET sold_seen = '$lecidx' WHERE sold_uidx = '$uid' AND sold_clidx = '$clidx'";
                    $lxres = $mysqli -> query($lxque);
                }else if (!in_array($lecidx, $seenArr)){
                    $isSeen = $seen.','.$lecidx;
                    $lxque = "UPDATE lms_sold SET sold_seen = '$isSeen' WHERE sold_uidx = '$uid' AND sold_clidx = '$clidx'";
                    $lxres = $mysqli -> query($lxque);
                }else if (in_array($lecidx, $seenArr)){
                    $ccque = "SELECT COUNT(*) AS cnt FROM lms_lec WHERE lec_clsnum = '$clidx'";
                    $ccres = $mysqli->query($ccque);
                    $ccrow = $ccres -> fetch_assoc();
                    $ccCnt = $ccrow['cnt'];
                    $seenCnt = count($seenArr);
                    if($seenCnt == $ccCnt){
                        $cique = "UPDATE lms_sold SET sold_complet=1 WHERE sold_uidx = '$uid' AND sold_clidx = '$clidx'";
                        $cires = $mysqli -> query($cique);
                    }
                }
            }
        }
    }
?>
