<?php

class UCP extends UCP_Controller {

    function __construct() {
        parent::__construct();

        $this->_requiresLogin[] = "index";
        $this->view->subMenuKey = "UCP";
    }

    public function index() {
        parent::index(__FILE__);
    }

}

?>
