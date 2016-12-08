<?php

/* 
 * Created Datetime:2016-3-15 11:39:12
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-15 
 * 
 */

namespace TimeCheer\Test\Database\DataSet;

class QueryDataSet extends \PHPUnit_Extensions_Database_DataSet_QueryDataSet
{
    
    public function addTable($tableName, $query = NULL)
    {
        if ($query === NULL) {
            $query = 'SELECT * FROM {{%' . $tableName . '}}';
        }
        
        $this->tables[$tableName] = new \PHPUnit_Extensions_Database_DataSet_QueryTable($tableName, $this->databaseConnection->replaceRawTableName($query), $this->databaseConnection);
    }
    
}