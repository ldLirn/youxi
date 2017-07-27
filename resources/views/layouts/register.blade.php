<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config("web.web_title")}}-注册</title>
    <link href="{{asset(HOME_CSS.'base.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'login.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset(ADMIN_JS.'jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
</head>

<body>
<div class="registered_head">
    <div class="registered_head_box">
        <div class="registered_head_left"><a href="{{web_url}}"><img src="{{asset(HOME_IMG.'login/logo.png') }}"></a><a class="curr" href="#">欢迎注册</a></div>
        <div class="registered_head_right"><a href="{{url('/login')}}">我已注册</a><a href="{{url('/login')}}">现在就</a><a class="curc" href="{{url('/login')}}">登录</a></div>
    </div>
</div>


@yield('content')



@include('layouts.footer')