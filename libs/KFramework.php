<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class KFramework {

    /**
     * Store the elements of the URL in the array as the result of explode "/".
     * @var array Holds the elements that make up the URL.
     */
    private $_url = null;

    /**
     * The variable that holds a controller object determined by the framework.
     * @var Controller The controller being used by the framework for functionality.
     */
    private $_controller = null;
    
    /**
     *
     * @var DataContainer A data container for storing all sorts of information.
     */
    private $dataContainer = null;

    /**
     * This array stores mixed values that are added when errors occour for optional display.
     * @var String Array Array used to hold error strings for display on an error page.
     */
    private $_errorLog = array();

    /**
     * Start the framework.
     */
    public function init() {
        $this->dataContainer = new DataContainer("Master");
        $this->_processURL();
        $this->_loadController();
    }

    /**
     * Process the URL into useable segments.
     */
    private function _processURL() {
        $url_raw = isset($_GET['url']) ? $_GET['url'] : SITE_DEFAULT_CONTROLLER;
        $url_edited = rtrim($url_raw, '/');
        $url_final = filter_var($url_edited, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url_final);
    }

    /**
     * This function was created to redirect users to the /setup/ folder if it
     * existed. This was the easiest way to ensure an administrator could be
     * taken through the steps required to get an account created properly.
     * 
     * This check would not load the /setup/ folder if it did not exist and is
     * used as a way to force administrators to remove the folder once they are
     * done with it.
     * 
     * Right now I am unsure if I want to force users to this page. Although
     * this function had a task to complete, it has been neutered and will not
     * perform these checks. It will remain until I decide whether or not I wish
     * to continue using it.
     */
    private function _checkSetup() {

        return false;

        // Skip the check if we're at the setup.
        if ($this->_url[0] == "setup") {
            return true;
        }

        $file = "setup/";
        if (file_exists($file)) {
            // Setup folder exists!
            $this->_url = array("setup");
            return true;
            //header("Location: /setup/");
        } else {
            return false;
        }
    }

    /**
     * Determine if we should load a controller from a different location based on the URL.
     * @return string Path to check for controllers.
     */
    public function _checkForAlternate() {
        if ($this->_url[0] == "setup") {
            if ($this->_url[1] == null) {
                $this->_url[1] = "index";
            }
            return "setup/";
        } else {
            return PATH_CONTROLLERS;
        }
    }

    /**
     *  Load the controller which matches the request in the URL.
     */
    private function _loadController() {
        // Load controllers from the setup folder if we haven't installed yet.
        //$setupOrNot = ($this->_checkSetup()) ? 'setup/' : PATH_CONTROLLERS;
        $alternatePath = $this->_checkForAlternate();
        // Load the controller.
        $controllerDetails = $this->_getControllerDetails($alternatePath);
        $this->dataContainer->setVariable("ControllerDetails", $controllerDetails);
        if (empty($controllerDetails)) {
            //$this->_dumpArrayReadable($controllerDetails);
            $this->_error('404');
            die();
        }

        // Require the file and create a new object.
        require $controllerDetails['fullPath'];
        $this->_controller = new $controllerDetails['name']($this->dataContainer);

        $controllerParams = $controllerDetails['params'];
        if (!empty($controllerParams)) {
            // Check to see if the first parameter is the name of a method in the controller.
            if (method_exists($this->_controller, $controllerParams[0])) {
                // Prevent access to any methods starting with an underscore. We don't want these being activated.
                if (!strncmp($controllerParams[0], "_", 1) == 0) {
                    // Check to see if this method requires admin
                    if ($this->_controller->verify($controllerParams[0])) {
                        // Method has been found and can be used.
                        // If we have more parameters than just the method name; send these to the method too!
                        if (count($controllerParams) > 1) {
                            $methodParams = array_slice($controllerParams, 1);
                            $this->_controller->{$controllerParams[0]}($methodParams);
                        } else {
                            $this->_controller->{$controllerParams[0]}();
                        }
                    }
                } else {
                    // Fire a 404 as something they specified did not exist to them.
                    $this->_error('404');
                }
            } else {
                // First param is not a method, send it to the index as an argument.
                if ($this->_controller->verify("index")) {
                    $this->_controller->index($controllerParams);
                }
            }
        } else {
            // A controller method was not found; load the index page for the controller.
            if ($this->_controller->verify("index")) {
                $this->_controller->index();
            }
        }
    }

    /**
     * Dissect the URL and determine the name of the controller we need to use.
     * 
     * @return array Controller details: path, name, and params.
     */
    private function _getControllerDetails($basePath = PATH_CONTROLLERS) {
        // Create an array to store all possible controller locations using the URL provided.
        $potentialControllerPaths = array();
        // Loop through the URL, removing parts from the end and saving the result.
        for ($i = 0; $i < count($this->_url); $i++) {
            // Cut off part of the URL path
            $potentialPathParts = array_slice($this->_url, 0, $i + 1);
            // Condense the remaining parts down into a complete new path.
            $potentialControllerPaths[] = implode("/", $potentialPathParts);
        }
        // Reverse the array, we want to search backwards to find the controller.
        $finalPotentialPaths = array_reverse($potentialControllerPaths);
        // Create a storage container for details about the controller if found.
        $details = array();
        // Attempt to locate the controller file.
        for ($i = 0; $i < count($finalPotentialPaths); $i++) {
            if (file_exists($basePath . $finalPotentialPaths[$i] . ".php")) {
                // We found a suitable file here, save some information about it.
                $number = count($finalPotentialPaths) - $i - 1;
                $details['path'] = array_slice($this->_url, 0, $number);
                $details['name'] = $this->_url[$number];
                $details['params'] = array_slice($this->_url, $number + 1);
                $details['fullPath'] = $basePath . $finalPotentialPaths[$i] . ".php";
                break;
            }
        }
        return $details;
    }

    /**
     * Fire an error and kill the script.
     */
    private function _error($type) {
        $this->_controller = new Error($this->dataContainer);
        $this->_controller->index(array($type));
        die();
    }

}
