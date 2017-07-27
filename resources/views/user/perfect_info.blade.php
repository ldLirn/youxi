@extends('layouts.user')
@section('content')
<script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('perfect_info') !!}</div>
    <div class="center_box">

        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>完善信息</span><p>提升账号安全性，快来完善！</p></div>
            </div>
			<form method="post" id="MemberFrm" class="form">
            <div class="basic">
				@if(count($errors)>0)
					@foreach($errors->all() as $error)
						<div class="basic_text"><p style="color: red; text-align: center;">{{$error}}</p></div>
					@endforeach
				@endif
					@if(session('msg'))
							<div class="basic_text"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
					@endif
            	<div class="basic_text"><span>支付密码：</span>
					<input type="password" class="text" name="pay_password" value=""  datatype="s6-20" errormsg="{{trans('home.s6-20')}}">
					<i>长度6-20位，字母区分大小写</i>
				</div>
				<div class="basic_text"><span>确认支付密码：</span>
					<input type="password" class="text" name="comfirm_password" value="" datatype="*"  recheck="pay_password">
				</div>
					<div class="basic_text"><span>密保问题：</span>
						<select name="question" class="text" style="height: 30px;width: 282px ">
							@foreach(trans('question') as $v)
							<option value="{{$v}}">{{$v}}</option>
							@endforeach
						</select>
						<i>请牢记您的密码提示问题和答案,重要</i>
					</div>
					<div class="basic_text"><span>密保答案：</span>
						<input type="text" class="text" name="answer" value=""  datatype="*">
					</div>
                <div class="basic_text"><span>QQ号码：</span>
					<input type="text" class="text" value="{{$user['qq']}}"  name="qq"  style="ime-mode:disabled"  datatype="n4-13" errormsg="{{trans('com.error_qq')}}" nullmsg="{{trans('com.no_qq')}}">
					<i>请正确输入您的QQ号码</i>
				</div>
                <div class="basic_text"><span>绑定手机：</span>
					<input type="text" class="text" value="@if($user['is_check_phone']=='1'){{substr_replace($user['telphone'],'****',3,4)}}@else{{$user['telphone']}}@endif" name="telphone"  @if($user['is_check_phone']=='0')datatype="/^1[34578]\d{9}$/"@else readonly="readonly" @endif   errormsg="{{trans('com.error_phone')}}" nullmsg="{{trans('com.no_phone')}}">
					@if($user['is_check_phone']=='0')<input  id="btnSendCode"  value="发送验证码" readonly="readonly">@else<i>您已绑定手机号</i>@endif</div>
					@if($user['is_check_phone']=='0')<div class="basic_text"  id="yzm"><span>手机验证码：</span><input type="text" class="text" name="verify_mobileCode" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" datatype="n6-6"  errormsg="{{trans('com.error_code')}}"　nullmsg="{{trans('com.no_code')}}"><i>{{trans('com.no_code')}}</i></div>@endif

				<div class="basic_text"><button>{{trans('com.submit')}}</button></div>
            </div>
				{{csrf_field()}}
			</form>


            </div>
        </div>
    </div>
</div>

<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
<script>
	$('#btnSendCode').sms({
		token       : "{{csrf_token()}}",
		interval    : 60,
		voice       : false,
		requestData : {
			//手机号
			mobile : function () {
				return $('[name=telphone]').val();
			},
			mobile_rule : 'check_mobile_unique'
		},
		alertMsg : function (msg, type) {
			alert(msg);
		}
	});

	$("#MemberFrm").Validform({
		tiptype:3,
		ignoreHidden:true,
		postonce:true,
		ajaxPost:true,
		callback:function(data){
			if(data.status=="y"){
				setTimeout(function(){
					layer.msg(data.info);
					window.location.href="{{$_GET['redirectUrl']}}";
				},1000);
			}else{
				$.Hidemsg();
				layer.alert(data.info,{icon: 6});
			}
		}

	});
</script>

@endsection