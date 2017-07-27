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
                <div class="fw_c"><span>更换绑定</span><p>在这里你可以更换手机</p></div>
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
                        <div class="bd_zt"><i>手机号码：</i>
                            <span>{{substr_replace($user['telphone'],'****',3,4)}}</span>
                        </div>
                        @if(isset($new) && $new=='1')
                            <form id="MemberFrm1" action="{{url('/user/changePhone')}}">
                                {{csrf_field()}}
                                <div class="bd_zt" style="height: 30px;"><i>新手机号码：</i><input type="text" class="text" name="new_phone" datatype="/^1[34578]\d{9}$/" errormsg="手机格式不正确"></div>

                                <div class="bd_zt" style="height: 30px;"><i>确认手机号码：</i><input type="text" class="text" name="r_phone" datatype="*" recheck="new_phone"  errormsg="两次输入的手机号不一致">
                                </div>
                                <div class="bd_zt"><input type="submit" class="submit"  value="提交" style="margin-left: 152px"></div>
                            </form>

                            @else
                            <form id="MemberFrm" method="post">
                                {{csrf_field()}}
                                <div class="bd_zt"><i>验证码：</i><input type="text" class="text" name="verifyCode" datatype="n6-6" errormsg="验证码格式不正确">
                                    <input  id="btnSendCode"  value="发送验证码" readonly="readonly" style="height: 25px;">
                                </div>
                                <div class="bd_zt"><input type="submit" class="submit"   value="提交"></div>
                            </form>

                            @endif

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
    <script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script>
        $('#btnSendCode').sms({
            //laravel csrf token
            //该token仅为laravel框架的csrf验证,不是access_token!
            token       : "{{csrf_token()}}",

            //请求间隔时间
            interval    : 60,

            //是否请求语音验证码
            voice       : false,

            //请求参数
            requestData : {
                //手机号
                mobile : function () {
                    return "{{$user['telphone']}}";
                },
                //手机号的检测规则
                mobile_rule : 'mobile_required'
                //定义服务器有消息返回时如何展示，默认为alert
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }

        });
        $("#MemberFrm").Validform({
            tiptype:3
        });
        $("#MemberFrm1").Validform({
            ajaxPost:true,
            callback:function(data){
                if(data.status=="y"){
                    $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                    layer.alert(data.info,{icon:6})
                    window.location.href = "{{url('/user/tel')}}";
                }else{
                    $.Showmsg(data.info);
                }
            }
        });



    </script>

@endsection