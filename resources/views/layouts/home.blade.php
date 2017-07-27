<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('web.web_title')}}</title>
    <link href="{{asset(HOME_CSS.'base.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'shop.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'public.js') }}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'slide.js') }}"></script>
    <script type="text/javascript" src="{{asset(HOME_JS.'base.js') }}"></script>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
</head>
<body>
<div class="top_tips" id="toptips"><div class="top_box"><div style="display: @if(config('web.topNews')!='')block@else none @endif;" class="top_news"><div class="icons icon_tip1 left"></div><div class="left"><a target="_blank" href="">{{config('web.topNews')}}</a></div><a title="关闭提示，不再提醒" id="toptips_btn" class="icons icon_close right"></a></div></div></div>
<div class="center_top">
    <div class="center_top_box">
        @if (Auth::guest())
        <div class="center_top_left"><span>您好！</span><span>请 <a href="{{ url('/login').'?redirectUrl='.url()->full() }}">登录</a></span><span><a href="{{url('/register')}}">免费注册</a></span></div>
        @else
            <div class="center_top_left"><span>您好！</span><span> <a href="{{url('/user')}}">{{ Auth::user()->name }}</a></span><span><a href="{{ url('/logout') }}">退出</a></span></div>
        @endif
        <div class="center_top_right">

            <a href="{{url('/user/money/recharge')}}">充值 丨</a>
            <a href="{{url('/user/money/Withdrawal')}}">提现 丨</a>
            @foreach($topnav as $k=>$v)

            <span name="{{$v['nav_url']}}">{{$v['nav_name']}}<em></em> 丨</span>

            <div class="sd0{{$num++}}">
                @foreach($v['child'] as $n)
                <a href="{{web_url.'/'.$n['nav_url']}}">{{$n['nav_name']}}</a>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
<header>
    <link href="{{asset(HOME_CSS.'tanchu.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset(HOME_JS.'gamesearch.js') }}"></script>
    <section class="w_1000 header_box clearfix">
        <input type="hidden" name="baseurl" id="baseurl" value="{{web_url}}">
        <section class="header_box">
            <h1 class="logo left"><a title="{{config('web.web_title')}}" href="{{web_url}}">
                    <img alt="{{config('web.web_title')}}" src="{{asset(HOME_IMG.'login/logo.png') }}" /></a>
            </h1>
            <div class="search SearchBig right">
                <div class="tab_menu" id="search_change" ref="#">
                    <div class="left">
                        <a id="search_gj" ref="gj" class="gj_red" href="javascript:void(0);">高级搜索</a>
                    </div>
                    <div class="left">
                        <a id="search_bt" ref="bt" class="pt" href="javascript:;">普通搜索</a>
                    </div>
                </div>
                <div class="tab_box clearfix"  id="select_div_gj">
                    <ul id="select_ul">
                        <li id="game" class="name arrow" ref="游戏名称" ref1="游戏名称">游戏名称</li>
                        <li id="area" class="area arrow" ref="游戏区" ref1="游戏平台">游戏区</li>
                        <li id="server" class="server arrow" ref="游戏服务器" ref1="运营商">游戏服务器</li>
                        <li id="kind" class="type arrow" ref="全部分类" ref1="游戏区服">全部分类</li>
                        <li id="trade" class="all arrow" ref="所有商品" ref1="全部分类">所有商品</li>
                        <li class="search_item"><input id="search_input_gj" class="search_input" placeholder="请输入商品编号" type="text" /></li>
                    </ul>
                    <div class="button"><a id="search_button_gj" class="left" href="">搜 索</a></div>
                </div>
                <div class="blue_box clearfix" style="display:none;" id="select_div_pt">
                    <ul class="pt-search">
                        <li class="text"><input id="search_input_bt" class="search-box left" placeholder="请输入商品编号" type="text" /></li>
                    </ul>
                    <div class="button_blue right"><a id="search_button_bt" class="left" href="">搜 索</a></div>
                </div>
                <div class="hot-search">
                    <ul>
                        @foreach($hot_keywords as $k=>$v)
                        <li><a href="{{url('/category/'.Hashids::encode($k))}}" target="_blank">{{$v}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
        <div id="game_select" style="display: none;">
            <s id="searchbar_arrow"  class="game_select_arrow"></s>
            <div id="gsBox" class="gs_box" style="display: block;">
                <div class="gs_box_inner">
                    <div class="gs_head clearfix">
                        <dl class="gs_name">
                            <dt id="gs_title">
                                历史选择：
                            </dt>
                            <dd id="gs_history"></dd>
                        </dl>
                        <a id="game_select_close" href="javascript:;" title="关闭窗口" class="close_btn">关闭窗口</a>
                    </div>
                    <div id="quick_div" class="gs_f_search">
                        <a id="quick_btn_back" class="gs_back_btn" href="javascript:void(0);" >返回</a>
                        <input id="quick_input" type="text" class="gs_f_search_box gs_f_search_box_default" placeholder="请输入游戏关键字" />
                        <a id="quick_btn" href="javascript:;" class="gs_f_search_btn">快速搜索</a>
                        <a class="nfqf" href="{{url('help/ask/5?type=2')}}" target="_blank">找不到游戏、区服？</a>
                    </div>
                    <div id="gpcontent"></div>
                </div>
            </div>
        </div>
    </section>
</header>

@yield('content')

@include('layouts.footer')