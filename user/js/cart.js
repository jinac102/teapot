//전체선택, 전체선택시 강의 가격 총합
$("#select_all").click(function () {
    let $input = $("input");

    if ($(this).is(":checked")) {
        $input.attr("checked", true); //체크 안되어있으면 체크

        let classArry = [];
        classArry = $("input[name='select_one']:checked")
            .map(function () {
                return $(this).val();
            })
            .get();

        let data = {
            classArry: classArry,
        };
        $.ajax({
            type: "POST",
            url: "calculate_price.php",
            data: data,
            dataType: "json",
            success: function ($return_data) {
                $amount = $return_data.price;
                $(".amount span").text($amount.toLocaleString("en-US"));
                $(".total_amount span").text($amount.toLocaleString("en-US"));
                couponCalc();
            },
        });
    } else {
        $input.attr("checked", false); //체크 되어있으면 언체크
        $(".amount span").text("0"); // 모두 체크 풀리면 0원으로 돌려놓기
        $(".total_amount span").text("0"); // 모두 체크 풀리면 0원으로 돌려놓기
    }
});

let $amount = "";

//체크된강의확인
let inputAllLength = $("input").length - 1;
let inputCheckLength = 0;
$(".select_one_label").click(function () {
    let $input = $(this).prev();
    // let $allInput = $("input[name=select_one]");
    if ($input.is(":checked")) {
        $input.attr("checked", false);
    } else {
        $input.attr("checked", true);
    } //체크박스 조절

    let classArry = [];
    classArry = $("input[name='select_one']:checked")
        .map(function () {
            return $(this).val();
        })
        .get();
    let data = {
        classArry: classArry,
    };
    $.ajax({
        type: "POST",
        url: "calculate_price.php",
        data: data,
        dataType: "json",
        success: function ($return_data) {
            $amount = $return_data.price;
            $(".amount span").text($amount.toLocaleString("en-US"));
            $(".total_amount span").text($amount.toLocaleString("en-US"));
            couponCalc();
        },
    }); //체크된 강의 총합 구하기
    if ($("input[name=select_one]:checked").length == 0) {
        $(".amount span").text("0");
        $(".total_amount span").text("0");
    }
    let inputCheckLength = $("input[name='select_one']:checked").length;
    if (inputAllLength == inputCheckLength) {
        $("#select_all").prop("checked", true);
    } else {
        $("#select_all").prop("checked", false);
    }
});

//쿠폰가격반영
$couponPrice = "";
$("#search_type").change(function () {
    couponCalc();
});

function couponCalc() {
    let name = $("#search_type option:selected").val();
    let data = {
        name: name,
    };
    $.ajax({
        type: "POST",
        url: "coupon_price.php",
        data: data,
        dataType: "json",
        success: function ($return_data) {
            let $couponPrice = $return_data.price;
            let $minPrice = $return_data.minPrice;
            let $totalPrice = "";
            if ($amount < $minPrice) {
                $minPrice = Number($minPrice).toLocaleString("en-US");
                $return = `${$minPrice}원 이상 주문`;
                $(".discount").text($return).css({ color: "red" });
                $(".total_amount span").text($amount.toLocaleString("en-US"));
            } else {
                if ($couponPrice.length < 3) {
                    $couponPrice = ($amount * $couponPrice) / 100;
                    $totalPrice = $amount - $couponPrice;
                    $(".discount")
                        .text($couponPrice.toLocaleString("en-US") + "원")
                        .css({ color: "red" });
                    $(".total_amount span").text(
                        $totalPrice.toLocaleString("en-US")
                    );
                } else {
                    $totalPrice = $amount - $couponPrice;
                    $(".discount").text(
                        Number($couponPrice).toLocaleString("en-US") + "원"
                    );
                    $(".total_amount span").text(
                        $totalPrice.toLocaleString("en-US")
                    );
                }
            }
        },
    });
}
//장바구니 일괄삭제
$(".delete_all").click(function () {
    let list = $("input[name='select_one']:checked").closest(".list");
    let classArry = [];
    classArry = $("input[name='select_one']:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    let data = {
        classArry: classArry,
    };
    $.ajax({
        type: "POST",
        url: "delete_cart.php",
        data: data,
        dataType: "json",
        success: function ($return_data) {
            if ($return_data.result == "success") {
                alert("삭제되었습니다.");
                delete_all(list);
            }
        },
    });
});

//장바구니 삭제
$(".delete_one").click(function () {
    let list = $(this).closest(".list");
    let clsnum = $(this).attr("value");
    let data = {
        clsnum: clsnum,
    };
    $.ajax({
        type: "POST",
        url: "delete_cart.php",
        data: data,
        dataType: "json",
        success: function ($data) {
            if ($data.result == "success") {
                alert("삭제되었습니다.");
                delete_one(list);
            }
        },
    });
});

function delete_all(a) {
    a.hide();
}
function delete_one(a) {
    a.hide();
}
function refresh() {}
//전체개수 구하기 -> 사용자의 체크개수,번호
$(".select_one_label").click(function () {
    let $input = $(".select_one_label");
    if (!$input.is("checked")) {
        $("#select_all").attr("checked", false);
    } else {
        $("#select_all").attr("checked", true);
    }
});

//결제하기
$(".pay").click(function () {
    let coupon = $("#search_type option:selected").val();
    let list = $("input[name='select_one']:checked").closest(".list");
    let classArry = [];
    classArry = $("input[name='select_one']:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    let data = {
        classArry: classArry,
        coupon: coupon,
    };
    $.ajax({
        type: "POST",
        url: "class_pay.php",
        data: data,
        dataType: "json",
        success: function ($return_data) {
            alert("결제되었습니다.");
            location.href = "/teapot/user/mycls/user_my_page.php";
        },
    });
});
