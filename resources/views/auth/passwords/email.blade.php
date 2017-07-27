@extends('layouts.register')
@section('content')
<div class="complete">

</div>
<div class="comp">
	<div class="comp_left">
    	<div class="cong">
                <div class="cong_right"><h3>找回密码</h3></div>
         </div>
        @if(session('msg'))
            <div class="bd_zt"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
        @endif
        <div class="como_tab"><span>验证方式 :</span><a  @if(!isset($_GET['m']))class="current"@endif href="{{url('password/reset')}}">手机验证</a><a href="{{url('password/reset?m=m')}}" @if(isset($_GET['m']))class="current"@endif>邮箱验证</a></div>
        <div class="reg">

            @if(isset($_GET['m']))
        <div class="sd_email" name="regbox" style="display: block">
            <form id="code_form" action="{{url('password/check_email_user')}}" method="post">
                {!! csrf_field() !!}
            <div class="sd_text"><span>用户名：</span><i><input type="text" class="text" name="name" placeholder="请输入您的用户名" datatype="s6-18"></i></div>
            <div class="sd_text"><span>绑定邮箱：</span><i><input type="text" class="text" name="email" placeholder="请输入您的邮箱" datatype="e"></i></div>
            <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmitNext">下一步</a></div>
            <div class="sd_bg02">{{trans('com.email_code_reset_tip')}}</div>
            </form>
        </div>
                @else
                <div class="sd_tel" name="regbox" >
                    <form id="code_phone_form" action="{{url('password/sf_reset')}}" method="post">
                        {!! csrf_field() !!}
                        <div class="sd_text"><span>手机：</span><i><input type="text" class="text" name="phone" placeholder="请输入您的手机号码" datatype="/^1[34578]\d{9}$/" errormsg="{{trans('com.error_phone')}}"></i></div>
                        <div class="sd_text"><span>手机验证码：</span><i><input type="text" class="textt" placeholder="验证码" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token())}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}"><input value="{{trans('com.get_phone_code')}}" readonly id="get_phone_code"></i></div>
                        <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmit">提交</a></div>
                        <div class="sd_bg01">{{trans('com.phone_code_reset_tip')}}</div>
                    </form>
                </div>
            @endif
       </div>
    </div>

</div>

<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script>

        $('#get_phone_code').sms({
            token       : "{{csrf_token()}}",
            interval    : 60,
            voice       : false,
            requestData : {
                mobile : function () {
                    return $('[name=phone]').val();
                },
                mobile_rule : 'check_mobile_exists'
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }
        });

        var InterValObj; //timer变量，控制时间
        var count = 60; //间隔函数，1秒执行
        var curCount;//当前剩余秒数
        function get_email_code() {
            var mail = $('[name=email]').val();
            var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
            if (!reg.test(mail)) {
                layer.msg("{{trans('com.error_email')}}", {icon: 5});
                return false;
            }
            layer.msg('发送中。。。', {icon: 16});
            var o_url = "{{url('/common/VerifyEmailCode?_token='.csrf_token())}}"+'&uid=';
            $('[name=yzm]').attr('ajaxurl',o_url);
            $.post("{{url('auth/send_reset_email')}}",{mail:mail,'_token':"{{csrf_token()}}"},function (msg) {
                if(msg.status=='1'){
                    layer.msg(msg.info, {icon: 5});
                }else if(msg.status=='2'){
                    var url = o_url+mail;
                    $('[name=yzm]').attr('ajaxurl',url);
                    curCount = count;
                    $("#btnSendCode").attr("disabled", "true");
                    $("#btnSendCode").css("background-color", "#d2ccc9");
                    $("#btnSendCode").val(curCount);
                    InterValObj = window.setInterval(SetRemainTime, 1000);
                    layer.msg(msg.info, {icon: 6});
                }else if(msg.status=='3'){
                    layer.msg(msg.info, {icon: 5});
                }
            })
        }
        /*防刷新：检测是否存在cookie*/
        if($.cookie("reset_pass_captcha")){
            var curCount = $.cookie("reset_pass_captcha");
            var btn = $('#btnSendCode');
            btn.val(curCount).attr('disabled',true).css('cursor','not-allowed');
            var resend = setInterval(function(){
                curCount--;
                if (curCount > 0){
                    btn.val(curCount).attr('disabled',true).css('cursor','not-allowed');
                    btn.css("background-color", "#d2ccc9");
                    $.cookie("reset_pass_captcha", count, {path: '/', expires: (1/86400)*curCount});
                }else {
                    clearInterval(resend);
                    btn.val("发送验证码").removeClass('disabled').removeAttr('disabled style');
                    btn.css("background-color", "#fff");
                }
            }, 1000);
        }
        //timer处理函数
        function SetRemainTime() {
            $.cookie("reset_pass_captcha", curCount, {path: '/', expires: (1/86400)*curCount});
            if (curCount == 0) {
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").css("background-color", "#fff");
                $("#btnSendCode").val("发送验证码");
            }
            else {
                curCount--;
                $("#btnSendCode").val(curCount);
            }
        }

        $("#code_phone_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            postonce:true,
            callback:function(form) {
                form[0].submit();
                return false;
            }
        });

        $("#code_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmitNext',
            ignoreHidden:true,
            postonce:true,
            callback:function(form) {
                form[0].submit();
                return false;
            }
        });
    </script>
@endsection