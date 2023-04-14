$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
if ($("#cc_type option:selected")) {
  let ct = $("#cc_type option:selected").val();
  if (ct == 1) {
    $("#cc_price").show();
    $("#cc_ratio").hide();
    $("#discount_choice").hide();
  } else if (ct == 2) {
    $("#cc_ratio").show();
    $("#cc_price").hide();
    $("#discount_choice").hide();
  } else {
    $("#discount_choice").show();
    $("#cc_price").hide();
    $("#cc_ratio").hide();
  }
}
console.log("실험");
$("#cc_type").change(function () {
  let ct = $("#cc_type option:selected").val();
  if (ct == 1) {
    $("#cc_type").attr("value", 1);
    $("#cc_price").show();
    $("#cc_ratio").hide();
    $("#discount_choice").hide();
  } else if (ct == 2) {
    $("#cc_type").attr("value", 2);
    $("#cc_ratio").show();
    $("#cc_price").hide();
    $("#discount_choice").hide();
  } else {
    $("#discount_choice").show();
    $("#cc_price").hide();
    $("#cc_ratio").hide();
  }
});

let unlimit = $("input[value='unlimit']");
unlimit.change(function () {
  let limit = $("coupon_deadline span input");
  console.log(limit);
  limit.attr("readonly", true);
});
/*
if (unlimit.is(":checked")) {
}
*/

$("#cc_type").change(function () {
  if ($(this).find("option").filter(":first-child").attr("checked") == true) {
    $(this).attr("value", "유형을 선택해주세요.");
  }
  let target = $(this).parent().siblings("input");
  console.log(target);
  target.attr("value", "");
});

let dateLimit = $("input[name=date_limit]");
dateLimit.change(function () {
  if (dateLimit.is(":checked")) {
    dateLimit.attr("value", 0);
    $("#checked").attr("checked", false);
    $(".datepicker").attr("disabled", true);
  } else {
    dateLimit.attr("value", 1);
    dateLimit.attr("checked", false);
    $("#checked").attr("checked", true);
    $(".datepicker").attr("disabled", false);
  }
});
if (dateLimit.val() == 0) {
  $(".datepicker").attr("disabled", true);
} else {
  $(".datepicker").attr("disabled", false);
  //   $(".datepicker").val(0);
}

let statu = $("#statu");
statu.change(function () {
  console.log("셀렉트이벤트");
  $("#statu option").attr("selected", false);
  $("#statu option:selected").attr("selected", true);
});

// let couponType = $("#cc_type");
// let type = couponType.children("option:selected");
// couponType.change(function () {
//     console.log(type.val());
//     if (type.val() == 1) {
//         console.log("할인가");
//         $(this).attr("value", 1);
//     } else {
//         console.log("할인율");
//         $(this).attr("value", 2);
//     }
// });
