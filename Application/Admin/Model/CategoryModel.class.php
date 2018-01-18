<?php 
namespace Admin\Model;

/**
* 分类模型
*/
class CategoryModel extends CommonModel
{
	//自定义字段
	protected $fields=array('id','cname','parent_id','isrec');
	//自动验证
	protected $_validate=array(
		array('cname','require','分类名称必须填写'),
	);

	//获取某个分类的子分类
	public function getChildren($id)
	{
		//先获取所有的分类信息
		//在对获取的信息进行格式化
		$list = $this->getCateTree();

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
		//dump($data);

		$list= $this->getTree($data,0,1,false);

		return $list;
	}
	//格式化分类信息

		public function getTree($data,$id=0,$lev=1,$iscate=true)
	{
		//使用静态变量保存
		static $list = array();
		//清楚上一次的记录
		if(!$iscate){
		$list = '';
		}
		foreach ($data as $key => $value) {
			//如果这个id等于父分类id  那么就把数据存入list[]
			if($value['parent_id']==$id){
				$value['lev']=$lev;
				$list[]=$value;
				//dump($value);
				//使用递归的方式获取分类下的子分类
				$this->getTree($data,$value['id'],$lev+1);
			}
		}
		return $list;
	}
	public function del($id){
		//查看要·删除的分类下是否有子分类
		$res = $this->where('parent_id='.$id)->find();
		if($res){
		return false;
		}
		return $this->delete($id);
	}
	public function findoneByid($id){
		return $this->where('id='.$id)->find();
	}
	public function update($date){
		return $this->save($date);
	}
	public function getFloor()
	{
		//获取所有顶级分类
		$data = $this->where('parent_id=0')->select();
		//进行遍历
		foreach ($data as $key => $value) {
			//获取二级分类
			$data[$key]['son'] = $this->where('parent_id=' . $value['id'])->select();
			$data[$key]['recson'] = $this->where('isrec=1 and parent_id=' . $value['id'])->select();
			//根据楼层二级分类的获取对应信息
			foreach($data[$key]['recson'] as $k =>$v){
				$data[$key]['recson'][$k]['goods'] = $this->getGoodsByCateId($v['id']);
			}
		}
		return $data;
	}
	public function getGoodsByCateId($cate_id,$limi=8){
			//根据当前分类下的
		    $childer=$this->getChildren($cate_id);
			$childer[]['id'] = $cate_id;
			foreach($childer as $key=>$value){
				$list[] = $value['id'];
			}
			$childer = implode(',',$list);
			//获取数据
		$goods = D('Admin/Goods')->where("is_sale=1 and cate_id in ($childer)")->limit($limi)->select();
			return $goods;
	}

}