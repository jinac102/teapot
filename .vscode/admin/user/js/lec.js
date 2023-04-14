var tabMenu = document.querySelectorAll("#tab");
var tabContents = document.querySelectorAll(".lf_wrapper > section");

for (tab of tabMenu) {
    tab.addEventListener("click", function (e) {
        e.preventDefault();
    });
}
const curr = document.querySelector("#curriculum ul");
const more = document.querySelector(".more");

const getp = new URLSearchParams(window.location.search);
const clidx = getp.get("clidx");

let j = 5;
lecIns(j);
more.addEventListener("click", () => {
    j += 5;
    lecIns(j);
});

function lecIns(j) {
    fetch("classroom_more_select.php", {
        method: "post",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "j=" + j + "&clidx=" + clidx,
    })
        .then((resp) => resp.json())
        .then((resp) => {
            curr.innerHTML = "";
            for (r of resp) {
                var li = document.createElement("li");
                curr.append(li);
                if (more.dataset.id === "auth") {
                    var a = document.createElement("a");
                    var aa = document.createElement("a");
                    var div = document.createElement("div");
                    var i = document.createElement("i");
                    li.prepend(a);
                    li.appendChild(div);
                    div.prepend(aa);
                    div.appendChild(i);

                    li.classList.add("d-flex", "justify-content-between");
                    a.textContent = r.title;
                    aa.textContent = "바로가기";
                    aa.setAttribute("href", `lecture.php?lidx=${r.lidx}`);
                    i.classList.add("fa-solid", "fa-angle-down");
                } else {
                    var span = document.createElement("span");
                    li.appendChild(span);
                    span.textContent = r.title;
                }
            }
        });
}
