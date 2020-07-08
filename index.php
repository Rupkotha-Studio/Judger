
<script type="text/javascript" src="http://coderoj.com/style/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap Lib -->

<link href="https://fonts.googleapis.com/css?family=Exo 2" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://coderoj.com/style/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="http://coderoj.com/style/lib/font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://coderoj.com/style/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js"></script>

<?php 
	$infoData = json_decode(file_get_contents("info.json"),true);
	$version = $infoData['version'];	
?>

<script type="text/javascript">
	var gitInfoUrl = "<?php echo $infoData['github-info-file']; ?>";
	var currentVersion = "<?php echo $version; ?>";
</script>

<!DOCTYPE html>
<html>
<head>
	<title>CoderOJ Compiler</title>
</head>
<body>

	<div class="containerr">
		<div class="row">
			<div class="col-md-12">
				<div class="topTitleArea">
					<div class="topTitle">
						CoderOJ
						<span class="topSubTitle">Compiler
							<span class="pull-right" id="versionBtnArea" style="display: none"><button onclick="updateVersion()" id="updateVersionBtn"></button></span>
						</span>
						
					</div>
				</div>

			</div>

			<div class="col-md-12">
				
				<div class="row">
					<div class="col-md-6">
						<select onchange="changeLanguage()" id="language" class="form-control selectLanguage">
							<option value="C">C</option>
							<option value="CPP">C++</option>
							<option value="CPP11" selected="">C++11</option>
						</select>
					</div>
					<div class="col-md-4">
						<input type="number" name="" class="form-control" id="timeLimit" value="2" placeholder="Time Limit">
					</div>
					<div class="col-md-2">
						<button id="runBtn" onclick="submitCode()">Run</button>
					</div>
				</div>
				
				
			</div>
			
			<div class="col-md-6">
				<textarea class="sourceEditor" id="code" placeholder="Source Code"></textarea>
			</div>
			<div class="col-md-6">
				<textarea rows="4" class="inputEditor" id="input" placeholder="Input"></textarea>
				<textarea rows="4" class="inputEditor" id="expectedOutput" placeholder="Expected Output"></textarea>
				<textarea rows="4" class="inputEditor1" id="output" placeholder="output" readonly></textarea>
				<div id="outputResponse" style="margin-bottom: 10px;">Total Time: <br/>Status: </div>
				<div id="debug" style="margin-bottom: 10px;"></div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="footer">
		<?php echo "Compiler Version: $version"; ?>

	</div>
		</div>
	</div>
	
	
</body>
</html>

<script type="text/javascript" src="js/script.js"></script>