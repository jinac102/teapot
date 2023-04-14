// 클래스 관리

// tiny 웹에디터
tinymce.init({
    selector: "textarea#tiny_sub",
    height: 100,
    menubar: false,
    toolbar:
        "bold italic backcolor | fontselect fontsizeselect formatselect | help",
    content_style:
        "body {  margin: 1rem 10%; font-family:Helvetica,Arial,sans-serif; font-size:14px }",
});

tinymce.init({
    selector: "textarea#tiny",
    height: 250,
    menubar: " false",
    statusbar: false,
    menubar: false,
    plugins:
        "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed code linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss",
    resize: false,
    toolbar_location: "top",
    /*setup: (editor) => {
        editor.ui.registry.addContextToolbar("textselection", {
            predicate: (node) => !editor.selection.isCollapsed(),
            items: "fontsizeselect | formatselect | fontselect ",
            position: "selection",
        });
    },*/
    toolbar:
        "  fontselect fontsizeselect formatselect | blocks bold italic | alignleft aligncenter alignright alignjustify | outdent indent | code emoticons",

    content_style:
        "body { margin: 1rem 10%; font-family:Helvetica,Arial,sans-serif; font-size:14px; }",
});

// //가격
// $("#free").click(function () {
//     var tag = (
//         <input
//             type="number"
//             name="cls_price"
//             id="price"
//             class="class_p_txt"
//             readonly
//         />
//     );
//     $("#price").append(tag).remove();
// });
