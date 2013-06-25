<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Table {

    private $_name = null;
    private $_columns = array();
    private $_charset = "utf8";
    private $_collate = "utf8_general_ci";
    private $_primary = null;

    public function __construct($name, $charset, $collate, $primary) {
        if ($name != null) {
            $this->_name = $name;
        }
        if ($charset != null) {
            $this->_charset = $charset;
        }
        if ($collate != null) {
            $this->_collate = $collate;
        }
        if ($primary != null) {
            $this->_primary = $primary;
        }
    }

    public function getName() {
        return $this->_name;
    }
    
    public function setName($name){
        $this->_name = $name;
    }

    public function addColumn($name, $type, $length, $default, $collation, $attributes, $not_null, $auto_increment, $unique) {
        $column = array();
        $column['name'] = $name;
        $column['type'] = $type;
        $column['length'] = $length;
        $column['default'] = $default;
        $column['collation'] = $collation;
        $column['attributes'] = $attributes;
        $column['not_null'] = $not_null;
        $column['auto_increment'] = $auto_increment;
        $column['unique'] = $unique;
        // Add the column to the table.
        $this->_columns[] = $column;
    }

    public function getCreateQuery() {
        $query = "CREATE TABLE IF NOT EXISTS";
        $query .= "`{$this->_name}` (";
        foreach ($this->_columns as $column) {
            $query .= "`{$column['name']}` ";
            $query .= "{$column['type']}";
            if ($column['length'] != null) {
                $query .= "({$column['length']})";
            }
            if ($column['attributes'] != null) {
                $query .= " {$column['attributes']}";
            }
            if ($column['not_null'] == true) {
                $query .= " NOT NULL";
            }
            if ($column['unique'] == true) {
                $query .= " UNIQUE";
            }
            if ($column['auto_increment'] == true) {
                $query .= " AUTO_INCREMENT";
            }
            $query .= ", ";
        }
        if ($this->_primary != null) {
            $query .= "PRIMARY KEY(`{$this->_primary}`),";
        }
        $query = rtrim($query, ', ');
        $query .= ") ";
        $query .= "CHARACTER SET {$this->_charset} ";
        $query .= "COLLATE {$this->_collate}";

        return $query;
    }

    public function getDeleteQuery() {
        $query = "DROP TABLE IF EXISTS {$this->_name}";
        return $query;
    }

}
