//login
var imgArray = new Array();
imgArray[0] = "/teapot/admin/img/bg_login1.png";
imgArray[1] = "/teapot/admin/img/bg_login2.png";
imgArray[2] = "/teapot/admin/img/bg_login3.png";
imgArray[3] = "/teapot/admin/img/bg_login4.png";

function showImage() {
  var imgNum = Math.round(Math.random() * 3);
  // console.log("showImg, ", imgNum);
  var objImg = document.getElementById("introImg");
  // objImg.src = imgArray[imgNum];

  // objImg.setAttribute("src", imgArray[imgNum]);
  document.querySelector(
    ".login_right"
  ).innerHTML = `<img src="${imgArray[imgNum]}" alt="로그인" id="introImg" />`;
}
showImage();
