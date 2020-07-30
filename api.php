<?php
	header('Access-Control-Allow-Origin: *');

	include "compiler_script/file.php";
	include "compiler_script/sand_box.php";
	include "compiler_script/cpp.php";
	include "api_script/api.php";
	
	$Api = new Api($_POST);
	$response = $Api->response();
	
	echo "$response";

?>
