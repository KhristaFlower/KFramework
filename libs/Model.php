<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Model {
    
    /**
     * @var Database The Database object.
     */
    protected $_db;
    
    public function __construct($DB_TYPE = DB_TYPE, $DB_HOST = DB_HOST, $DB_DATABASE = DB_DATABASE, $DB_USER = DB_USER, $DB_PASS = DB_PASS) {
        // Make the database connection
        $this->_db = new Database($DB_TYPE, $DB_HOST, $DB_DATABASE, $DB_USER, $DB_PASS);
    }

}
