<?php 

	header('content-type:text/html;charset=utf-8');
	//appkey
	$key='e3673a585812e1a081a3a4a5a7066fe7';

	$url = 'http://v.juhe.cn/exp/index?key='.$key.'&com=zto&no=449527557239';
	//发送http get请求
	$res = file_get_contents($url);
	echo '<pre>';
	var_dump(json_decode($res,true));
?>