@extends('layouts.safe_header')
@section('content')
    <style>
        .Help{margin-bottom: 20px;}
    </style>
<div class="Help">
    <div class="Help_nav">
        <div class="Help_nav_box">
            @foreach($nav as $v)
            <a href="{{url('/help/safe/news/list/'.$v['id'])}}">{{$v['cat_name']}}</a>
            @endforeach
        </div>
    </div>

    <section class="safeyz">
        <div class="safeyz-r left">
            <form id="checkform" action="{{url('/help/safe/test')}}" method="post">
            <div id="check_content">
                <ul id="check_ul">
                    <li><a class="qq  @if(FilterManager::isActive('tag','qq') || !isset($_GET['tag'])) hover @endif" href="{{url('help/safe/Verification?tag=qq')}}"><span class="wz">客服验证</span></a></li>
                    <li><a class="exmail @if(FilterManager::isActive('tag','mail')) hover @endif" href="{{url('help/safe/Verification?tag=mail')}}"><span class="wz">邮箱验证</span></a></li>
                    <li><a class="ie @if(FilterManager::isActive('tag','url')) hover @endif" href="{{url('help/safe/Verification?tag=url')}}"><span class="wz">网址验证</span></a></li>
                    <li><a class="brank @if(FilterManager::isActive('tag','bank')) hover @endif" href="{{url('help/safe/Verification?tag=bank')}}"><span class="wz">银行账户验证</span></a></li>
                </ul>
                <div class="qq-ner" style="display: @if(FilterManager::isActive('tag','qq') || !isset($_GET['tag'])) block @else none @endif;">
                    <div class="title">
                        <p>QQ号码必须输入，建议进入QQ资料中获取。</p>
                    </div>
                    <div class="kuang">
                        <div class="hao">QQ号码：<input class="text-input" type="text" value="@if(isset($_GET['qq']) && $_GET['qq']!=''){{$_GET['qq']}}@endif"  name="qq" maxlength="13" datatype="/^[1-9]\d{4,16}$/" errormsg="{{trans('com.error_qq')}}"></div>
                    </div>
                    <div class=""><a class="red_btn">立即验证</a>
                    </div>

                    <div class="tip" id="qq_result"> <span id="msgdemo" style="margin-left:30px;"></span></div>
                    <div class="tip red" style="font-size:14px;font-weight:bold;">友情提醒：请谨防受骗！</div>
                </div>
                <div class="qq-ner" style="display: @if(FilterManager::isActive('tag','mail')) block @else none @endif;">
                    <div class="title">
                        <p>请输入邮箱地址（包含@及后缀），可为你验证DD373的系统邮件真伪。</p>
                    </div>
                    <div class="wrap">
                        <div class="exmail">邮箱地址：<input class="text-input " name="email" id="email" maxlength="40" type="text" datatype="e"></div>
                    </div>
                    <div class=""><a class="red_btn" href="javascript:;">立即验证</a></div>
                    <div class="tip" id="email_result"> <span id="msgdemo" style="margin-left:30px;"></span></div>
                    <div class="tip red" style="font-size:14px;font-weight:bold;">友情提醒：仅供DD373的系统邮件真伪使用，不作为客服身份验证依据！</div>
                </div>
                <div class="qq-ner" style="display: @if(FilterManager::isActive('tag','url')) block @else none @endif;">
                    <div class="title">
                        <p>请输入网址，可为你验证访问网站的真伪。</p>
                    </div>
                    <div class="wrap">
                        <div class="exmail">输入网址：<input class="text-input " name="url" id="url" maxlength="100" type="text" datatype="url"></div>
                    </div>
                    <div class=""><a class="red_btn">立即验证</a></div>
                    <p id="redtn" style="display: none"></p>
                    <div class="tip" id="url_result"> <span id="msgdemo" style="margin-left:30px;"></span></div>
                    <div class="tip red" style="font-size:14px;font-weight:bold;">友情提醒：仅供验证您访问的DD373网站的真伪使用，不作为客服身份验证依据！</div>
                </div>
                <div class="qq-ner" style="display: @if(FilterManager::isActive('tag','bank')) block @else none @endif;" >
                    <div class="title">
                        <p>输入银行账户，确保位数正确。</p>
                    </div>
                    <div class="wrap">
                        <div class="exmail">银行账户：<input class="text-input " name="bank" id="bank" maxlength="30" type="text" datatype="n15-24" errormsg="{{trans('com.error_bank')}}"></div>
                        {{csrf_field()}}
                    </div>
                    <div><a class="red_btn">立即验证</a></div>
                    <div class="tip" id="bank_result"> <span id="msgdemo" style="margin-left:30px;"></span></div>
                    <div class="tip red" style="font-size:14px;font-weight:bold;">友情提醒：仅供银行柜台充值时验证银行账号使用，不作为客服身份验证依据！</div>
                </div>
            </div>
            </form>
        </div>
        <div class="safeyz-l left">
            <div class="Anti-fraud">
                <div class="title" style="height: 100px;background: #e8b976;color:#fff;text-align: center;line-height: 100px;font-size: 18px;cursor: pointer">查看假客服列表</div>
                <div class="title" style="height: 180px;background: #416d8a;color:#fff;text-align: center;font-size: 16px;margin-top: 20px;padding: 60px 0">
                    <p style="line-height: 50px;"> 已列入</p>
                <p>1200个假客服QQ</p>
                <p>80个假客服举报正在受理中</p>
                </div>
            </div>

        </div>
        <div class="safeyz-l left">
            <div class="Anti-fraud">
                <div class="title">常见问题</div>
                <div class="nering">
                    <ul>
                        @foreach($recommend as $v)
                        <li><a href="{{url('/help/safe/news/detail/'.$v->id)}}">{{$v->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </section>
<div class="clear_both"></div>
</div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $("#checkform").Validform({
        tiptype:function(msg,o,cssctl){
            if(!o.obj.is("form")){
                var objtip=o.obj.siblings(".Validform_checktip");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }else{
                var objtip=o.obj.find("#msgdemo");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }
        },
        ignoreHidden:true,
        btnSubmit:'.red_btn',
        ajaxPost:true,
    });
    @if(isset($_GET['qq']) && is_numeric($_GET['qq']))
        $('.red_btn').click();
    @endif
</script>
@endsection