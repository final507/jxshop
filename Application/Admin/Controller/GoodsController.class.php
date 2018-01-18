<?php
namespace Admin\Controller;

        class GoodsController extends CommonController
        {
            //定义字段
            protected $fields = array(
                'id','goods_name','goods_sn',
                'cate_id','market_price',
                'shop_price','goods_img','goods_thumb',
                'goods_body','is_hot','is_rec',
                'is_new','addtime','isdel',
                'is_sale','type_id','cx_price','start','end'
            );
            public function add()
            {
                if (IS_GET) {
                   $model = D('Category');
                   $cate = $model->getCateTree();
                    $type = D('Type')->select();
                    $this->assign('type', $type);
                    $this->assign('cate', $cate);
                    $this->display();
                    exit();
                }
                //上传了商品图片
                $model = D('Goods');
                $res = $model->create();
                if (!$res) {
                    $this->error($model->getError());
                }
                $id = $model->add($res);
                if (!$id) {
                    $this->error($model->getError('败了'));
                }
                $this->success('成了');
            }

            //显示所有商品数据
            public function index()
            {
                $cate = D('Category');
                $cate = $cate->getCateTree();
                $this->assign('cate', $cate);
                //以上是获取全部分类信息
                $model = D('Goods');
                $data = $model->listData();
                //dump($data);
                $this->assign('data', $data);
                $this->assign('pageStr', $data['pageStr']);
                $this->display();
            }

            //删除操作
            public function dels()
            {
                //接收数据
                $good_id = intval(I('get.goods_id'));
                if ($good_id <= 0) {
                    $this->error('参数错误');
                }
                $model = D('Goods');
                $res = $model->dels($good_id);
                if ($res === false) {
                    $this->success('删除失败');
                }

                $this->error('删除成功');
            }

            //接收编辑ID  进行显示
            public function edit()
            {
                //接收数据
                if (IS_GET) {
                    $goods_id = intval(I('get.goods_id'));
                    $model = D('Goods');
                    $info = $model->findOneById($goods_id);
                    if (!$info) {
                        $this->error('参数错误');
                    }
                    $cate = D('Category')->getCateTree();
                    //获取扩展分类
                        $cate_goods_id = D('goodsCate')->where("goods_id=$goods_id")->select();
                    if (!$cate_goods_id) {
                        $cate_goods_id = array('msg' => 'no data');
                    }
                    //因为商品描述是用HTML来进行入库 所以要用HTML进行反转
                        $info['goods_body'] = htmlspecialchars_decode($info['goods_body']);
                        $this->assign('info', $info);
                        $this->assign('ext_cate_id', $cate_goods_id);
                        $this->assign('cate', $cate);
                        $typa = D('Type');
                        $type = $typa->select();
                        $this->assign('type',$type);
                    //根据商品标是获取属性和对应的类型
                        $good_attr = M('GoodsAttr');
                        //组织SQL
                        $attr = $good_attr->alias('a')->field('a.*,b.attr_name,b.attr_type,b.attr_input_type,b.attr_value')->where('a.goods_id='.$goods_id)->join('left join jx_attribute b on a.attr_id=b.id')->select();
                    //进行格式化
                    foreach($attr as $key=>$value){
                        if($value['attr_input_type']==2){
                                $attr[$key]['attr_value'] = explode(',',$value['attr_value']);
                        }
                    }
                        $this->assign('attr',$attr);
                        //获取商品对应的图片
                        $goods_img_list = M('GoodsImg')->where('goods_id='.$goods_id)->select();
                        $this->assign('goods_img_list',$goods_img_list);
                        $this->display();
                } else {
                    //实现数据入库
                    $model = D('Goods');
                    $data = $model->create();
                        if (!$data) {
                            $this->error($model->getError());
                        } else {
                            $res = $model->updata($data);
                            if ($res === false) {
                                $this->error($model->getError());
                            }
                            $this->success("修改成功",U('index'));
                        }
                }
            }
            //回收站商品列表显示
            public function trash()
            {
                //获取分类信息
                $cate = D('Category')->getCateTree();
                $this->assign('cate',$cate);

                $model =D('Goods');
                //调用模型方法获取数据
                $data = $model->listData(0);
                $this->assign('data',$data);
                $this->display();
            }
            //还原商品
            public function recover()
            {
                $goods_id = intval(I('get.goods_id'));
                $model = D('Goods');
                $res = $model->setStatus($goods_id,1);
                if($res ===false){
                    $this->error('修改失败');
                }
                $this->success('修改成功');
            }
            public function remove()
            {
                $goods_id= intval(I('get.goods_id'));
                if($goods_id<=0){
                    $this->error('参数错误');
                }
                $model = D('Goods');
                $res = $model->remove($goods_id);
                if($res ===false){
                    $this->error('删除失败');
                }
                $this->success('删除成功');
            }
            //关于点击选项卡显示内容
            public function showAttr(){
                //接收数据
                $type_id = intval(I('post.type_id'));
                //判断数据是否存在
                if($type_id==0){
                    $this->error("参数错误");
                }
                //查询数据库
                $data = D('Attribute')->where('type_id='.$type_id)->select();
                foreach($data as $key=>$value){
                            // 表示属性的类型 1表示唯一 2表示单选
                        if($value['attr_input_type'] ==2){
                                $data[$key]['attr_value'] = explode(',',$value['attr_value']);
                        }
                }
                                $this->assign('data',$data);
                                $this->display();
            }
            public function delImg(){
                //接受参数----request	获取REQUEST 参数
                $img_id = intval(I('request.img_id'));
                $ImgModel = M('GoodsImg');
                $info = $ImgModel->where('id='.$img_id)->find();
                if(!$info){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'参数错误'));
                }
                //此时已经接受全部参数  且有这张图片 开始删除
                unlink($info['goods_img']);
                unlink($info['goods_thumb']);
                //开始删除数据库图片
                $ImgModel->where('id='.$img_id)->delete();
                //返回结果
                $this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
            }
            //显示数据库存  --根据ID进行区分
            public function setNumber()
            {
                //接收数据
                if (IS_GET) {
                    $goods_id = intval(I('get.goods_id'));
                    $model = D('GoodsAttr');
                    $attr = $model->getSigleAttr($goods_id);
                    //如果返回为false
                    if(!$attr){
                        $this->display('nosigle');
                       $info = D('Goods')->where('id='.$goods_id)->find();
                        $this->assign('info',$info);
                        $this->display('nosigle');
                        exit;
                    }
                    $info = D('GoodsNumber')->where('goods_id='.$goods_id)->select();
                    $this->assign('info',$info);
                    $this->assign('attr', $attr);
                    $this->display();
                    exit;
                } else {
                    //接受数据
                    $attr = I('post.');
                    $goods_id = $attr['goods_id'];
                    $goods_number = $attr['goods_number'];
                    //此时没有单选属性的提交
                    if(!$attr['attr']){
                    D('Goods')->where('id='.$goods_id)->setField('goods_number',$goods_number);
                        exit;
                    }
                    foreach($attr['goods_number'] as $key => $value){
                                //因为每次循环要清空上次机记录
                             $tmp = array();
                            foreach($attr['attr'] as $k =>$v){
                                $tmp[] = $v[$key];
                            }
                            //当本函数结束时数组单元将被从最低到最高重新安排。
                            sort($tmp);
                            $goods_attr_ids = implode(',',$tmp);
                            //实现组合的去重
                            if(in_array($goods_attr_ids,$has)){

                            }
                            $list[] = array(
                                'goods_id'=>$goods_id,
                                'goods_number'=>$value,
                                'goods_attr_ids'=>$goods_attr_ids
                            );
                    }
                    //进行数据入库
                        $str = D('GoodsNumber')->where('goods_id='.$goods_id)->delete();
                      $res = D('GoodsNumber')->addAll($list);
                    //计算库存
                    $counts = array_sum($attr['goods_number']);
                    $goods_id = D('Goods')->where('id='.$goods_id)->setField('goods_number',$counts);
                    //对入库数据进行去重

                    if(!$res && !$str){
                        $this->error("参数错误");
                    }
                        $this->success("成功且开始跳转",'Goods/index');
                }
            }
        }

