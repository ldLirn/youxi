<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<title>{{config('web.web_title')}}-登陆</title>
<link href="{{asset(HOME_CSS.'login.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'base.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{asset(HOME_JS.'jquery.min.js') }}"></script>
<script type="text/javascript" src="{{asset(HOME_JS.'base.js')}}"></script>
</head>

<body>
<div class="login_head">
	<div class="login_head_box">
    	<div class="login_head_left"><a href="{{web_url}}"><img src="{{asset(HOME_IMG.'login/logo.png') }}"></a><a class="curr" href="#">欢迎登录</a></div>
        <div class="login_head_right"><a href="{{ url('/register') }}">还没有账号？</a><a class="curc" href="{{ url('/register') }}">立即注册</a></div>
    </div>
</div>

<div class="login_bg">
    <form id="login_form"  method="post" action="{{ url('/login') }}">
        {!! csrf_field() !!}
	<div class="login_bg_box">
		<div class="login_bg_left">{!! $ad !!}</div>
        <div class="login_bg_right">
        	<h3>会员登录</h3>
            <div class="dl_box">
            	<div class="dl_text"><span><img src="{{asset(HOME_IMG.'login/icon01.png') }}"></span><i><input type="text" class="text" name="login" placeholder="用户名/手机/邮箱" value="{{old('login')}}"></i></div>
                <div class="dl_text"><span><img src="{{asset(HOME_IMG.'login/icon02.png') }}"></span><i><input type="password" class="text" name="password" placeholder="密码" value=""></i></div>

                <div class="dl_text">
                    <span style="width: 100px;"><img src="{{url('login/verify')}}" alt="验证码" onclick="this.src='{{url('login/verify')}}?'+Math.random()" style="cursor: pointer;margin-top: 0" class="J_codeimg"></span>
                   <i style="width:200px"><input type="text" class="text" name="verify" placeholder="验证码" maxlength="6"></i>
                </div>

                @if ($errors->has('login'))
                    <span class="help-block">
                         <strong>{{ $errors->first('login') }}</strong>
                    </span>
                @endif
                <div class="forget"><a href="{{ url('/password/reset') }}">忘记密码？</a></div>
                <div class="dl_btn"><a href="javascript:void(0)" onclick="check_form()">登录</a></div>
                <input type="hidden" id="ip_code">
            </div>
        </div>
    </div>
    </form>
</div>
@if($errors->has('login') && $errors->first('login')==trans('com.ip_not_allow'))
    <style>
        .layui-layer-content{overflow: hidden}
        .Validform_checktip{width: auto !important;text-align: left !important;}
    </style>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
    <div id="a1" style="display:none;">
        <div class="comp_left" style="float: none;margin: 50px auto;">
            <div class="cong">
                <div class="cong_right"><p>{{trans('com.ip_not_allow_alert')}}</p></div>
            </div>
            <div class="como_tab"><span>验证方式 :</span><a class="current" href="javascript:void(0)">手机验证</a><a href="javascript:void(0)">邮箱验证</a></div>
            <div class="reg">
                <form class="code_login_form" action="{{url('/login')}}" method="post">
                <div class="sd_tel" name="regbox">
                        {{csrf_field()}}
                        <div class="sd_text"><span>{{trans('com.phone_code')}}</span><i><input type="text" class="textt" placeholder="验证码" name="verify_mobileCode"  ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token())}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}"><input readonly id="btnSendCode" value="{{trans('com.get_phone_code')}}"></i>
                        </div>
                        <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmit" style="width: 200px;">{{trans('com.submit')}}</a></div>
                        <div class="sd_bg01">{{trans('com.phone_code_tip')}}</div>
                </div>


                <div class="sd_email" name="regbox">
                        <input type="hidden" name="uid" value="{{$errors->first('email')}}" readonly>
                        <div class="sd_text"><span>{{trans('com.email_code')}}</span><i><input type="text" class="textt"  name="verify_EmailCode" ajaxurl="{{url('/common/VerifyEmailCode?_token='.csrf_token().'&uid='.$errors->first('email'))}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}"><input readonly id="BtnEmailCode" value="{{trans('com.get_email_code')}}" onclick="get_email_code()"></i></div>
                        <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmit" style="width: 200px;">{{trans('com.submit')}}</a></div>
                        <div class="sd_bg02">{{trans('com.email_code_tip')}}</div>
                </div>
                </form>
            </div>
        </div>

    </div>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
<script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
    <script>
        function ip_code() {
            layer.open({
                type: 1,
                shade: false,
                area: ['590px', '415px'],
                title: false,
                content: $('#a1'),
                cancel: function(index){
                    layer.close($('#a1').hide());
                    this.content.show();
                }
            });
        }
        ip_code();

        $('#btnSendCode').sms({
            token       : "{{csrf_token()}}",
            interval    : 60,
            voice       : false,
            requestData : {
                mobile : function () {
                    return "{{$errors->first('telphone')}}";
                },
                mobile_rule : 'mobile_required'
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }
        });


        $(".code_login_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            ignoreHidden:true,
            postonce:true,
            callback:function(form) {
                form[0].submit();
                return false;
            }
            });
</script>
    <script>
        var InterValObj; //timer变量，控制时间
        var count = 60; //间隔函数，1秒执行
        var curCount;//当前剩余秒数
        function get_email_code() {
            var mail = "{{$errors->first('email')}}";
            InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
            $.post("{{url('/auth/send_reset_email')}}",{mail:mail,'_token':"{{csrf_token()}}"},function (msg) {
                curCount = count;
                $("#BtnEmailCode").attr("disabled", "true");
                $("#BtnEmailCode").css("background-color", "#d2ccc9");
                $("#BtnEmailCode").val(curCount);
                if(msg.status=='1'){
                    layer.msg(msg.info, {icon: 5});
                }else if(msg.status=='2'){
                    layer.msg(msg.info, {icon: 6});
                }else if(msg.status=='3'){
                    layer.msg(msg.info, {icon: 5});
                }
            })
        }
        /*防刷新：检测是否存在cookie*/
        if($.cookie("login_email_captcha")){
            var curCount = $.cookie("login_email_captcha");
            var btn = $('#BtnEmailCode');
            btn.val(curCount).attr('disabled',true).css('cursor','not-allowed');
            var resend = setInterval(function(){
                curCount--;
                if (curCount > 0){
                    btn.val(curCount).attr('disabled',true).css('cursor','not-allowed');
                    btn.css("background-color", "#d2ccc9");
                    $.cookie("captcha", count, {path: '/', expires: (1/86400)*curCount});
                }else {
                    clearInterval(resend);
                    btn.val("发送验证码").removeClass('disabled').removeAttr('disabled style');
                    btn.css("background-color", "#fff");
                }
            }, 1000);
        }
        //timer处理函数
        function SetRemainTime() {
            $.cookie("login_email_captcha", curCount, {path: '/login', expires: (1/86400)*curCount});
            if (curCount == 0) {
                window.clearInterval(InterValObj);//停止计时器
                $("#BtnEmailCode").removeAttr("disabled");//启用按钮
                $("#BtnEmailCode").css("background-color", "#fff");
                $("#BtnEmailCode").val("发送验证码");
            }
            else {
                curCount--;
                $("#BtnEmailCode").val(curCount);
            }
        }
    </script>

@endif
@include('layouts.footer')
<script>
    function check_form() {
        if($.trim($('input[name=login]').val())==''){
            $('input[name=login]').parent().parent().addClass('has-error')
            return false;
        }else{
            $('input[name=login]').parent().parent().removeClass('has-error')
        }
        if($.trim($('input[name=password]').val())==''){
            $('input[name=password]').parent().parent().addClass('has-error')
            return false;
        }else{
            $('input[name=password]').parent().parent().removeClass('has-error')
        }
        if($.trim($('input[name=verify]').val())==''){
            $('input[name=verify]').parent().parent().addClass('has-error')
            return false;
        }else{
            $('input[name=verify]').parent().parent().removeClass('has-error')
        }
        $('#login_form').submit();
    }
</script>