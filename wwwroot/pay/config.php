<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016082100302597",

		//商户私钥
		'merchant_private_key' => "MIIEpQIBAAKCAQEAsXm+n3t+QgcdJqeK3W8hYNZD77eJQBjBU3jh4bQbnAxIKPzM8rJqMKxILEaAe/dC/9DpIgGUhnmJiOtWf2Xo/3HFaRfzf5Ss3SLKQgvu3sW0SiLsah/n8wJzpucHSDDj5s/mXJrQ8dIyz20rvapQyEsnQuUONg7Itg5qMf+CYVIGVzcHm8lfsrL6Ao1wByrKubvdZYJ5x2kDBMg7op2Ks//fTpH2P+h+ZbM14giTglnNqhN0u5+6894i95R2iZpOxYByafr6PXEnZsCotVRpmVOYFMBFQZntVFsghHfRABaICYEXSjnZOIP29tHdiu4ul+6z2/mgT1wb94LBw0junQIDAQABAoIBAQCok7bQsDHmr/EtpVlPKl8vJ3dSfSievKTuD9WnWTgcisIERNS792LMpujLPZCPr/dxHNRFm/Cjp1BPwRLhYkDmWwAj6j89wVBNoN0zzTfxXSP6g5/C0lm1R2/pamtNVDs2I+ZxshCkkn/27YDt4JhpGJHLhd1w1awq2hhfM495tiXgtS/cG6Vk8r6WRIlLlb6ZSweTgu38/h05n8cueI9wIjw6vjw9wBk8uqscf4np2r+5zGHRPdgo5xHYrHXI4Fkj7D9ROTC+DHQXS8uFo3ryUbesaXk6KRmUXMaTMZHcFE0LNgdBemNU86spA9OK7fmvhaiEzkt3GFrFtslSpWFBAoGBAN0auVgUZXTrohF8Uof5aQg9YE5Muqtt8VS82o5heRym8J5xR1tbplRki4xAEhx8ZNdMw3OGtNCbUrNKWXgJMDDlibOBrp6fHvuG+kqOTEHWDlP/KfxBsWA4kgWRqEYgN845xVueUPohLBUjJ3n23G0w3zHstMR/WI/ar4g1NNiNAoGBAM18ST4BW386ZKaS8OOzzF5whhPTbE2vhuVNN4k2Zt2maFi/zcDNwyc1c9dRAw0empHdIyX+V/Utzs5sRiplVG6ZjulCSIqvBlFhTZeI7mazE896JpLgQhZLtsS2QEusNrWzehKmhRCOwjlLXnBuO7lT8uwV8EDilxml8jUWUJJRAoGBAKqGfuYYrPsU9KUJvllSmZgaRhl9ggbPP258TQ+8y3y2oCOC+GbUc57pANuFWrKPmfKXKLMD9JZjBNB0ijZS19EOZzqDzRpXXLzfKFCyGMw5/Ej6JfaA7/1nA++5nA+hr4ik87qqioevZ+FRgJPHOdAY/jrx9aULFlG0dubVKlHNAoGAMoVZOJ560XgY4P+FrGY7XAjMXjmACkWao+vtOJYgimRsiU13F+0/CvfQaGLpniMlG7HD/4ZeN9CwZP4n7iqFrL+ibGU4kqhfpEiJHDW1b5idyUgeDcSHWxX4dLreafyIYvoijE1Wr/B5fj6ylG/1zSX/tt3Z+Qn83nh3aWf4HVECgYEAxVpPs3JYXRqu0G094OjAztXFrJMaVAKip0j7QJHLxsrsMN1AYX4oNsaTNNdhzPtyCTUpr7KVCQE59fvS5xYwVaFicMuINd+6PVVcScQ3YCM2z8CUeli5c67DwqLh2dG4xfOSowivsq+Wu/4sk4vBFRgvDna2lc5wzwyL+9hMnz8=",
		//异步通知地址
		'notify_url' => "http://localhost/pay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://localhost/pay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
			//注意 dev不能少 不然会出现appid失效问题

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvfTtLfFr4/6EzWNUSz1PPZ2kuOcnBp5MmqfUGOy+zJv/p4EBKFY0BbYQVq22JEkRzHneF7QZp7/F0uYzVqDF5sL6CY6M4OEelWYxC+cRssx16zyogGYNAqbjHjoVdTWeZVXu5yB0DzLPrmtS+MdI3mbVQjK4xR7j7tI0bxt+6LiFR4kZ2xk/oOWW3/sQtTtpiyNqFKq841vcFCkZoL/RvI0vGHwnDAtJXcOAMnVFa8m8T1yIeFXeceFCmECHjbilAgww8bQWHz9gdH1/QqUP1KBYq9d3ssakGvdbEjZT8VkyrX0TGV08W3wQQk8McoTuRW6hMKqmx0YG4jRd32YhsQIDAQAB",
);