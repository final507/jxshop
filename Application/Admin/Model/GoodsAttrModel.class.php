<?php
namespace Admin\Model;

/**
 * 管理员模型
 */
class GoodsAttrModel extends CommonModel
{
    protected $fields=array('id','goods_id','attr_id','attr_values');
                public function insertAttr($attr,$goods_id)
                {
                    foreach ($attr as $key => $value) {
                        foreach ($value as $v) {
                            $attr_list[]=array(
                                'goods_id'=>$goods_id,
                                'attr_id'=>$key,
                                'attr_values'=>$v
                            );
                        }
                    }
                    $this->addAll($attr_list);
                }
                public function getSigleAttr($goods_id){
                    //接受参数
                    if($goods_id<=0){
                        $this->error="哎呀出错了";
                        return false;
                    }
                    $data = $this->alias('a')->join('left join jx_attribute b on a.attr_id=b.id')->
                                    field("a.*,b.attr_name,type_id,attr_type,attr_input_type,attr_value")->
                                    where("a.goods_id=$goods_id and b.attr_type=2")->select();

                            //为了方便显示  转化为三维数组
                    foreach($data as $key=>$values){
                        $list[$values['attr_id']][]= $values;
                    }
                    return $list;
                }

}