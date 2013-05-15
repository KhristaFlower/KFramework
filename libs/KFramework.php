<?php

class KFramework {

    private $_url = null;
    private $_controller = null;
    private $_controllerPath = PATH_CONTROLLERS;
    private $_modelPath = PATH_MODELS;
    private $_viewPath = PATH_VIEWS;
    private $_defaultErrorController = SITE_DEFAULT_ERROR_CONTROLLER;
    private $_defaultController = SITE_DEFAULT_CONTROLLER;
    
    /**
     * This array stores mixed values that are added when errors occour for optional display.
     * @var String Array Array used to hold error strings for display on an error page.
     */
    private $_errorLog = array();
    
    /**
     * Used to offset the URL index positions when trying to determine the method to invoke.
     * @var Integer The array offset for the controller in the URL.
     */
    private $_controllerDepth = 0; // Set automatically - Leave at 0.
    
    /**
     * When a controller file is stored in a subfolder to the main one, the route to that file is stored here.
     * @var String The path required to go from the controller base folder to the controller being used.
     */
    private $_controllerDepthPath = ""; // Set automatically - Leave blank.

    /**
     * Start the framework.
     */
    public function init() {
        $this->_getURL();
        $this->_loadController();
        //$this->_callControllerMethod();
    }

    /**
     * Process the URL into useable segments.
     */
    private function _getURL() {
        $url_raw = isset($_GET['url']) ? $_GET['url'] : $this->_defaultController;
        $url_edited = rtrim($url_raw, '/');
        $url_final = filter_var($url_edited, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url_final);
    }

    /**
     *  Load the controller which matches the request in the URL.
     */
    private function _loadController() {
        $controller = $this->_selectController();
        if (empty($controller)){
            echo "No controller found.";
            die();
        }
        
        echo $controller;
        
        $controllerPath = pathinfo($controller);
        echo "<br/><br/>".$controllerPath['dirname'];
        die();
        
    }

    /**
     *  Calculate the controller that should be loaded using the URL.
     * 
     *  The following checks will be performed in the controller folder until a controller is located:
     *  url[0].php as a controller
     *  url[0]/url[1].php as a controller
     *  url[0]/url[0].php as a controller
     *  Return nothing.
     * 
     * @return String File path to a controller file.
     * 
     */
    private function _selectController() {
        $possibleController = $this->_controllerPath . $this->_url[0] . '.php';
        if (file_exists($possibleController)) {
            return $possibleController;
        }

        $possibleController = $this->_controllerPath . "{$this->_url[0]}/{$this->_url[1]}.php";
        if (file_exists($possibleController)) {
            return $possibleController;
        }
        
        $possibleController = $this->_controllerPath . "{$this->_url[0]}/{$this->_url[0]}.php";
        if (file_exists($possibleController)){
            return $possibleController;
        }
        
        // No controller was found in a location that it could be expected based on the URL parameters.
        return null;
    }
    
    /**
     * Fire an error and kill the script.
     */
    private function _error($errorType = SITE_DEFAULT_ERROR_CONTROLLER)
    {
        
    }

}

?>
