<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Error extends Controller {

    public function __construct($details) {
        parent::__construct($details);
    }

    public function index($args) {
        $v = PATH_VIEWS . "/error/error_";
        switch ($args[0]):
            case "404":
                $this->renderSpecificPage($v . $args[0]);
                break;
            default:
                $this->renderSpecificPage($v . "generic");
                break;
        endswitch;
    }

}
