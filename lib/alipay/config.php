<?php
$config = array (	
		//应用ID,您的APPID。预约猫
		'app_id' => "2017122101034802",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAruTT50H6Gxc8SjG7m29i7ZnfVPFRwArV8h0wXXm84dcCKQRZswY60g2xWDQ7M4R8PMY5F7KelBpT8k5XKCyJgn3BVAw/FmN2Yp/M/tCNGeLGko1fqdSfiE20FzZCbLO4kV6FG9mi1Cfh0T5VEMRbN7k4H7ypI9wJni7skPGSsVVxAxcM2LgNi1/Xe2bNuQcwkkbwnvhAkghTxkU5a1N+EYmsvFOchsgYYkjYCPwUwT2XJPlDoKP3gAXvoB70JO/vspqlhZdCNHTMBuPrl6QSXvLRvk3lMBKpstnGC2LUOiwQKWYnVzGn/68DNJyqfGz8q5gusCIqW1MtuMZ5579BqwIDAQABAoIBAQCHbiD9OiTvZ33DQmGxin6D2RyMzVXtrTZhBuNV7xgplfJRStIfBFr2H65NzBxv107RTPoW9LVBoGWTA8EQFfThvHnBmL4dmyWoV3BJfbtV6Tq1b449l611wh4Lv3OOc1kgEJ5oo44oVT3TZz49/p9YNjBUuyYK46/68wEzeC2M7YGIiBgRAXe/Iy3af8fKVUZ0YLtWbtjGPNeljKPSqRb7DjCdNZbQiPA53Spenqgh3sehkxmDEjvCjmOMw1cWUCQ55KMq7dewBAjFL7XIBir15bRtmBbvkznTNHY0srX3wCWHF3CWJp+GPJ1oJSQUKQO2DNoAVbWvgtEI6TdlZucRAoGBAODJlAO56ZSlzXuYHAnAh3/vexh+zl8RfhXSiJFONoE50burJcWx67Whl5jGLsTolzsMB9+xibqeO+ywG3SmpQF8FIPmcFGLnjfjIRzK2RUExseQyRxguk8SHFz2yxs/O/TbAGYDy3eMSllBHNV/ZnJVYzTi4B35NiJDtPa3jq1pAoGBAMcttGhUF965yAbXHyZd6rQkwALtRPVWHkWBtgqj3ZstNz1Y1tpTn6wRy3jRq5syiDJRUNsZCcTCiwqQYHUmIUVXHJdkKEs+PuN47w7I8HHVO5Hm37KUsAjLfryBJjl4QE061I2BoV9Is5Nkx4mZCMffnASoDoeKwQGcp+aPe4/zAoGBAKGIWcQfujnmt/XkBeoAH58RAf1FSpnIoTmfVCJO+R395bidsYQSahbYq27Oo9c+aUa2S4Y1N4sSoG9i0igOhK6/cqKiWv5OfYEdx7LAFiVjjFDmu46X9+pQUm9/rc7DrxsysWOdwH4FI3xmLQlDBuSMdcEQdAs2Be+zhfxxRadZAoGAX+zwJQrTEC5zWnACjYzPu4CzhPVWr72RCLKmxMsUsGZ/YylFGJMLpGhRkVeRiUY1993Xzh1p6fwz0JumCOWbQnTozTSsf0h0K0OUBo/Z1Uj3zpXdiHk5qpKu8ARXL3htp4Q82AXlfSlbaxIvU2KDqxdTYZ66mKbHu4oCBvV1cecCgYBmbrmrd2yLjgn/l6GZfWLY5jSNwB4KETCjes4WXc2M8YgOY6iWZQ/13nK2rLoEJgZpyASN57C4JuHhlxvnet1EaC42c2OHzqZRIOdukl3cb9+W4WYe3NUMNTv32DalzLOgRGZNscuAqHm71UdFOTQ6GATU8MDmGJPqk4GaBNvgKQ==",
		
		//异步通知地址
		'notify_url' => "https://yuyuemao.cn/lib/alipay/wappay/notify_url.php",
		
		//同步跳转
		'return_url' => "https://yuyuemao.cn/lib/alipay/wappay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAruTT50H6Gxc8SjG7m29i7ZnfVPFRwArV8h0wXXm84dcCKQRZswY60g2xWDQ7M4R8PMY5F7KelBpT8k5XKCyJgn3BVAw/FmN2Yp/M/tCNGeLGko1fqdSfiE20FzZCbLO4kV6FG9mi1Cfh0T5VEMRbN7k4H7ypI9wJni7skPGSsVVxAxcM2LgNi1/Xe2bNuQcwkkbwnvhAkghTxkU5a1N+EYmsvFOchsgYYkjYCPwUwT2XJPlDoKP3gAXvoB70JO/vspqlhZdCNHTMBuPrl6QSXvLRvk3lMBKpstnGC2LUOiwQKWYnVzGn/68DNJyqfGz8q5gusCIqW1MtuMZ5579BqwIDAQAB",
		
	
);