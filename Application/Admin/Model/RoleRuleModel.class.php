<?php
namespace Admin\Model;
/**
 * 分类模型
 */
class RoleRuleModel extends CommonModel
{
    protected $fields=array('id','role_id','rule_id');
    public function disfetch($role_id,$rules)
    {
        //1、将当前角色对应的权限删除
        $this->where("role_id=$role_id")->delete();
        //2、将最新的权限新写入数据库
        foreach ($rules as $key => $value) {
            $list[]=array(
                'role_id'=>$role_id,
                'rule_id'=>$value
            );
        }
        $this->addAll($list);
    }
        public function listData(){
            //定义页码数
           /* $pagesize = 2;
            //计算数量
            $count = $this->count();
            $page = new \Think\page($count,$pagesize);
            $show  = $page->show();
            //接收页码
            $p = intval(I('get.p'));*/
            //$list = $this->page($p,$show)->select();
          // $data ="select * from jx_role";

            $data = $this->select();

            return $data;
        }
        public function remove($role_id){
            //接收数据
            return $this->where("id=$role_id")->delete();
        }
        public function findOneById($role_id)
        {
            return $this->where("id=$role_id")->find();
        }

        public function getRules($role_id){
            return $this->where("role_id=$role_id")->select();
        }
 }