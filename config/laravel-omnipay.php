<?php

return [

	// The default gateway to use
	'default' => 'unionpay',

	// Add in each gateway here
	'gateways' => [
		'unionpay' => [
			'driver' => 'UnionPay_Express',
			'options' => [
				'merId'				=> '777290058173603',
				'certDir'			=> storage_path('app/unionpay'),
				'certPath'			=> storage_path('app/unionpay/700000000000001_acp.pfx'),
				'certPassword'		=> '000000',
				'returnUrl'			=> 'http://192.168.52.220:8000/unionpay/notify',
				'notifyUrl'			=> 'http://192.168.52.220:8000/unionpay/notify',
			]
		],
		'alipay' => [
			'driver' => 'Alipay_AopWap',
			'options' => [
				'signType'			=> 'RSA2',
				'appId'				=> '2019092667860138',
				'privateKey'		=> 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDnM5a0zUjUn3POfh2nJ+LJbeRFcLDsAvBH3wSi32QnlJcIz9vrjSq6MiPbkgcluiybpyTSUTXbV3FjCXkiFD4CQzQLXU2lGZR7vGpSGEtcJpyz4fQJR49vkaLXkRh75IJSgFWcr2WWDLrF6IK4rTzoirFKuKH7GFhfsE/elkDiaLxHA5IJ102NyBe5FKGPDu2ywxtVRZK3DbKhNXbiMd8vBdRLMJ31lxeicvmj0gK2x8iehREYkIKBLRWb1AH6HBOmcUXryDp9yzMuvseEzRP2r3L3mFTENv1teqg46nYhxq7r6HSe9zyFQf1ZJs1Mygq0gzZk5R6noF1wkCQkahwXAgMBAAECggEAJGAKewG9Tq6Tos5WzgDJfpWKj55OR6OiuDwPV6y77jpDlQBXAnVgXpEa8SXFeBsVf5vJgEmEprDYRxOrekAjDWoTWyJf3/TpVpprQ+VMnf/5MZgANCGNIKmSLEZIyt1F38MPNSqnWfdAv3h4cKPY7GE9yZrI6V+IL+3mcwfCx5wUTWEaFquD9de/NElh1hwVF7ErzFXIE7Vfa4VVPJJlByVUDJZgW6jD8sJTE1K9nj1jGEWMkzegDXrMlhOS1GFVUv2uUlpw+ebAi7R0JOz4YIsYU7DZWQsrhZiNYMcSIX+mOgG9wMejEYQbUDjfkd+pJJcrf1sps8Q3D5DItZbnUQKBgQD0GDYV9SGtP0qz3FuNNAiDOoJh/fJ9S8FhJO7qDifNBEShU+XYm2kAMkUBdh29aARoyFBRqWyOgJepNwZ2LmQ7ufAF3wma/HPnsgakqZZdf1LTVYlN4xePHZ6tNHUmt0Qe0A1apm1J5djCSJBxYFOJwwCFKQMvTCFH+zPE/+D46QKBgQDyemS5b6nqqDmVhF7zi7bpfqCFwtbvJbHJW2KDJdTZmIKBAIR44a/5zjiAJQTdB/qVTLGC9ZQLUCLESZZuOhlGeWcfn66GxKfzEFiAxUmy1CG8ML1xC8Og16pzGf9nrv2d2N8BYNsWxKxeldVzqlcyAmkXtdIRjA/PRooSqeVM/wKBgQDwMPbfynRWD2bJ7/diziXmQ+fS11oLM0VZ+0bhqAZANof2HCGbcOn02IKQupLvM3DLTvnCMa5x11XlnBDOsD3Pi9sFXAEOsoa3IrZox7v/yu9Mp+nRa7peCO6AT5NMAqCUlXPelNAMHJGcNF12QyxQ7kMPxVit7QL+2tCJdKUDKQKBgDI+gliads8VBLmisDovHTvM7V5KPVdYrDpZIVSjpjNgkspAXTLfMSPGQ5bqFNPoL1h4h9/nG0Is3MdnqDA3Ab3EskWvRO7QGS0Ymf4040yXAFaKkva1xVey2LL5FB9b91mZ8rvKYhuZrU38JjrNdTv7m+M53cmdCDmfGEU9xzHpAoGAIV/rmrrX4HxT5j65oIZXdv/8vQxF2JpjpPZC6+HHcN9614LGmLogTfZyvVzCFTWjcpZTWG/4d4a5srA049+bDzEz0pDQj6DOydavKT/WDGXLN+9jyQEpUvf/JYNQyoMZbD1cKDoWjWYgPAtRBkgchy+tWdHpo83M3MP4/9ylEVo=',
				'alipayPublicKey'	=> 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2cFmIwXNSXhG/+eItgQ1WzUpymOTm/sXhsBk6UQDyi6fuasVcfO5EwnWpgOe4n7VS1jsD4x2eeCtis4Ry8IOp475ZlKxLvfioG18CmYE/6WOxN691VHKqsYDDjbrWyTOvLguFrK+cl/orLsWIXR4X4XYNTrZXLYOqPxv9V5N5nlUomHizpRhJ0noHOvItYdrZok0au5SEW7sGdNiO4reDO3sDm9uLK3BFfgW2QVl7hHoyhRp4AuLyKqIRySShQifdZqgQfpXf3khreNTahhlyIMY5AHAoJf+WgoIAebT5NeQHj9fUzjJdLcAEQQY0Fnz+TGmcdhan8jV79FirKXnLQIDAQAB',
				'notifyUrl'			=> 'http://sdk.longame.cn:8000/alipay/notify',
			]
		],
		'wechatpay' => [
			'driver' => 'WechatPay_App',
			'options' => [
				'appId' 			=> '2019092667860138 ',
				'mchId' 			=> '777290058173603',
				'apiKey' 			=> 'XXSXXXSXXSXXSX',
				'notifyUrl'			=> 'http://192.168.52.220:8000/wechatpay/notify',
			]
		]
	]

];