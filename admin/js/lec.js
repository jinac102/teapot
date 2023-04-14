let fileInput = document.querySelector("#file_table_id");
let modiform = document.querySelector("#lecture_modify");
let modibtns = document.querySelectorAll("#modify button");

// ===================================
// 멀티 파일 업로드
// ===================================
let uploadFiles = [];
let dropbox = document.querySelector("#upload_box");
let uplist = document.querySelector("#uplist");

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
    document.querySelector("#upload_box p").style.display = "none";
    document.querySelector("#upload_box i").style.display = "none";
    const files = [...e.dataTransfer?.files];

    for (let i = 0; files.length > i; i++) {
        let file = files[i];
        let size = uploadFiles.push(file);
        attachfile(files[i]);
    }
});
//========== 파일 업로드 ==========
function attachfile(file) {
    let formData = new FormData();
    formData.append("savefile", file);
    console.log(formData);
    fetch("lecture_attach_insert.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.result == "size") {
                alert(" 5mb 이하만 첨부할 수 있습니다");
                return;
            }
            if (data.result == "success") {
                let thidx = "";
                if (!isNaN(fileInput.value) && !isNaN(data.thidx)) {
                    if (fileInput.value !== "") {
                        thidx += fileInput.value + ",";
                    }
                    if (data.thidx !== "") {
                        thidx += data.thidx + ",";
                    }
                }
                thidx = thidx.slice(0, -1); // 마지막에 있는 콤마 제거
                fileInput.value = thidx;
                preview(data.file_name, data.thidx);
            }
        })
        .catch((error) => console.error(error));
}
//========== 업로드 리스트 생성 ==========
function preview(f, i) {
    const p = document.createElement("p");
    p.className = `n${i}`;
    p.innerText = f;

    const span = document.createElement("span");
    span.dataset.idx = i;
    span.style.color = "red";
    span.innerText = "X";

    span.addEventListener("click", function (e) {
        const del_num = e.target.getAttribute("data-idx");
        file_del(del_num);
        console.log(del_num);
    });

    p.appendChild(span);
    uplist.appendChild(p);
}
//========== 파일삭제 ==========
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
// ===================================
// 멀티 파일 수정용
// ===================================
if (modibtns) {
    modibtns.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            if (e.target.classList.contains("lec_modify")) {
                var lidx = e.target.getAttribute("id");
                fetch("lecture_modify_load.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        lidx: lidx,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        document.querySelector("#lidx").value = data.lidx;
                        document.querySelector("#title").value = data.lec_title;
                        var idnote = document.querySelector("#status");
                        var noteop = idnote.querySelectorAll("option");
                        idnote.value = data.lec_st;
                        for (np of noteop) {
                            if (data.lec_st == np.value) {
                                np.selected == true;
                            }
                        }
                        document.querySelector("#href").value = data.lec_href;
                        document.querySelector("#note").innerText =
                            data.lec_text;
                        let timeStamp = document.querySelector(".timestamp");
                        let row1 = data.row1;
                        loaded(data.lidx);
                        tinymce.init(tinyset);
                        if (data.row1) {
                            for (r of row1) {
                                timeStamp.innerHTML += `<div class="timestamp_inputwrap">
                  <p class="timeinput">
                      <input type="text" name="stp_minute[]" id="stp_minute" value="${r.stp_minute}">분
                      <input type="text" name="stp_second[]" id="stp_second" value="${r.stp_second}">초
                  </p>
                  <p class="timedesc">
                      <input type="text" name="stp_desc[]" id="stp_desc" value="${r.stp_second}">
                  </p>
              </div>`;
                            }
                        } else {
                            tspAdd();
                        }
                    });
            }
        });
    });
}
//수정시 파일 로드
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
            if (!data.length == 0) {
                document.querySelector("#upload_box p").style.display = "none";
                document.querySelector("#upload_box i").style.display = "none";
                let thidxList = [];
                for (dt of data) {
                    preview(dt.filename, dt.thidx);
                    thidxList.push(dt.thidx);
                }
                document.getElementById("file_table_id").value =
                    thidxList.join(",");
            }
        })
        .catch((error) => console.error(error));
}
//수정사항 반영
if (modiform) {
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
}
function closeModal() {
    location.reload();
}
// ===================================
// 타임스탬프
// ===================================
let timeStamp = document.querySelector(".timestamp");
function tspAdd() {
    let stampIns = document.createElement("div");
    stampIns.classList = "timestamp_inputwrap";
    stampIns.innerHTML = `<p class="timeinput">
        <input type="text" name="stp_minute[]" class="stp_minute">분 
        <input type="text" name="stp_second[]" class="stp_second">초
    </p>
    <p class="timedesc">
        <input type="text" name="stp_desc[]" class="stp_desc" placeholder="해당 부분 설명 입력">
    </p>`;
    timeStamp.appendChild(stampIns);
}

// ===================================
// tinymce
// ===================================
function save() {
    tinymce.activeEditor.save();
    return true;
}
var tinyset = {
    selector: "textarea#note",
    content_css: "../css/lec.css",
    width: 544,
    height: 219,
    statusbar: false,
    menubar: false,
    plugins: "anchor autolink emoticons link",
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
