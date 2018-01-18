<?php
namespace Home\Controller;

class GoodsController extends CommonController {

    public function index()
    {
        //接收商品ID
        $goods_id = intval(I('get.goods_id'));
        if ($goods_id <= 0){
            //此时参数不正常----进行重定向
            $this->redirect('Index/index');
         }
            $goodsModel = D('Admin/Goods');
            $goods = $goodsModel->where('is_sale=1 and id='.$goods_id)->find();
            if(!$goods){
                $this->redirect('Index/index');
            }
            if($goods['cx_price']>0 && $goods['start']<time() && $goods['end']>time()){
                $goods['shop_price'] = $goods['cx_price'];
            }
        //进行HTML反转
        $goods['goods_body'] = htmlspecialchars_decode($goods['goods_body']);
        $pic = M('GoodsImg')->where('goods_id='.$goods_id)->select();
        //获取当前商品对应的属性信息
        $attr = M('GoodsAttr')->alias('a')->field('a.*,b.attr_name,b.attr_type')->join('left join jx_attribute b on a.attr_id=b.id')->where('a.goods_id='.$goods_id)->select();
        //将已有的属性信息根据单选与唯一进行拆分
        foreach ($attr as $key => $value) {
            if($value['attr_type']==1){
                //表示唯一属性
                $uniqid[]=$value;
            }else{
                //单选属性 需要格式化为三维数组，因为模板显示需要两层循环显示。并且对于同一个属性 需要显示在一起因此可以使用属性id作为第一维的下标
                $sigle[$value['attr_id']][]=$value;
            }
        }
        //获取当前商品的评论信息
        $model = D('Comment');
        $comment = $model->getList($goods_id);
        $buyer = D('Impression')->where('goods_id='.$goods_id)->order('count desc')->limit(8)->select();
        $this->assign('buyer',$buyer);
        $this->assign('uniqid',$uniqid);
        $this->assign('sigle',$sigle);
        $this->assign('goods',$goods);
        $this->assign('pic',$pic);
        //获取当前商品的印象
        $this->assign('comment',$comment);
        $this->display();
    }
    //实现商品品论
    public function comment(){
        $this->checkLogin();
        $modle = D('comment');
        $res = $modle->create();
        if(!$res){
            $this->error("参数错误");
        }
        $modle->add($res);
        if(!$modle){
            $this->error($modle->getError());
        }
        $this->success("成功");
    }
    //实现点击增加有用值的需求
    public function good(){
        //获取参数
        $comment_id = I('post.comment_id');
        $model = D('comment');
        $info =$model->where('id='.$comment_id)->find();
        if(!$info){
            $this->ajaxReturn(array('statuFs'=>0,'msg'=>'error'));
        }
        //如果存在此商品增加一
        $model->where('id='.$comment_id)->setField('good_number',$info['good_number']+1);
            $this->ajaxReturn(array('status'=>1,'msg'=>'ok','good_number'=>$info['good_number']+1));
    }
}