<?php
namespace Admin\Model;
/**
 * 分类模型
 */
class AdminModel extends CommonModel
{
            //定义字段---角色表
        protected $fields = array('id','username','password');
        //创建自动验证
        protected $_validate = array(
            array('username','require','用户不能为空'),
            array('username','','用户名不能重复',1,'unique'),
            array('password','require','密码不能为空')
        );
        protected $_auto= array(
            array('password','md5',3,'function')
        );
        protected function _after_insert($data){
            $admin_role = array(
                'admin_id'=>$data['id'],
                'role_id'=>I('post.role_id')
            );
           $modle = M('AdminRole');
               $modle->add($admin_role);
        }
        public function listData(){
            // $list = $this->alias('a')->field('a.*,c.role_name')->join('left join jx_role')->;
            $list = $this->alias('a')->field("a.*,c.role_name")->join("left join jx_admin_role b on a.id=b.admin_id")->join("left join jx_role c on b.role_id=c.id")->select();
            return $list;
        }
       public function remove($admin_id){
           //开始实物
           $this->startTrans();
           //删除对应的用户信息
           $username = $this->where('id=$admini_id')->delete();
           if(!$username){
               //回滚
               $this->rollback();
               return false;
           }
           //删除对应的角色信息
           $role = M('AdminRole')->where('admin_id=$admin_id')-$this->delete();
           if(!$role){
               //回滚
               $this->rollback();
               return false;
           }
           //提交实物
           $this->commit();
           return true;
       }
            //根据用户ID查询所有的信息
        public function findOne($admin_id){
            return $this->alias('a')->field("a.*,b.role_id")->
            join("left join jx_admin_role b on a.id=b.admin_id")->
            where("a.id=$admin_id")->find();
        }
        public function updata($data){
            //
            $role_id = intval(I('post.role_id'));
            //修改基本信息
            $this->save($data);
            //修改对应的角色
            M('AdminRole')->where('admin_id='.$data['id'])->save(array('role_id'=>$role_id));
        }
        public function login($admin_name,$admin_pass){
            //查询用户
           $res = $this->where("username='$admin_name'")->find();
            /*dump($res['password']);
            dump(md5($admin_pass));
            die;*/
            if(!$res){
                $this->error="用户名不存在";
                return false;
            }

            if(md5($admin_pass) === $res['password']){
                $this->error = '密码错误';
                return false;
            }
            session('admin',$res);
            return true;
        }
}


