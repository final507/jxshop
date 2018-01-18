<?php 
namespace Admin\Model;

/**
* 角色模型
*/
class RoleModel extends CommonModel
{
	//定义字段
	protected $fields=array('id','role_name');
	//自动验证
	protected $_validate=array(
		array('role_name','require','角色名称必须填写！'),
		array('role_name','','角色名重复！',1,'unique')
	);



	public function listData()
	{
		/*//定义页尺寸
		$pageszie = 3;
		//计算数据总数
		$count = $this->count();
		//生成分页导航信息
		$page = new \Think\Page($count,$pageszie);
		$show = $page ->show();
		//接受当前所在的页码
		$p = intval(I('get.p'));
		$list = $this->page($p,$pageszie)->select();
		return array('pageStr'=>$show,'list'=>$list);*/
		$data = $this->select();
		return $data;
	}

	public function remove($role_id)
	{
		return $this->where("id= $role_id")->delete();
	}
	public function getRules($role_id){
		return $this->where("role_id='$role_id'")->select();
	}
}