<?php
namespace Home\Model;
use Think\Model;

class CommentModel extends Model
{
    protected $fields=array('id','user_id','goods_id','addtime','content','star','good_number');

    //前置钩子
    public function _before_insert(&$data){
        //创建品论时间
        $data['addtime'] = time();
        $data['user_id'] = session('user_id');
    }
    //实现商品评论分页
    public function getList($goods_id){
        $p = I('get.p');
        $pagesize = 2;
        //计算总数
        $counts = $this->where('goods_id='.$goods_id)->count();
        //计算
        $page = new \Think\Page($pagesize,$counts);
        //使用锚点  --设置为true
        $page->setConfig('is_anchor',true);
        $show = $page->show();
        //获取评论信息
        $list = $this->alias('a')->field('a.*,b.username')->where('a.goods_id='.$goods_id)->join('left join jx_user b on a.user_id = b.id')->page($p,$pagesize)->select();

        return array('list'=>$list,'show'=>$show) ;
    }

    public function _after_insert($data){
        //接收ID
        $name  = I('post.name');
        $old  = I('post.old');
        foreach($old as $key => $value){
            M('Impression')->where('id='.$value)->setInc('count');
        }
        $name = explode(',',$name);
        $name = array_unique($name);
        foreach($name as $key => $value){
            if(!$value){
                continue;
            }
            //判断印象的数据库是否存在
            $where = array('goods_id'=>$data['goods_id'],'name'=>$value);
            $model = M('Impression');
            $res = $model->where($where)->find();
            if(!$res){
                //存在
                $model->where($where)->setInc('count');
            }else{
                $where['count'] =1;
                $model->add($where);
            }
        }
        //实现商品表中评论总数增加
        M('Goods')->where('id='.$data['goods_id'])->setInc('plcount');
    }
}
