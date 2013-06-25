<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Authentication_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Take the details the user entered into the form and determine whether a
     * match could be made in the database. Return the success value.
     * @param string $UorEFieldName Form input 'name' attribute for the Username / Email field.
     * @param string $PassFieldName Form input 'name' attribute for the Password field.
     * @return boolean True if User and Pass matched up, False if not.
     */
    public function loginUsernameOrEmail($UorEFieldName, $PassFieldName) {
        // Here we store all validation tests as keys and assign their
        // values as test arguments.
        $usernameTests = array(
            Form::VALIDATE_REQUIRED => null,
            Form::VALIDATE_ALLOWED_CHARS => '/^[A-Za-z0-9-_]+$/',
            Form::VALIDATE_MIN_LENGTH => 2,
            Form::VALIDATE_MAX_LENGTH => 30
        );
        $emailTests = array(
            Form::VALIDATE_REQUIRED => null,
            Form::VALIDATE_MAX_LENGTH => 50,
            Form::VALIDATE_EMAIL => null
        );

        $usernameTest = $this->_customTest($UorEFieldName, $usernameTests);
        $emailTest = $this->_customTest($UorEFieldName, $emailTests);

        $this->_view->login_success = false;
        $hashedPass = null;

        if ($usernameTest && !$emailTest) {
            // Login using the Username.
            $hashedPass = $this->getHashedPassword("Username", $_POST[$UorEFieldName]);
        } else if (!$usernameTest && $emailTest) {
            // Login using the Email.
            $hashedPass = $this->getHashedPassword("Email", $_POST[$UorEFieldName]);
        } else {
            // The value entered failed both tests, $hashedPass will remain null.
        }

        if ($hashedPass != null) {
            $hasher = new PasswordHash(HASHING_COST, HASHING_PORTABLE);
            if ($hasher->CheckPassword($_POST[$PassFieldName], $hashedPass['password'])) {
                return array("ID" => $hashedPass['id'], "Username" => $hashedPass['username']);
            }
        }
        return false;
    }

    /**
     * Perform a series of validation tests on a field and return whether it passed or not.
     * @param string $fieldName The name of the field we are validating.
     * @param array $validationArray The array of Form:: constants starting with VALIDATE_.
     * @return boolean Has the test passed? True means no errors, False means errors.
     */
    private function _customTest($fieldName, $validationArray) {
        $testForm = new Form();
        $testForm->post($fieldName);
        $testPassed = true;
        // Perform each test and make a note if it fails.
        foreach ($validationArray as $validationConst => $arg) {
            if ($arg != null) {
                $testForm->validate($validationConst, $arg);
            } else {
                $testForm->validate($validationConst);
            }
        }
        if (!$testForm->isErrorFree()) {
            $testPassed = false;
        }
        return $testPassed;
    }

    /**
     * Get the hashed password for the username or email provided.
     * @param string $UorE Are we checking for a username or an email? Value from earlier test.
     * @param string $value The username or email entered by the user.
     * @return string The hashed password representing the username or email entered.
     */
    private function getHashedPassword($UorE, $value) {
        $query = "SELECT id,username,password FROM KF_Admins WHERE $UorE = '$value'";
        $results = $this->_db->select($query);
        return $results[0];
    }

}
