@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">

@section('content')

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
        <div class="Help_seach">
        	<div class="left_ds">您的位置：<span>帮助中心->搜索结果</span></div>
            <form action="{{url('help/SearchArticle')}}" id="SearchArticle">
            <div class="right_ds"><span><input type="text" class="text" name="keywords" value="@if(isset($_GET['keywords'])){{$_GET['keywords']}}@endif"></span><a href="javascript:check_form()">搜索</a></div>
            </form>
            <script>
                function check_form(){
                    var keywords = $.trim($('[name=keywords]').val());
                    if(keywords==''){layer.msg('请输入搜索关键词')}else{$('#SearchArticle').submit();}
                }
            </script>
        </div>
    </div>
    <div class="Help_box">
    	<div class="Help_left">
        	<h3>帮助中心</h3>
        	<dl>
                @foreach($menu as $k=>$v)
                <dt id="{{$v['id']}}" @if(isset($_GET['menu']) && $k==$_GET['menu']) class="on" @endif><span>{{$v['cat_name']}}</span><i><img src="{{asset(HOME_IMG.'center/help_img01.jpg')}}"></i></dt>
                    @foreach($v['son'] as $n)
                        <dd class="menu_{{$n['p_id']}}" style="@if(isset($_GET['menu']) && $k==$_GET['menu']) display:block @else display:none @endif"><a href="{{url('/help/cate/'.$n['id'].'?menu='.$k)}}">{{$n['cat_name']}}</a></dd>
                    @endforeach
                @endforeach
            </dl>
        </div>
        <div class="Help_right">
            @if(isset($tag))
                <div class="content">
                    <div class="con_title">
                        <h1>{{$data['title']}}</h1>
                        <span>{{$data['created_at']}}</span>
                    </div>
                    <div class="text">
                        {!! $data['content'] !!}
                    </div>
                </div>
            @else
                <div class="content">
                    <ul class="helpList">
                        <li class="helpList_title">
                            <p class="que_title left">标题</p>
                            <p class="onclick left"></p>
                            <p class="date left">时间</p>
                        </li>
                        @foreach($data as $v)
                            <li>
                                <p class="que_title left"><a href="{{url('/help/detail/'.$v->id.'?cat='.$v->cat_id)}}">{!! $v->title !!}</a></p>
                                <p class="onclick left"></p>
                                <p class="date left">{{$v->created_at}}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</div>


@endsection