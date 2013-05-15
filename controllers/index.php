<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->mainMenuKey = "Index";
    }

    function index() {
        parent::index(__FILE__);
    }

}

?>