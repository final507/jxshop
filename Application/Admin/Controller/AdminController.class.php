<?php
namespace Admin\Controller;

class AdminController extends CommonController
{
    public function add(){
        if(IS_GET){
            $role = D('Role')->select();
            $this->assign('role',$role);
            $this->display('add');
        }else{
            $model = D('Admin');
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $model->add($data);
            $this->success('数据写入成功');
        }
    }
    //进行显示所有管理员-
        public function index(){
        $model = D('Admin');
        //调用listdata进行格式化
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }

    public function dels()
    {
        $admin_id= intval(I('get.admin_id'));
        if($admin_id<=1){
            $this->error('参数错误');
        }
        $model = D('Admin');
        $res = $model->remove($admin_id);
        if($res ===false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }
//接收编辑ID  进行显示
    public function edit()
    {
        //接收数据
        if (IS_GET) {
            $admin_id = intval(I('get.admin_id'));
            $model = D('Admin');
            $info = $model->findOne($admin_id);
            $role = D('Role')->select();
            $this->assign('role', $role);
            $this->assign('info', $info);
            $this->display();
        } else {
            //实现数据入库
            $model = D('Admin');
            $data = $model->create();
            dump($data);
            if (!$data) {
                $this->error($model->getError());
            } else {
                if ($data['id']<=1) {
                    $this->error($model->getError());
                }
                $model->updata($data);
                $this->success("修改成功",U('index'));
            }
        }
    }
}