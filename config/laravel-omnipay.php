<?php

return [

	// 默认支付网关
	'default' => 'alipay',

	// 各个支付网关配置
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],

		/**
		 *  Alipay_Express 支付宝即时到账接口
		 *	Alipay_Secured 支付宝担保交易接口
		 *  Alipay_Dual 支付宝双功能交易接口
		 *	Alipay_WapExpress 支付宝WAP客户端接口
		 *	Alipay_MobileExpress 支付宝无线支付接口
		 *	Alipay_Bank 支付宝网银快捷接口
		 */
		
		'alipay' => [
			'driver' => 'Alipay_Express',
			'options' => [
				'partner' => 'your pid here',         
				'key' => '3431241',
				'sellerEmail' =>'41901561@qq.com',
				'returnUrl' => 'sf.qq.com/pay/return',
				'notifyUrl' => 'sf.qq.com/pay/return'
			]
		]
	]
	

];