@extends('layouts.user')
@section('content')

<div class="content">
    <div class="center_title">我的位置：{!! Breadcrumbs::render('user') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="certification">
            	<div class="sdk">
                	<div class="sdk_text user_ner_l"><span class="_realName">用户认证：</span>
                        <a class="@if($user['is_check_datecard']=='1')realName @else realName-grey @endif" href="" title="实名认证"></a>
                        <a class="@if($user['back_bd_img']!='')identity @else identity-grey @endif" href="" title="身份认证"></a>
                        <div class="clear_both"></div>
                    </div>
                    <div class="sdk_text"><span>买家信用：<img src="{{$buy_rank['rank_img']}}" alt="{{$buy_rank['rank_name']}}" title="{{$buy_rank['rank_name']}}"> </span><span>卖家信用：<img src="{{$sell_rank['rank_img']}}" alt="{{$sell_rank['rank_name']}}" title="{{$sell_rank['rank_name']}}"></span></div>
                    <div class="sdk_text"><span class="current">作为买家成交笔数：<i>{{$buy_sum}}</i></span><span class="current">作为卖家成交笔数：<i>{{$sell_sum}}</i></span></div>
                    <div class="sdk_text">上次登录ip：<em>{{$user['last_ip']}}</em></div>
                    <div class="sdk_text">上次登陆时间：<em>{{date('Y-m-d H:i:s',$user['last_login'])}}</em></div>
                </div>
                <div class="sdk_bg"></div>
                <div class="skk">
                	<div class="amount">账户总金额：<span>{{number_format(($user['money']+$user['frozen_money']),2)}}</span>元<a href="{{url('/user/money/info')}}">查看详情</a></div>
                    <div class="amount">账户可用金额：<span>{{$user['money']}}</span>元<a href="{{url('/user/money/info')}}">查看详情</a></div>
                    <div class="amount">锁定资金金额：<span>{{$user['frozen_money']}}</span>元<a href="{{url('/user/money/info')}}">查看详情</a></div>
                    <div class="amount">可提现金额：<span>{{$user['money']}}</span>元<a href="{{url('/user/money/info')}}">查看详情</a></div>
                    <div class="amount_btn"><a href="{{url('/user/money/recharge')}}">充值</a><a class="curent" href="{{url('/user/money/Withdrawal')}}">提现</a></div>
                </div>
            </div>
            <div class="audit">
            	<div class="audit_left">
                	<div class="audit_left_top">
                    	<div class="audit_img"><img src="{{asset(HOME_IMG.'center/icon02.png') }}"></div>
                        <div class="aud">
                        	<div class="stars"><i>{!! $str['str'] !!}</i><b>{{$str['fs']}}</b><span>分</span></div>
                            <p>您的账号还可以提升安全级别，建议按照体检结果进行操作</p>
                        </div>
                    </div>
                    <ul>
                    	<li><i><img src="{{asset(HOME_IMG.'center/audit_01.png') }}"></i><b>登录密码</b><span>状态：已设定</span><a href="{{url('user/reset_pass')}}">立即修改</a></li>
                        <li><i><img src="{{asset(HOME_IMG.'center/audit_02.png') }}"></i><b>密保问题</b><span>状态：@if($user['answer']!='')已设定@else未设定@endif</span><a href="{{url('user/question')}}">@if($user['answer']!='')立即修改@else立即设定@endif</a></li>
                        <li><i><img src="{{asset(HOME_IMG.'center/audit_03.png') }}"></i><b>手机绑定</b><span>状态：@if($user['is_check_phone']=='1')已绑定@elseif($user['is_check_phone']=='0')未绑定@endif</span><a href="{{url('user/tel')}}">查看详情</a></li>
                        <li><i><img src="{{asset(HOME_IMG.'center/audit_04.png') }}"></i><b>邮箱绑定</b><span>状态：@if($user['is_check_email']=='1')已绑定@elseif($user['is_check_email']=='0')未绑定@endif</span><a href="{{url('user/EditEmail')}}">@if($user['is_check_email']=='1')修改绑定@elseif($user['is_check_email']=='0')立即绑定@endif</a></li>
                        <li style="border-bottom:0;"><i><img src="{{asset(HOME_IMG.'center/audit_05.png') }}"></i><b>IP绑定</b><span>状态：@if($user['bind_ip']!='')已绑定@else未绑定@endif</span><a href="{{url('user/ip')}}">@if($user['bind_ip']!='')查看详情@else立即绑定@endif</a></li>
                    </ul>
                </div>
                <div class="audit_right">
                	<div class="hot_bg"></div>

                </div>
            </div>
            <div class="remind">
            	<div class="remind_left">
                	<div class="remind_left_top">安全交易提醒</div>
                    <div class="validation">
                    	<div class="newsst">
                            @foreach($recommend as $v)
                            <a href="{{url('help/safe/news/detail/'.$v['id'])}}">{{$v['title']}}</a>
                            @endforeach
                        </div>
                        <div class="dation">
                            <a href="{{url('help/safe/Verification?tag=qq')}}"><img src="{{asset(HOME_IMG.'center/dation_img01.jpg') }}"></a>
                            <a href="{{url('help/safe/Verification?tag=url')}}"><img src="{{asset(HOME_IMG.'center/dation_img02.jpg') }}"></a>
                            <a href="{{url('help/safe/Verification?tag=mail')}}"><img src="{{asset(HOME_IMG.'center/dation_img03.jpg') }}"></a>
                            <a href="{{url('help/safe/Verification?tag=bank')}}"><img src="{{asset(HOME_IMG.'center/dation_img04.jpg') }}"></a>
                        </div>
                    </div>
                </div>
                <div class="remind_right">
                	<div class="remind_left_top">点卡充值</div>
                    <div class="up">
                    	<div class="up_box"><span>游戏：</span><select class="select"><option>DOTA2</option></select></div>
                        <div class="up_box"><span>充值面额：</span><select class="selecct"><option>15元</option></select></div>
                         <div class="up_text">价格：<span>14.95</span>元</div>
                         <div class="up_btn"><a href="#">立即充值</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
