<?php
namespace Admin\Controller;

class RuleController extends CommonController {
	//实现权限的添加
	public function add()
	{
		if(IS_GET){
			//获取格式化之后的分类信息
			$model= D('Rule');
			$cate = $model->getCateTree();
			//将信息赋值给模板
			$this->assign('cate',$cate);
			$this->display();
		}else{
			//数据入库
			$model = D('Rule');
			//创建数据---自动验证
			$data = $model->create();
			if(!$data){
				$this->error($model->getError());
			}
			$insertid = $model->add($data);
			if(!$insertid){
				$this->error('数据写入失败');
			}
			$res = new \Admin\Controller\RoleController();
			$res->flushAdmin();
			$this->success('写入成功');
		}
	}

	//权限的数据显示
	public function index()
	{
		$model = D('Rule');
		$list = $model->getCateTree();
		$this->assign('list',$list);
		$this->display();
	}
	//实现权限分类的删除
	public function dels()
	{
		$id = intval(I('get.id'));
		//判断是否是顶级权限分类
		if($id<=0){
			$this->error('参数不对！');
		}
		$model = D('Rule');
		//调用模型中的删除方法实现删除操作
		$res = $model->dels($id);
		if($res===false){
			$this->error('删除失败');
		}
		$this->success('删除成功');
	}

	//关于权限的编辑
	public function edit()
	{
		//显示所有参数
		if(IS_GET){
			//接收参数
			$id = intval(I('get.id'));
			//根据ID参数获取该分类的信息
			$model = D('Rule');
			$info = $model ->findOneById($id);
			$this->assign('info',$info);
			//获取所有的分类信息
			$cate = $model->getCateTree();
			$this->assign('cate',$cate);
			$this->display();
		}else{
			//提交编辑完成的内容
			$model = D('Rule');
			//自动验证
			$data = $model->create();
			if(!$data){
				$this->error($model->getError());
			}
			$res = $model ->update($data);
			if($res === false){
				$this->error($model->getError());
			}
			$this->success('修改成功');
		}
	}
}