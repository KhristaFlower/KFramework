<?php

class Index extends Controller {

    function __construct($details) {
        parent::__construct($details);

        $this->view->mainMenuKey = "Index";
    }

    function index() {
        parent::index(__FILE__);
    }

}

?>