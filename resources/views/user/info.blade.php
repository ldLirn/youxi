@extends('layouts.user')
@section('content')
<script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_info') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>修改基本信息</span><p>个性化的昵称，可减少登录用户名的泄露，提升账号安全线，快来完善！</p></div>
            </div>
			<form method="post" id="MemberFrm" class="form" enctype="multipart/form-data" action="{{url('/user/info')}}">
            <div class="basic">
				@if(count($errors)>0)
					@foreach($errors->all() as $error)
						<div class="basic_text"><p style="color: red; text-align: center;">{{$error}}</p></div>
					@endforeach
				@endif
					@if(session('msg'))
							<div class="basic_text"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
					@endif
            	<div class="basic_text"><span>安全邮箱：</span>
					<input type="text" class="text" value="{{substr_replace($user['email'],'****',3,4)}}" readonly="readonly" style="border: none;" >
					@if($user['is_check_email']=='1')<i>您的邮箱已通过安全验证</i>@else <i class="red" onclick='window.location.href="{{url('/user/BindEmail')}}"'>马上去验证</i> @endif
				</div>
                <div class="basic_text"><span>QQ号码：</span>
					<input type="text" class="text" value="{{$user['qq']}}"  name="qq"  style="ime-mode:disabled"  datatype="n4-13" errormsg="qq格式不正确" nullmsg="请填写QQ号">
				</div>
                <div class="basic_text"><span>手机号码：</span>
					<input type="text" class="text" value="@if($user['is_check_phone']=='1'){{substr_replace($user['telphone'],'****',3,4)}}@else{{$user['telphone']}}@endif" name="telphone"  @if($user['is_check_phone']=='0')datatype="/^1[34578]\d{9}$/"@else readonly="readonly" @endif   errormsg="手机格式不正确" nullmsg="请填写手机号">
					@if($user['is_check_phone']=='0')<input onclick="valid_yz()" id="btnSendCode" style="display: none" value="发送验证码" readonly="readonly">@else<i>您已绑定手机号</i>@endif</div>
					@if($user['is_check_phone']=='0')<div class="basic_text" style="display: none" id="yzm"><span>手机验证码：</span><input type="text" class="text" name="verifyCode" datatype="n6-6"  errormsg="验证码格式不正确"　nullmsg="请输入验证码"><i>请输入手机验证码</i></div>@endif
                <div class="basic_text"><span>会员头像：</span>
					<em>
						<img src="@if($user['head_img']!=''){{$user['head_img']}}@else{{asset(HOME_IMG.'center/name_img.png')}}@endif" id="art_img" style="max-width: 100px">
						<input type="hidden" value="@if($user['head_img']!=''){{$user['head_img']}}@else{{(HOME_IMG.'center/name_img.png')}}@endif" name="thumb" id="thumb" datatype="*"/>
					</em>
					<a class="curr" href="javascript:void(0)"><input id="file_upload" name="file_upload" type="file" multiple="false"></a>
				</div>
				<div class="basic_text"><button>提交</button></div>
            </div>
				{{csrf_field()}}
			</form>
			<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
			<script type="text/javascript">
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
					$("input[name='qq']").keydown(function(e) {
						digitInput($(this), e);
					});
					$("#MemberFrm").Validform({
						tiptype:3,
						ignoreHidden:true,
						callback:function(form){
							layer.prompt({
								title: "{{$user['question']}}",
								formType: 1 //prompt风格，支持0-2
							}, function(pass){
								$.post("{{url('/user/check_answer')}}",{answer:pass,'_token':"{{csrf_token()}}"},function (msg) {
									if(msg.status=='1'){
										form[0].submit();
									}else{
										layer.alert(msg.info);
									}
								})
							});

							return false;
						}

					});

				});
				$('input[name=telphone]').bind("input propertychange",function () {
					$('input[name=telphone]').removeClass('Validform_error');
					var phone = $('input[name=telphone]').val()
					if(!/^1[34578]\d{9}$/.test(phone)){
						$("#btnSendCode").css("display", "none");
						$("#yzm").css("display", "none");
						$('input[name=telphone]').addClass('Validform_error');
						return false;
					}else {
						$("#btnSendCode").css("display", "block");
						$("#yzm").css("display", "block");
					}
				})

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
					},
					alertMsg : function (msg, type) {
						alert(msg);
					}
				});
			</script>
			<div class="Infor">
            	<table>
               		 <thead>
                  		<tr>
                      		<th>账号安全信息</th>
                      		<th>账号安全信息</th>
                      		<th>状态</th>
                      		<th>操作</th>
                  		</tr>
                        <tr>
                      		<td class="blod">登陆密码</td>
                      		<td>英文加数字或符号的组合密码，安全性更高，建议您定期更换密码</td>
                      		<td>已设置</td>
                      		<td><a href="{{url('/user/reset_pass')}}">立即修改</a></td>
                  		</tr>
                        <tr>
                      		<td class="blod">密码提示问题</td>
                      		<td>设置后用于密码找回、修改个人信息等，让您的信息更安全。</td>
                      		<td>@if($user['answer']=='')未@else已@endif设置</td>
                      		<td><a href="{{url('/user/question')}}">立即@if($user['answer']=='')设置@else修改@endif</a></td>
                  		</tr>
                        <tr>
                      		<td class="blod">手机绑定</td>
                      		<td>账户有资金相关操作时，将向您的手机免费发送验证码及重要操作提示。</td>
                      		<td>@if($user['is_check_phone']=='0')未@else已@endif设置</td>
                      		<td><a href="{{url('/user/tel')}}">查看详情</a></td>
                  		</tr>
                        <tr>
                      		<td class="blod">邮箱验证</td>
                      		<td>用于密码找回、邮件订阅服务等，验证完成后，将提升账户安全等级。</td>
                      		<td>@if($user['is_check_email']=='0')未@else已@endif设置</td>
							<td><a href="{{url('/user/EditEmail')}}">立即@if($user['is_check_email']=='0')验证@else修改@endif</a></td>
                  		</tr>
                         <tr>
                      		<td class="blod">IP绑定</td>
                      		<td>用于判断登录地址,登录时保护您的账户安全。</td>
							 <td>@if($user['bind_ip']=='')未@else已@endif设置</td>
							 <td><a href="{{url('/user/bind_ip')}}">立即@if($user['bind_ip']=='')绑定@else修改@endif</a></td>
                  		</tr>
               		 </thead>
                  </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
	<script type="text/javascript">
		<?php $timestamp = time();?>
        $(function() {
			$('#file_upload').uploadify({
				'buttonText':'更换头像',
				'removeTimeout':0,
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'_token'     :"{{csrf_token()}}"
				},
				'fileTypeDesc' : 'Image Files',
				'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
				'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
				'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
				'uploader' : '{{url('/img/upload')}}',
				'onUploadSuccess' : function(file, data, response) {
					$('#art_img').attr('src',data);
					$('#thumb').val(data);
				},
				'overrideEvents': ['onSelectError', 'onDialogClose'],
				//返回一个错误，选择文件的时候触发
				'onSelectError': function (file, errorCode, errorMsg) {
					switch (errorCode) {
						case -100:
							alert("上传的文件数量已经超出系统限制的" + $('#file_upload').uploadify('settings', 'queueSizeLimit') + "个文件！");
							break;
						case -110:
							alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload').uploadify('settings', 'fileSizeLimit') + "大小！");
							break;
						case -120:
							alert("文件 [" + file.name + "] 大小异常！");
							break;
						case -130:
							alert("文件 [" + file.name + "] 类型不正确！");
							break;
					}
					return false;
				},

				//检测FLASH失败调用
				'onFallback': function () {
					alert("您未安装FLASH控件，无法上传！请安装FLASH控件后再试。");
				}
			});

		});
	</script>
@endsection