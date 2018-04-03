var editor;

function initEditor(){
  // trigger extension
  ace.require("ace/ext/language_tools");
  editor = window.ace.edit("editor");
  editor.getSession().setMode("ace/mode/java");
  editor.setTheme("ace/theme/monokai");
  // enable autocompletion and snippets
  editor.setOptions({
      enableBasicAutocompletion: true,
      enableSnippets: true,
      enableLiveAutocompletion: true
  });
}

initEditor();

function changeLanguage(){
    var lang = document.getElementById("language").value;
    if(lang==="c"){
        lang = "c_cpp";
    }
    window.ace.edit("editor").getSession().setMode("ace/mode/" + lang);
}

function changeTheme() {
    var theme =  document.getElementById("selectTheme").value;
    window.ace.edit("editor").setTheme("ace/theme/" + theme);
}

function changeFont() {
    var size =  document.getElementById("selectFont").value;
    document.getElementById('editor').style.fontSize=size +"px";
}
