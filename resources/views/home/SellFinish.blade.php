
@extends('layouts.home')
@section('content')
    <style>
        .sure{ width:956px; height:280px; background-color:#fffaf4; border:1px solid #e5e9ea; margin-top:15px;margin: 0 auto}
        .sure .success .wz{ width:500px; margin:10px 0px 0px 120px; border-bottom:1px dotted #e3e7e9; height:54px;}
        .sure .success .icon{ display:block; background-position:-450px -105px; width:56px; height:56px;}
        .sure .success .zi{ font-size:14px; color:#494848; margin:20px 0px 0px 10px; display:block;}
        .sure .pro_message{ margin:10px 0px 0px 120px;}
        .sure .pro_message .leftside{width:15px; height:167px;}
        .sure .pro_message .ner{  width:680px; height:163px; }
        .sure .pro_message .ner .top{ width:665px; height:95px; border-bottom:1px dashed #c9c9c9;}
        .sure .pro_message .ner .top .left_wz{ width:142px; height:90px; padding-left:10px;}
        .sure .pro_message .ner .top .left_wz .s{ margin-left:15px; margin-top:25px; width:125px; height:20px;}
        .sure .pro_message .ner .top .left_wz .d a{ color:#499dd7; text-decoration:underline;}
        .sure .pro_message .ner .top .right_wz ul{ margin-top:10px;}
        .sure .pro_message .ner .top .right_wz ul li{ line-height:25px; float:none}
        .sure .pro_message .ner .bottom .text{ display:block; margin-top:25px; margin-left:15px;}
        .sure .pro_message .ner .bottom a{ display:block; margin:22px 0px 0px 20px; height:24px;color:#fff; line-height:24px; text-align:center; }
        .sure .pro_message .ner .bottom a.jixu{ width:100px; background-color:#ea9721;}
        .sure .pro_message .ner .bottom a.qita{ width:123px; background-color:#079eed;}
        .sure .pro_message .ner .bottom a.sousuo{ width:113px; background-color:#8d7ec3;}
        .safeclass{ width:958px; height:320px; border:2px solid #e6e9ea; margin-top:20px;}
        .safeclass .title{ width:120px; height:47px; background-position:-565px -106px; margin:20px 0px 0px 50px;}
        .safeclass .text1{ font-size:16px; width:340px; text-indent:2em; line-height:32px; font-family:"å¾®è½¯é›…é»‘"; color:#8e8e8d; margin:20px 0px 0px 60px;}
        .safeclass .text2{ color:#70706e; font-size:16px; font-family:"å¾®è½¯é›…é»‘"; margin:40px 0px 0px 60px;}
        .safeclass .text2 a{ text-decoration:underline; color:#519ccf;}
        .safeclass .cartoon{ width:530px; height:300px; border:1px solid #cfcfcf; margin:10px 0px 0px 10px;}
        .safeclass .cartoon .tp01{ width:260px; border-right:1px solid #cfcfcf;}
        .safeclass .cartoon .tp02{ width:260px; padding-left:8px; height:142px;}
        .safeclass .cartoon .tp03{ width:252px; border-right:1px solid #cfcfcf; border-top:1px solid #cfcfcf;}
        .safeclass .cartoon .tp04{ width:268px; border-top:1px solid #cfcfcf;}
    </style>
    <div class="sure" style="height:380px;">
        <div class="success">
            <div class="wz">
                <span class="icon left"></span>
                <span class="zi left"><strong>您出售的求购商品已经发布成功，请等待客服交易。</strong></span>
            </div>
        </div>
        <div class="pro_message">
            <div class="left leftside"></div>
            <div class="left ner">
                <div class="top">
                    <div class="left left_wz">
                        <span class="s left"><strong>求购信息：</strong></span>
                    </div>
                    <div class="left right_wz">

                        <ul>
                            <li>求购编号：{{session('need_info.need_code')}} </li>
                            <li>求购名称：{{session('need_info.need_name')}}</li>
                            <li>游戏区服：{{session('need_info.need_game')}}</li>
                        </ul>
                    </div>
                </div>
                <div class="top">
                    <div class="left left_wz">
                        <span class="s left"><strong>出售信息：</strong></span>
                    </div>
                    <div class="left right_wz">
                        <ul>
                            <li>商品编号：{{session('need_info.sell_code')}} </li>
                            <li>游戏区服：{{session('need_info.need_game')}}</li>
                        </ul>
                    </div>
                </div>
                <div class="bottom">
                    <span class="left text">您还可以：</span>
                    <a class="jixu left" href="{{url('/need')}}" >继续出售求购商品</a>
                    <a class="qita left" href="{{url('/user/SellOrder')}}" >查看订单</a>
                </div>
            </div>
        </div>
    </div>
@endsection