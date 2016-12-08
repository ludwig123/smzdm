<?php
namespace Home\Controller;
use Think\Controller;

const THREE_DAY = 259200;
const ONE_HOUR = 3600;
const ONE_DAY = 86400;
const TWO_DAY = 172800;
/**
* 
*/
class SearchController extends HomeController
{
	
	public function search($keyword=null, $mall=null)
	{	
		$mall_list = $this->get_mall_list();

            $searchInput = $this->getSearchInput();
		$keyword = $searchInput['keyword'];
		$mall = $searchInput['mall'];

		$timeLimit = microtime(true)-ONE_DAY;

		$map['content'] = array('like','%'.$keyword.'%');
		$map['title'] = array('like','%'.$keyword.'%');
		$map['mall'] = array('like',$mall.'%');
		$map['time_sort'] = array('EGT',$timeLimit );


		$items = M('items');
		$list = $items->where($map)->order('time_sort desc')->select();

		$this->assign('list',$list);
		$this->assign('mall_list',$mall_list);
		$this->display();


	}

	public function searchAjax(){
            $searchInput = $this->getSearchInput();

		$keyword = $searchInput['keyword'];
		$mall = $searchInput['mall'];

		
		$map['content'] = array('like','%'.$keyword.'%');
		$map['title'] = array('like','%'.$keyword.'%');
		$map['mall'] = $mall;
		
		$items = M('items');
		$list = $items->where($map)->order('time_sort desc')->limit(20)->select();

		foreach ($list as $vo) {
			$itemStr .= '<tr>
						<td><a href="'.$vo["href"].'">'.$vo["title"].'</a></td>
						<td>'.$vo["price"].'</td>
						<td>'.$vo["content"].'</td>
						<td>'.$vo["worthy"].'</td>
						<td>'.$vo["unworthy"].'</td>
						<td><a href="'.$vo["href"].'">'.$vo["mall"].'</a></td>
						<td>'.$vo["post_time"].'</td>
						</tr>';

						$mallArr[$vo["mall"]] = $vo["mall"];
					}
					foreach ($mallArr as $k=>$v) {
						$mallStr .= '<option value="'.$v.'">'.$v.'</option>';
					}
		  $data[0] = $itemStr;
		  $data[1] = '<option value=""></option>'.$mallStr;

	$this->ajaxReturn($data);

}


/**
 * 用户个人订阅的聚合推送首页！！
 * @return [type] [description]
 */
	public function index()
	{
		$name = get_user_name();
		$subscribeList = D('Subscribe')->getSubscribeList($name);


		$keywords = array();
		foreach ($subscribeList as $k) {
			$keywords[] = '%'.$k[keyword].'%';
		}

		$timeLimit = microtime(true)-TWO_DAY;

		//$map['content'] = array('like', $keywords, 'OR');
		$map['title'] = array('like', $keywords, 'OR');
		//$map['_logic'] = 'OR';
		$map['time_sort'] = array('EGT',$timeLimit );


		$items = M('items');
		$list = $items->order('time_sort desc')->where($map)->select();

		foreach ($list as $v) {
			$mall_list[$v["mall"]]= $v["mall"];
		}

		//var_dump($mall_list);


		$this->assign('list',$list);
		$this->assign('mall_list',$mall_list);
		$this->display();

	}

	private function get_mall_list(){
		$Model = new \Think\Model();
		$mall_list = $Model->query("SELECT DISTINCT mall FROM __PREFIX__items ORDER BY CONVERT(mall USING gb2312)");
		return $mall_list;
	}
        
        private function getSearchInput(){
            $keyword = trim(htmlspecialchars($_GET['keyword']));
                $mall = trim(htmlspecialchars($_GET['mall']));
                $result['keyword'] = $keyword;
                $result['mall'] = $mall;
                return $result;
        }




}