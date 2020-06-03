
<script type="text/javascript" src="http://coderoj.com/style/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap Lib -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://coderoj.com/style/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="http://coderoj.com/style/lib/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://coderoj.com/style/lib/bootstrap/js/bootstrap.min.js"></script>



<!DOCTYPE html>
<html>
<head>
	<title>CoderOJ Compiler</title>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="topTitleArea">
					<div class="topTitle">CoderOJ</div>
					<div class="topSubTitle">Compiler</div>
				</div>
			</div>
			
			<div class="col-md-7" style="text-align: center;">
				<select onchange="changeLanguage()" id="language" class="form-control selectLanguage">
					<option value="C">C</option>
					<option value="CPP">C++</option>
					<option value="CPP11" selected="">C++11</option>
				</select>
				<textarea class="sourceEditor" id="code" placeholder="Source Code"></textarea><br/>
				<textarea rows="4" class="inputEditor" id="input" placeholder="Input"></textarea>
				<textarea rows="4" class="inputEditor" id="expectedOutput" placeholder="Expected Output"></textarea>
				<input type="number" name="" id="timeLimit" value="2" placeholder="Time Limit">
				<button onclick="submitCode()">Run</button>
			</div>
			<div class="col-md-5">
				
				<textarea rows="4" class="inputEditor1" id="output" placeholder="output" readonly></textarea>
				<div id="outputResponse" style="margin-bottom: 10px;">Total Time: <br/>Status: </div>
				<div id="debug" style="margin-bottom: 10px;"></div>
			</div>
		</div>
	</div>
	
</body>
</html>

<script type="text/javascript" src="js/script.js"></script>