<?php

/** davidggdev - main index controller */

namespace Balrog;

/**
 * MySql pdo scaffold to handle database managament.
 */
class Database
{
    private $pdoConnection;

    /**
     * Set connection on create instance
     */
    public function __construct()
    {
        $this->pdoConnection = new \PDO(
            "mysql:host=" . BLR_SQL_HOST . ";dbname=" . BLR_SQL_DBNAME,
            BLR_SQL_USER,
            BLR_SQL_PASSWORD
        );
    }

    /**
     * Send a request to the raw database
     * e.g.: 
     *  // Some code...
     *  $data = $this->database->query('SELECT * FROM test');
     * 
     * @var string  $query  SQL raw string query 
     * @return array    Result of the request       
     */
    public function query($query) : array
    {
        $stmt = $this->pdoConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Send a SELECT request  
     * e.g.: 
     *  // Some code...
     *  $data = $this->database->select(['id','url'],'test');
     * 
     * Where e.g.:
     *  // Some code...
     *  $data2 = $this->database->select(['*'],'test', ['id' => 2]);
     * 
     * @var array   $query  Array with columns to select e.g. : ['*'] | ['column_name']
     * @var string  $table  Table name
     * @var array   $where  Array with the columns and values for the selection
     * @return array    Result of the request      
     * @
     */
    public function select(array $query, string $table, array $where = []) : array
    {  
        $whereStatementInner = [];
        $whereString = '';
        if(count($where)!==0){ 
            $whereStatement = $this->concatOperator($where, 'AND');
            $whereStatementInner = $whereStatement['collection'];
            $whereString = ' WHERE ' . substr($whereStatement['where'], 0, -5); 
        }        
        $partialQuery = "SELECT " . implode(',', $query) . ' FROM ' . $table . $whereString . ';'; 
        $stmt = $this->pdoConnection->prepare($partialQuery);
        $stmt->execute($whereStatementInner);  
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Concatenates an array into a string with the operator passed in.
     * @var array   $collectionOperator Array columns=>values
     * @var string  $operator   String operator name
     */
    private function concatOperator(array $collectionOperator, string $operator) : array
    { 
        $stmntQueryWhere = '';         
        foreach ($collectionOperator as $key => $value) {
            $stmntQueryWhere .= "$key=:" . $key . "_vl $operator ";
            $stmntExecuteCollection[] = [
                ":" . $key . "_vl" => $value
            ];
            $collectionOperator[':'.$key.'_vl'] = $collectionOperator[$key];
            unset($collectionOperator[$key]);
        }
        return [
            'collection' => $collectionOperator,
            'where' => $stmntQueryWhere
        ];
    }
}
