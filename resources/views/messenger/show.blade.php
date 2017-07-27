@extends('layouts.user')
@section('content')
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('messages') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>站内信详细</span><p>在这里你看到信箱信息的详细内容</p></div>
            </div>

            <div class="basic">

            	<div class="basic_text"><span>消息内容：</span>
					<p style="padding-top: 7px">{{$data['notify_body']}}</p>
				</div>
                <div class="basic_text"><span>发送时间：</span>
					<p style="padding-top: 7px">{{$data['created_at']}}</p>
				</div>

				<div class="basic_text"><button onclick='window.location.href="{{url('/user/messages')}}"'>返回列表</button></div>
            </div>

        </div>
    </div>
</div>

@endsection