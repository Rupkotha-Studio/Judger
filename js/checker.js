$(document).ready(function() {
    setCheckerEditor();
});

var checkerEditor;

function runChecker() {

    var data = {
        checker: btoa(checkerEditor.getValue()),
        input: btoa($("#input").val()),
        output: btoa($("#output").val()),
        expectedOutput: btoa($("#expectedOutput").val()),
        apiType : "checker"
    }

    $("#runBtn").html("Running...");
    $("#runBtn").prop("disabled",true);
    $("#outputResponse").html("loading....");
    $("#debug").html("");
    $.post("api.php", data, function(response) {
        processApiResponseData(response);
    });
}

function processApiResponseData(response){
    $("#runBtn").html("Run");
    $("#runBtn").prop("disabled",false);
    $("#debug").html(response);
    response = JSON.parse(response);
    if (typeof response.error == 'undefined') {
        $("#outputResponse").html("<u>Checker Log:</u> <br/>" + response.checkerLog);
    } 
    else $("#outputResponse").html(response.errorMsg);
}

function setCheckerEditor(){
    checkerEditor = ace.edit("checker");
    checkerEditor.setShowPrintMargin(false);
    checkerEditor.setOption("maxLines", 33);                    
    checkerEditor.setOption("minLines", 33);                    
    checkerEditor.setReadOnly(false);
    checkerEditor.setFontSize("14px");

    checkerEditor.setValue(checkEditorCode);
    checkerEditor.clearSelection();

    checkerEditor.getSession().setMode("ace/mode/c_cpp");
}


var checkEditorCode = "\
#include \"testlib.h\"\n\
#include <bits/stdc++.h>\nusing namespace std;\n\
\n\
int main(int argc, char * argv[]) {\n\
    registerTestlibCmd(argc, argv);\n\
    quitf(_ok,\"output is ok\");\n\
}\n\
";