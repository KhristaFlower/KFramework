<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class View {
    
    private $dataContainer = null;

    function __construct() {
        
    }

    /**
     * Render any file in or under the KFramework root directory.
     * @param string $path Path to the file to be rendered.
     */
    public function renderSpecificPage($path) {
        $template = new Template("$path.php", $this->dataContainer);
        $template->display();
    }
    
    /**
     * 
     * @param DataContainer $dataContainer
     */
    public function setDataContainer($dataContainer){
        $this->dataContainer = $dataContainer;
    }

}
