@extends('layouts.user')
@section('content')

<link href="{{asset(HOME_CSS.'sale.css') }}" rel="stylesheet" type="text/css" />
<div class="Sell">

    <div class="place clear_both">
        <p>我的位置：{!! Breadcrumbs::render('sell_select_game') !!}</p>
    </div>

    <div class="sale-process">
        <div class="wrap">
            <div class="icon1 icon left"></div>
            <div class="line-red left"></div>
            <div class="icon2 icon left"></div>
            <div class="line-grey left"></div>
            <div class="icon3 icon left"></div>
        </div>
        <div class="text">
            <p class="text1">选择商品分类</p>
            <p class="text2">发布商品并委托{{config('web.web_title')}}出售</p>
            <p>买家支付,{{config('web.web_title')}}立即给您汇款</p>
        </div>
    </div>
    {{--<div class="searchtab">--}}
        {{--<div class="tabnet">网络游戏</div>--}}
        {{--<div class="tabmobile" onclick="window.location.href = '{{url('/sy')}}';">手机游戏</div>--}}
    {{--</div>--}}
    <div class="quick_search" style="border: 1px solid #c4dcec;">
        <div class="txt"></div>
        <ul>
            <li class="h"><strong>您经常的选择是：</strong></li>
            <li>
                <div class="q_input" id="sell_history_title">
                    <span class="q_input2 left" id="sell_history_memo">请选择</span>
                    <em class="arrow_box left">
                        <s class="black_arrow"></s>
                    </em>
                </div>
                <ul class="q_input_content" id="sell_history">
                </ul>
            </li>
            <li class="del" id="del_history">清除选择</li>
        </ul>
    </div>
    <div class="way" style="position:relative;">
        <div class="jytip" style="display:none;" id="jc-tsk" top="-82px">
            <div class="cont">
                <div>
                    <strong>寄售交易：</strong>您需提供出货的帐号，将商品寄放在该帐号内，当商品被订购后，客服会登陆您的帐号，替您和买家完成交易。
                    <p><a target="_blank" href="">详细说明</a></p>
                    <p><a target="_blank" href="">收费标准</a></p>
                </div>
                <div class="arrow">
                    <em></em>
                    <span style=""></span>
                </div>
            </div>
        </div>
        <div class="jytip" style="display:none;top:-15px;" id="db-tsk">
            <div class="cont">
                <div>
                    <strong>担保交易：</strong>无需提供游戏帐号信息，买家购买后，客服会立即联系您发货。
                    <p><a target="_blank" href="">详细说明</a></p>
                    <p><a target="_blank" href="">收费标准</a></p>
                </div>
                <div class="arrow">
                    <em></em>
                    <span style=""></span>
                </div>
            </div>
        </div>

        <div class="SGameType">
            <div class="Box">
                <div class="Bitem" id="GameDiv">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div>
                    </div>
                </div>
                <div class="Bitem" id="TypeDiv" style="display:none;">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div></div>
                </div>
                <div class="Bitem" id="TypeCateDiv" style="display:none;">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div></div>
                </div>
                <div class="Bitem" id="DealDiv" style="display:none;">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div></div>
                </div>
                <div class="Bitem" id="AreaDiv" style="display:none;">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div></div>
                </div>
                <div class="Bitem" id="ServerDiv" style="display:none;">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div></div>
                </div>
                <br class="clear_both">
            </div>
        </div>
    </div>

    <div class="nonce_nav">
        <span class="jiantou"></span>
        <span class="text">您当前的选择是：<span class="SelectGame text" id="buttom_text"></span></span>
    </div>
    <form action="" method="post" id="nextFrom">
        <input type="text" name="HG" id="HG" style="display:none">
        <input type="text" name="G" id="G" style="display:none">
        <input type="text" name="T" id="T" style="display:none">
        <input type="text" name="TP" id="TP" style="display:none">
        <input type="text" name="TPC" id="TPC" style="display:none">
        <input type="text" name="IsJh" id="IsJh" style="display:none">
        {{csrf_field()}}
        <div style="text-align:center;">
            <div class="button" id="nextdiv" style="display:inline-block;">
                <a>好了，继续发布</a>
            </div>
        </div>
    </form>
    <div style="display:none;">
        <input id="reqobj" type="hidden" data-t="" data-game="" data-area="" data-server="" data-type="" data-stype="">
    </div>
</div>
<script type="text/javascript" src="{{asset(HOME_JS.'Sell.js')}}"></script>
<script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
@endsection