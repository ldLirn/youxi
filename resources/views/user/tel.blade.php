@extends('layouts.user')
@section('content')
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('tel') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>手机绑定</span><p>在这里你可以绑定更换手机</p></div>
            </div>
   			<div class="phone_bin">
            	<div class="phone_bin_top">
                	<div class="phone_left">
                        @if(count($errors)>0)
                            @foreach($errors->all() as $error)
                                <div class="bd_zt"><p style="color: red; text-align: center;">{{$error}}</p></div>
                            @endforeach
                        @endif
                        @if(session('msg'))
                                <div class="bd_zt"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
                        @endif
                        <div class="bd_zt"><i>手机绑定状态：</i>
                            <span>@if($user['is_check_phone']=='1')绑定成功@else未绑定@endif</span>
                        </div>
                        <form id="MemberFrm" method="post">
                            {{csrf_field()}}
                        @if($user['is_check_phone']=='1')
                        <div class="bd_zt"><i>当前绑定的手机号：</i><span>{{substr_replace($user['telphone'],'****',3,4)}}</span></div>
                            @else
                            <div class="bd_zt"><i>请输入手机号：</i><input type="text" style="border: 1px solid #999" class="text" name="telphone" datatype="/^1[34578]\d{9}$/">
                                <input  id="btnSendCode"  value="发送验证码" readonly="readonly" style="height: 25px;">
                            </div>
                         <div class="bd_zt" style="margin-top: 20px;float: left" id="yzm"><i style="float: left">手机验证码：</i><input type="text" class="text" name="verifyCode" datatype="n6-6" errormsg="验证码格式不正确" style="float: left"></div>
                                <div class="bd_zt"><input type="submit" class="submit"   value="提交" style="display: inline-block;margin-top: 20px;"></div>
                        @endif
                        </form>
                    </div>
                    @if($user['is_check_phone']=='1')
                    <div class="phone_right"><a href="{{url('/user/changePhone')}}">更换号码</a></div>
                    @endif
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
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
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

</script>
    <script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script>
        $('#btnSendCode').sms({
            token       : "{{csrf_token()}}",
            //请求间隔时间
            interval    : 60,
            //是否请求语音验证码
            voice       : false,
            //请求参数
            requestData : {
                //手机号
                mobile : function () {
                    return $('[name=telphone]').val();
                },
                //手机号的检测规则
                mobile_rule : 'mobile_required'
                //定义服务器有消息返回时如何展示，默认为alert
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }
        });
    </script>
@endsection