@extends('layouts.register')
@section('content')
<script type="text/javascript" src="{{asset(HOME_JS.'base.js')}}"></script>
<style>
    .Validform_wrong{
       color: red !important;
        width: auto !important;
    }
    .Validform_checktip{
        width: auto !important;
    }
</style>
<div class="complete">
	 <ul>
		 <li class="active"><span>1</span><i>填写基本信息</i><div class="line"></div></li>
		 <li class="active"><span>2</span><i>完成注册</i><div class="line"></div></li>
		 <li><span>3</span><i>激活成功</i><div class="line"></div></li>
	 </ul>
</div>
<div class="comp">
	<div class="comp_left">
            <div class="cong">
            	<div class="cong_img"><img src="{{asset(HOME_IMG.'login/icon03.png') }}"></div>
                <div class="cong_right"><h3>恭喜您注册成功</h3><p>您的账户需要安全验证后才能激活</p></div>
         </div>
        <div class="como_tab"><span>验证方式 :</span><a  @if(!isset($_GET['c']))class="current"@endif href="javascript:void(0)">手机验证</a><a href="javascript:void(0)" @if(isset($_GET['c']))class="current"@endif>邮箱验证</a></div>
        <div class="reg">

        <div class="sd_tel" name="regbox" @if(isset($_GET['c']))style="display: none;" @endif>
            <form id="phone_form" action="{{url('auth/send_phone_code')}}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="m" value="{{$_GET['m']}}">
                <input type="hidden" name="n" value="{{$_GET['n']}}">
        	<div class="sd_text"><span>手机：</span><i><input type="text" class="text" name="phone" placeholder="请输入您的手机号码"  datatype="/^1[34578]\d{9}$/" ></i></div>
            <div class="sd_text"><span>手机验证码：</span><i><input type="text" class="textt" placeholder="验证码" name="verify_mobileCode" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}"><a href="javascript:void(0)" id="btnSendCode">{{trans('com.get_phone_code')}}</a></i>
            </div>
            <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmit">提交</a></div>
            <div class="sd_bg01">系统向您的手机发送验证码，输入验证码后即可激活账号！</div>
            </form>
        </div>


        <div class="sd_email" name="regbox" @if(isset($_GET['c']))style="display: block;" @endif>
            <form id="code_form" action="{{url('auth/send_email')}}" method="post">
                {!! csrf_field() !!}
                @if(isset($_GET['c']))
            <div class="sd_text"><span>邮箱：</span><i><input type="text" class="text" name="email" placeholder="请输入您的邮箱"></i></div>
                    <input type="hidden" name="n" value="{{$name}}">
                    <input type="hidden" name="m" value="">
                    <input type="hidden" name="c" value="t">
                @else
                    <input type="hidden" name="m" value="{{$_GET['m']}}">
                    <input type="hidden" name="n" value="{{$_GET['n']}}">
                @endif
            <div class="sd_btn"><a href="javascript:get_email_code()">提交</a></div>
            <div class="sd_bg02">系统向您的邮箱发送邮件，点击链接即可激活账号！</div>
            </form>
        </div>

       </div>
    </div>
    <div class="comp_right">{!! $ad !!}</div>
</div>
    <script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
    <script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script>
        $("#phone_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            postonce:true,
            ajaxPost:true,
            callback:function(data){
                if(data.status=="y"){
                    setTimeout(function(){
                        $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                        window.location.href="{{url('/login')}}";
                    },1000);
                }
            }
        });

        $('#btnSendCode').sms({
            token       : "{{csrf_token()}}",
            interval    : 120,
            voice       : false,
            requestData : {
                mobile : function () {
                    return $('[name=phone]').val();
                },
                mobile_rule : 'check_mobile_unique'
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }
        });
        function get_email_code() {
            @if(isset($_GET['c']))
                var e = $('[name=email]').val();
                var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                if(!reg.test(e))
                {
                    layer.msg("{{trans('com.error_email')}}");
                    return false;
                }
            $.post("{{url('/common/VerifyEmailUnique')}}",{e:e,"_token":"{{csrf_token()}}"},function (msg) {
                       if(msg.status=='1'){
                           $('[name=m]').val(msg.info);
                           layer.msg('发送中。。。', {icon: 16});
                           $('#code_form').submit();
                       }else{
                           layer.msg(msg.info);
                       }
                })
            @else
            layer.msg('发送中。。。', {icon: 16});
            $('#code_form').submit();
            @endif
        }
    </script>
@endsection