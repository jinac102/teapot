</head>
  <body>
    <header>
      <div class="main_menu d-flex justify-content-between align-items-center">
        <h1 class="logo"><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/index.php"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/logo.png" alt="" /></a></h1>
        <ul class="gnblist suit_bold_s d-flex justify-content-center flex-grow-1">
          <li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/class/class_list.php">class</a></li>
            <li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/qna/qna_list.php">q&a</a></li>
            <li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/event/event_list.php">event</a></li>
        </ul>
        <?php
          if(isset($_SESSION['UNAME'])){
        ?>
          <ul class="header_icons d-flex m-0 p-0 gap-4">
            <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/mycls/user_my_page.php"><span class="suit_bold_s"><?php echo $_SESSION['UNAME'] ?></span> 님<img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_user.svg" alt="mypage"/></a>
            </li>
            <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/member/logout_action.php"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_logout.svg" alt="logout" /></a>
            </li>
            <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/cart/cart.php"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_cart.svg" alt="cart" /></a>
            </li>
          </ul>
        <?php }else{ ?>
        <ul class="header_icons d-flex m-0 p-0 gap-4">
          <li>
            <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/mycls/user_my_page.php" ><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_user.svg" alt="mypage"/></a>
          </li>
          <li>
            <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/login.php" ><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_login.svg" alt="login"/></a>
          </li>
          <li>
            <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/cart/cart.php"><img src="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/img/icon_cart.svg" alt="cart"/></a>
          </li>
        </ul>
        <?php } ?>
      </div>
      <aside class="sidebar_recent" id="sidebar_recent">
        <div class="sidebar_wrapper" id="sidebar_wrapper">
          <h2 class="suit_bold_xs text-center my-3">최근 본 강의</h2>
          <ul id="recent_lecs_list">
            <?php
             if(isset($_COOKIE['recentView'])){
             $recentCookie = $_COOKIE['recentView'];
             if(!empty($recentCookie)){
                $ckque = "SELECT * FROM lms_class where clidx IN ($recentCookie)";
                $ckres = $mysqli->query($ckque);
               
                while($ckobg = $ckres->fetch_object()){
                  $ckrow[] = $ckobg;
                }
                foreach($ckrow as $ck){              
            ?>
            <li class="recent_lecs" id="recent_lecs">
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/teapot/user/lec/classroom.php?clidx=<?= $ck->clidx; ?>">
                <img src="<?= $ck->thumb_url; ?>" alt="" /><span><?= $ck->cls_title;?></span>
              </a>
            </li>
            <?php } } }?>
          </ul>
          <a href="#" id="top_btn" class="suit_bold_xs">TOP</a>
        </div>
      </aside>
    </header>