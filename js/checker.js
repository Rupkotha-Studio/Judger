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

    $("#runBtn").html("Running....");
    $("#runBtn").prop("disabled",true);
    $("#outputResponse").html("<i class='fa fa-spinner fa-spin'></i> Wating For Response...");
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
        if(response.checkerError!="")
            $("#outputResponse").html("<div class='checkerError'><b><i class='fa fa-exclamation-circle'></i> Checker Error:</b><br/>" + response.checkerError+"</div>");
        else{
            if(response.checkerVerdict == 1)
                $("#outputResponse").html("<div class='checkerValidVerdict'><i class='fa fa-check-circle'></i> Checker Verdict Is Correct</div>");
            else 
                $("#outputResponse").html("<div class='checkerWrongVerdict'><i class='fa fa-times-circle'></i> Checker Verdict Is Wrong</div>");
            $("#outputResponse").append("<div class='checkerLog'>" + response.checkerLog+"</div>");
        }
        
    } 
    else $("#outputResponse").html(response.errorMsg);
}

function setCheckerEditor(){
    checkerEditor = ace.edit("checker");
    checkerEditor.setShowPrintMargin(false);
    checkerEditor.setOption("maxLines", 31);                    
    checkerEditor.setOption("minLines", 31);                    
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