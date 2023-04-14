// tiny library
tinymce.init({
  selector: "textarea#mytextarea",
  content_css: "../css/qna.css",
  width: 1260,
  height: 560,
  statusbar: false,
  menubar: false,
  plugins:
    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss",
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
});