<?php
	header('Access-Control-Allow-Origin: *');

	include "compiler/sandBox.php";
	include "compiler/cpp.php";
	include "api_script/api.php";
	
	$Api = new Api($_POST);
	$response = $Api->response();
	
	echo "$response";

?>
