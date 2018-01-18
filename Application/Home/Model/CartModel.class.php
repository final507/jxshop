<?php
namespace Home\Model;
use Think\Model;

class CartModel extends Model{
    protected $fields=array('id','user_id','goods_id','goods_count','goods_attr_ids');

    //实现商品加入购物车
    public function addCart($goods_id,$goods_count,$attr)
    {
        //实现商品加入购物车
        //将属性组合进行排序
        sort($attr);
        //将属性进行转换
        $goods_attr_ids = $attr ? implode(',',$attr) : '';
        //检查库存
        $res = $this->checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids);
        if(!$res){
            return false;
        }
        //判断用户是否登录
        $user_id = session('user_id');
        if($user_id){
            //已经登录 --操作数据表
         $tmp = array(
             'user_id'=>$user_id,
             'goods_id'=>$goods_id,
             'goods_attr_ids'=>$goods_attr_ids
         );
            //返回的是是否存在 此商品
            $info = $this->where($tmp)->find();
            if($info){
                //增加对应的数量
                $this->where($tmp)->setField($goods_count+$info['goods_count']);
            }else{
                //如果此时不存在 直接写入数据
                $tmp['goods_count'] = $goods_count;
                $this->add($tmp);
            }
        }else{
            //此时没有登录  -将商品写入cookie
            $cart=unserialize(cookie('cart'));
            //判断商品是否存在
           //拼接下标
            $key = $goods_id.'-'.$attr;
            if(array_key_exists($key,$cart)){
                //存在
               $cart[$key]+=$goods_count;
            }else{
                //不存在
                $cart[$key]=$goods_count;
            }
            //将最近数据进行写入
            cookie('cart',serialize($cart));
        }
        return true;
    }
    //实现检查库存
    public function checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids){
        //检查总的库存
        $goods = D('Admin/Goods')->where("id=$goods_id")->find();
        if($goods['goods_number']<$goods_count){
            $this->error = "库存不足";
            return false;
        }
        //检查单个属性的库存
        if($goods_attr_ids){
            $where = "goods_id = $goods_id and goods_attr_ids = '$goods_attr_ids'";
            $number = M('GoodsNumber')->where($where)->find();
             if(!$number || $number['goods_number']< $goods_count){
                return false;
            }
        }
            return true;
    }
    //实现用户登录之后进行购物车商品转移
    public function cookie2db(){
        //从cookie中读取数据
        //unserialize — 从已存储的表示中创建 PHP 的值
        $cart = unserialize(cookie('cart'));
        //判断是否登录
        //获取当前用户的ID标识
        $user_id = session('user_id');
        if(!$user_id){
            return false;
        }
        //进行循环
        foreach($cart as $key=>$value){
            $tmp = explode('-',$key);
            //根据对应的属性查询商品是否存在
            $arr = array(
                'user_id'=>$user_id,
                'goods_id'=>$tmp[0],
                'goods_attr_ids'=>$tmp[1]
            );
            $res = $this->where($arr)->find();
            if($res){
               //加上数据库中已有数据
                $this->where($arr)->setField('goods_count',$value+$res['goods_count']);
            }else{
                //如果此时不存在 直接写入数据
                $arr['goods_count'] = $value;
                $this->add($arr);
            }
        }
        //将cookie数据清楚
        cookie('cart',null);
    }
    //实现购物车显示数据
    public function getList(){
        //判断用户是否登录
        $user_id = session('user_id');
        if($user_id){
        //登录时
            $data = $this->where('user_id='.$user_id)->select();
        }else{
            //未登录----直接从cookie中获取数据
            $res = unserialize(cookie('cart'));
            //转换格式
            foreach($res as $key=>$value){
                //进行数据拆分
                $tmp = implode('-',$key);
                $data[] = array(
                    'goods_id'=>$tmp[0],
                    'goods_count'=>$tmp[1],
                    'goods_attr_ids'=>$value
                );
            }
        }
        //根据商品ID获取对应的商品信息
        $goodsModle = D("Admin/Goods");
        foreach($data as $key => $value){
                if(!$value['goods_id']){
                   echo "参数错误";
                    exit();
                }
            $goods = $goodsModle->where('id='. $value['goods_id'])->find();
            //总结-----因为select获取到的是二维数组  无法获取到对应的价格 谨记！！！！
            //设置价格
            if($goods['cx_price']>0 && $goods['start']<time() && $goods['end']>time()){
                //此时处于促销价格
                $goods['shop_price'] = $goods['cx_price'];
            }
            $data[$key]['goods'] = $goods;
            //组合属性
            if($value['goods_attr_ids']){
                $attr = M('GoodsAttr')->alias('a')->join('left join jx_attribute b on a.attr_id=b.id')->field('a.attr_values,b.attr_name')->where("a.id in ({$value['goods_attr_ids']})")->select();
                $data[$key]['attr']=$attr;
            }
        }
        return $data;
    }
    //删除
    public function dels($goods_id,$goods_attr_ids){
        $goods_attr_ids = $goods_attr_ids ? $goods_attr_ids :'';
        $user_id = session('user_id');
        if($user_id){
            $where="user_id = $user_id and goods_id=$goods_id and goods_attr_ids='$goods_attr_ids'";
            $this->where($where)->delete();
        }else{
            $cart = unserialize(cookie('cart'));
            //手动的拼接当前商品对应的key信息
            $key = $goods_id.'-'.$goods_attr_ids;
            unset($cart[$key]);
            //将最新的数据再次写入到cookie中
            cookie('cart',serialize($cart));
        }
    }
    //实现购物车金额计算
    public function getTotle($data){
            $count = $price = 0;
        foreach($data as $key=>$value){
                 $count+=$value['goods_count'];
                 $price+=$value['goods_count'] * $value['goods']['shop_price'];
        }
        return array('count'=>$count,'price'=>$price);
    }
    //具体实现对购物车中商品数量的更新
    public function updateCount($goods_id,$goods_attr_ids,$goods_count)
    {
        //增加判断当目前$goods_count值小于等于0时不进行更新
        if($goods_count<=0){
            return false;
        }
        $goods_attr_ids = $goods_attr_ids?$goods_attr_ids:'';

        $user_id = session('user_id');
        if($user_id){
            $where="user_id = $user_id and goods_id=$goods_id and goods_attr_ids='$goods_attr_ids'";
            $this->where($where)->setField('goods_count',$goods_count);
        }else{
            $cart = unserialize(cookie('cart'));
            //手动的拼接当前商品对应的key信息
            $key = $goods_id.'-'.$goods_attr_ids;
            $cart[$key]=$goods_count;
            //将最新的数据再次写入到cookie中
            cookie('cart',serialize($cart));
        }
    }
}