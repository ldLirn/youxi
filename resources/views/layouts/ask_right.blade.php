<div class="complaints_right">
    <div class="service">
        <h3>我的服务记录</h3>
        <div class="service_jl">
            @if (Auth::guest())
                <span>请<a href="{{url('/login/?redirectUrl='.url()->full())}}">登录</a>，查看全部服务记录</span>
            @else
                <span>您好！</span><span> <a href="{{url('/user')}}">{{ Auth::user()->name }}</a></span><span>&nbsp;&nbsp;&nbsp;</span><span><a href="{{ url('/logout') }}">退出</a></span>
            @endif
        </div>
        <div class="service_da"><span>我的咨询记录：</span><i><a href="{{url('/help/ask/MyList/1')}}">{{$ask['ask']}}</a></i></div>
        <div class="service_da"><span>我的投诉记录：</span><i><a href="{{url('/help/ask/MyList/3')}}">{{$ask['complaint']}}</a></i></div>
        <div class="service_da"><span>我的建议记录：</span><i><a href="{{url('/help/ask/MyList/2')}}">{{$ask['advise']}}</a></i></div>
        <div class="service_btn"><a href="{{url('/help/ask/type')}}">我要提问</a></div>
    </div>
    <div class="service">
        <h3>自助服务</h3>
        <ul>
            <li><i><img src="{{asset(HOME_IMG.'center/ccc01.jpg')}}"></i><a href="{{url('/user/unbindPhone')}}">手机绑定解除</a></li>
            <li><i><img src="{{asset(HOME_IMG.'center/ccc03.jpg')}}"></i><a href="{{url('/user/AbnormalCapital')}}">资金异常核对</a></li>
            <li><i><img src="{{asset(HOME_IMG.'center/ccc04.jpg')}}"></i><a href="{{url('/user/EditEmail')}}">注册邮箱修改</a></li>
            <li><i><img src="{{asset(HOME_IMG.'center/ccc05.jpg')}}"></i><a href="{{url('/user/AccountName')}}">修改开户名</a></li>
        </ul>
    </div>
</div>