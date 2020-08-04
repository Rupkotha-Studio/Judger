$(document).ready(function() {
    setCodeEditor();
    changeLanguage();
    setCheckerEditor();
});

var sourceCodeEditor;
var checkerEditor;


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
        timeLimit: $("#timeLimit").val(),
        checker : btoa(checkerEditor.getValue()),
        apiType : "compile"
    }

    var data = {};
    data['createSubmission'] = data1;

    console.log(data);

    $("#runBtn").html("Running...");
    $("#runBtn").prop("disabled",true);

    $.post("api", data1, function(response) {
        processApiResponseData(response);
    });
}

function processApiResponseData(response){
    $("#runBtn").html("Run");
    $("#runBtn").prop("disabled",false);
    $("#debug").html(response);
    response = JSON.parse(response);
    if (typeof response.error == 'undefined') {
        if (response.status.status == "CE" || response.status.status == "RTE") $("#output").val(atob(response.compileMessage));
        else $("#output").val(atob(response.output));
        $("#outputResponse").html("Total Time: " + response.time + " s<br/>Status: " + response.status.description+"<br/>Checker Log: " + response.checkerLog);
    } 
    else $("#outputResponse").html(response.errorMsg);
}

function setCodeEditor(){
    sourceCodeEditor = ace.edit("code");
    sourceCodeEditor.setShowPrintMargin(false);
    sourceCodeEditor.setOption("maxLines", 18);                    
    sourceCodeEditor.setOption("minLines", 18);                    
    sourceCodeEditor.setReadOnly(false);
    sourceCodeEditor.setFontSize("14px");
}

function setCheckerEditor(){
    checkerEditor = ace.edit("checker");
    checkerEditor.setShowPrintMargin(false);
    checkerEditor.setOption("maxLines", 18);                    
    checkerEditor.setOption("minLines", 18);                    
    checkerEditor.setReadOnly(false);
    checkerEditor.setFontSize("14px");

    checkerEditor.setValue(checkEditorCode);
    checkerEditor.clearSelection();

    checkerEditor.getSession().setMode("ace/mode/c_cpp");
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

var checkEditorCode = "\
#include \"testlib.h\"\n\
#include <bits/stdc++.h>\nusing namespace std;\n\
\n\
int main(int argc, char * argv[]) {\n\
    registerTestlibCmd(argc, argv);\n\
    quitf(_ok,\"output is ok\");\n\
}\n\
";

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