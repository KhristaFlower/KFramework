<?php

class UCP_Controller extends Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->view->mainMenuKey = "UCP";
        $this->view->subMenu['UCP'] = "/ucp/";
        $this->view->subMenu['Settings'] = "/ucp/settings";
        $this->view->subMenu['Messages'] = "/ucp/messages";
    }
    
    public function index($name)
    {
        parent::index($name);
    }
}

?>
