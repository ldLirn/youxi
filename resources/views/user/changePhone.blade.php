@extends('layouts.user')
@section('content')
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('tel_change') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>手机绑定</span><p>在这里你可以绑定更换手机</p></div>
            </div>
   			<div class="phone_bin">
            	<div class="phone_bin_top" style="height: auto">

                        <div class="mobileinfo">
                            <div class="SpeT" style="display:block;">
                                <ul class="model">
                                    <li><span class="ttxt1" style="font-size:14px;">请先确认当前绑定的手机号<font style="font-weight:bold;color:red;">{{substr_replace($user['telphone'],'****',3,4)}}</font> 是否能接收短信，再选择修改方式：  </span></li>
                                    <li>
                                        <div class="ttxt1" style="width:580px; height:60px;background-color:#FFFEEF;border:1px solid #F7E5B3">
                                            <ul class="left" id="left_ico">
                                            </ul>
                                            <div style="margin-left:100px;margin-top:-37px;"><h3 style="font-size:15px;">基于对您账户及操作环境的检测，我们将提供以下方式供您选择</h3></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ttxt1 phonecontitle" id="phoneapply" style="width:580px;">
                                            <p class="ptype">无法接收短息</p>
                                            <p class="pyangshi left">原手机号已丢失或停用，使用非手机身份验证方式修改</p>
                                            <strong class="strongup" id="phoneapplydown"></strong>
                                        </div>
                                        <div class="ttxt1 phonecontent" id="phoneapplycontent" style="width: 580px; height: 100px; display: none;">
                                            <p class="pfangshi">通过异常申请解绑手机</p>
                                            <p class="pyangshi">先通过异常申请解绑手机，然后重新绑定新的手机号码</p>
                                            <div style="margin-left:60px; margin-top:-50px;">
                                                <a id="ImgBinMobile" class="btn1" href="{{url('/user/unbindPhone')}}">立即解绑</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li style="margin-bottom:30px;">
                                        <div class="ttxt1 phonecontitle" id="phonechange" style="width:580px;">
                                            <p class="ptype">能接收短息</p>
                                            <p class="pyangshi">通过原手机号接收短信校验码的方式修改</p>
                                            <strong class="strongup" id="phonechangedown"></strong>
                                        </div>
                                        <div class="ttxt1 phonecontent" id="phonechangecontent" style="width: 580px; height: 100px; display: none;">
                                            <p class="pfangshi">通过验证短信</p>
                                            <p class="pyangshi">如果你的{{substr_replace($user['telphone'],'****',3,4)}}手机还在正常使用，请选择此方式</p>
                                            <div style="margin-left:60px; margin-top:-50px;">
                                                <a id="ImgBinMobile" class="btn1" href="{{url('/user/changePhone/active')}}">立即修改</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                <div class="phone_bin_box">
                	<h3>手机绑定帮助中心</h3>
                    <div class="phone_bin_text">
                    	<h4>1.什么是手机绑定？</h4>
                        <p>手机绑定可以让您的帐户更加安全！因为手机绑定后，当您进行支付时，我们会发送给您一条短信验证码，只有在输入该验证码后才能成功支付。 请不要将验证码泄漏给任何人（包括{{config('web.web_title')}}客服）！</p>
                    </div>
                    <div class="phone_bin_text">
                    	<h4>2.手机绑定收费吗？</h4>
                        <p>手机绑定目前完全免费。</p>
                    </div>
                </div>
            </div>
                </div>
        </div>
    </div>
</div>

<script>
    function prevent(e) {
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    }
    function digitInput(el, e) {
        var ee = e || window.event; // FF、Chrome IE下获取事件对象
        var c = e.charCode || e.keyCode; //FF、Chrome IE下获取键盘码
        //var txt = $('label').text();
        //$('label').text(txt + ' ' + c);
        var val = el.val();
        if (c == 110 || c == 190){ // 110 (190) - 小(主)键盘上的点
            (val.indexOf(".") >= 0 || !val.length) && prevent(e); // 已有小数点或者文本框为空，不允许输入点
        } else {
            if ((c != 8 && c != 46 && // 8 - Backspace, 46 - Delete
                    (c < 37 || c > 40) && // 37 (38) (39) (40) - Left (Up) (Right) (Down) Arrow
                    (c < 48 || c > 57) && // 48~57 - 主键盘上的0~9
                    (c < 96 || c > 105)) // 96~105 - 小键盘的0~9
                    || e.shiftKey) { // Shift键，对应的code为16
                prevent(e); // 阻止事件传播到keypress
            }
        }
    }
    $(function(){
        $("input[name='telphone']").keydown(function(e) {
            digitInput($(this), e);
        });
        $("#MemberFrm").Validform({

        });

    });
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function valid_yz() {
        var phone = $('input[name=telphone]').val()
        curCount = count;
        $.post("{{url('auth/send_phone_code')}}",{user:"{{$user['id']}}",phone:phone,'_token':"{{csrf_token()}}"},function (msg) {
            if(msg.status=='1'){
                layer.msg(msg.info, {icon: 5});
            }else if(msg.status=='2'){
                $("#btnSendCode").attr("disabled", "true");
                $("#btnSendCode").css("background-color", "#d2ccc9");
                $("#btnSendCode").val( curCount + "秒");
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                $('#yzm').css("display", "block");
                layer.msg(msg.info, {icon: 6});
            }
        })
    }
    /*防刷新：检测是否存在cookie*/
    if($.cookie("captcha")){
        var curCount = $.cookie("captcha");
        var btn = $('#btnSendCode');
        btn.val( curCount + "秒").attr('disabled',true).css('cursor','not-allowed');
        var resend = setInterval(function(){
            curCount--;
            if (curCount > 0){
                btn.val(curCount + "秒").attr('disabled',true).css('cursor','not-allowed');
                btn.css("background-color", "#d2ccc9");
                $.cookie("captcha", count, {path: '/', expires: (1/86400)*curCount});
            }else {
                clearInterval(resend);
                btn.css("background-color", "#fff");
                btn.val("重新发送").removeClass('disabled').removeAttr('disabled style');
            }
        }, 1000);
    }
    //timer处理函数
    function SetRemainTime() {
        $.cookie("captcha", curCount, {path: '/', expires: (1/86400)*curCount});
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#btnSendCode").removeAttr("disabled");//启用按钮
            btn.css("background-color", "#fff");
            $("#btnSendCode").val("重新发送");
        }
        else {
            curCount--;
            $("#btnSendCode").val(curCount + "秒");
        }
    }
</script>
    <script type="text/javascript">
        $(function () {
            $("#phoneapply").click(function () {
                var flg = $("#phoneapplycontent").is(":hidden");
                if (flg) {
                    $("#phonechangecontent").hide();
                    $("#phoneapplycontent").show();
                    $("#phonechangedown").removeClass("strongdown").addClass("strongup");
                    $("#phoneapplydown").removeClass("strongup").addClass("strongdown");
                }else{
                    $("#phoneapplycontent").hide();
                    $("#phoneapplydown").removeClass("strongdown").addClass("strongup");
                }
            })
            $("#phonechange").click(function () {
                var flg = $("#phonechangecontent").is(":hidden");
                if (flg) {
                    $("#phoneapplycontent").hide();
                    $("#phonechangecontent").show();
                    $("#phoneapplydown").removeClass("strongdown").addClass("strongup");
                    $("#phonechangedown").removeClass("strongup").addClass("strongdown");
                } else {
                    $("#phonechangecontent").hide();
                    $("#phonechangedown").removeClass("strongdown").addClass("strongup");
                }
            })
        })
    </script>

@endsection