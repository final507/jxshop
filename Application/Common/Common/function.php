<?php
/**
 * 发送模板短信
 * @param to 手机号码集合,用英文逗号分开
 * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
 * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
 */
function sendTemplateSMS($to,$datas,$tempId)
{
	header('Content-type:text/html;charset=utf-8');
	include_once("./CCPRestSmsSDK.php");

//主帐号,对应开官网发者主账号下的 ACCOUNT SID
	$accountSid= '8a216da86077dcd00160a2e1457e1baf';

//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
	$accountToken= 'a3d6349cc6804f4ea4c17183b5efa01b';

//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
	$appId='8aaf07086077a6e60160a2e35ccc15fd';

//请求地址
//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
//生产环境（用户应用上线使用）：app.cloopen.com
	$serverIP='sandboxapp.cloopen.com';


//请求端口，生产环境和沙盒环境一致
	$serverPort='8883';

//REST版本号，在官网文档REST介绍中获得。
	$softVersion='2013-12-26';

	$rest = new \REST($serverIP,$serverPort,$softVersion);
	$rest->setAccount($accountSid,$accountToken);
	$rest->setAppId($appId);

	$result = $rest->sendTemplateSMS($to,$datas,$tempId);
	if($result == NULL ) {
		return false;
	}
	if($result->statusCode!=0) {
		return false;
	}
	return true;
}
//生成商品列表中连接地址
function myU($name,$value)
{
	//获取当前浏览器上已经拥有的属性值的参数信息
	$attr = I('get.attr');
	if($name=='sort'){
		//将目前的排序字段保存到$sort变量中
		$sort=$value;
		$price = I('get.price');//获取浏览器上已有的条件信息
	}elseif ($name == 'price') {
		//将目前的价格信息保存到变量中
		$price = $value;
		$sort=I('get.sort');
	}elseif ($name == 'attr') {
		//根据属性值生成连接地址
		//可以实现使用多个属性值作为条件
		if(!$attr){
			$attr=$value;
		}else{
			//说明目前已经拥有了属性值对应的条件
			//将已经拥有的属性值参数信息转换为数组
			$attr = explode(',',$attr);
			$attr[]=$value;
			//对目前已经拥有的属性值信息进行去重操作
			$attr = array_unique($attr);
			$attr = implode(',',$attr);
		}
	}

	return U('Category/index').'?id='.I('get.id').'&sort='.$sort.'&price='.$price.'&attr='.$attr;
}