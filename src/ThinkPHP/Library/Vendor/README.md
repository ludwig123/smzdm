# TPUnit

ThinkPHP PHPUnit框架集成，基于TP3.2，建议PHP 5.4以上环境。

单元测试应该是提高PHP编码质量的解决之道，但应该没有多少PHP团队在用单元测试改善开发过程，更不用提TDD开发方法。

不可否认ThinkPHP框架在国内PHP圈子中的“至高”地位，所以才有这次整合尝试，同时也在团队中进行推行相关实践。

## 1. 初始配置

为了减少学习成本，建议使用像Netbeans这样的IDE来设定PHPUnit的基本环境。

通过Netbeans的操作界面，可以直接了解PHPUnit使用过程的一些核心概念。

  * [基于Netbeans的PHPUnit环境配置](http://www.cnblogs.com/x3d/p/phpunit-in-netbeans8.html)
  * ```git clone git@github.com:web3d/TPUnit.git```  到ThinkPHP的Vendor目录下
  * 给ThinkPHP框架打补丁 将Think\Think类的start方法最后一行改为 ```!constant('NO_NEED_RUN_APP') && App::run();``` ，同时 Think\App::init() 方法 ```!constant('NO_NEED_RUN_APP') && Dispatcher::dispatch();``` （注：由于创建测试文件的命令是在Cli环境执行，与TP的Cli模式处理冲突，暂时解决方案）


## 2. 开始

将TPUnit中demo目录下的bootstrap.php文件复制到你的tests目录下。

在上一步的配置过程中，有一个“使用引导”的地方记得勾选并指定bootstrap.php文件所在目录。

由于ThinkPHP框架中坑爹的.class.php后缀名，导致NB生成的测试类文件后缀与类名不一致，有点丑，但不影响测试。

## 3. 支持的特性

### 3.1 基本的UnitTest

最经典的例子：

参看上面的参考配置文档中：[基于Netbeans的PHPUnit环境配置](http://www.cnblogs.com/x3d/p/phpunit-in-netbeans8.html)

### 3.2 DB UnitTest

参看本项目demo目录 /demo/Application/Common/Model/UrlModelTest.php 文件。

DBUnit主要由四种断言构成，目前已支持TP对这四种断言的支持：

* 对表中数据行的数量作出断言
* 对表的状态作出断言
* 对查询的结果作出断言
* 对多个表的状态作出断言

具体请查看<https://github.com/web3d/TPUnit/blob/master/demo/Application/Common/Model/UrlModelTest.php>

其中，{{%url}} 是从Yii2框架中引入的表名前缀替换方案，{{和}}是表名界定符，%是表名前缀占位符。
