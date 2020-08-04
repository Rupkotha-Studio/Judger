$(document).ready(function() {
    setFieldVal();
    setCheckerEditor();
});

var checkerEditor;
var checkerCode,input,output,answer;

function setFieldVal(){
   // eraseCookie("checkerEditor");
   // checkerCode = getCookie("checkerEditor");
   // if(checkerCode == "")
        checkerCode = checkEditorCode;
   // $("#input").val(getCookie("input"));
   // $("#output").val(getCookie("output"));
   // $("#expectedOutput").val(getCookie("expectedOutput"));
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toGMTString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}

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
    $.post("api", data, function(response) {
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
    checkerEditor.setValue(checkerCode);
    checkerEditor.clearSelection();

    checkerEditor.getSession().setMode("ace/mode/c_cpp");
}

function updateTxt(e){
    setCookie(e.id, e.value, 30);
    console.log(e.value);
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