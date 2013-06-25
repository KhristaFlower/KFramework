<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Login extends ACP {

    public function __construct($details) {
        parent::__construct($details);
        
        $this->_requiresAdmin = array();
    }

    public function process() {
        require_once 'models/authentication_model.php';
        $model = new Authentication_Model();
        // If a password match is found, return the ID of the account.
        $details = $model->loginUsernameOrEmail("UorE", "password");
        if ($details != null) {
            // Get some information about the user.
            $userIP = $_SERVER['REMOTE_ADDR'];
            $userBrowser = $_SERVER['HTTP_USER_AGENT'];
            $userString = hash('sha256', $userIP . $userBrowser);
            // Save the information to the session.
            $KF_Admin = array(
                "ID" => $details["ID"],
                "Username" => $details["Username"],
                "LoginString" => $userString,
                "LoggedIn" => true
            );
            $_SESSION['KF_Admin'] = $KF_Admin;
            // Send the user to the ACP.
            header('Location: /acp/');
        } else {
            // Error
            $this->dataContainer->getContainer("View")
                    ->setVariable("login_success", false);
        }
        
        $this->renderPage('index');
    }

}
