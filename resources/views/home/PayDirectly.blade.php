@extends('layouts.home')
@section('content')
    <link href="{{asset(HOME_CSS.'pay.css') }}" rel="stylesheet" type="text/css">
<form method="post" action="{{url('/pay/pay_post')}}" id="PayForm" target="_blank">
    <div class="all">

        <div id="ShopTitle" class="order-title">
            <div class="order1">
                <div class="left order-text"><p><span class="bt">{{$data['goods_name']}}</span><span style="font-weight:normal;padding-left:30px; font-size:12px;">{{$data['qu']}}</span></p></div>
                <div class="right jiage"><span class="qian"><strong>{{$data['order_amount']}}</strong></span>元</div>
            </div>
        </div>
        <div class="fukuan">
            <div class="fangshi">
                <div class="left fs"><strong>付款方式：</strong></div>
                <div class="zh left">账户余额</div>
                <div class="left zf">支付：<span class="red" style="font-size:15px; padding:0 5px 0 5px"><strong>{{$data['pay_money']}}</strong></span>元</div>
            </div>

            <div class="brank" style="overflow:hidden;height:66px;">
                <div class="left fs"></div>
                <div class="zh left">
                    <div>
                        @if($data['pay_id']=='1')
                        <img style="border:1px solid #dedede;" src="{{asset(HOME_IMG.'alipay.jpg')}}">
                            @elseif($data['pay_id']=='2')
                            <img style="border:1px solid #dedede;" src="{{asset(HOME_IMG.'weixinpay.jpg')}}">
                        @endif
                    </div>
                </div>
                    <div class="left zf" style="width:auto;">支付：<span class="red" style="font-size:15px; padding:0 5px 0 5px"><strong>{{$data['sy_money']}}</strong></span>元</div>
            </div>

            <div class="anniu">
                <div class="left fs"></div>
                <div class="zh left">
                    <input id="pay_id" name="pay_id" type="hidden" value="{{$data['pay_id']}}">
                    <input id="" name="order_sn" type="hidden" value="{{$data['order_sn']}}">
                    {!! csrf_field() !!}

                    <div class="btn"><a href="javascript:void(0);" id="PaySure">确认付款</a></div>
                    <div class="tip">
                        <p><a href="{{url('/pay_order?order_sn='.$data['order_sn'])}}">选择其他付款方式</a> | <a href="" target="_blank">查看支付帮助</a></p>
                    </div>
                </div>
                <div class="left">
                    
                </div>
            </div>
        </div>
    </div>
</form>
    <script type="text/javascript">
        $(function () {
            $("#PaySure").click(function () {
                $("#PayForm").submit();
            });
        });
    </script>

@endsection