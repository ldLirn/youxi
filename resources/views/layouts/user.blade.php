<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config("web.web_title")}}-个人中心</title>
    <link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'base.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'base.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(ORG.'uploadify/uploadify.css')}}">
    <script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
    <script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
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
    <div class="center_nav_box">
        <div class="center_nav_img"><a title="{{config('web.web_title')}}" href="{{web_url}}">
                <img alt="{{config('web.web_title')}}" src="{{asset(HOME_IMG.'login/logo.png') }}" /></a></div>
        <div class="center_nav_list"><a href="{{url('/all_game')}}">我要买</a><a href="{{url('/user/sell')}}">我要卖</a><a href="{{url('need')}}">求购交易</a><a href="{{url('help')}}">客服中心</a></div>
    </div>
</div>

@yield('content')

@include('layouts.footer')





