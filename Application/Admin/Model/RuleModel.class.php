<?php 
namespace Admin\Model;
/**
* 分类模型
*/
class RuleModel extends CommonModel
{
	//自定义字段
	protected $fields=array('id','rule_name','module_name','controller_name','action_name','parent_id','is_show');
	//自动验证
	protected $_validate=array(
		array('rule_name','require','权限名称必须填写'),
		array('module_name','require','模型名称必须填写'),
		array('controller_name','require','控制器称必须填写'),
		array('action_name','require','方法名称必须填写'),
	);
	//获取某个分类的子分类
	public function getChildren($id)
	{
		//先获取所有的分类信息
		$data = $this->select();
		//在对获取的信息进行格式化
		$list = $this->getTree($data,$id,1,false);
		foreach ($list as $key => $value) {
			$tree[]=$value['id'];
		}
		return $tree;
	}

	//获取格式化之后的数据
	public function getCateTree($id=0)
	{
		//先获取所有的分类信息
		$data = $this->select();
		//在对获取的信息进行格式化
		$list = $this->getTree($data,$id);
		return $list;
	}
	//格式化分类信息
	public function getTree($data,$id=0,$lev=1,$iscache=true)
	{
		static $list = array();
		//根据参数决定是否需要重置
		if(!$iscache){
			$list=array();
		}
		foreach ($data as $key => $value) {
			if($value['parent_id']==$id){
				$value['lev']=$lev;
				$list[]=$value;
				//使用递归的方式获取分类下的子分类
				$this->getTree($data,$value['id'],$lev+1);
			}
		}
		return $list;
	}

	//删除分类
	public function dels($id)
	{
		//如果删除的分类下有子权限不容许删除
		$result = $this->where('parent_id='.$id)->find();
		if($result){
			return false;
		}
		return $this->where('id='.$id)->delete();
	}

	public function update($data)
	{
		// 需要过滤掉设置父分类为自己或者自己下的子分类
		// 1、根据要修改的分类的标识 获取到自己下的所有的子分类
		$tree = $this->getCateTree($data['id']);
		//将自己添加到不能修改的数组中
		$tree[]=array('id'=>$data['id']);
		// dump($tree);exit();
		// 2、根据提交的parent_id的值 判断如果等于当前修改的分类ID或者是当前分类下的所有子分类的ID不容许修改
		foreach ($tree as $key => $value) {
			if($data['parent_id']==$value['id']){
				$this->error='不能设置子分类为父分类';
				return false;
			}
		}
		return $this->save($data);
	}
}

