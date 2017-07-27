<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config("web.web_title")}}-安全中心</title>
    <link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'base.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'safe.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'base.js') }}"></script>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
</head>

<body>
<div class="center_top">
    <div class="center_top_box">
        @if (Auth::guest())
            <div class="center_top_left"><span>您好！</span><span>请 <a href="{{ url('/login').'?redirectUrl='.url()->full() }}">登录</a></span><span><a href="{{url('/register')}}">免费注册</a></span></div>
        @else
            <div class="center_top_left"><span>您好！</span><span> <a href="{{url('/user')}}">{{ Auth::user()->name }}</a></span><span><a href="{{ url('/logout') }}">退出</a></span></div>
        @endif
    </div>
</div>

<div class="center_nav">
    <div class="center_nav_box clear_both">
        <div class="center_nav_img"><a title="{{config('web.web_title')}}" href="{{web_url}}">
                <img alt="{{config('web.web_title')}}" src="{{asset(HOME_IMG.'login/logo.png') }}" /></a></div>
        <div class="center_nav_list"><a href="{{url('/help')}}">客服服务</a><a href="{{url('/help/safe/news/list')}}">安全知识中心</a><a href="{{url('user')}}">帐号安全</a><a href="{{url('/help/safe/Verification')}}" style="border-right: none">验证中心</a></div>
    </div>
</div>

@yield('content')

@include('layouts.footer')

