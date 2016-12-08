<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 
 * 
 */
class SubscribeController extends HomeController{
	public function mySubscribe(){
                	if ( !is_login() ) {
    		$this->error( '您还没有登陆',U('User/login') );
    	}
		$name = get_user_name();
		$email = get_user_email();

		$list = D('Subscribe')->getSubscribeList($name);
		

		

		$this->assign('name',$name);
		$this->assign('email',$email);
		$this->assign('list',$list);
		$this->display();
		
	}

//如何防止一个人添加两个相同的关键词？
	public function addKeyword(){
                	if ( !is_login() ) {
    		$this->error( '您还没有登陆',U('User/login') );
    	}

		$data['keyword'] = htmlspecialchars($_GET['keyword']);		
		$data['user'] = get_user_name();
		if (!empty($data['keyword'])) {
		M('subscribe')->add($data);
	}
		header("Location: ".__ROOT__."/index.php/Home/Subscribe/mySubscribe");


	}

//连续删除多个关键词时候，会出现页面不刷新的问题
//用懒惰删除，标记它删除即可
//新增一列记录历史推送次数
	public function remove(){
                	if ( !is_login() ) {
    		$this->error( '您还没有登陆',U('User/login') );
    	}

		$data['keyword'] = htmlspecialchars($_GET['keyword']);	
		$data['user'] = get_user_name();
		M('subscribe')->where($data)->delete();
		 header("Location: ".__ROOT__."/index.php/Home/Subscribe/mySubscribe");
	}
	
}