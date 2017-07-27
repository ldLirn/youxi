@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('reset_pass') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>修改支付密码</span><p>在这里你可以修改您的支付密码</p></div>
            </div>
            <div class="password_box">
                <form id="MemberFrm" action="{{url('/user/EditPayPass/update')}}" method="post">
            	<div class="password_main">
                	<div class="password_text"><span>原支付密码：</span><input type="password" class="text" maxlength="20" name="o_password"  datatype="*6-16" nullmsg="请输入密码！"
                                                                         errormsg="密码范围在6~20位之间！" ajaxurl="{{url('/user/check_old_pass?_token='.csrf_token().'&t=1')}}"></div>
                    <div class="password_text"><span>新支付密码：</span><input type="password" name="password" maxlength="20" class="text" datatype="*6-16" nullmsg="请输入密码！" errormsg="密码范围在6~20位之间！"></div>
                    <div class="password_text"><span>密码强度：</span>
                      <div class="passstrength"></div>
                    </div>
                    <div class="password_text"><span>确认新密码：</span><input type="password" class="text" name="password_confirmation" datatype="*" recheck="password" nullmsg="请再输入次密码！" errormsg="您两次输入的账号密码不一致！"></div>
                    <div class="password_btn"><button>提交</button></div>
                    {{csrf_field()}}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $("#MemberFrm").Validform({
        tiptype:3,
    });
</script>
@endsection