let fileInput = document.querySelector("#file_table_id");

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
    document.querySelector("#upload_box p").style.display = "none";
    document.querySelector("#upload_box i").style.display = "none";

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
                let thidx = fileInput.value + data.thidx + ",";
                fileInput.value = thidx;
                preview(data.file_name, data.thidx);
            }
        })
        .catch((error) => console.error(error));
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
// ========== 수정삭제 ==========

// ========== tinymce ==========
function save() {
    tinymce.activeEditor.save();
    return true;
}
