<?php

class Controller {

    /**
     * @var String Array - Holds the names of the methods that require administration rights to access.
     */
    public $_requiresAdmin;

    /**
     * @var String Array - Holds the names of the methods that require a user to be logged in to access.
     */
    public $_requiresLogin;

    /**
     * @var Boolean - Stores true or false depending on if an account is in session or not.
     */
    public $_loggedIn = false;

    /**
     * @var String - Stores any additional pathing that was required to reach this controller.
     */
    public $_depthPath = "";

    function __construct() {
        session_start();

        $this->_requiresAdmin = array();
        $this->_requiresLogin = array();

        $this->view = new View();

        // Store a list of files that will be used on every page.
        $this->view->js[] = "public/js/jquery.js";
        $this->view->css[] = "public/css/default_main.css";
        $this->view->css[] = "public/css/nav_sub.css";

        $this->_loggedIn = $this->checkLogin();

        // Build up the navigation bar that will show at the top of the page.
        // This setting stores the current tab for styling.
        $this->view->mainMenuKey = "Index";

        // Store all links that will be available at all times.
        $this->view->mainMenuAll['Index'] = "/";

        // Store the links to locations that require a logged in account to access.
        $this->view->mainMenuIn['UCP'] = '/ucp/';
        $this->view->mainMenuIn['Logout'] = '/ucp/logout/';

        // Store the links that will be visible only to those who are not logged in.
        $this->view->mainMenuOut['Login'] = '/ucp/login/';

        // Store the links that will be availalbe if an account has admin privilages.
        $this->view->mainMenuAdmin['ACP'] = "/acp/";
    }

    /**
     * Check to see if the account in session has the permission to access a function.
     * @param String $function_name The name of the function to check an account against.
     */
    public function _verify($function_name) {
        if (in_array($function_name, $this->_requiresLogin)) {
            echo "This page requires logging in.";
        }

        if (in_array($function_name, $this->_requiresAdmin)) {
            echo "You must be an administrator to access this page.";
        }
    }

    /**
     * Attempt to load the model for the given controller.
     * @param String $name Name of the model file.
     * @param String $path Location of the model files.
     */
    public function loadModel($name, $modelPath) {
        $path = $modelPath . $name . '_model.php';

        if (file_exists($path)) {
            require $path;
            $path_parts = pathinfo($name);
            $modelName = $path_parts['filename'] . '_Model';
            $this->model = new $modelName;
        }
    }

    /**
     * Automatically loads the index page for the given controller.
     * @param String $name Name of the index page.
     */
    function index($name) {
        $pathInfo = pathinfo($name);
        $viewLocation = (strlen($this->_deepPath) > 0) ? "{$this->_deepPath}/" : "";
        $viewLocation .= "{$pathInfo["filename"]}/{$pathInfo["filename"]}_index";
        $this->view->render($viewLocation);
    }

    /**
     * Check that the user is logged in.
     * @return Boolean User is logged in.
     */
    function checkLogin() {
        //TODO Write the checkLogin function.
    }

}

?>
