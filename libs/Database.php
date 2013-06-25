<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Database extends PDO {

    /**
     * Create a new Database object with the specified parameters.
     * @param string $TYPE Type
     * @param string $HOST Host
     * @param string $DATABASE Database
     * @param string $USER Username
     * @param string $PASS Password
     */
    public function __construct($TYPE, $HOST, $DATABASE, $USER, $PASS)
    {
        parent::__construct("$TYPE:host=$HOST;dbname=$DATABASE", $USER, $PASS);
    }
    
    /**
     * Select data from the database.
     * @param string $sql A SQL string (eg "SELECT * FROM col_a WHERE id = :id")
     * @param array $array Parameters to bind (eg array(":id"=>$id))
     * @param constant $fetchMode PDO::FetchMode
     * @return mixed Query result
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $stmt = $this->prepare($sql);
        foreach($array as $key => $value){
            $stmt->bindValue("$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }
    
    /**
     * Inset data into a specified table.
     * @param string $table The name of the table to insert into.
     * @param string $data An associative array
     */
    public function insert($table, $data)
    {
        ksort($data);
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':'.implode(', :', array_keys($data));
        
        $stmt = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        
        foreach($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->execute();
    }
    
    /**
     * Update data within the database with new data.
     * @param string $table Name of the table to update.
     * @param array $data The new data that will replace the old data.
     * @param string $where The condition for the update.
     */
    public function update($table, $data, $where){
        ksort($data);
        
        $fieldDetails = null;
        foreach($data as $key => $value){
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $stmt = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->execute();
    }
    
    /**
     * Delete data from the database.
     * @param string $table The name of the table to delete from.
     * @param string $where The test to perform when determining data to delete.
     * @param integer $limit Maximum number of rows to delete that match the where test.
     * @return integer Affected rows
     */
    public function delete($table, $where, $limit = 1){
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
    
    /**
     * Return a list of all tables that exist in the current database.
     * @return array A list of all tables in the database.
     */
    public function getTables(){
        // Collect a list of the table names.
        $tableNames = $this->query("show tables")->fetchAll(PDO::FETCH_NUM);
        // Format the list into one neat array.
        $tables = array();
        foreach($tableNames as $table){
            $tables[] = $table[0];
        }
        return $tables;
    }
    
    /**
     * Used to perform raw queries on the database. It is highly recommended
     * not to use this method when handling end-user input.
     * @param string $query A raw query to perform on the database.
     */
    public function rawQuery($query){
        $stmt = $this->prepare($query);
        $stmt->execute();
    }

}
