<?php

namespace Addons\Subscribe;
use Common\Controller\Addon;

/**
 * 什么值得买订阅插件
 * @author hejing
 */

    class SubscribeAddon extends Addon{

        public $info = array(
            'name'=>'Subscribe',
            'title'=>'什么值得买订阅',
            'description'=>'什么值得买订阅网站列表',
            'status'=>1,
            'author'=>'hejing',
            'version'=>'0.1'
        );

        public $admin_list = array(
            'model'=>'subscribe',		//要查的表
			'fields'=>'*',			//要查的字段
			'map'=>'',				//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order'=>'id desc',		//排序,
			'listKey'=>array( 		//这里定义的是除了id序号外的表格里字段显示的表头名
				'字段名'=>'表头显示名'
			),
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的show_subscribe钩子方法
        public function show_subscribe($param){

        }

    }