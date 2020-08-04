<?php
	header('Access-Control-Allow-Origin: *');

	include "src/sandbox/file.php";
	include "src/sandbox/checker/checker.php";
	include "src/sandbox/sandbox.php";
	include "src/sandbox/compiler/cpp.php";
	include "src/api/api.php";
	
	$Api = new Api($_POST);
	$response = $Api->response();
	
	echo "$response";

?>
