
<script type="text/javascript" src="http://coderoj.com/style/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap Lib -->

<link href="https://fonts.googleapis.com/css?family=Exo 2" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://coderoj.com/style/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="http://coderoj.com/style/lib/font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="<?php assest('css/style.css') ?>">
<script type="text/javascript" src="http://coderoj.com/style/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js"></script>

<?php
$infoData = json_decode(file_get_contents("info.json"), true);
$version  = $infoData['version'];
?>

<script type="text/javascript">
	var gitInfoUrl = "<?php echo $infoData['github-info-file']; ?>";
	var currentVersion = "<?php echo $version; ?>";
</script>

<!DOCTYPE html>
<html>
<head>
	<title>CoderOJ Ide</title>
</head>
<body>

	<style type="text/css">
		.ideNavbar{
			background-color: #ffffff;
			color: #000000;
			min-height: 45px;
			padding-top: 5px;
		}
		.ideNavbar input,select{
			padding: 8px;
			color: #000000;
			background-color: #ffffff;
			width: 200px;
			border-radius: 5px;
			border: 1px solid #CCCCCC;
			margin-bottom: 5px;
			margin-right: 5px;
		}
		.ideNavbar input:focus{
			outline: none;
			border: 1px solid #1678C2;
		}
		.ideNavbar select:focus{
			outline: none;
			border: 1px solid #1678C2;

		}
		textarea{
			border-radius: 5px;
			border: 1px solid #CCCCCC;
			width: 100%;
			resize: none;
			height: 160px;
			margin-bottom: 5px;
			padding: 5px;
		}

		textarea:focus{
			outline: none;
		}

		button{
			width: 100px;
			font-size: 16px;
			padding: 9px;
			border-radius: 5px;
			border-width: 0px;
			background-color: #1678C2;
			color: #ffffff;
			font-weight: bold;
		}
	</style>

	<div class="row">
		<div class="ideNavbar">
			<div class="col-md-3">
				<div class="topTitle">
						CoderOJ
						<span class="topSubTitle">Ide
							<span class="pull-right" id="versionBtnArea" style="display: none"><button onclick="updateVersion()" id="updateVersionBtn"></button></span>
						</span>
					</div>
			</div>
			<div class="col-md-9">
				<select onchange="changeLanguage()" style="" id="language" class="">
					<option value="C">C</option>
					<option value="CPP">C++</option>
					<option value="CPP11" selected="">C++11</option>
					<option value="JAVA">Java</option>
					<option value="PYTHON2">Python2</option>
				</select>
				<input type="number" name="" style="" class="" id="timeLimit" value="2" placeholder="Time Limit">
				<input type="number" style="" name="" class="" id="memoryLimit" value="128000" placeholder="Memory Limit">
				<button id="runBtn" onclick="submitCode()"><i class="fas fa-play"></i> Run</button>
			</div>

		</div>
	</div>

	<div class="containerr">
		<div class="row">

			<div class="col-md-7">
				<div class="fieldTitle">Enter Source Code</div>
				<textarea class="sourceEditor" id="code" placeholder="Source Code"></textarea>
				<div id="checker_area">
					<span style="margin-right: 5px" class="fieldTitle">Select Checker Type: </span> <input onchange="selectChecker('default')" type="radio" name="checker_type" value="default" id="default_check_box" checked=""> <label style="margin-right: 10px;" class="form-check-label" for="default_check_box">Default</label>
					<input type="radio" name="checker_type" value="custom" onchange="selectChecker('custom')" id="custom_check_box"> <label class="form-check-label" for="custom_check_box">Custom</label><br/>
					<div id="default_checker">
						<select id="select_default_checker" style="margin-top: 10px;margin-left: 15px;" class="">
							<option value="lcmp">lcmp</option>
							<option value="yesno">yesno</option>
						</select>
					</div>
					<div id="custom_checker" style="display: none;">
						<div class="fieldTitle">Enter Checker Code</div>
						<textarea rows="4" class="inputEditor1" id="checker" placeholder="Checker"></textarea>
					</div>
				</div>
				
			</div>
			<div class="col-md-5">
				<div class="row">
					<div class="col-md-6">
						<div class="fieldTitle">Input</div>
						<textarea rows="4" id="input" placeholder="Input"></textarea>
					</div>
					<div class="col-md-6">
						<div class="fieldTitle">Expected Output</div>
						<textarea rows="4" id="expectedOutput" placeholder="Expected Output"></textarea>
					</div>
					<div class="col-md-12">
						<div class="fieldTitle">Output</div>
						<textarea rows="4" id="output" placeholder="output" readonly></textarea>
					</div>
				</div>
				
				
				<div id="outputResponse" style="margin-bottom: 10px;">Total Time: <br/>Total Memory:<br/>Status: <br/>Checker Log: </div>
				<div id="debug" style="margin-bottom: 10px;"></div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="footer">
				<?php echo "Judger Version: $version"; ?>
			</div>
		</div>
	</div>


</body>
</html>

<script type="text/javascript" src="<?php assest('js/ide.js') ?>"></script>