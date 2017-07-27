@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('recharge') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>帐号充值</span><p></p></div>
            </div>
            <div class="account">
                {{--<div class="account_top"><span class="current">搜付账户</span><span>QQ服务</span><span>游戏点卡</span></div>--}}
                <div class="account_box">
                	<div class="gst_top"><span class="current">第三方充值</span>{{--<span>银行卡/信用卡充值</span><span>卡类充值</span><span>银行柜台充值</span><span>境外汇款</span>--}}</div>
                    <div class="account_main" id="first">
                    	<div class="account01">
	                   		 <div class="socg">
                                 <i class="current" alt="支付宝付款"><img src="{{asset(HOME_IMG.'alipay.jpg')}}"><em><img src="{{asset(HOME_IMG.'/gou.png')}}"></em></i>
                                 <i alt="微信付款"><img src="{{asset(HOME_IMG.'weixinpay.jpg')}}"></i>
                             </div>
                        	<div class="account_btn"><a href="javascript:void(0)" id="ThirdSelect">下一步</a></div>
                        </div>
                    </div>
                    <div class="account_main" id="next_alipay" style="display: none">
                        <div class="account02">
                            <h3>您正在为账户 <i style="color: #1572b3">{{$user['name']}}</i> 充值</h3>
                            <div class="account_text">充值渠道：<i><img src="{{asset(HOME_IMG.'alipay.jpg')}}"></i><span>支付宝保证货款安全，购物真放心！</span></div>
                            <div class="account_text">充值金额：<input type="text" class="text" name="PayMoney_alipay">元</div>
                            <div class="xtbn_btn"><a href="javascript:void(0)" id="GetRate_alipay">确认充值，去支付宝付款</a></div>
                            <div class="xtbn_btn"><a href="javascript:void(0)" class="back">重新选择支付方式</a></div>
                        </div>
                    </div>
                    <div class="account_main" id="next_wx" style="display: none">
                        <div class="account02">
                            <h3>您正在为账户 <i style="color: #1572b3">{{$user['name']}}</i> 充值</h3>
                            <div class="account_text">充值渠道：<i><img src="{{asset(HOME_IMG.'weixinpay.jpg')}}"></i><span>使用微信支付保证货款安全，购物真放心！</span></div>
                            <div class="account_text">充值金额：<input type="text" class="text" name="PayMoney_wx">元</div>
                            <div class="xtbn_btn"><a href="javascript:void(0)" id="GetRate_wx">确认充值，去微信付款</a></div>
                            <div class="xtbn_btn"><a href="javascript:void(0)" class="back">重新选择支付方式</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".socg i").click(function(){
        $(".socg i").removeClass("current");
        $(".socg i em").remove();
        $(this).addClass("current").siblings().removeClass("current");
        $(this).append('<em><img src="{{asset(HOME_IMG.'/gou.png')}}"></em>');
    })
    $("#ThirdSelect").click(function () {
        var tselect = $(".socg .current").attr("alt");
        if (tselect == "支付宝付款") {
            $("#first").hide();
            $("#next_alipay").show();
            $("#next_wx").hide();
        }
        else if (tselect == "微信付款") {
            $("#next_wx").show();
            $("#first").hide();
            $("#next_alipay").hide();
        }
        return false;
    });
    $(".back").click(function () {
            $("#first").show();
            $("#next_alipay").hide();
            $("#next_wx").hide();
    });

    $("#GetRate_alipay").click(function () {
        var paymoney = $("[name=PayMoney_alipay]").val();
        if (paymoney == "") {
            layer.alert("请输入要充值的金额",{icon:5});
            return false;
        }
        else {
            var reg = /^[1-9]{1}\d*(\.\d{1,2})?$/;
            if (!reg.test(paymoney)) {
                layer.alert("请输入正确格式的金额，小数点后最多两位且不能小于1元",{icon:5});
                return false;
            }
        }
    });
    $("#GetRate_wx").click(function () {
        var paymoney = $("[name=PayMoney_wx]").val();
        if (paymoney == "") {
            layer.alert("请输入要充值的金额",{icon:5});
            return false;
        }
        else {
            var reg = /^[1-9]{1}\d*(\.\d{1,2})?$/;
            if (!reg.test(paymoney)) {
                layer.alert("请输入正确格式的金额，小数点后最多两位且不能小于1元",{icon:5});
                return false;
            }
        }
    });

</script>

@endsection