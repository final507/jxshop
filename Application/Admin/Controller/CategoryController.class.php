<?php
namespace Admin\Controller;

class CategoryController extends CommonController {
	//实现分类的添加
	public function add()
	{
		if(IS_GET){
			//获取格式化之后的分类信息
			$model= D('Category');
			$cate = $model->getCateTree();
			//将信息赋值给模板
			$this->assign('cate',$cate);
			$this->display();
		}else{
			//数据入库
			$model = D('Category');
			//创建数据
			$data = $model->create();
			if(!$data){
				$this->error($model->getError());
			}
			$insertid = $model->add($data);
			if(!$insertid){
				$this->error('数据写入失败');
			}
			$this->success('写入成功');
		}
	}
	public function index(){
		//数据显示操作
		$model =  D('Category');
		$list = $model->getCateTree();
		$this->assign('list',$list);
		$this->display();

	}
	public function del(){
		//实现分类删除
		//接受ID
		$id = intval(I('get.id'));
		if($id<=0){
			$this->error('参数错误');
		}
		$model = D('Category');
		$res = $model->del($id);
		if($res === false){
			$this->error('删除失败');
		}
		$this->success('删除成功');
	}
	public function updata(){
		if(IS_GET) {
			$id = intval(I('get.id'));
			//显示数据$
			$model = D('Category');
			//获取指定数据
			$cate = $model->findoneByid($id);
			$info = $model->getCateTree();

			$this->assign('info', $info);
			$this->assign('cate', $cate);
			$this->display();

	}else{
			$model = D('Category');
			$date = $model->create();
			$res = $model->update($date);
			if($res ===false){
				$this->error('失败');
			}
				$this->success('成功');
		}
	}
}