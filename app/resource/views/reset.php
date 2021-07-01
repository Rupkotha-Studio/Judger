<?php 
	header('Access-Control-Allow-Origin: *');

	function getJsonData($url){
		return json_decode(file_get_contents($url),true);
	}

	$currentData = getJsonData("info.json");
	$githubData = getJsonData($currentData['github-info-file']);

	if(!isset($githubData['version']))return;
	
	exec("rm -r *");
	$fileName = $githubData['name'];
	shell_exec("git clone ".$githubData['github-url']);
	exec("chmod -R 777 $fileName");
	exec("mv $fileName/* .");
	exec("rm -r $fileName");
	echo "Successfully Reset ".$githubData['version'];
?>