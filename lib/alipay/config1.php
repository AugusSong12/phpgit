<?php
$config = array (	
		//应用ID,您的APPID。预约猫
		'app_id' => "2017120500383218",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpQIBAAKCAQEAxht2TnE9aSf0gitWs3+mQwZ2MsAhihR6dy1i8Hev+Evr/ZTlXxzJZ38jQgYz53ckjxbQYXGOUoFnsidIhU6PcPPsJSUQR/nu4akpLjqo+7o4EHm/pUNhaqI6BpuJeYIDR1212ZdLTBL8PhFADlZgPhi1TPos2ENaAR5TvNV4yiPtYikZHHrTQELmJzEplV+a3PtvvGnIXF3FXzCcRoO9OhqygVN2xV2n/ulYeAi3Amm8uTpKWbCTQZ3h1JROulF5NALxZbhW1Y/P48ACpoK37zAcRt/zqcezcwmeyNEeDYGPH4HoHNVbC1p5Qt4bt0ara4RTPurw/HKYV11Snq6AfQIDAQABAoIBABhSWs36nR2B6ETq6TQUYecsrepBKFz5cqebDOCU8Se8unZhh1+L+zYXp859UHYEbJqcpGyyMlTyyjZXGFI1eOrXJ5DP4hXUG33c9M9WKFTvYd6z89FoWldrH1CcW95tFdX3LVJPftESK6G7IHAiLqKxCeEvfb33Vt94R7ORSckXNJdXGeGQOrnxpNmq9BmZY8lSbyq1vMZVyKKYD7Zrfjm4O2pd1NL9dTCoj8PB05B5B0Z9KdZF5BMNr1PLHQdUly5EmiDcEOIcfoJwMpyTlo9YbJGE0AAScjVXh/RdicAoWGe9aXxv6TfUNQ+jsaI7wA+Pq289flaiO5P7+u3ze0ECgYEA9WtgUkKyou6Mfqjj6n441aDIDm1YdtO7GwamYTRgg3z2Lkdtbm+WqeFjsFcC90uGbvxAreLSw7IEoOj2SPK/3cIKPuTvERa0Mt/mkq7M6abX0WBXSHL+a3QHMTgQsRpRgZKjU6D3dxWul5zXJo+wRg1lyzo+v87BCsb37XO2cVkCgYEAzqXqRego50MAUmOEnZHKZK34saRvk7X9H0sXTDybWKBdj2ge8nuA3LQm5GFemorl22cuq/IB0Q7f4BX7ywf6hgltdAgQ7sCIO6AMcELbDyjg2qbbFxv7an4YVytmD7xVAaXiKwwEZmr3pC7RBN/kNgu4v6tNAkavADnN2nKbn8UCgYEA2J5cOH9ymWmhTLLZ6UJb/AOcUU+mg8vDHMmz1Zybi7Oiv5qANrf77hppGV7T2V8qW4//rvvEOMNKXpUBvcW2IJCC5py/fv/hMf560AHGEH4ZhE9a+zG06zdQmdr4sLmgM5Qw4UH064GRx3TCWuD9H/f3X3gbpsVhkpeogkheQpECgYEAlHQbBhePcvvuOkHmHnCC7qsQc0XHJl1iN13xocIUc6nZLNHHEbnpzCPboMvWc71+/Yx1ue7EoVRHPqtsVOIpdqtFJ0s4JtzHwdXruaY9yvk597pQwJxIlKt7fvvdeUZ55xItlXEvpAgKWbeMTy0svCrVkVRVoWH4DHh6Swl0hWUCgYEA7FQALqZNxLFLkqj797O1p+vzlxGMaA2Wp785NtsAm3ZNA4umAFcuKMtaA+bSm4Dnuh5ymn7Nzn9bMLMUnJt5Yk9iHq/STX/aunaH8M3tixGulQlkLeYKkr1L8xP1Zqc3v3JcZDiDX7JyWCe9YekYSaRbC96Gl/hjPD8L6XBCOyY=",
		
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
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4f2p3xfGrGYKeP4MsPbh3VL0sFGhMzWEveo7UHx1BsEgXrQceIH8g3W6gVDm0qijLumvzWo3SzeGs6E9zOmiIoPTood1sBmITqRzC8D2qGAPyrX9WyBoJzJi14Q7295FdE5aeoL7PZCLr9uGVEmzfhtRIprf+gbxp3X5etF4nH7ZYQWWDCg4P4A59ZXY+sLx24KYUwZ8Mp6yoTsGKnHDrElze/yP8WQVHq5CtRW/yCPpKC/SDH5JGp61gPgqxIIc76dEBC+vKlNX1wYPB0UoWXREqKUj7VyFj0ORuLriNxlGiSbKkvszVBkbFjPZu/9qNQcoVJrEXpP4bExIqgMhewIDAQAB",
		
	
);