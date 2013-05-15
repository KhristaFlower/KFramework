<?php

class View {

    public $js = array();
    public $css = array();

    function __construct() {
        
    }

    public function render($name) {
        require PATH_VIEWS . 'header.php';
        require PATH_VIEWS . $name . '.php';
        require PATH_VIEWS . 'footer.php';
    }

}

?>
