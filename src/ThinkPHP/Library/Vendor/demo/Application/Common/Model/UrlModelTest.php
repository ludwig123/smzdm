<?php

/* 
 * Created Datetime:2016-3-11 11:01:24
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-11 
 * 
 */

namespace TimeCheer\OAO\UnitTest;

use TimeCheer\Test\Database\TestCase;
use TimeCheer\Test\Database\ArrayDataSet;

/**
 * Demo 演示Model的功能操作的测试
 */
class UrlModelTest extends TestCase
{
    protected function getDataSet()
    {
        return new ArrayDataSet([
            'url' => [
                ['url' => 'http://www.baidu.com', 'create_time' => time()],
                ['url' => 'http://www.baidux.com', 'create_time' => time()],
            ],
            'channel' => [
                ['id' => 1, 'pid' => 0, 'title' => 'channel 1', 'create_time' => time(), 'status' => 1],
                ['id' => 2, 'pid' => 1, 'title' => 'channel 2', 'create_time' => time(), 'status' => 1],
                ['id' => 3, 'pid' => 1, 'title' => 'sub channel 1', 'create_time' => time(), 'status' => 1],
                ['id' => 4, 'pid' => 1, 'title' => 'sub channel 2', 'create_time' => time(), 'status' => 1],
                ['id' => 5, 'pid' => 2, 'title' => 'sub channel 3', 'create_time' => time(), 'status' => 1],
                ['id' => 6, 'pid' => 2, 'title' => 'sub channel 4', 'create_time' => time(), 'status' => 0],
            ],
        ]);
    }
    
    /**
     * 对表中数据行的数量作出断言
     */
    public function testAddEntry()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('url'), "Pre-Condition");

        $model = M('url');
        $model->add(['url' => 'http://x3d.pw', 'create_time' => time()]);

        $this->assertEquals(3, $model->count(), "Inserting failed");
    }
    
    /**
     * 对表的状态作出断言
     */
    public function testAddEntryFully()
    {
        
        $model = M('url');
        $model->add(['url' => 'http://x3d.pw', 'create_time' => time()]);
        
        $queryTable = $this->getConnection()->createQueryTable(
                'url', 'SELECT id, url FROM {{%url}}'
        );

        $expectedTable = $this->createFlatXmlDataSet(TEST_ROOT . "/data/expected/url_inserted.xml")
                              ->getTable("url");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    /**
     * 对查询的结果作出断言
     */
    public function testComplexQuery()
    {
        $queryTable = $this->getConnection()->createQueryTable(
            'url_channel', 'SELECT u.id AS url_id, u.url, c.title, c.pid FROM {{%url}} u '
                . 'LEFT JOIN {{%channel}} c ON u.id=c.id'
        );
        $expectedTable = $this->createFlatXmlDataSet(TEST_ROOT . "/data/expected/urlchannel.xml")
                              ->getTable("url_channel");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    /**
     * 对多个表的状态作出断言
     * 从数据库连接建立数据库数据集，并将其与基于文件的数据集进行比较
     */
    public function testCreateDataSetAssertion()
    {
        //尚未实现TP表名前缀逻辑 所以不能用下面的写法
        //$dataSet = $this->getConnection()->createDataSet(array('url'));
        
        //暂时只实现下面这种通过db创建dataset的方式
        $dataSet = new \TimeCheer\Test\Database\DataSet\QueryDataSet($this->getConnection());
        $dataSet->addTable('url'); // additional tables
        
        $dataSet->addTable('channel'); // additional tables
        $expectedDataSet = $this->createFlatXmlDataSet(TEST_ROOT . '/data/expected/url_manual.xml');
        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }
    
    /**
     * 对多个表的状态作出断言
     * 自行构造数据集
     */
    public function testManualDataSetAssertion()
    {
        $dataSet = new \TimeCheer\Test\Database\DataSet\QueryDataSet($this->getConnection());
        $dataSet->addTable('url', 'SELECT id, url FROM {{%url}}'); // additional tables
        $expectedDataSet = $this->createFlatXmlDataSet(TEST_ROOT . '/data/expected/url_manual.xml');
        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }
    
    /**
     * 过滤表字段
     * 从数据库连接建立数据库数据集，并将其与基于文件的数据集进行比较
     */
    public function testDataSetFilter()
    {
        $dataSet = new \TimeCheer\Test\Database\DataSet\QueryDataSet($this->getConnection());
        
        $dataSet->addTable('url'); // additional tables
        $filterDataSet = new \PHPUnit_Extensions_Database_DataSet_DataSetFilter($dataSet);
        $filterDataSet->setExcludeColumnsForTable('url', array('short', 'create_time', 'status'));
        
        $expectedDataSet = $this->createFlatXmlDataSet(TEST_ROOT . '/data/expected/url_manual.xml');
        $this->assertDataSetsEqual($expectedDataSet, $filterDataSet);
    }

}