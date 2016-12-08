<?php

namespace Home\Model;
use Think\Model;

class SubscribeModel extends Model{
	private $userName;

	
	
	
	
	public function getSubscribeList($user){
		$map['user'] = $user;
		$list = M('subscribe')->where($map)->select();
		return $list;
	}
	
	public function get_user_name(){
		return $_SESSION['onethink_home']['user_auth']['username'];
		
	}

//新增一个关键词
	public function add($keyword){

//subscribe 添加一个条目 user 关键词
		//如果已经存在该关键词，无视，如果不存在，添加该关键词，并在过往条目中检索一遍

		$Subscribe = M("subscribe");
		$data['keyword'] = 'abc';
		$data['user'] = $_SESSION['onethink_home']['user_auth']['username'];

		 $Subscribe->add($data);

	}

//移除一个关键词
	public function remove($keyword, $user){
		//根据名字和关键词从subscribie中删去这个即可

	}


}