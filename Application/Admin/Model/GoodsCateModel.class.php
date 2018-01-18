<?php
namespace Admin\Model;
//这是关于商品去重的代码优化
        class GoodsCateModel extends CommonModel
        {
            public function insertExtCate($ext_cate_id, $good_id)
            {
                //数据去重
                $ext_cate_id = array_unique($ext_cate_id);

                foreach ($ext_cate_id as $value) {
                    if ($value != 0) {
                        $list[] = array(
                            'goods_id' => $good_id,
                            'cate_id' => $value);
                    }
                    //把数据进行写入操作
                    $this->addAll($list);
                }
            }

        }