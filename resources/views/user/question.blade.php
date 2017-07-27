@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('question') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>@if($user['question']=='')设置@else修改@endif密保问题</span><p>在这里你可以@if($user['question']=='')设置@else修改@endif密保问题</p></div>
            </div>
            <div class="password_box">
                <form action="" method="post" id="MemberFrm">
            	<div class="password_main">
                    @if(session('msg'))
                        <div class="password_text"><a>{{session('msg')}}</a></div>
                    @endif
                    @if($user['question']!='')
                	<div class="password_text"><span>原密保问题：</span><input type="text" class="text" value="{{$user['question']}}" readonly="readonly"></div>
                    <div class="password_text"><span>原密保答案：</span><input type="text" name="answer"  class="text" datatype="*" nullmsg="必填"><a href="{{url('/user/ForgetAnswer')}}">忘记密保答案</a></div>
                    @endif
                    <div class="password_text"><span>密保问题：</span>
                        <select name="n_question">
                            <option value="您最喜欢的游戏是什么?">您最喜欢的游戏是什么?</option>
                            <option value="您的出生地是？">您的出生地是？</option>
                            <option value="您的暗号?">您的暗号?</option>
                        </select>
                    </div>
                    <div class="password_text"><span>密保答案：</span><input type="text" class="text" name="n_answer" datatype="*" nullmsg="必填"></div>
                    <div class="password_btn"><button href="javascript:void(0)" id="btn">提交</button></div>
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