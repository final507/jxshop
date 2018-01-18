<?php
namespace Admin\Controller;

class TypeController extends CommonController {
	//角色的添加
	public function add()
	{
		if(IS_GET){
			$this->display();
		}else{
			$model = D('Type');
			$data = $model->create();
			if(!$data){
				$this->error($model->getError());
			}
			$model->add($data);
			$this->success('写入数据成功');
		}
	}
	//角色的列表显示
	public function index()
	{
		$model = D('Type');
		$data = $model->listData();
		$this->assign('data',$data);
		$this->display();
	}

	public function dels()
	{
		$type_id = intval(I('get.type_id'));
		if($type_id<=0){
			$this->error('参数错误');
		}
		$res = D('Type')->remove($type_id);
		if($res === false){
			$this->error('删除失败');
		}
		$this->success('删除成功');
	}

	public function edit()
	{
		$model = D('Type');
		if(IS_GET){
			$type_id = intval(I('get.type_id'));
			$info = $model ->findOneById($type_id);
			$this->assign('info',$info);
			$this->display();
		}else{
			$data = $model->create();
			if(!$data){
				$this->error($model->getError());
			}
			if($data['id']<=0){
				$this->error('参数错误');
			}
			$model->save($data);
			$this->success('修改成功',U('index'));
		}
	}

	public function disfetch()
	{
		if(IS_GET){
			//获取当前角色已经拥有的权限
			$role_id = intval(I('get.role_id'));
			if($role_id<=1){
				$this->error('参数错误');
			}
			$hasRules = D('RoleRule')->getRules($role_id);
			//对获取到的权限进行格式化操作转换为一维数组目的是为了方便实现TP自带的in标签进行判断
			foreach ($hasRules as $key => $value) {
				$hasRulesIds[]=$value['rule_id'];
			}
			$this->assign('hasRules',$hasRulesIds);

			$RuleModel=D('Rule');
			$rule = $RuleModel->getCateTree();
			$this->assign('rule',$rule);
			$this->display();
		}else{
			$role_id = intval(I('post.role_id'));
			if($role_id<=1){
				$this->error('参数错误');
			}
			//接受提交的权限的ID标识 此时是数组格式
			$rules = I('post.rule');
			D('RoleRule')->disfetch($role_id,$rules);
			//修改角色的权限后需要将当前角色下的所有的文件信息全部删除
			//获取当前修改的角色下的所有的用户信息
			$user_info = M('AdminRole')->where('role_id='.$role_id)->select();
			foreach ($user_info as $key => $value) {
				//删除某个用户的对应的文件信息
				S('user_'.$value['admin_id'],null);
			}
			$this->success('操作成功',U('index'));
		}
	}
}