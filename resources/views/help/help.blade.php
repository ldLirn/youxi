@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
@section('content')

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
        <div class="Help_seach">
        	<div class="left_ds">您的位置：<span>帮助中心</span></div>
            <div class="right_ds"><span><input type="text" class="text"></span><a href="#">搜索</a></div>
        </div>
    </div>
    <div class="Help_box">
    	<div class="Help_left">
        	<h3>帮助中心</h3>
        	<dl>
                @foreach($menu as $k=>$v)
                <dt id="{{$v['id']}}"><span>{{$v['cat_name']}}</span><i><img src="{{asset(HOME_IMG.'center/help_img01.jpg')}}"></i></dt>
                @foreach($v['son'] as $n)
                <dd class="menu_{{$n['p_id']}}" style="display: none"><a href="{{url('/help/cate/'.$n['id'].'?menu='.$k)}}">{{$n['cat_name']}}</a></dd>
                @endforeach
                @endforeach
            </dl>
        </div>
        <div class="Help_right">
        	<div class="lc_box">
            	<div class="lc_ent"><h3>购买流程：</h3><span><img src="{{asset(HOME_IMG.'center/help_img03.jpg')}}"></span></div>
                <div class="lc_ent"><h3 class="curr">出售流程：</h3><span><img src="{{asset(HOME_IMG.'center/help_img04.jpg')}}"></span></div>
            </div>
            <div class="fica">
            	<h3>帮助信息分类</h3>
                @foreach($menu as $k=>$v)
                    @if(in_array($v['id'],[38,49,31,34]))
                <div class="guarantee">
                	<h4>{{$v['cat_name']}}</h4>
                    <div class="jst">
                        @foreach($v['son'] as $n)
                        <a  href="{{url('/help/cate/'.$n['id'].'?menu='.$k)}}">{{$n['cat_name']}}</a>
                        @endforeach
                    </div>
                </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection