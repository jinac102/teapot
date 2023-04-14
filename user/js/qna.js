// tiny library
tinymce.init({
  selector: "textarea#mytextarea",
  content_css: "../css/qna.css",
  width: 1129,
  height: 500,
  statusbar: false,
  menubar: false,
  plugins: "emoticons",
  toolbar:
    "bold italic underline strikethrough | fontselect fontsizeselect formatselect | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent ",
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
  content_style: "body {font-family:suit ; font-size:18px; }",
});
