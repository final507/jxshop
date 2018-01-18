<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    //实现权限的添加
    public function login()
    {
        if(IS_GET){
            $this->display();
        }else{
            //接收数据

            $admin_verify = I('post.capthca');
            //进行验证码比对
            $res = new \Think\Verify($admin_verify);
            if(!$res){
                $this->error("验证码错误哦");
            }else{
                $admin_name = I('post.username');
                $admin_pass = I('post.password');
                $model = D('Admin');
                $res = $model->login($admin_name,$admin_pass);
                if(!$res){
                $this->error($model->getError());
                }
                    $this->success("登录成功",U('Index/index'));
            }
        }
    }

    public function verify(){
        //实例化GD
        //设置尺寸
        $config = array('length'=>3,'heigth'=>20);
        $verify = new \Think\Verify($config);
        //显示
        $verify->entry();
    }
}