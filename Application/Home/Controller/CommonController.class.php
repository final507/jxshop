<?php
namespace Home\Controller;
use Think\Controller;
//公共控制器
class CommonController extends Controller {
	public function __construct()
	{
		parent::__construct();
		//获取分类信息
		$cate = D('Admin/Category')->getCateTree();
		$this->assign('cate',$cate);
	}
	public function checkLogin(){
		//判断用户是否登录
		$user = session('user_id');
		if(!$user){
			$this->error('请先登录呢',U('User/login'));
		}
	}
}