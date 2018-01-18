<?php 
namespace Admin\Model;
use Think\Model;
/**
* 公共模型
*/
class CommonModel extends Model
{
	//根据ID获取指定的数据
	public function findOneById($id)
	{
		return $this->where('id='.$id)->find();
	}
}

