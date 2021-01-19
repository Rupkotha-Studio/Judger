<?php

/**
 *
 */
require 'app/route/route.php';
$GLOBALS['pageList'] = $pageList;

function assest($file){
    echo "app/resource/assest/$file";
}

function view($file){
    return "app/resource/views/$file";
}

class App
{
    private $pageList = array();

    public function __construct()
    {
        $this->pageList = $GLOBALS['pageList'];
        $this->loadPage();
    }

    public function loadPage()
    {
        foreach ($this->pageList as $key => $value) {
            if (isset($_GET[$key])) {
                include "app/resource/views/$value.php";
                return;
            }
        }
        include "app/resource/views/welcome.php";
    }
}
