<?php
namespace Home\Controller;

class UserController extends CommonController {

	public function regist()
	{
		if(IS_GET){
			$this->display();
		}else{
			$username =I('post.username');
			$password =I('post.password');
			$checkcode =I('post.checkcode');
			$tel = I('post.tel');
			$telcode = I('post.telcode');
			//检查验证码是否正确
			$obj =new \Think\Verify();
			if(!$obj->check($checkcode)){
				$this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
			}
			if(!$telcode){
				$this->ajaxReturn(array('status'=>0,'msg'=>'没有输入手机验证码'));
			}
			$data = session('telcode');
			if(!$data){
				$this->ajaxReturn(array('status'=>0,'msg'=>'没有发送手机验证码'));
			}
			if($data['time']+$data['limit']<time()){
				$this->ajaxReturn(array('status'=>0,'msg'=>'手机验证码过期'));
			}
			if($data['code'] != $telcode){
				$this->ajaxReturn(array('status'=>0,'msg'=>'手机验证码错误'));
			}
			//实例化模型对象 调用方法入库
			$model =D('User');
			$res = $model->regist($username,$password);
			if(!$res){
				$this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
			}
			$this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
		}
	}

	//生成验证码
	public function code()
	{
		$obj =new \Think\Verify();
		$obj->entry();
	}

	public function login()
	{
		if(IS_GET){
			$this->display();
		}else{
			$username =I('post.username');
			$password =I('post.password');
			$checkcode =I('post.checkcode');
			//检查验证码是否正确
//			$obj =new \Think\Verify();
//			if(!$obj->check($checkcode)){
//				$this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
//			}
			//实例化模型对象 调用方法入库
			$model =D('User');
			$res = $model->login($username,$password);
			if(!$res){
				$this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
			}
			$this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
		}
	}

	public function logout()
	{
		session('user',null);
		session('user_id',null);
		$this->redirect('/');
	}

}