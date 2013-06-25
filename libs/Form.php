<?php

require_once 'libs/FormValidator.php';

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Form {

    private $_currentItem = null;
    
    private $_postData = array();
    
    private $_validator;
    
    private $_validationErrors = array();

    const VALIDATE_MIN_LENGTH = "minLength";
    const VALIDATE_MAX_LENGTH = "maxLength";
    const VALIDATE_DIGIT = "digit";
    const VALIDATE_EMAIL = "email";
    const VALIDATE_ALLOWED_CHARS = "allowedChars";
    const VALIDATE_FIELDS_MATCH = "fieldsMatch";
    const VALIDATE_REQUIRED = "required";
    
    function __construct() {
        $this->_validator = new FormValidator();
    }
    
    public function getPostData(){
        return $this->_postData;
    }
    
    public function getErrors(){
        return $this->_validationErrors;
    }
    
    public function isErrorFree(){
        if(count($this->_validationErrors) > 0){
            return false;
        }else{
            return true;
        }
    }
    
    public function post($fieldName){
        $this->_postData[$fieldName] = $_POST[$fieldName];
        $this->_currentItem = $fieldName;
        return $this;
    }
    
    public function fetch($fieldName = false){
        if($fieldName){
            if(isset($this->_postData[$fieldName])){
                return $this->_postData[$fieldName];
            }else{
                return false;
            }
        }else{
            return $this->_postData;
        }
    }
    
    /**
     * Validate whether the last field entered matches a certain criteria and
     * set an error should one be found.
     * @param const $typeOfValidator A VALIDATE_ constant in this class.
     * @param Mixed $arg Additional arguments, not required for all validations.
     * @return Form Allows for chaining validation checks.
     */
    public function validate($typeOfValidator, $arg = null){
        $debug = false;
        if($debug) echo "Test: $typeOfValidator<br/>";
        if($debug) echo "Current Item: {$this->_currentItem}<br/>";
        if($debug) echo "Item Value: {$this->_postData[$this->_currentItem]}<br/>";
        if(method_exists($this->_validator, $typeOfValidator)){
            if($arg == null){
                $validationInfo = $this->_validator->{$typeOfValidator}($this->_postData[$this->_currentItem]);
            }else{
                $validationInfo = $this->_validator->{$typeOfValidator}($this->_postData[$this->_currentItem], $arg);
            }
        }else{
            die("Validator '$typeOfValidator' does not exist!");
        }
        
        if(isset($validationInfo)){
            $this->_validationErrors[$this->_currentItem] = $validationInfo;
            if($debug) echo "<font color='red'>FAILED!</font><br/>";
        }else{
            if($debug) echo "<font color='green'>PASSED!</font><br/>";
        }
        if($debug) echo "-----<br/>";
        return $this;
    }

}
