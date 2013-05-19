<?php

class Controller {

    /**
     * @var string An array to hold the names of the methods that require administration rights to access.
     */
    protected $_requiresAdmin;

    /**
     * @var string An array to hold the names of the methods that require a user to be logged in to access.
     */
    protected $_requiresLogin;

    /**
     * @var boolean Stores true or false depending on if an account is in session or not.
     */
    protected $_loggedIn = false;
    
    /**
     * Contains details sent from the KFramework to this controller.
     * @var array Contains details about this controller.
     */
    protected $_details;
    
    public function __construct($details) {
        session_start();
        
        $this->_details = $details;
        
        $this->view = new View();
        
        $this->_loggedIn = $this->checkLogin();
        
        $this->_requiresAdmin = array();
        $this->_requiresLogin = array();

        // Store a list of files that will be used on every page.
        $this->view->css[] = "main.css";

        // Create a new navigation menu for display at the top of the page.
        $this->view->_navMenu = new NavigationMenu();
        
        // Create categories for display on the navigation bar and populate them.
        $homeCategory = new NavigationCategory("Home","/");
        $ucpCategory = new NavigationCategory("UCP","/ucp/");
        $ucpCategory->addMenuItem(new NavigationItem("Messages","/ucp/messages/"));
        $ucpCategory->addMenuItem(new NavigationItem("Settings","/ucp/settings/"));
        $ucpCategory->addMenuItem(new NavigationItem("Profile","/ucp/profile/"));
        $ucpCategory->addMenuItem(new NavigationItem("Groups","/ucp/groups/"));
        $testCategory = new NavigationCategory("Test","/");
        $testCategory->addMenuItem(new NavigationItem("Navigation Test","/ucp/navtest/"));
        
        // Add categories to the main navigation.
        $this->view->_navMenu->addCategory($homeCategory)->addCategory($ucpCategory)->addCategory($testCategory);
    }

    /**
     * Check to see if the account in session has the permission to access a function.
     * @param String $function_name The name of the function to check an account against.
     */
    protected function _verify($function_name) {
        if (in_array($function_name, $this->_requiresLogin)) {
            echo "This page requires logging in.";
            //@TODO: Create login required error page.
            die();
        }

        if (in_array($function_name, $this->_requiresAdmin)) {
            echo "You must be an administrator to access this page.";
            //@TODO: Create admin required error page.
            die();
        }
    }

    /**
     * Attempt to load the model for the given controller.
     * @param String $name Name of the model file.
     * @param String $path Location of the model files.
     */
    protected function loadModel($name, $modelPath) {
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
    public function index() {
        $this->renderPage("index");
    }
    
    public function renderPage($page){
        $viewLocation = (empty($this->_details['path'])) ? "" : implode("/", $this->_details['path']) . "/";
        $viewLocation .= "{$this->_details['name']}/{$this->_details['name']}_$page";
        
        $this->view->render($viewLocation);
    }

    /**
     * Check that the user is logged in.
     * @return Boolean User is logged in.
     */
    private function checkLogin() {
        //TODO Write the checkLogin function.
    }

}

?>
