$(document).ready(function() {
    setCodeEditor();
    changeLanguage();
    setCheckerEditor();
});
var sourceCodeEditor;
var checkerEditor;
var apiUrl = "api/api.php";

function checkNeedUpdate() {
    return;
    $.get(gitInfoUrl, "", function(response) {
        response = JSON.parse(response);
        githubVersion = response.version;
        if (githubVersion != currentVersion) {
            $("#versionBtnArea").show();
            $("#updateVersionBtn").html("Update New Version " + githubVersion);
        }
    });
}
setTimeout(function() {
    checkNeedUpdate();
}, 3000);

function updateVersion() {
    var data = {
        'updateVersion': 1
    }
    return;
    $("#updateVersionBtn").html("Updating...");
    $("#updateVersionBtn").prop("disabled", true);
    $.post("ajax_request.php", data, function(response) {
        alert(response);
        location.reload();
    });
}

function selectChecker(type){
    if(type == "default"){
        $("#custom_checker").hide();
        $("#default_checker").show();
    }
    else{
        $("#default_checker").hide();
        $("#custom_checker").show();
    }
}

function submitCode() {

    var data1 = {
        source_code: btoa(sourceCodeEditor.getValue()),
        input: btoa($("#input").val()),
        expected_output: btoa($("#expectedOutput").val()),
        language: $("#language").val(),
        time_limit: $("#timeLimit").val(),
        memory_limit: $("#memoryLimit").val(),
        checker_type: $('input[name="checker_type"]:checked').val(),
        custom_checker: btoa(checkerEditor.getValue()),
        default_checker: $("#select_default_checker").val(),
        api_type: "submission"
    }
    console.log(data1);
    //return;
    var data = {};
    data['createSubmission'] = data1;
    console.log(data);
    $("#runBtn").html("Running...");
    $("#runBtn").prop("disabled", true);
    $.post(apiUrl, data1, function(response) {
        $("#runBtn").html("Run");
        $("#runBtn").prop("disabled", false);
        processApiResponseData(response);
    }).fail(function(error) {
        $("#runBtn").html("Run");
        $("#runBtn").prop("disabled", false);
        $("#outputResponse").html(error.responseText);
    });
}

function processApiResponseData(response) {
    $("#debug").html(response);
    response = JSON.parse(response);
    if (typeof response.error == 'undefined') {
        //  console.log(response.status.status);
        if (response.status.status == "CE" || response.status.status == "MLE" || response.status.status == "RTE") $("#output").val(response.checkerLog);
        else $("#output").val(atob(response.output));
        $("#outputResponse").html("Total Time: " + response.time + " s<br/>Total Memory: " + response.memory + "<br/>Status: " + response.status.description + "<br/>Checker Log: " + response.checkerLog);
    } else $("#outputResponse").html(response.errorMsg);
}

function setCodeEditor() {
    sourceCodeEditor = ace.edit("code");
    sourceCodeEditor.setShowPrintMargin(false);
    sourceCodeEditor.setOption("maxLines", 23);
    sourceCodeEditor.setOption("minLines", 23);
    sourceCodeEditor.setReadOnly(false);
    sourceCodeEditor.setFontSize("14px");
}

function setCheckerEditor() {
    checkerEditor = ace.edit("checker");
    checkerEditor.setShowPrintMargin(false);
    checkerEditor.setOption("maxLines", 13);
    checkerEditor.setOption("minLines", 13);
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
    if (language == "PYTHON2" || language == "PYTHON3") editorCode = pythonSource;
    $("#code").val(editorCode);
    sourceCodeEditor.setValue(editorCode);
    sourceCodeEditor.clearSelection();
    setEditorSelectLanguage(language);
}

function setEditorSelectLanguage(selectLanguage) {
    if (selectLanguage.startsWith("C")) {
        sourceCodeEditor.getSession().setMode("ace/mode/c_cpp");
    } else if (selectLanguage.startsWith("CPP")) {
        sourceCodeEditor.getSession().setMode("ace/mode/c_cpp");
    } else if (selectLanguage.startsWith("JAVA")) {
        sourceCodeEditor.getSession().setMode("ace/mode/java");
    } else if (selectLanguage.startsWith("PY")) {
        sourceCodeEditor.getSession().setMode("ace/mode/python");
    } else if (selectLanguage.startsWith("RUST")) {
        sourceCodeEditor.getSession().setMode("ace/mode/rust");
    } else if (selectLanguage.startsWith("D")) {
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
class Main {\n\
    public static void main(String[] args) throws Exception {\n\
        System.out.println(\"hello, world\");\n\
    }\n\
}\n\
";