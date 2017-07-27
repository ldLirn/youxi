@extends('layouts.admin')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">{{config('web.web_title')}}后台管理系统</div>
			<ul>
				<li><a href="{{url('/')}}">前台首页</a></li>
				<li><a href="{{url('admin/start')}}">管理页</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：{{session('users.admin_name')}}</li>
				<li><a href="{{url('admin/power/edit_info')}}" target="main">个人资料</a></li>
				<li><a href="{{url('admin/power/edit_pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/logout')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
		@foreach($menu as $v)
			<li>
				<h3><i class="fa fa-fw {{$v->ico}}"></i>{{$v->name}}</h3>
				<ul class="sub_menu">
					@foreach($v->child as $m)
					<li><a href="{{url('admin/'.$m->url)}}" target="main"><i class="fa fa-fw {{$m->ico}}"></i>{{$m->name}}</a></li>
						@endforeach
				</ul>
			</li>
		@endforeach

		</ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/start')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2016. Powered By <a href="http://www.lushisky.com">炉石星空</a>.
	</div>
	<!--底部 结束-->

@endsection


