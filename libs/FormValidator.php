<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class FormValidator {

    public function minLength($data, $length) {
        if (strlen($data) < $length) {
            return "Minimum string length is $length";
        }
    }

    public function maxLength($data, $length) {
        if (strlen($data) > $length) {
            return "Maximum string length is $length";
        }
    }

    public function digit($data) {
        if (ctype_digit($data) == false) {
            return "Your string '$data' must be numeric";
        }
    }

    public function email($data) {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return "Must provide a valid email";
        }
    }

    public function allowedChars($data, $chars) {
        if (!preg_match($chars, $data)) {
            return "Field contains invalid characters";
        }
    }

    public function fieldsMatch($fieldA, $fieldB) {
        if ($fieldA != $_POST[$fieldB]) {
            return "Fields did not match";
        }
    }

    public function required($data) {
        if ($data == null) {
            return "Field requires filling";
        }
    }

    public function __call($name, $arguments) {
        throw new Exception("$name does not exist inside of: " . __CLASS__);
    }

}
