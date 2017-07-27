@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
@section('content')
<body>

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
    </div>
    <div class="box1000 m_t_10 clear_both">
        <div class="zx_location">您的位置：<a href="{{url('/help')}}">客服中心首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<span>选择问题类型</span></div>
        <div class="service_content">
            <ul class="select_type">
                <li><span class="select_txt"></span></li>
                <li class="select_zx"><a href="{{url('/help/ask?type=1')}}"></a></li>
                <li class="select_ts"><a href="{{url('/help/ask?type=2')}}"></a></li>
                <li class="select_jy"><a href="{{url('/help/ask?type=3')}}"></a></li>
            </ul>
        </div>
    </div>
</div>

@endsection

