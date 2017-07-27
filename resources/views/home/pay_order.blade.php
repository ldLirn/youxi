@extends('layouts.home')
@section('content')
    <link href="{{asset(HOME_CSS.'pay.css') }}" rel="stylesheet" type="text/css">
<div class="all">
    <div id="ShopDetail" class="more-order" style="display: block;">
        <div class="order">
            <p class="left"><b>商品标题：</b>{{$goods_data['goods_name']}}</p>
            <p class="left"><b>游戏区服：</b>{{$goods_data['game']['game_name']}} / {{$goods_data['da_qu']['qu_name']}} / {{$goods_data['xia_qu']['qu_name']}}/{{$goods_data['has_many_type']['type']}}</p>
        </div>
        <div class="order">
            <p class="left"><b>订单编号：</b>{{$order['order_sn']}}</p>
            <p class="left"><b>订单总价：</b><strong style="font-size:14px;color:Red;">{{$order['order_amount']}}</strong>元</p>
        </div>
    </div>
    <div class="order-nering2">
        <form method="post" id="PayForm">
            <div class="pay-message red-kuang">

                <div class="zhanghu"><strong>账户</strong>（{{Auth::user()->name}}）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;可用余额：<strong style="color:#339900">{{Auth::user()->money}}</strong>元</div>

            <div  id="pay_by_money">
                @if(Auth::user()->money >'0')
                <div class="zhanghu" id="pay_password"><strong>使用余额:&nbsp;&nbsp;</strong><input type="text" name="pay_by_money" class="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="zhanghu" id="pay_password"><strong>支付密码:&nbsp;&nbsp;</strong><input type="password" name="pay_password" class="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="confirm_pay_pass" value="确定" id="confirm_pay_pass"></div>
                @endif
            </div>
                <input id="" type="hidden" value="{{$order['order_amount']}}" name="order_amount">
                <input id="pay_id" name="pay_id" type="hidden" value="1">
                <input id="pay_money" name="goods_id" type="hidden" value="{{$goods_data['id']}}">
                <input id="" name="order_sn" type="hidden" value="{{$order['order_sn']}}">
                <input id="" name="goods_name" type="hidden" value="{{$goods_data['goods_name']}}">
                <input id="" name="qu" type="hidden" value="{{$goods_data['game']['game_name']}} / {{$goods_data['da_qu']['qu_name']}} / {{$goods_data['xia_qu']['qu_name']}}/{{$goods_data['has_many_type']['type']}}">
                {!! csrf_field() !!}
            </div>
            <div class="pay-style">
                <div class="bt">还可以选择其他支付方式</div>
                <div class="wrap">
                    <div class="title">
                        <ul class="PayTypeTab">
                            <li class="ahover"><a>第三方支付</a></li>
                        </ul>
                    </div>

                    <!--brank end-->
                    <div class="card card-red TypeTab" id="TSDiv" style="display: block;">
                        <div class="ThirdParty">
                            <div class="left ImgContent" id="CftRaRor">
                                <img class="Chargeimg current" src="{{asset(HOME_IMG.'alipay.jpg')}}" alt="支付宝付款">

                            <img class="gou" src="{{asset(HOME_IMG.'gou.png')}}"></div>
                                <div class="left ImgContent" id="ZfbRaRor"><img class="Chargeimg" src="{{asset(HOME_IMG.'weixinpay.jpg')}}" alt="微信付款"></div>

                        </div>
                        <ul class="gt">
                            <li class="btn"><a id="ThirdSelect">下一步</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
    <script type="text/javascript" src="{{asset(HOME_JS.'pay.js')}}"></script>
<script>
    $(".Chargeimg").click(function () {
        if (!$(this).hasClass("current")) {
            var html = '<img class="gou" src="{{asset(HOME_IMG.'gou.png')}}" />';
            $(this).parent().append(html);
            $(this).addClass("current").parent().siblings().find(".Chargeimg").next().remove();
            $(this).parent().siblings().find(".Chargeimg").removeClass("current");
        }
        var tselect = $(".ThirdParty .current").attr("alt");
        if (tselect == "支付宝付款") {
            $('#pay_id').val('1');
        }
        else if (tselect == "微信付款") {
            $('#pay_id').val('2');
        }

    });

    $('#confirm_pay_pass').click(function () {
        var money = parseFloat($('[name=pay_by_money]').val()) ;
        var reg = /^\d+(?=\.{0,1}\d+$|$)/;
        if(!reg.test(money)){
            layer.msg('请输入正确的金额',{icon: 5});
            return false;
        };
        if($('[name=pay_password]').val()=='' || $('[name=pay_password]').val().length<6){
            layer.msg('请输入支付密码',{icon: 5});
            return false;
        }
        if(money>parseFloat($('[name=order_amount]').val())){
            layer.msg('支付余额不能大于订单金额',{icon: 5});
            return false;
        }
        var pay_password = $('[name=pay_password]').val();
        $.post("{{url('/pay/money')}}",{money:money,pay_password:pay_password,'_token':"{{csrf_token()}}",id:"{{$order['id']}}"},function (msg) {
            if(msg.status=='-1'){
                layer.msg(msg.info,{icon: 5});
            }else if(msg.status=='-2'){
                layer.msg(msg.info,{icon: 5});
            }else if(msg.status=='-3') {
                layer.msg(msg.info, {icon: 5});
            }else if(msg.status=='202'){
                location.href = "{{url('/pay/success?order_sn='.$_GET['order_sn'])}}";
            }else if(msg.status=='200'){
                $('#pay_by_money').html('');
                $('#pay_by_money').html('<div class="zhanghu" id="pay_password"><input name="use_balace" value="1" type="hidden"><strong>使用余额:&nbsp;&nbsp;</strong><strong style="color:#339900">'+money+'</strong>元</div> <div class="zhanghu" id="pay_password"><strong>还需支付:&nbsp;&nbsp;</strong><strong style="color:#339900">'+msg.sy_money+'</strong>元</div>');
            }else if(msg.status=='-200'){
                layer.confirm(msg.info, {
                    btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"]
                }, function(){
                    window.location.href="{{url('/user/info/perfect?redirectUrl='.\Illuminate\Support\Facades\Request::getRequestUri())}}";
                }, function(){

                });
            }else{
                layer.msg('未知错误',{icon: 5});
            }
        })
    })

</script>
@endsection