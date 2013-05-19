<?php

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
     * This array stores mixed values that are added when errors occour for optional display.
     * @var String Array Array used to hold error strings for display on an error page.
     * @todo Implement error controllers and logging.
     */
    private $_errorLog = array();

    /**
     * Start the framework.
     * @
     */
    public function init() {
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
     *  Load the controller which matches the request in the URL.
     */
    private function _loadController() {
        $controllerDetails = $this->_getControllerDetails();
        if (empty($controllerDetails)) {
            echo "No controller found.";
            die();
        }

        // Require the file and create a new object.
        require $controllerDetails['fullPath'];
        $this->_controller = new $controllerDetails['name']($controllerDetails);

        $controllerParams = $controllerDetails['params'];
        if (!empty($controllerParams)) {
            // Check to see if the first parameter is the name of a method in the controller.
            if (method_exists($this->_controller, $controllerParams[0])) {
                // Prevent access to any methods starting with an underscore. We don't want these being activated.
                if (!strncmp($controllerParams[0], "_", 1) == 0) {
                    // Method has been found and can be used.
                    // If we have more parameters than just the method name; send these to the method too!
                    if (count($controllerParams) > 1) {
                        $methodParams = array_slice($controllerParams, 1);
                        $this->_controller->{$controllerParams[0]}($methodParams);
                    } else {
                        $this->_controller->{$controllerParams[0]}();
                    }
                } else {
                    // Fire a 404 as something they specified did not exist to them.
                }
            }
        } else {
            // A controller method was not found; load the index page for the controller.
            $this->_controller->index();
        }
    }

    /**
     * Dissect the URL and determine the name of the controller we need to use.
     * 
     * @return array Controller details: path, name, and params.
     */
    private function _getControllerDetails() {
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
            if (file_exists(PATH_CONTROLLERS . $finalPotentialPaths[$i] . ".php")) {
                // We found a suitable file here, save some information about it.
                $number = count($finalPotentialPaths) - $i - 1;
                $details['path'] = array_slice($this->_url, 0, $number);
                $details['name'] = $this->_url[$number];
                $details['params'] = array_slice($this->_url, $number + 1);
                $details['fullPath'] = PATH_CONTROLLERS . $finalPotentialPaths[$i] . ".php";
                break;
            }
        }
        return $details;
    }

    /**
     * Fire an error and kill the script.
     */
    private function _error($errorType = SITE_DEFAULT_ERROR_CONTROLLER) {
        
    }

}

?>
