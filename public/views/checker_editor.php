<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="col-md-8">
	<div class="fieldTitle">Enter Checker C++ Code</div>
	<textarea rows="4" class="inputEditor1" onkeypress="updateTxt(this)" id="checker" placeholder="Checker"></textarea>

	<div class="pull-right">
		<button id="runBtn" onclick="runChecker()">Run</button>
	</div>
	<div id="outputResponse" style="margin-bottom: 4px;">
	</div>
</div>
<div class="col-md-4">
	<div class="fieldTitle">Input</div>
		<textarea class="inputEditor" style="height: 140px;width: 100%" onkeyup="updateTxt(this)" id="input" placeholder="Input"></textarea>
		<div class="fieldTitle" style="margin-top: 5px">Output</div>
		<textarea rows="4" onkeyup="updateTxt(this)" style="height: 140px;" class="inputEditor1" id="output" placeholder="output"></textarea>
		<div class="fieldTitle">Answare</div>
		<textarea style="height: 140px;width: 100%" onkeyup="updateTxt(this)" rows="4" class="inputEditor" id="expectedOutput" placeholder="Expected Output"></textarea>
		<div id="debug" style="margin-bottom: 4px;"></div>
</div>


<style type="text/css">
	.checkerError{
		color: red;
	}
	.checkerValidVerdict{
		color: green;
		font-weight: bold;
	}
	.checkerWrongVerdict{
		color: red;
		font-weight: bold;
	}
	.checkerLog{
		color: #2c3e50;
	}
	.checkerLogBody{
		color: #34495e;
	}
</style>