<?php
	header('Access-Control-Allow-Origin: *');

	include "compiler_script/sandBox.php";
	include "compiler_script/cpp.php";
	include "api_script/api.php";
	
	$Api = new Api($_POST);
	$response = $Api->response();
	
	echo "$response";

?>
