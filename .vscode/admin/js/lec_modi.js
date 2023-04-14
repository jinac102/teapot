var formData = new FormData(document.getElementById("lecture_modify"));
let fileInput = document.querySelector("#file_table_id");
let modiform = document.querySelector("#lecture_modify");
let modibtns = document.querySelectorAll("#modify button");

// ========== 드래그박스 ==========

var uploadFiles = [];
var dropbox = document.querySelector("#upload_box");
var uplist = document.querySelector("#uplist");

dropbox.addEventListener("dragover", function (e) {
    e.preventDefault();
    this.style.backgroundColor = "#fff";
});
dropbox.addEventListener("dragleave", function (e) {
    e.preventDefault();
    this.style.backgroundColor = "#fcf6f6";
});
dropbox.addEventListener("drop", function (e) {
    e.preventDefault();
    this.style.backgroundColor = "#fcf6f6";

    const files = [...e.dataTransfer?.files];

    for (let i = 0; files.length > i; i++) {
        var file = files[i];
        var size = uploadFiles.push(file);
        attachfile(files[i]);
    }
});
function attachfile(file) {
    let formData = new FormData();
    formData.append("savefile", file);

    fetch("lecture_attach_insert.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            if (data.result == "size") {
                alert(" 50kb 이하만 첨부할 수 있습니다");
                return;
            }
            if (data.result == "success") {
                let thidx = fileInput.value;
                if (thidx !== "") {
                    thidx += ",";
                }
                thidx += data.thidx;
                fileInput.value = thidx;
                preview(data.file_name, data.thidx);
            }
        })
        .catch((error) => console.error(error));
}
//수정대상글 불러오기 loaded
modibtns.forEach(function (btn) {
    btn.addEventListener("click", function (event) {
        if (event.target.classList.contains("lec_modify")) {
            var lidx = event.target.getAttribute("id");
            fetch("lecture_modify_load.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    lidx: lidx, // 수정된 부분
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    document.querySelector("#lidx").value = data.lidx;
                    document.querySelector("#title").value = data.title;
                    var idnote = document.querySelector("#status");
                    var noteop = idnote.querySelectorAll("option");
                    idnote.value = data.status;
                    for (np of noteop) {
                        if (data.status == np.value) {
                            np.selected == true;
                        }
                    }

                    document.querySelector("#href").value = data.href;
                    document.querySelector("#note").innerText = data.note;
                    tinymce.init(tinyset);
                    loaded(data.lidx);
                });
        }
    });
});

function loaded(ii) {
    console.log(ii);
    fetch("lecture_attach_load.php", {
        method: "post",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({
            lidx: ii,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            let thidxList = [];
            for (dt of data) {
                preview(dt.filename, dt.thidx);
                thidxList.push(dt.thidx);
            }
            document.getElementById("file_table_id").value =
                thidxList.join(",");
        });
    // .catch((error) => console.error(error));
}

function preview(f, i) {
    const p = document.createElement("p");
    p.className = `n${i}`;
    p.innerText = f;

    const span = document.createElement("span");
    span.dataset.idx = i;
    span.style.color = "red";
    span.innerText = "X";

    span.addEventListener("click", function (event) {
        const del_num = event.target.getAttribute("data-idx");
        file_del(del_num);
        console.log(del_num);
    });

    p.appendChild(span);
    uplist.appendChild(p);
}
function file_del(idx) {
    if (!confirm("삭제하시겠습니까")) {
        return false;
    }

    const formData = new FormData();
    formData.append("idx", idx);

    fetch("lecture_attach_delete.php", {
        method: "post",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.result);
            uplist.querySelector(`.n${idx}`).style.display = "none";
        })
        .catch((error) => console.error(error));
}
modiform.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch("lecture_modify_insert.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if ((data.result = "success")) {
                location.href = `lecture_preview.php?lidx=${data.lidx}`;
            }
        })
        .catch((error) => console.error(error));
});
var tinyset = {
    selector: "textarea#note",
    content_css: "../css/lec.css",
    width: 987,
    height: 219,
    statusbar: false,
    menubar: false,
    toolbar:
        "undo redo | fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent ",
    tinycomments_mode: "embedded",
    tinycomments_author: "Author name",
    forced_root_block: "",
    mergetags_list: [
        { value: "First.Name", title: "First Name" },
        { value: "Email", title: "Email" },
    ],
    setup: function (editor) {
        editor.on("change", function () {
            editor.save();
        });
    },
};
function closeModal() {
    location.reload();
}
