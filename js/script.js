$(document).ready(function() {
    changeLanguage();
});

function submitCode() {

    var timeLimit = $("#timeLimit").val();
    if (timeLimit == "") {
        alert("Enter Time Limit");
        return;
    }

    var data1 = {
        sourceCode: btoa($("#code").val()),
        input: btoa($("#input").val()),
        expectedOutput: btoa($("#expectedOutput").val()),
        language: $("#language").val(),
        timeLimit: $("#timeLimit").val()
    }

    var data = {};
    data['createSubmission'] = data1;

    $("#output").val("Loading......");

    $.post("api.php", data1, function(response) {
        $("#debug").html(response);
        response = JSON.parse(response);

        if (typeof response.error == 'undefined') {

            if (response.status.status == "CE" || response.status.status == "RTE") $("#output").val(atob(response.compileMessage));
            else $("#output").val(atob(response.output));

            $("#outputResponse").html("Total Time: " + response.time + " s<br/>Status: " + response.status.description);
        } else $("#outputResponse").html(response.errorMsg);
    });
}

function changeLanguage() {
    var language = $("#language").val();
    var editorCode = "";
    if (language == "C") editorCode = cSource;
    if (language == "CPP") editorCode = cppSource;
    if (language == "CPP11") editorCode = cppSource;
    if (language == "JAVA") editorCode = javaTestSource;

    $("#code").val(editorCode);
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
#include <iostream>\n\
\n\
int main() {\n\
    std::cout << \"hello, world\" << std::endl;\n\
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