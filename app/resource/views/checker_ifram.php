
<script type="text/javascript" src="http://coderoj.com/style/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap Lib -->

<link href="https://fonts.googleapis.com/css?family=Exo 2" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://coderoj.com/style/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="http://coderoj.com/style/lib/font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="public/style/css/style.css">
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
	<title>CoderOJ Checker</title>
</head>
<body>
	<div class="containerr"><div style="color: #000000"><?php echo "v ".$version; ?></div>
		<div class="row">

			<?php include "public/views/checker_editor.php"; ?>
		</div>
		
	</div>
</body>
</html>

<script type="text/javascript" src="public/style/js/checker.js"></script>