<?php

/* 
 * PHPUnit的启动文件，配置了基于TP的应用环境
 * 需要对ThinkPHP的框架类打补丁，\Think\Think::start方法的最后一句改为：!constant('NO_NEED_RUN_APP') && App::run();
 * Created Datetime:2016-3-10 22:55:16
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-10 
 * 
 */

error_reporting(E_ALL);
date_default_timezone_set('PRC');

/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define('APP_DEBUG', true);

define('TEST_ROOT', __DIR__);

// 网站根路径设置 根据实际情况构造
define('SITE_PATH', dirname(TEST_ROOT));

/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define('APP_PATH', SITE_PATH . '/Application/');

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('RUNTIME_PATH', SITE_PATH .'/Runtime/');

/**
 * 让TP不执行完整的MVC调度,用于开启单元测试模式
 */
define('NO_NEED_RUN_APP', true);

/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require SITE_PATH . '/ThinkPHP/ThinkPHP.php';
\Think\App::init();

require VENDOR_PATH . '/TimeCheer/Test/AutoLoader.class.php';
\TimeCheer\Test\AutoLoader::register();

//还需要实现测试代码自动加载

require VENDOR_PATH . '/TimeCheer/Test/Loader.class.php';
\TimeCheer\Test\Loader::register(TEST_ROOT);
