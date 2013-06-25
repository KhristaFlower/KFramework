<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Controller {

    /**
     * @var string An array to hold the names of the methods that require administration rights to access.
     */
    protected $_requiresAdmin = array();

    /**
     * @var string An array to hold the names of the methods that require a user to be logged in to access.
     */
    protected $_requiresLogin = array();

    /**
     * @var boolean Stores true or false depending on if an admin account is in session or not.
     */
    protected $_KF_Admin_LoggedIn = false;

    /**
     * @var DataContainer A single object to hold all data that needs to be moved around.
     */
    protected $dataContainer = null;
    protected $_view;

    public function __construct($dataContainer) {
        session_start();

        $this->dataContainer = $dataContainer;
        $this->dataContainer->addContainer(new DataContainer("View"));
        $this->dataContainer->addContainer(new DataContainer("KF_Admin"));

        $this->_view = new View();

        $loggedIn = $this->checkLogin();

        // Create a new navigation menu for display at the top of the page.
        $mainNavigationMenu = new NavigationElement();

        // Create categories for display on the navigation bar and populate them.
        $homeSubMenu = new NavigationElement("Home", "/");
        // Add categories to the main navigation.
        $mainNavigationMenu->addElement($homeSubMenu);

        $mainAdministrationMenu = new NavigationElement();
        $adminMenu = new NavigationElement("Admin", "");
        if ($loggedIn) {
            $adminMenu->addElement(new NavigationElement("Open ACP", "/acp/"));
            $adminMenu->addElement(new NavigationElement("", "", NavigationElement::TYPE_DIVIDER));
            //$adminMenu->addElement(new NavigationElement("Logged in as", "", NavigationElement::TYPE_HEADING));
            $adminMenu->addElement(new NavigationElement($_SESSION['KF_Admin']['Username'], "", NavigationElement::TYPE_HEADING));
            $adminMenu->addElement(new NavigationElement("Logout", "/acp/logout"));
        } else {
            $adminMenu->addElement(new NavigationElement("Login", "/acp/login"));
        }
        $mainAdministrationMenu->addElement($adminMenu);

        $this->dataContainer->getContainer("View")
                ->setVariable("MainNav", $mainNavigationMenu)
                ->setVariable("AdminNav", $mainAdministrationMenu);
    }

    /**
     * Check to see if the account in session has the permission to access a function.
     * @param string $function_name The name of the function to check an account against.
     */
    public function verify($function_name) {
        // Check to see if the function we want to use requires an admin to access.
        if (in_array($function_name, $this->_requiresAdmin)) {
            if (!$this->dataContainer->gc("KF_Admin")->gv("LoggedIn")) {
                //echo "You must be an administrator to access this page.";
                header('Location: /acp/login/');
                //@TODO: Create admin required error page.
                die();
                return false;
            }
        }
        return true;
    }

    /**
     * Attempt to load the model for the given controller.
     * @param string $name Name of the model file.
     * @param string $path Location of the model files.
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
     * @param string $name Name of the index page.
     */
    public function index() {
        $this->renderPage("index");
    }

    /**
     * Render a page that is equal to or below the current controller.
     * If you render the logout page in the ACP controller then acp_logout.php
     * will be rendered as our page in a folder under the views location.
     * @param string $page Name of the page for the current controller to render.
     */
    public function renderPage($page) {
        $details = $this->dataContainer->getVariable("ControllerDetails");
        $viewLocation = (empty($details['path'])) ? "" : implode("/", $details['path']) . "/";
        $viewLocation .= "{$details['name']}/{$details['name']}_$page";

        $this->renderSpecificPage(PATH_VIEWS . $viewLocation);
    }

    /**
     * Render any file in or under the KFramework root directory.
     * @param string $path Path to the file to be rendered.
     */
    public function renderSpecificPage($path) {
        $this->_view->setDataContainer($this->dataContainer);
        $this->_view->renderSpecificPage($path);
    }

    /**
     * Check that the user is logged in.
     * @return boolean User is logged in.
     */
    private function checkLogin() {
        $KF_Admin = $_SESSION['KF_Admin'];
        if (isset($KF_Admin['LoggedIn'], $KF_Admin['ID'], $KF_Admin['Username'], $KF_Admin['LoginString'])) {
            $userIP = $_SERVER['REMOTE_ADDR'];
            $userBrowser = $_SERVER['HTTP_USER_AGENT'];
            $userString = hash('sha256', $userIP . $userBrowser);

            if ($KF_Admin['LoginString'] == $userString) {
                $this->dataContainer->getContainer("KF_Admin")
                        ->setVariable("LoggedIn", true)
                        ->setVariable("ID", $KF_Admin['ID'])
                        ->setVariable("Username", $KF_Admin['Username']);
                return true;
            } else {
                session_destroy();
            }
        }
        $this->dataContainer->getContainer("KF_Admin")->setVariable("LoggedIn", false);
        return false;
    }

    /**
     * Provide a DataContainer to the controller, sent automatically.
     * @param DataContainer $dataContainer The DataContainer.
     */
    public function setDataContainer($dataContainer) {
        $this->dataContainer = $dataContainer;
    }

}
