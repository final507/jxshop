<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016082100303173",

    //商户私钥
    'merchant_private_key' => "MIIEpgIBAAKCAQEA1PacZjyacxTg5y3Jv0yfVWYZ4AgE5eLYmXLgqHi9IjFcLL+BGNYaM2INj3gBZn2QT0j/wByr6bI8ZEvy8h1MLi7YBSmMjmZ4GwrI/1DAl8rJ4JhLWimP8zmQNgifBkJuSACKjT33DqOUWiHHcLOELPlynaNRKWfUviNj2Jw1TCtI200sa48+EKtJp1f/7a5cK1gh1rY3rhYTjF0zOt20Q/EzAaes7xNCRqT89qMirEgJZ9rvhpJ0mMzePdOjKGYjyrCDlisf27Dv5kpFxnWHkGqSuk7EdYr8NzNIRrdat9MkFxzt6URv/XkBhCXfc8MziT5cF/76F0gIbxMEpKOafQIDAQABAoIBAQC5pQkNroLNE0RDAo0+L+MtpMWloBf09lzu10+0TRxCtFivwXkeV3WbmTxM9sXxvD+SfgZESDosjG1M2VA9cwC3uaoiRef7MqQ8npg8yP461FJLcTcur9CGrIVkNPu7jylnpuEg4wV9Q2fNcmjTfAoa0pDxji7wM00nOt6NMw7bB8CfcMLziX1iWU2qALUB5ixudcYR6scLBmluaf2XngbUssyDrS2AJavK99sjNuDHTPwc1pElGNTQCpkrVRiMuSkJwps4Km0eVh03dypyo0FvAuwtfS6PiJL8sHpQqQATGiVl78trbbJQ/RXrvkpZyicl3akeWwXotMO+St4NRH5BAoGBAPja6P50Woq5VDNh3NWt2rdYZlk0FMZK0yvYfl6TPosN7KTfw6XKzNpUuQey9rq3TwrbP0LIFuc2Yke13HMwuak4k/1v07AWmILIQrtw3VlZLRkfIMAP8EF6F8P/TTjEcLGrWBndE1kim2BDjDoNqlV+OXJ3lOhZMb2dDdwAOiUJAoGBANsT5TsX+lzXK9qrC8WIDifGLn+/owr2NHuwTl81lO7tgf25rD43YHV5i6SOfQGJx22UmWO5GwOLcnXPpIEcQgwFKI49L/QCj3PpkrP0cEW40gGTd2FI9Ou8wqdgygORq7NCwyV2Sb6zlDV/kP0FJM882nSCy1LsqyrSPdCpWPrVAoGBALKQ0jMT5ow4Y9Ti2gVx1MlO41IK7wVCV7jUhgjy+yPof+/mqIrktI3N0V9W6XgdZNhTbldLIDQUb/0o3+DAC9kDQh3PCkUGUbU2YbwCRrKALL4j+eoXBbzWEQuQvCaJvpueaX9VhTamgHtYvNxDRgBGrI4YhH8c0XZPpcxBVXeRAoGBAM+AZqy0J2TsQRNa00mDdrThl4VUhB+L12YYNgMkAy7TMz6ZMLW1Sd27BDMW6vwb/hKiny6/UwDmgcForQ3FMCGmeSVQey0Jh8poP5XHPtgrGG55uKcirSjjnxNeL7l1rkWaRLAk+/Bus0CA1VlyF81afCfDAsZGeFGU1QvgevEJAoGBANi7qam0x3cpPobewP/khF5EIWpd5amMWdfatPTD9Pt+fw343DdZFEv0MTshx2Yk8FuV+QQ1LyE5AjvY3R14NnDQe18XPcMgrnqhNJW5oXCj9FO7KUeo+IKM5tqyoQTLo1OH40PP4Hn4bLFa2maSlJI+NWy+9HoA2uN3f3BR7f1O",

    //异步通知地址
    'notify_url' => "http://www.think.com/pay/notify_url.php",

    //同步跳转
    'return_url' => "http://www.think.com/Order/returnUrl.html",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA/EosoxLz0BGyRP/GppaESEVToldj4aDkpOlYiRYWNnXJPNOEIGQtjMoy//BGIc/AR52BRIxz3nCy1Xz5qeA08xy1Wuyx2WK9+GbCQoYKAY8Z0O9VyvOJxOvZdcL8UZ2VlRjhq1/vMaFb6OkI861Kd75UAzHBQj/snetG1grPKm3s9rG9YNY9iVH4nPHb11PXzaMyi45g9O8tzGqztgNShwr0LY4m3InM6+28GGFqDwz12a/K7ULergE3h/tAxLZIyhenfY8RDraUBNg+FCW+3Euw8vgdWKyJkb6vwwbk2yuaOoxNMqTRAwMAZJCwwUe5kiOpyq96w2WOi4NElI3J7QIDAQAB",
);