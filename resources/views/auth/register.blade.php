@extends('layouts.register')
@section('content')
    <style>
        .layui-layer-content{padding: 0 20px;}
    </style>
<div class="complete">
	 <ul>
		 <li class="active"><span>1</span><i>填写基本信息</i><div class="line"></div></li>
		 <li><span>2</span><i>完成注册</i><div class="line"></div></li>
		 <li><span>3</span><i>激活成功</i><div class="line"></div></li>
	 </ul>
</div>
<div class="comp">
	<div class="comp_left">
        @if(count($errors)>0)
            <div class="mark">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
            @if(session('msg'))
                <div class="mark">
                    <p>{{session('msg')}}</p>
                </div>
            @endif
        @endif
        <form action="{{ url('auth/postRegister') }}" method="POST" id="register_form">
            {!! csrf_field() !!}
    	<div class="comp_text"><span>用户名：</span><i><input type="text" class="text" name="name" value="{{ old('name') }}" datatype="s6-18"  nullmsg="请输入用户名！" errormsg="昵称至少6个字符,最多18个字符！"><em>6到18个字符，可带数字和下划线。</em></i></div>
        <div class="comp_text"><span>邮箱：</span><i><input type="text" class="text" name="email" value="{{ old('email') }}" datatype="e"  nullmsg="请输入邮箱地址！" errormsg="邮箱格式有误！"><em>邮箱将是以后验证的主要凭证</em></i></div>
        <div class="comp_text"><span>请设置密码：</span><i><input type="password" class="text" name="password" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"><em>6-20个字符，建议使用字母，数字或符号组合。</em></i></div>
        <div class="comp_text"><span>请确认密码：</span><i><input type="password" class="text" name="password_confirmation" datatype="*" recheck="password" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！"></i></div>
        <div class="comp_eck"><input type="checkbox" class="checkbox" name="" datatype="*"  nullmsg="请同意用户协议！"><span>我已阅读并同意</span><a href="javascript:show()">《搜付在线用户服务协议》</a></div>
        <div class="comp_btn"><a href="javascript:$('#register_form').submit()">下一步</a></div>
        </form>
    </div>
	<div class="comp_right">{!! $ad !!}</div>
</div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    function show() {
        //页面层
        layer.open({
            type: 1,
            title:'用户注册协议',
            skin: 'footer_text', //加上边框
            area: ['600px', '400px'], //宽高
            content: "{!! $register_news['content'] !!}"
        });
    }

    $("#register_form").Validform({

    });

</script>
@endsection

