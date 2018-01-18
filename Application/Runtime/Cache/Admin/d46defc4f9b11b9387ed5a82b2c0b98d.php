<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 分类添加  </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="#">商品分类</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加分类 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    
    <div class="tab-div">
        <div id="tabbar-div">
            <p>
                <span class="tab-front">通用信息</span>
                <span class="tab-front">商品属性</span>
                <span class="tab-front">商品相册</span>
            </p>
        </div>
        <div id="tabbody-div">
            <form enctype="multipart/form-data" action="" method="post">
                <table width="90%" class="table" align="center">
                    <tr>
                        <td class="label">商品名称：</td>
                        <td><input type="text" name="goods_name" value=""size="30" />
                        <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td class="label">商品货号： </td>
                        <td>
                            <input type="text" name="goods_sn" value="" size="20"/>
                            <span id="goods_sn_notice"></span><br />
                            <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品促销： </td>
                        <td>
                            促销价格：<input type="text" name="cx_price" value="" size="20"/>
                            开始时间：<input type="text" name="start" value="" size="20"/>
                            结束时间：<input type="text" name="end" value="" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品分类：</td>
                        <td>
                            <select name="cate_id">
                                <option value="0">|--请选择</option>
                                <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>">|<?php echo (str_repeat('--',$vo["lev"])); echo ($vo["cname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">扩展分类：</td>
                        <td>
                            <input type="button" name="addExtCate" id="addExtCate" value="增加扩展分类">
                            <select name="ext_cate_id[]">
                                <option value="0">|--请选择</option>
                                <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>">|<?php echo (str_repeat('--',$vo["lev"])); echo ($vo["cname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">本店售价：</td>
                        <td>
                            <input type="text" name="shop_price" value="" size="20"/>
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">是否上架：</td>
                        <td>
                            <input type="radio" name="is_sale" value="1" checked="checked" /> 是
                            <input type="radio" name="is_sale" value="0"/> 否
                        </td>
                    </tr>
                    <tr>
                        <td class="label">加入推荐：</td>
                        <td>
                            <input type="checkbox" name="is_hot" value="1" /> 热卖 
                            <input type="checkbox" name="is_new" value="1" /> 新品 
                            <input type="checkbox" name="is_rec" value="1" /> 推荐
                        </td>
                    </tr>

                    <tr>
                        <td class="label">市场售价：</td>
                        <td>
                            <input type="text" name="market_price" value="" size="20" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">商品图片：</td>
                        <td>
                            <input type="file" name="goods_img" size="35" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品描述：</td>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
                            <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
                            <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                            <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                            <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
                            <script id="editor" name="goods_body" type="text/plain" style="width:800px;height:500px;"></script>
                        </td>
                    </tr>
                </table>
                <table width="90%" class="table" align="center" style="display: none;">
                    <tr>
                        <td class="label">商品类型：</td>
                        <td>
                            <select name="type_id" id="type_id">
                                <option value="0">请选择类型</option>
                                <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="showAttr"></td>
                    </tr>
                </table>
                <table width="90%" class="table pic" align="center" style="display: none;">
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input type="button" name="addNewPic" class="addNewPic" value="增加相册图片">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">相册图片：</td>
                        <td>
                            <input type="file" name="pic[]">
                        </td>
                    </tr>
                    
                </table>
                <div class="button-div">
                    <input type="submit" value=" 确定 " class="button"/>
                    <input type="reset" value=" 重置 " class="button" />
                </div>
            </form>
        </div>
    </div>

</div>
<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script src="/Public/Admin/Js/jquery-1.8.3.min.js">
</script>

<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

    //实现扩展分类的点击按钮增加select选择框
    $('#addExtCate').click(function(){
        //复制select
        var newSelect = $(this).next().clone();
        //将内容写入到td中
        $(this).parent().append(newSelect);
    
    });
    //实现选项卡切换
    $('#tabbar-div p span').click(function(){
        //将所有的table设置为隐藏
        $('.table').hide();
        //将当前点击的选项卡对应的内容设置为显示
        var i =$(this).index();
        $('.table').eq(i).show();
    });

    $('#type_id').change(function(){
        //获取到当前被选中的类型标识
        var type_id = $(this).val();
        $.ajax({
            url:"<?php echo U('showAttr');?>",
            data:{type_id:type_id},
            type:'post',
            success:function(msg){
                $('#showAttr').html(msg);
            }
        });
    });
    function clonethis(obj){
        //获取当前tr的对象
        var current = $(obj).parent().parent();
        if($(obj).html()=='[+]'){
            //复制当前的tr
            var newtr = current.clone();
            //将当前的特殊符号该为[-]
            newtr.find('a').html('[-]');
            current.after(newtr);
         }else{
            current.remove();
         }
    }

    //实现点击按钮增加图片上传
    $('.addNewPic').click(function(){
        //1、将上传框对应的tr进行复制
        var newfile=$(this).parent().parent().next().clone();
        //2、将复制的上传框追加到table中
        $('.pic').append(newfile);
    });
</script>