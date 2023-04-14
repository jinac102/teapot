<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>TEAPOT | DashBoard</title>
        <link rel="icon" href="../img/pabcon.png" />

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
            integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
            integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous"
        />
        <link
            href="https://cdn.jsdelivr.net/gh/sunn-us/SUIT/fonts/static/woff2/SUIT.css"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="../css/reset.css" />
        <link rel="stylesheet" href="../css/common.css" />
        <link rel="stylesheet" href="../css/admin.css" />
        <link rel="stylesheet" href="../css/coupon_add.css" />
    </head>
    <body>
        <div class="background d-flex flex-column">
            <div class="logo">
                <a href=""><img src="../img/logo.png" alt="" /></a>
            </div>
            <div class="d-flex">
                <div class="m-bg">
                    <ul class="m-dash d-flex flex-column">
                        <li>
                            <a href="" class="suit_rg_m">Dashboard</a>
                        </li>
                        <li>
                            <a href="" class="suit_rg_m"
                                >회원관리<i class="fa-solid fa-user"></i
                            ></a>
                        </li>
                        <li>
                            <a href="" class="suit_rg_m"
                                >클래스 관리<i class="fa-solid fa-book"></i
                            ></a>
                        </li>
                        <li>
                            <a href="" class="suit_rg_m"
                                >이벤트 관리<i
                                    class="fa-solid fa-cake-candles"
                                ></i
                            ></a>
                        </li>
                        <li>
                            <a href="" class="suit_rg_m"
                                >쿠폰 관리<ion-icon
                                    name="ticket-outline"
                                ></ion-icon
                            ></a>
                        </li>
                        <li>
                            <a href="" class="suit_rg_m"
                                >Q&A<i class="fa-regular fa-circle-question"></i
                            ></a>
                        </li>
                    </ul>
                    <div class="profile">
                        <div>
                            <img src="../img/charlie.png" alt="" />
                            <p class="suit_rg_s">ID 관리자</p>
                            <p class="suit_rg_s">PW 1234</p>
                        </div>
                    </div>
                    <span class="logout"
                        ><a href="" class="suit_rg_s"
                            >logout<i
                                class="fa-solid fa-arrow-right-from-bracket"
                            ></i></a
                    ></span>
                </div>
                <main class="p-5 col-md-10 suit_rg_l">
                    <h2 class="suit_bold_xl">쿠폰수정</h2>
                    <div class="contents d-flex flex-column gap-5">
                        <p>
                            <label for="coupon_name">쿠폰명</label>
                            <input type="text" id="coupon_name" />
                        </p>
                        <p>
                            <label for="coupon_discount">할인폭</label>
                            <input type="text" id="" />
                            <span class="desc">이상</span>
                        </p>
                        <div class="d-flex gap-2">
                            <label for=""></label>
                            <input type="" id="" />
                            <ul class="cate">
                                <li class="category">
                                    할인유형
                                    <a href="">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </a>
                                </li>
                                <li class="categorys">
                                    <ul>
                                        <li>₩</li>
                                        <li>%</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <p class="small d-flex align-items-center">
                            <label for="coupon_deadline">쿠폰기한</label>
                            <input type="radio" name="deadline" />
                            <span class="desc">기한설정</span>
                            <input
                                type="date"
                                name="coupon_start"
                                class="datepicker"
                            />
                            ~
                            <input
                                type="date"
                                name="coupon_end"
                                class="datepicker"
                            />
                            <input type="radio" name="deadline" />
                            <span class="desc">기한없음</span>
                        </p>
                        <div class="d-flex">
                            <label for="">발급방식</label>
                            <ul class="cate">
                                <li class="category">
                                    선택하기
                                    <a href="">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </a>
                                </li>
                                <li class="categorys">
                                    <ul>
                                        <li>자동발행</li>
                                        <li>수동발행</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="edit d-flex flex-row-reverse gap-4">
                        <button class="btn_s" onclick="location.href='coupon_list.php'">취소</button>
                        <button class="btn_s">수정</button>
                    </div>
                </main>
            </div>
        </div>
        <script src="../js/coupon_add.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
            integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"
        ></script>
        <script
            type="module"
            src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
        ></script>
        <script
            nomodule
            src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
        ></script>
        <script src="../js/script.js"></script>
    </body>
</html>
