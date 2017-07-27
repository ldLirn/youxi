@extends('layouts.register')
@section('content')
<div class="complete">
	 <ul>
		 <li class="active"><span>1</span><i>填写基本信息</i><div class="line"></div></li>
		 <li class="active"><span>2</span><i>完成注册</i><div class="line"></div></li>
		 <li class="active"><span>3</span><i>激活成功</i><div class="line"></div></li>
	 </ul>
</div>
<div class="comp">
	<div class="comp_lest">
    	<div class="cong">
            <div class="cong_img"><img src="{{asset(HOME_IMG.'login/icon03.png') }}"></div>
            <div class="cong_right"><h3>恭喜您激活成功</h3></div>
        </div>
        <div class="cc_btn"><a href="{{url('/login')}}">马上去登录</a></div>
    </div>
    <div class="comp_right"><img src="{{asset(HOME_IMG.'login/zc_img.jpg') }}"></div>
</div>
@endsection
