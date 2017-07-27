@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
@section('content')
<body>

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
    </div>
    <article class="nering">
        <section class="nering-t" style="margin-top: 20px">
            <div class="nering-t">
                <a class="left common help help-bj" href="{{url('/help/help')}}">帮助中心</a>
                <a class="left common ask ask-bj" href="{{url('/help/ask')}}">投诉咨询</a>
                <a class="left common safe safe-bj" href="{{url('/help/safe')}}">安全验证</a>
            </div>
        </section>
        <section class="nering-b">
            <div class="nering-b">
                <div class="nering-b-l left">
                    <a class="left zi" href="/Ask.html">
                        <div class="title">{{config('web.web_title')}}建议区</div>
                        <div class="wz">
                            <p>您对{{config('web.web_title')}}有任何建议、批评、想法，都可以在此反馈。我们将虚心聆听，认真改进，不断进步！ </p>
                            <p>欢迎您在此留下对{{config('web.web_title')}}的意见和建议！</p>
                        </div>
                    </a>
                    <a class="left DD DD-bj" href="{{web_url}}"></a>
                    <a class="left jy jy-bj" href="{{url('/help/ask')}}">发表建议</a>
                    <a class="left xiao xiao-bj" href="{{web_url}}"></a>
                    <a class="left tishi" href="{{url('/help/ask')}}">
                        <p>{{config('web.web_title')}}客服温馨提示：</p>
                        <p>
                            1.若您遇到紧急情况需要立即沟通，请致电我们的客服热线：{{TEL}}
                            <br>
                            2.客服热线电话均无外拨功能。
                            <br>
                            3.如遇电话正忙，请稍后再拨。若有不周敬请谅解，我们会尽快改善！
                        </p>
                    </a>
                </div>

                <div class="left yz">
                    <ul class="yz">
                        <li class="brank-bj mr-5"><a href="{{url('help/safe/Verification?tag=bank')}}" style="display:block; width:100px; height:100px"></a></li>
                        <li class="text"><a href="{{url('help/safe/Verification?tag=bank')}}">银行账户验证</a></li>
                        <li class="text mr-5"><a href="{{url('help/safe/Verification?tag=url')}}">网址验证</a></li>
                        <li class="ie-bj"><a href="{{url('help/safe/Verification?tag=url')}}" style="display:block; width:100px; height:100px"></a></li>
                        <li class="email-bj mr-5"><a href="{{url('help/safe/Verification?tag=mail')}}" style="display:block; width:100px; height:100px"></a></li>
                        <li class="text"><a href="{{url('help/safe/Verification?tag=mail')}}">邮箱验证</a></li>
                        <li class="QQ-bj"></li>
                        <li class="yz-bj"></li>
                    </ul>
                </div>
            </div>
        </section>
    </article>
</div>

@endsection

