<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Testing extends Controller {

    public function __construct($dataContainer) {
        parent::__construct($dataContainer);
    }

    public function template($args) {
        if ($args[0] == "master") {
            $template = new Template('templates/main.php', $this->dataContainer);
        } else if ($args[0] == "secondary") {
            $template = new Template('templates/secondary.php', $this->dataContainer);
        } else if ($args[0] == "tertiary") {
            $template = new Template('templates/tertiary.php', $this->dataContainer);
        }

        $template->display();
    }

}
