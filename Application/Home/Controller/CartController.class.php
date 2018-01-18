<?php
namespace Home\Controller;

class CartController extends CommonController {

    //实现商品加入购物车
    public function addCart()
    {
        $goods_id = intval(I('post.goods_id'));
        $goods_count = intval(I('post.goods_count'));
        $attr = I('post.attr');   //此值为空
        $model = D('Cart');
        $res = $model->addCart($goods_id,$goods_count,$attr);
        if(!$res){
           $this->error("加入购物车失败");
        }
            $this->success("加入购物车成功");
    }
    public function index(){
        $model = D('Cart');
        $data = $model->getList();
        //计算当前购物车金额
        $total = $model->getTotle($data);
        $this->assign('total',$total);
        $this->assign('data',$data);
        $this->display();
    }
    public function dels(){
        $goods_id = intval(I('post.goods_id'));
        $goods_attr_ids = intval(I('post.goods_attr_dis'));
         D('Cart')->dels($goods_id,$goods_attr_ids);
      $this->success("删除成功");
    }
    public function updateCount(){
        //接收参数
        $goods_id = intval(I('post.goods_id'));
        $goods_count = intval(I('post.goods_count'));
        $goods_attr_ids = intval(I('post.goods_attr_dis'));
        D('Cart')->updateCount($goods_id,$goods_attr_ids,$goods_count);
    }

}