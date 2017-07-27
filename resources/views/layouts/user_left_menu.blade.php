<div class="center_left">
    <div class="name_box">
        <div class="name">用户名：<span>{{$user['name']}}</span></div>
        <div class="name_img"><img src="@if($user['head_img']!=''){{$user['head_img']}}@else{{asset(HOME_IMG.'center/name_img.png')}}@endif"></div>
        <div class="exit"><a href="{{url('/logout')}}">安全退出</a></div>
    </div>
    <div class="sidebar">
        <dl>
            <dt class="current @if(FilterManager::isActive('menu',100)) on  @endif"><i><img src="{{asset(HOME_IMG.'center/sidebar_img01.png') }}"></i><span>我是买家</span><em>+</em></dt>
            <dd><a href="{{url('/all_game?menu=100')}}">我要买</a></dd>
            <dd><a href="{{url('/needsPublish?menu=100')}}">我要求购</a></dd>
            <dd><a href="{{url('/user/dk?menu=100')}}">我购买的点卡</a></dd>
            <dd><a href="{{url('/user/goods?menu=100')}}">我购买的商品</a></dd>
            <dd><a href="{{url('/user/needs?menu=100')}}">我发布的求购</a></dd>
            <dd><a href="{{url('/user/needsOrder?menu=100')}}">我的求购订单</a></dd>
            <dd><a href="{{url('/user/changePrice?menu=100')}}">我的求降价申请</a></dd>
            <dd><a href="{{url('/user/address?menu=100')}}">我收货信息管理</a></dd>
            <dd><a href="#">我购买的商城点劵</a></dd>
        </dl>
        <dl>
            <dt @if(FilterManager::isActive('menu',101)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img02.png') }}"></i><span>我是卖家</span><em>+</em>  </dt>
            <dd><a href="{{url('/user/sell?menu=101')}}" target="_blank">我要出售</a></dd>
            <dd><a href="{{url('/user/MySell?menu=101')}}">我发布的商品</a></dd>
            <dd><a href="{{url('/user/SellOrder?menu=101')}}">我出售的商品</a></dd>
            <dd><a href="{{url('/user/sell/changePriceInfo?menu=101')}}">求降价申请管理</a></dd>

        </dl>

        <dl>
            <dt @if(FilterManager::isActive('menu',102)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img04.png') }}"></i><span>账户信息</span><em>+</em>  </dt>
                <dd><a href="{{url('/user/info?menu=102')}}">基本信息</a></dd>
                <dd><a href="{{url('/user/IDCard?menu=102')}}">实名认证</a></dd>
                 <dd><a href="{{url('/user/bindBank?menu=102')}}">银行卡管理</a></dd>
                <dd><a href="{{url('/user/tel?menu=102')}}">手机绑定</a></dd>
                <dd><a href="{{url('/user/ip?menu=102')}}">IP绑定</a></dd>
                <dd><a href="{{url('/user/EditPayPass?menu=102')}}">修改支付密码</a></dd>
                <dd><a href="{{url('/user/reset_pass?menu=102')}}">修改登录密码</a></dd>
                <dd><a href="{{url('/user/question?menu=102')}}">修改密保问题</a></dd>

        </dl>
        <dl>
            <dt @if(FilterManager::isActive('menu',103)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img05.png') }}"></i><span>资金管理</span><em>+</em>  </dt>
                <dd><a href="{{url('/user/money/recharge?menu=103')}}">我要充值</a></dd>
                <dd><a href="{{url('/user/money/Withdrawal?menu=103')}}">我要提现</a></dd>
                <dd><a href="{{url('/user/money/info?menu=103')}}">资金明细</a></dd>

        </dl>
        <dl>
            <dt @if(FilterManager::isActive('menu',104)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img06.png') }}"></i><span>积分中心</span><em>+</em>  </dt>
            <dd><a href="{{url('/exchange')}}">积分商城</a></dd>
            <dd><a href="{{url('/user/integral?menu=104')}}">积分明细</a></dd>
            <dd><a href="{{url('/user/exchange/list?menu=104')}}">积分兑换</a></dd>
        </dl>
        <dl style="position: relative">
            <dt @if(FilterManager::isActive('menu',105)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img07.png') }}"></i><span>消息中心</span>@if($user['messages']>0)<div class="mail_num"><span class="num">{{$user['messages']}}</span></div><em>+</em>@endif </dt>
            <dd><a href="{{url('/user/messages?menu=105')}}">站内信</a></dd>

        </dl>
        <dl>
            <dt @if(FilterManager::isActive('menu',106)) class="on"  @endif><i><img src="{{asset(HOME_IMG.'center/sidebar_img08.png') }}"></i><span>异常申请</span><em>+</em>  </dt>
            <dd><a href="{{url('/user/AbnormalCapital/list?menu=106')}}">资金异常申请</a></dd>
            <dd><a href="{{url('/user/EditEmail/list?menu=106')}}">修改邮箱申请</a></dd>
            <dd><a href="{{url('/user/AccountName/list?menu=106')}}">修改开户名申请</a></dd>
            <dd><a href="{{url('/user/unbindPhone/list?menu=106')}}">手机解绑申请</a></dd>
            <dd><a href="{{url('/user/unlocked/list?menu=106')}}">账号解封申请</a></dd>
        </dl>

        <dl>
            <dt><i><img src="{{asset(HOME_IMG.'center/sidebar_img10.png') }}"></i><span>咨询投诉</span><em>+</em>   </dt>
            <dd><a href="{{url('help/ask/MyList/1')}}">我的问题</a></dd>
            <dd><a href="{{url('help/ask?type=1')}}">我要咨询</a></dd>
            <dd><a href="{{url('help/ask?type=3')}}">我要投诉</a></dd>
            <dd><a href="{{url('/user/')}}">举报假客服</a></dd>
        </dl>
        <dl>
            <dt><i><img src="{{asset(HOME_IMG.'center/sidebar_img11.png') }}"></i><span>帮助中心</span><em>+</em>  </dt>
            <dd><a href="{{url('help/cate/35?menu=8')}}">如何出售</a></dd>
            <dd><a href="{{url('help/cate/32?menu=7')}}">如何购买</a></dd>
            <dd><a href="{{url('help/cate/33?menu=7')}}">如何求购</a></dd>
            <dd><a href="{{url('help/cate/41?menu=5')}}">如何充值</a></dd>
            <dd><a href="{{url('help/cate/39?menu=0')}}">如何提现</a></dd>
        </dl>
    </div>
</div>

<script>
    $(function(){
        $('dl dt.on').siblings('dd').show().parent('dl').siblings('dl').find('dd').hide();
    })
</script>