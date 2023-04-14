// ===================================
// 강의 목록 로딩
// ===================================
const curr = document.querySelector("#curriculum ul");
const more = document.querySelector(".more");

let j = 1;
lecIns(j);
more.addEventListener("click", () => {
    j += 1;
    lecIns(j);

    // console.log(j);
});

function lecIns(j) {
    fetch("classroom_more_select.php", {
        method: "post",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "j=" + j + "&clidx=" + clidx,
    })
        .then((resp) => resp.json())
        .then((resp) => {
            if (resp.result == "empty") {
                more.innerText = "등록된 강좌가 없습니다.";
            }
            curr.innerHTML = "";
            for (r of resp) {
                let li = document.createElement("li");
                curr.append(li);
                let liHead = document.createElement("div");
                liHead.classList.add(
                    "li-head",
                    "d-flex",
                    "justify-content-between",
                    "align-items-center"
                );
                if (more.dataset.id === "auth" || r.status == 0) {
                    let span = document.createElement("span");
                    span.className = "li-title";

                    let i = document.createElement("i");
                    li.setAttribute("data-idx", `${r.lidx}`);
                    li.appendChild(liHead);
                    liHead.prepend(span);

                    liHead.appendChild(i);

                    if (r.title.length > 70) {
                        let title = r.title.substring(0, 70) + ".....";
                        span.textContent = title;
                    } else {
                        span.textContent = r.title;
                    }
                    i.classList.add("fa-solid", "fa-caret-down");

                    let url = `../class/lec_main.php?clidx=${clidx}&lidx=${r.lidx}`;

                    buildTs(li, url, "00", "00", "처음부터 수강하기");

                    tsinsert(r.lidx);
                    if (more.dataset.id !== "auth") {
                        let span2 = document.createElement("span");
                        span2.className = "title-sup";
                        span2.textContent = "free";
                        span.appendChild(span2);
                    }
                } else {
                    let span = document.createElement("span");
                    span.className = "lix-title";
                    li.appendChild(liHead);
                    liHead.appendChild(span);
                    span.textContent = r.title;
                }
                if (r.result == "full") {
                    more.classList.remove("d-flex");
                    more.style.display = "none";
                }
            }
        });
    accordion();
}

function buildTs(parent, url, mn, sc, ds) {
    let tsLink = document.createElement("a");
    tsLink.className = "timestamp justify-content-between align-items-center";
    tsLink.setAttribute("href", url);
    let spanP = document.createElement("span");
    spanP.className = "ts-title suit_rg_xs";
    let playI = document.createElement("i");
    playI.className = "fa-solid fa-play";
    tsLink.appendChild(spanP);
    tsLink.appendChild(playI);
    spanP.innerHTML = `<span class="digit">${mn}</span>
    : <span class="digit">${sc}</span>
    <b>${ds}</b>`;
    parent.appendChild(tsLink);
}
// ===================================
// 타임스탬프 삽입
// ===================================
function tsinsert(idx) {
    fetch("classroom_timestamp.php", {
        method: "post",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `lidx=${idx}`,
    })
        .then((resp) => resp.json())
        .then((resp) => {
            for (rs of resp) {
                if (rs.lidx) {
                    let currli = curr.querySelectorAll("li");
                    for (cl of currli) {
                        if (rs.lidx == cl.dataset.idx) {
                            let mn = `${rs.mn}`.padStart(2, "0");
                            let sc = `${rs.sc}`.padStart(2, "0");
                            let YTStamp = parseInt(mn) * 60 + parseInt(sc);
                            let url = `../class/lec_main.php?clidx=${clidx}&lidx=${rs.lidx}&t=${YTStamp}`;
                            buildTs(cl, url, mn, sc, rs.ds);
                        }
                    }
                }
            }
        });
}
// ===================================
// 타임스탬프 아코디언
// ===================================
function accordion() {
    setTimeout(() => {
        let currlio = curr.querySelectorAll("li");
        for (c of currlio) {
            c.addEventListener("click", (e) => {
                let timeStamp = e.currentTarget.querySelectorAll(".timestamp");
                for (ti of timeStamp) {
                    ti.classList.toggle("d-flex");
                }
            });
        }
    }, 500);
}
// ===================================
// 컨텐츠 탭 구문
// ===================================
if (more.dataset.id !== "auth") {
    let tabMenu = document.querySelectorAll(".tabs a");
    let tabContents = document.querySelectorAll(".lf_wrapper > section");
    tabContents[1].style.display = "none";
    for (tab of tabMenu) {
        tab.addEventListener("click", (e) => {
            e.preventDefault();
            let targetId = e.target.getAttribute("href");
            for (tm of tabMenu) {
                tm.classList.remove("active");
            }
            e.target.classList.add("active");

            for (tc of tabContents) {
                tc.style.display = "none";
            }
            document.querySelector(targetId).style.display = "block";
        });
    }
}
// ===================================
// 좋아요, 공유, 카트담기, 카트이동
// ===================================
let favIns = document.querySelector(".fav-ins");
let share = document.querySelector("#share");
let cartIns = document.querySelector("#cart-ins");
let cartA = document.querySelector("#cart-a");
if (favIns) {
    cartA.addEventListener("click", () => {
        if (cartIns.classList.contains("inserted")) {
            alert("이미 장바구니에 담겨있습니다.");
        } else {
            let submitText = "결제화면으로 이동합니다.";
            cartInsert(submitText);
            location.href = "../cart/cart.php";
        }
    });

    cartIns.addEventListener("click", () => {
        if (cartIns.classList.contains("inserted")) {
            fetch("cart_del.php", {
                method: "post",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "clidx=" + clidx,
            })
                .then((resp) => resp.json())
                .then((resp) => {
                    if (resp.result == "success") {
                        alert("장바구니에서 제거하였습니다.");
                        cartIns.classList.toggle("inserted");
                    }
                });
        } else {
            let cartText = "강좌를 장바구니에 등록하였습니다.";
            cartInsert(cartText);
        }
    });

    function cartInsert(n) {
        fetch("cart_insert.php", {
            method: "post",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "clidx=" + clidx,
        })
            .then((resp) => resp.json())
            .then((resp) => {
                if (resp.result == "success") {
                    alert(`${n}`);
                    cartIns.classList.toggle("inserted");
                } else if (resp.result == "alert") {
                    alert("먼저 로그인해주세요.");
                }
            });
    }
    share.addEventListener("click", (e) => {
        let copiedURL = window.location.href;
        let tempArea = document.createElement("textarea");

        tempArea.value = copiedURL;
        document.body.appendChild(tempArea);
        tempArea.select();
        document.execCommand("copy");
        document.body.removeChild(tempArea);
        alert("클래스 주소를 복사하였습니다.");
    });

    let favtog = favIns.getAttribute("data-idx");
    if (favtog != 0) {
        favIns.classList.add("inserted");
        favIns.querySelector("i").classList.add("fa-solid");
        favIns.querySelector("i").classList.remove("fa-regular");
    }
    favIns.addEventListener("click", () => {
        fetch("fav_toggle.php", {
            method: "post",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "clidx=" + clidx,
            //   body: "fidx=" + favtog,
        })
            .then((resp) => resp.json())
            .then((resp) => {
                if (resp.result == "ins") {
                    alert("좋아요를 추가하였습니다.");
                    favIns.classList.add("inserted");
                    favIns.querySelector("i").classList.add("fa-solid");
                    favIns.querySelector("i").classList.remove("fa-regular");
                } else if (resp.result == "del") {
                    alert("좋아요를 삭제하였습니다.");
                    favIns.classList.remove("inserted");
                    favIns.querySelector("i").classList.add("fa-regular");
                    favIns.querySelector("i").classList.remove("fa-solid");
                } else if (resp.result == "alert") {
                    alert("로그인이 필요합니다.");
                }
            });
    });

    // favIns.addEventListener("click", () => {
    //     if (favIns.classList.contains("inserted")) {
    //         fetch("fav_del.php", {
    //             method: "post",
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded",
    //             },
    //             body: "clidx=" + clidx,
    //         })
    //             .then((resp) => resp.json())
    //             .then((resp) => {
    //                 if (resp.result == "success") {
    //                     alert("좋아요를 취소하였습니다.");
    //                     favIns.classList.toggle("inserted");
    //                     favIns.querySelector("i").classList.add("fa-regular");
    //                     favIns.querySelector("i").classList.remove("fa-solid");
    //                 }
    //             });
    //     } else {
    //         fetch("fav_insert.php", {
    //             method: "post",
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded",
    //             },
    //             body: "clidx=" + clidx,
    //         })
    //             .then((resp) => resp.json())
    //             .then((resp) => {
    //                 if (resp.result == "success") {
    //                     alert("좋아요 입력하였습니다.");
    //                     favIns.classList.toggle("inserted");
    //                     favIns.querySelector("i").classList.add("fa-solid");
    //                     favIns
    //                         .querySelector("i")
    //                         .classList.remove("fa-regular");
    //                 } else if (resp.result == "alert") {
    //                     alert("먼저 로그인해주세요.");
    //                 }
    //             });
    //     }
    // });
}
