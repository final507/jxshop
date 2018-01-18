<?php
namespace Admin\Controller;

class RoleController extends CommonController
{
            // 添加角色
        public function add(){
            if(IS_GET){
                $this->display();
            }else{
                $model = D('Role');
                $data = $model->create();
                if(!$data){
                    $this->error($model->getError());
                }
                $model->add($data);
                $this->success('数据写入成功');
            }
        }
           //进行列表显示
        public function index(){
            $model = D('Role');
            //调用listdata进行格式化
            $data = $model->listData();
            $this->assign('data',$data);
            $this->display();
        }
            //实现删除
        public function dels(){
            $role_id = intval(I('get.role_id'));
            if ( $role_id <= 1) {
                $this->error('参数错误');
            }
            $model = D('Role');
            $res = $model->remove($role_id);
            if ($res === false) {
                $this->success('删除失败');
            }

            $this->error('删除成功');
        }
            //接收编辑ID  进行显示
         public function edit()
    {
        //接收数据
             $model = D('Role');
            if(IS_GET){
                $role_id = intval(I('get.role_id'));
                $info = $model->findOneById($role_id);
                $this->assign('info', $info);
                $this->display();
            }else{
                //实现数据入库
                $data = $model->create();

                if (!$data) {
                    $this->error($model->getError());
                }
                if ($data ['id']<=1) {
                    $this->error($model->getError());
                }
                    $model->save($data);
                    $this->success("修改成功",U('index'));
            }
        }
            public function disfetch()
            {
                if(IS_GET){
                    //获取当前角色拥有的权限信息
                    $role_id = intval(I('get.role_id'));
                    if($role_id<=1){
                        $this->error('参数错误');
                    }
                    $hasRules = D('RoleRule')->getRules($role_id);
                    //对权限信息进行格式化操作。目的是为了方便使用TP自带的in标签。对应in标签要求是一个一维数组或者是一个字符串格式
                    foreach ($hasRules as $key => $value) {
                        $hasRulesIds[]=$value['rule_id'];
                    }
                    $this->assign('hasRules',$hasRulesIds);

                    //获取所有的权限信息
                    $RuleModel=D('Rule');
                    $rule = $RuleModel->getCateTree();
                    $this->assign('rule',$rule);
                    $this->display();
                }else{
                    $role_id = intval(I('post.role_id'));
                    if($role_id<=1){
                        $this->error('参数错误');
                    }
                    $rules =I('post.rule');
                    D('RoleRule')->disfetch($role_id,$rules);
                    //如果此时超级管理员权限修改应当删除之前的全部缓存文件
                    $user_info = M('AdminRole')->where('role_id='.$role_id)->select();
                    foreach($user_info as $key=>$value){
                        //循环删除--设置缓存为NULL
                        S('user_'.$value['admin_id'],null);
                    }
                    $this->success('操作成功',U('index'));
                }
            }
                public function flushAdmin(){
                  $user = M('AdminRole')->where('role_id=1')->select();
                    foreach($user as $key=>$value){
                        S('user_'.$value['admin_id'],null);
                    }
                }
}
