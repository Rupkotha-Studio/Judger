<?php

/**
 * 
 */

require 'app/page.php';
$GLOBALS['pageList'] = $pageList;
class App
{
	private $pageList = array();
	
	function __construct()
	{
		$this->pageList = $GLOBALS['pageList'];
		$this->loadPage();
	}

	public function loadPage(){
		$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'],'/')) : '/';
    	$url = isset($url[0])?$url[0]:$url;
    	
    	if(isset($this->pageList[$url])){
    		$page = $this->pageList[$url];
    		include "public/views/$page.php";
    	}
    	else echo "request is not found";
    	
    	
	}
}