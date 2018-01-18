<?php
namespace Home\Controller;

class MemberController extends CommonController {

	public function __construct()
	{
		parent::__construct();
		//登录验证
		$this->checkLogin();
	}

	//显示我的订单
	public function order()
	{	
		$user_id = session('user_id');
		$data = D('Order')->where('user_id='.$user_id)->select();
		$this->assign('data',$data);
		$this->display();
	}
}