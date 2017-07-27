<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home\CommonController;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Omnipay\Omnipay;

class AlipayController extends CommonController
{

    // 支付信息  test
    public function pay(){
        dd(Input::all());
        $gateway = Omnipay::gateway();
        dd($gateway);
        $options = [
            'out_trade_no' => date('YmdHis') . mt_rand(1000,9999),
            'subject' => 'Alipay Test',
            'total_fee' => '0.01',
        ];
        $response = $gateway->purchase($options)->send();
        $response->redirect();
    }


    //回调
    public function result(){

        $gateway = Omnipay::gateway();

        $options = [
            'request_params'=> $_REQUEST,
        ];

        $response = $gateway->completePurchase($options)->send();

        if ($response->isSuccessful() && $response->isTradeStatusOk()) {
            //支付成功后操作
            exit('支付成功');
        } else {
            //支付失败通知.
            exit('支付失败');
        }
    }
}
