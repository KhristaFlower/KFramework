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

    /*
     * For now this function will work as a temporary solution for page rendering.
     */
    public function render($name) {
        require PATH_VIEWS . 'header.php';
        echo '<body>';
        echo '<div class="wrapper">';
            echo '<div class="header">KFramework</div>';
            echo '<div class="navigation">' . $this->_navMenu->renderMenu() . '</div>';
            echo '<div class="clearall"></div>';
            echo '<div class="content">';
            require PATH_VIEWS . $name . '.php';
            echo '</div>';
            require PATH_VIEWS . 'footer.php';
        echo '</div>';
        echo '</body>';
    }

}

?>
