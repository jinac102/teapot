<?php
  include $_SERVER['DOCUMENT_ROOT']."/teapot/admin/inc/db.php";

  // 관리자 정보 가져오기
  $sql = "SELECT * from lms_user where super=1";
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
  $rs = $result->fetch_object();
?>
</head>
<body>
  <div class="background d-flex flex-column">
  <div>
      <div class="d-flex">
        <div class="d-flex flex-column menugroup">
        <div class="logo">
          <a href=""><img src="../img/logo.png" alt="" /></a>
        </div>
        <div class="wrap m-bg d-flex flex-wrap justify-content-center">
          <ul class="m-dash d-flex flex-column">
            <li>
              <a href="/teapot/admin/dashboard/dashboard.php" class="suit_rg_m">Dashboard</a>
            </li>
            <li>
              <a href="/teapot/admin/member/member_main.php" class="suit_rg_m">회원관리<i class="fa-solid fa-user"></i></a>
            </li>
            <li>
              <a href="/teapot/admin/class/class_main.php" class="suit_rg_m">클래스 관리<i class="fa-solid fa-book"></i></a>
            </li>
            <li>
              <a href="/teapot/admin/event/event_list.php" class="suit_rg_m">이벤트 관리<i class="fa-solid fa-cake-candles"></i></a>
            </li>
            <li>
              <a href="/teapot/admin/coupon/coupon_list.php" class="suit_rg_m">쿠폰 관리<i class="bi bi-ticket-perforated"></i></a>
            </li>
            <li>
              <a href="/teapot/admin/qna/qna_list.php" class="suit_rg_m">Q&A<i class="fa-regular fa-circle-question"></i></a>
            </li>
          </ul>
          <div class="profile align-self-end">
            <div>
            <?php
                  if($rs->user_file == ''){
                ?>
                <img src="/teapot/admin/img/pabcon.png" style="width:95px; hight:95px;"/>
                <?php
                }else{
                ?>
                <div class="profileimg">
                  <img  src="<?php echo $rs->user_file?>" />
                </div>
                  <?php
                  }
                  ?>
              <!-- <img src="../img/charlie.png" alt="" /> -->
              <p class="suit_bold_s">ID : <?php echo $rs->userid;?></p>
              <p class="suit_bold_s">NAME : <?php echo $rs->username;?></p>
            </div>
          </div>
        <span class="logout align-self-center">
          <button type="button" class="suit_bold_s" onclick="location.replace('/teapot/admin/member/logout_action.php');">LOG OUT<i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </span>
      </div>
    </div>
    <script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"
></script>
  <script>
    let categorys = $(".categorys");
    let dashMenu = $(".m-dash > li");
    let link = document.location.href; 

    let link_modify = link.replace("http://tgif.dothome.co.kr/teapot", "..");
      console.log(link_modify);
    let test = $("a[href='"+link_modify+"']");
    test.closest("li").addClass("clicks");
  </script>