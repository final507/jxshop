<?php
namespace Home\Controller;

class CategoryController extends CommonController {

	public function index()
	{
		$model = D('Admin/Goods');
		$data = $model->getList();
		$this->assign('data',$data);
		$this->display();
	}
}