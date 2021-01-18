<?php

/**
 *
 */
require 'app/route.php';
$GLOBALS['pageList'] = $pageList;
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
                include "public/views/$value.php";
                return;
            }
        }
        include "public/views/welcome.php";
    }
}
