<?php

/* 
 * 基于ThinkPHP的Db单元测试基类
 * Created Datetime:2016-3-10 23:14:04
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-10 
 * 
 */

namespace TimeCheer\Test\Database;

/**
 * Db 测试用例基类,主要是实现了基于TP的DB的自动连接
 */
abstract class TestCase extends \PHPUnit_Extensions_Database_TestCase
{
    
    /**
     *
     * @var \PDO  只实例化 pdo 一次，供测试的清理和装载基境使用
     */
    private static $pdo = null;

    /**
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection 对于每个测试，只实例化一次
     */
    private $conn = null;

    /**
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected final function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new \PDO(C('DB_TYPE') . ':host=' . C('DB_HOST') . ';port='.C('DB_PORT').';dbname=' . C('DB_NAME'), C('DB_USER'), C('DB_PWD'));
            }
            $this->conn = new Connection(self::$pdo, C('DB_NAME'));
        }

        return $this->conn;
    }
    
}