<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class ACP extends Controller {

    public function __construct($details) {
        parent::__construct($details);

        $this->_requiresAdmin[] = "index";

        // Create a brand new navmenu that is only shown when in the ACP.
        // Only display this if the user is logged in (don't show on login and logout pages that extend this one)
        if ($this->dataContainer->getContainer("KF_Admin")->getVariable("LoggedIn")) {
            $adminMenu = new NavigationElement();
            $adminMenu->addElement(new NavigationElement("Home", "/"));
            $adminMenu->addElement(new NavigationElement("Extension Manager", "/acp/extensions/"));

            // Set our new menu, override the default.
            $this->dataContainer->getContainer("View")->setVariable("MainNav", $adminMenu);
        }
    }

    public function logout() {
        $this->dataContainer->getContainer("View")->setVariable("MainNav", null);
        session_destroy();
        $this->renderPage('logout');
    }

}
