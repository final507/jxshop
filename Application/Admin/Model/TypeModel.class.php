<?php 
namespace Admin\Model;

/**
* 角色模型
*/
class TypeModel extends CommonModel
{
	//定义字段
	protected $fields=array('id','type_name');
	//自动验证
	protected $_validate=array(
		array('type_name','require','类型名称必须填写！'),
		array('type_name','','类型名重复！',1,'unique')
	);

	public function listData()
	{
		//定义页尺寸
		$pageszie = 3;
		//计算数据总数
		$count = $this->count();
		//生成分页导航信息
		$page = new \Think\Page($count,$pageszie);
		$show = $page ->show();
		//接受当前所在的页码
		$p = intval(I('get.p'));
		$list = $this->page($p,$pageszie)->select();
		return array('pageStr'=>$show,'list'=>$list);
	}

	public function remove($type_id)
	{
		return $this->where("id= $type_id")->delete();
	}
}