<?php 
    $recentCookie = $_COOKIE['recentView'];
    $ckque = "SELECT * FROM lms_class where clidx IN ($recentCookie)";
    $ckres = $mysqli->query($ckque);
    while($ckobg = $ckres->fetch_object()){
        $ckrow[] = $ckobg;
    }
    foreach($ckrow as $ck){
    ?>
    <li class="recent_lecs" id="recent_lecs">
        <a href="/teapot/user/lec/classroom.php?clidx=<?= $ck->clidx; ?>"
        ><img src="<?= $ck->thumb_url; ?>" alt="" /><span
            ><?= $ck->cls_title;?></span
        ></a
        >
    </li>
<?php } ?>