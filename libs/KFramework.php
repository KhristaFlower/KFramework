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
        $url = isset($_GET['url']) ? $_GET['url'] : $this->_defaultController;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
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
        die();
    }

    /**
     *  Calculate the controller that should be loaded using the URL.
     * 
     *  The following checks will be performed in the controller folder until a controller is located:
     *  url[0].php as a controller
     *  url[0]/url[1].php as a controller
     *  url[0]/url[0].php as a controller
     *  Throw a 404, we were unable to locate a controller.
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

}

?>
