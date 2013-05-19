<?php

class View {

    /**
     * Add names of CSS files to include. The file path will start from the selected theme directory.
     * @var String An array to hold links to CSS files for adding to the head tag.
     */
    public $css = array();

    /**
     * Add names of the JS files to include. The file path starts at the root directory.
     * @var String An array to hold links to JS files for adding to the head tag.
     */
    public $js = array();

    /**
     * The navigation object to display on the page.
     * @var NavigationMenu The main navigation bar to use for the website.
     */
    public $_navMenu;
    
    /**
     * Used when feeding certain information back to the user; may be removed in the future.
     * @var array A mixed array containing the parameters from the URL.
     */
    public $_params;

    function __construct() {
        
    }

    public function render($name) {
        require PATH_VIEWS . 'header.php';
        require PATH_VIEWS . $name . '.php';
        require PATH_VIEWS . 'footer.php';
    }

}

?>
