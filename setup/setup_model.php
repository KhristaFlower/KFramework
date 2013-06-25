<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Setup_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTables() {
        return $this->_db->getTables();
    }

    /**
     * Create a table that doesn't already exist in the database.
     * @param Table $table The table to be created.
     */
    public function createTable($table) {
        $createQuery = $table->getCreateQuery();
        $this->_db->rawQuery($createQuery);
    }

    /**
     * Delete a table from the database.
     * @param Table $table The table that should be deleted.
     */
    private function deleteTable($table) {
        $deleteQuery = $table->getDeleteQuery();
        $this->_db->rawQuery($deleteQuery);
    }

    /**
     * Recreates a table by deleting one if it exists and then creating it again.
     * @param Table $table The table that should be recreated.
     */
    public function recreateTable($table) {
        $this->deleteTable($table);
        $this->createTable($table);
    }

    public function createAccount($username, $email, $password) {
        $creation_time = time();
        $data = array(
            'Username' => $username,
            'Email' => $email,
            'Password' => $password,
            'Creation' => $creation_time
        );
        $this->_db->insert("KF_Admins", $data);
    }

    public function checkForExistingAccounts() {
        $adminAccoutNames = $this->_db->select("SELECT `Username` FROM KF_Admins");
        $adminUsernames = array();
        foreach ($adminAccoutNames as $adminName) {
            $adminUsernames[] = $adminName['Username'];
        }
        return $adminUsernames;
    }
    
    /**
     * Get the password for the account entered by the user.
     * Username or Email is determined by tests performed earlier.
     * @param string $UorE Username or Email
     * @param string $value Data the user entered on the login form.
     * @return string Hashed password associated with this account.
     */
    public function getLoginDetails($UorE, $value) {
        $query = "SELECT password FROM KF_Admins WHERE $UorE = '$value'";
        $results = $this->_db->select($query);
        return $results[0]['password'];
    }

}
