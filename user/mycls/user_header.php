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
        <ul class="d-flex m-0 p-0 gap-4">
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
        <!-- <ul>
          <li>
            <a href=""><span class="suit_bold_s">뚜니</span> 님<img src="../img/icon_user.png" alt="mypage"/></a>
          </li>
          <li>
            <a href=""><img src="../img/icon_logout.svg" alt="logout" /></a>
          </li>
          <li>
            <a href=""><img src="../img/icon_cart.svg" alt="cart" /></a>
          </li>
        </ul> -->
      </div>
    </header>