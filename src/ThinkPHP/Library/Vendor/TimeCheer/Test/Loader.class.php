<?php

/*
 * Created Datetime:2016-3-11 10:45:05
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-3-11 
 * 
 */

namespace TimeCheer\Test;

/**
 * 用于将单元测试代码的命名空间注册到自动加载机制
 */
class Loader
{

    protected $dir;

    protected $prefix = 'UnitTest\\';
    
    /**
     *
     * @var string TP的坑爹文件扩展名造成的设定
     */
    protected $suffix = '.classTest';

    /**
     * 构造函数
     * @param string $dir 手动指定起始目录
     * @param string $prefix 指定要加载的测试类命名空间前缀
     * @param string $suffix NB生成的测试文件后缀名 一般不用指定
     */
    public function __construct($dir, $prefix = '', $suffix = '')
    {
        $this->dir = $dir;
        if ($prefix) {
            $this->prefix = $prefix;
        }
        if ($suffix) {
            $this->suffix = $suffix;
        }
    }

    /**
     * 向PHP注册SPL autoloader
     * @param string $dir 指定要加载的测试类所在目录
     * @param string $prefix 指定要加载的测试类命名空间前缀
     * @return void
     */
    public static function register($dir, $prefix = '', $suffix = '')
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');

        spl_autoload_register(array(new self($dir, $prefix, $suffix), 'autoload'), FALSE, TRUE);
    }

    /**
     * 系统自动注册
     *
     * @param string $class 类名
     *
     * @return boolean 正常加载返回true
     */
    public function autoload($class)
    {
        if (0 !== strpos($class, $this->prefix)) {
            return false;
        }

        if (file_exists($file = $this->dir . '/' . substr(str_replace('\\', '/', str_replace($this->prefix, '', $class)), -1, 5) . $this->suffix . '.php')) {
            require_once $file;

            return true;
        }

        return false;
    }

}
