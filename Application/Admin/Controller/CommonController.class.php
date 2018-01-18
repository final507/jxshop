<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    //这里是属性时用来判断是否是超级管理员
    public $is_check_rule = true;
    //用来存放用户的基本信息，
    public $user = array();
    public function __construct()
    {
        parent::__construct();
        header('content-type:text/html;charset=utf8');
        //判断当前用户是否登录
        //但是这是出现了死循环----因为当用户翻墙时没有登录信息--会跳转到登录界面但是这时因为是构造函数会在此判读是否登录所有产生死循环
        //解决办法---去login控制器下继承基类的控制器 这样就不会在去判断是否登录了
        $admin = session('admin');
        if(!$admin){
            $this->error('没有登录哦',U('Login/login'));
        }
        //将当前用户的信息保存到属性中
        $this->user = $admin;
        //根据用户ID获取角色ID
        $role_info = M('AdminRole')->where("admin_id=".$admin['id'])->find();
        //dump($role_info);die;
        $this->user['role_id']=$role_info['role_id'];
        //根据角色ID获取对应的权限ID
        $ruleModel = D('Rule');
        //判断当前用户是否是超级管理员
        if($role_info['role_id']==1){
            //此时我们就不去验证权限
            $this->is_check_rule = false;
            $rule_list = $ruleModel->select();
        }else{
            //若不是
            //根据对应的角色Id获取对应的权限ID---获取权限信息
            $rules = D('RoleRule')->getRules($role_info['role_id']);
            //查到的权限ID是二维数组--所以要进行格式化
            foreach($rules as $key=>$value){
                $rules_ids = $value['rule_id'];
            }
            //又因为是数组格式所以我们要转化为字符串
            $rules_ids = implode(',',$rules_ids);
            $rule_list = $ruleModel->where("id in ($rules_ids)")->select();
        }
        //将获取到的二维数组格式化
            foreach($rule_list as $key=>$value){
            //把对应的权限进行字符串拼接
            $this->user['rules'][] = strtolower($value['model_name'].'/'.$value['controller_name'].'/'.$value['action_name']);
//                dump($value);
            if($value['is_show']==0){
                $this->user['menus'][] = $value;
            }
        }
        //关于MYSql优化问题-----把用户数据写入缓存文件  下次登录直接读取缓存文件
        S('user_'.$admin['id'],$this->user);

        if($this->is_check_rule){
            //将其增加对应的默认访问权限
            $this->user['rules'] = 'admin/index/index';
            $this->user['rules'] = 'admin/index/top';
            $this->user['rules'] = 'admin/index/menu';
            $this->user['rules'] = 'admin/index/main';
            //普通管理员
            //获取当前用户访问的URL地址
            $action = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
            if(!in_array($action, $this->user['rules'])){
                if(IS_AJAX){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'没有权限'));
                }else{
                    echo '没有权限';exit();
                }
            }
        }
    }
}