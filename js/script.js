$(document).ready(function() {
    setCodeEditor();
    changeLanguage();
});

var sourceCodeEditor;


function checkNeedUpdate(){
    
    $.get(gitInfoUrl, "", function(response) {
       response = JSON.parse(response);
       githubVersion = response.version;
       if(githubVersion != currentVersion){
        $("#versionBtnArea").show();
        $("#updateVersionBtn").html("Update New Version "+githubVersion);
       }
       
    });
}

setTimeout(function(){ checkNeedUpdate(); }, 3000);

function updateVersion(){

    var data = {
        'updateVersion' : 1
    }
    $("#updateVersionBtn").html("Updating...");
    $("#updateVersionBtn").prop("disabled",true);
    $.post("ajax_request.php", data, function(response) {
        alert(response);
        location.reload();
    });
}

function submitCode() {

    var timeLimit = $("#timeLimit").val();
    if (timeLimit == "") {
        alert("Enter Time Limit");
        return;
    }

    var data1 = {
        sourceCode: btoa(sourceCodeEditor.getValue()),
        input: btoa($("#input").val()),
        expectedOutput: btoa($("#expectedOutput").val()),
        language: $("#language").val(),
        timeLimit: $("#timeLimit").val()
    }

    var data = {};
    data['createSubmission'] = data1;

    $("#runBtn").html("Running...");
    $("#runBtn").prop("disabled",true);

    $.post("api.php", data1, function(response) {
        $("#debug").html(response);
        response = JSON.parse(response);
        $("#runBtn").html("Run");
        $("#runBtn").prop("disabled",false);
        if (typeof response.error == 'undefined') {

            if (response.status.status == "CE" || response.status.status == "RTE") $("#output").val(atob(response.compileMessage));
            else $("#output").val(atob(response.output));

            $("#outputResponse").html("Total Time: " + response.time + " s<br/>Status: " + response.status.description);
        } else $("#outputResponse").html(response.errorMsg);
        
    });
}

function setCodeEditor(){
    sourceCodeEditor = ace.edit("code");
    sourceCodeEditor.setShowPrintMargin(false);
    sourceCodeEditor.setOption("maxLines", 37);                    
    sourceCodeEditor.setOption("minLines", 37);                    
    sourceCodeEditor.setReadOnly(false);
    sourceCodeEditor.setFontSize("14px");

}

function changeLanguage() {
    var language = $("#language").val();
    var editorCode = "";
    if (language == "C") editorCode = cSource;
    if (language == "CPP") editorCode = cppSource;
    if (language == "CPP11") editorCode = cppSource;
    if (language == "JAVA") editorCode = javaTestSource;

    $("#code").val(editorCode);
    sourceCodeEditor.setValue(editorCode);
    sourceCodeEditor.clearSelection();
    setEditorSelectLanguage(language);
}

function setEditorSelectLanguage(selectLanguage){
    if (selectLanguage.startsWith("C")) {
        sourceCodeEditor.getSession().setMode("ace/mode/c_cpp");
    }
    else if (selectLanguage.startsWith("CPP")) {
        sourceCodeEditor.getSession().setMode("ace/mode/c_cpp");
    }
    else if (selectLanguage.startsWith("JAVA")) {
       sourceCodeEditor.getSession().setMode("ace/mode/java");
    }
    else if (selectLanguage.startsWith("PY")) {
        sourceCodeEditor.getSession().setMode("ace/mode/python");
    }
    else if (selectLanguage.startsWith("RUST")) {
        sourceCodeEditor.getSession().setMode("ace/mode/rust");
    }
    else if (selectLanguage.startsWith("D")) {
        sourceCodeEditor.getSession().setMode("ace/mode/d");
    }
}



// Template Sources

var cSource = "\
#include <stdio.h>\n\
\n\
int main(void) {\n\
    printf(\"hello, world\\n\");\n\
    return 0;\n\
}\n\
";


var cppSource = "\
#include <bits/stdc++.h>\nusing namespace std;\n\
\n\
int main() {\n\
    cout << \"hello, world\" << endl;\n\
    return 0;\n\
}\n\
";

var prologSource = "\
:- initialization(main).\n\
main :- write('hello, world\\n').\n\
";

var pythonSource = "print(\"hello, world\")";

var javaTestSource = "\
import static org.junit.jupiter.api.Assertions.assertEquals;\n\
\n\
import org.junit.jupiter.api.Test;\n\
\n\
class MainTest {\n\
    static class Calculator {\n\
        public int add(int x, int y) {\n\
            return x + y;\n\
        }\n\
    }\n\
\n\
    private final Calculator calculator = new Calculator();\n\
\n\
    @Test\n\
    void addition() {\n\
        assertEquals(2, calculator.add(1, 1));\n\
    }\n\
}\n\
";