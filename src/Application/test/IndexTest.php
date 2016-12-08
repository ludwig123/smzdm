<?php
//定义TP的版本
define('TPUNIT_VERSION','3.2.3');
//定义目录路径，最好为绝对路径
define('TP_BASEPATH', 'C:/wamp/www/smzdm/src/');
//导入base库
//  include_once 'C:\wamp\www\smzdm\src\Application\test\base.php';
//导入要测试的控制器
  include_once 'C:\wamp\www\smzdm\src\Application\Home\Controller\IndexTestController.class.php';

class IndexTest extends PHPUnit_Framework_TestCase{
    //构造函数
//     function __construct(){
//         //定义TP的版本
//         define('TPUNIT_VERSION','3.2.3');
//         //定义目录路径，最好为绝对路径
//         define('TP_BASEPATH', 'C:\wamp\www\smzdm\src');
//         //导入base库
//         include_once 'C:\wamp\www\smzdm\src\Application\test\base.php';
//         //导入要测试的控制器
//         include_once 'C:\wamp\www\smzdm\src\Application\Home\Controller\IndexTestController.class.php';
//     }
    
// protected function setUp()
//     {
//         //定义TP的版本
//         define('TPUNIT_VERSION','3.2.3');
//         //定义目录路径，最好为绝对路径
//         define('TP_BASEPATH', 'C:\wamp\www\smzdm\src');
//         //导入base库
//         include_once 'C:\wamp\www\smzdm\src\Application\test\base.php';
//         //导入要测试的控制器
//         include_once 'C:\wamp\www\smzdm\src\Application\Home\Controller\IndexTestController.class.php';
//     }
    
//     测试index动作
//     public function testIndex(){
//         //新建控制器
//         $index=new \Home\Controller\IndexTestController();
//         //调用控制器的方法
//         $index->test();
//         //断言
//         $this->assertNotEmpty(['foo']);
//         $this->expectOutputString('111');
//         echo 'runn';
//     }
    
    public function testOne()
    {
    	$this->assertTrue(false);
    	echo "run";
    }

}
