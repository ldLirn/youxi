@extends('layouts.register')
@section('content')
<div class="complete">
	 <ul>
		 <li class="active"><span>1</span><i>填写基本信息</i><div class="line"></div></li>
		 <li class="active"><span>2</span><i>完成注册</i><div class="line"></div></li>
		 <li><span>3</span><i>激活成功</i><div class="line"></div></li>
	 </ul>
</div>
<div class="comp">
	<div class="comp_lest">
    	<div class="cong">
            <div class="cong_img"><img src="{{asset(HOME_IMG.'login/icon03.png') }}"></div>
            <div class="cong_right"><h3>恭喜您注册成功</h3><p>激活邮箱已发送，请登录邮箱点击激活链接即可激活帐号。</p></div>
        </div>
        <div class="sond">
        	<p>用户名：{{$_GET['n']}}</p>
            <p>安全邮箱：{{$_GET['m']}}</p>
            <div class="ccs"><a href="{{url('/auth/register_success?m='.$_GET['m'].'&n='.$_GET['n'].'&c='.'')}}">点此更换邮箱</a>
                <a class="curn" href="{{url('/auth/register_success?m='.$_GET['a'].'&n='.$_GET['s'])}}">点此手机验证</a>
            </div>
        </div>
        <div class="cc_text">邮件的有效期为24小时，为了保证您及时收到邮件，请您将{{config('mail.username')}}添加到邮箱白名单中（如何添加？）。添加过后，请您点击重新发送邮件，我们将会再次为您发送。</div>

            <input type="hidden" name="m1" value="{{$_GET['m']}}">
            <input type="hidden" name="n1" value="{{$_GET['n']}}">
        <div class="cc_btn">
            <input onclick="get_email_code()" type="button" id="btnSendCode"  value="没收到？再次发送激活邮件" style="cursor: pointer">

            </div>

    </div>
    <div class="comp_right"><img src="{{asset(HOME_IMG.'login/zc_img.jpg') }}"></div>
</div>
<script>
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function get_email_code() {
        curCount = count;
        $("#btnSendCode").attr("disabled", "true");
        $("#btnSendCode").css("background-color", "#d2ccc9");
        $("#btnSendCode").val("没收到？请在" + curCount + "秒后重新提交");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
       $.post("{{url('auth/send_email')}}",{m1:"{{$_GET['m']}}",n1:"{{$_GET['n']}}",'_token':"{{csrf_token()}}"},function (msg) {
           if(msg.status=='1'){
               layer.msg(msg.info, {icon: 6});
           }else if(msg.status=='2'){
               layer.msg(msg.info, {icon: 5});
           }
       })
    }
    /*防刷新：检测是否存在cookie*/
    if($.cookie("captcha")){
        var curCount = $.cookie("captcha");
        var btn = $('#btnSendCode');
        btn.val("没收到？请在" + curCount + "秒后重新提交").attr('disabled',true).css('cursor','not-allowed');
        var resend = setInterval(function(){
            curCount--;
            if (curCount > 0){
                btn.val("没收到？请在" + curCount + "秒后重新提交").attr('disabled',true).css('cursor','not-allowed');
                btn.css("background-color", "#d2ccc9");
                $.cookie("captcha", count, {path: '/', expires: (1/86400)*curCount});
            }else {
                clearInterval(resend);
                btn.val("重新发送").removeClass('disabled').removeAttr('disabled style');
                btn.css("background-color", "#ff6600");
            }
        }, 1000);
    }
    //timer处理函数
    function SetRemainTime() {
        $.cookie("captcha", curCount, {path: '/', expires: (1/86400)*curCount});
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#btnSendCode").removeAttr("disabled");//启用按钮
            $("#btnSendCode").css("background-color", "#ff6600");
            $("#btnSendCode").val("重新发送");
        }
        else {
            curCount--;
            $("#btnSendCode").val("没收到？请在" + curCount + "秒后重新提交");
        }
    }
</script>
@endsection
