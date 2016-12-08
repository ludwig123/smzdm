<?php

/*
 * Created Datetime:2016-3-15 9:31:11
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-15 
 * 
 */

namespace TimeCheer\Test\Database;

/**
 * 继承默认DB连接,实现TP表名前缀特性
 */
class Connection extends \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
{
    
    /**
     *
     * @var array 
     */
    protected $config;

    /**
     * Creates a new database connection
     *
     * @param PDO $connection
     * @param string $schema - The name of the database schema you will be testing against.
     */
    public function __construct(PDO $connection, $schema = '')
    {
        parent::__construct($connection, $schema);
        
        $this->config['tablePrefix'] = C('DB_PREFIX');
    }

    /**
     * Creates a dataset containing the specified table names. If no table
     * names are specified then it will created a dataset over the entire
     * database.
     *
     * @param array $tableNames
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     * @todo Implement the filtered data set.
     */
    public function createDataSet(array $tableNames = NULL)
    {
        if (empty($tableNames)) {
            return new \PHPUnit_Extensions_Database_DB_DataSet($this);
        } else {
            $tableNames = array_map(array($this, 'addTablePrefix'), $tableNames);
            return new \PHPUnit_Extensions_Database_DB_FilteredDataSet($this, $tableNames);
        }
    }
    
    /**
     * 数组遍历回调方法,用于给表名加前缀
     * @param string $value
     */
    protected function addTablePrefix($value)
    {
        return $this->config['tablePrefix'] . $value;
    }
    
    /**
     * Creates a table with the result of the specified SQL statement.
     *
     * @param string $resultName
     * @param string $sql
     * @return \PHPUnit_Extensions_Database_DB_Table
     */
    public function createQueryTable($resultName, $sql)
    {
        
        return parent::createQueryTable($resultName, $this->replaceRawTableName($sql));
    }
    
    /**
     * Returns the actual name of a given table name.
     * This method will strip off curly brackets from the given table name
     * and replace the percentage character '%' with [[Connection::tablePrefix]].
     * @param string $sql the sql to be converted
     * @return string the real sql
     */
    public function replaceRawTableName($sql)
    {
        if (strpos($sql, '{{') !== false) {
            $sql = preg_replace('/\\{\\{(.*?)\\}\\}/', '\1', $sql);

            return str_replace('%', $this->config['tablePrefix'], $sql);
        } else {
            return $sql;
        }
    }

    /**
     * Returns the number of rows in the given table. You can specify an
     * optional where clause to return a subset of the table.
     *
     * @param string $tableName
     * @param string $whereClause
     * @return int
     */
    public function getRowCount($tableName, $whereClause = NULL)
    {
        return parent::getRowCount($this->config['tablePrefix'] . $tableName, $whereClause);
    }

    /**
     * Disables primary keys if connection does not allow setting them otherwise
     *
     * @param string $tableName
     */
    public function disablePrimaryKeys($tableName)
    {
        parent::disablePrimaryKeys($this->config['tablePrefix'] . $tableName);
    }

    /**
     * Reenables primary keys after they have been disabled
     *
     * @param string $tableName
     */
    public function enablePrimaryKeys($tableName)
    {
        parent::enablePrimaryKeys($this->config['tablePrefix'] . $tableName);
    }

}
