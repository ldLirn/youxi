@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
@section('content')
    <style>
        .helpList{width: 750px;}
    </style>
<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
        <div class="Help_seach">
        	<div class="left_ds">您的位置：<span>投诉咨询</span>>><span>搜索结果</span></div>
            <form action="{{url('help/SearchArticle')}}" id="SearchArticle">
                <input type="hidden" name="tag" value="ask">
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
    <div class="complaints">

            <div class="complaints_left">
                <div class="content">
                    <ul class="helpList">
                        <li class="helpList_title">
                            <p class="que_title left" style="text-align: center;">
                                标题
                            </p>
                            <p class="onclick left" style="width:200px;margin:0 10px 0 10px;text-align: center;">
                                处理时间
                            </p>
                        </li>
                        @foreach($data as $v)
                            <li>
                                <p class="que_title left">
                                    <a href="{{url('/help/ask/detail/'.$v['id'].'?type='.$v['type_id'])}}">{!! $v['ask_title'] !!}</a>
                                </p>
                                <p class="date left">{{date('Y-m-d H:i:s',$v['ask_time'])}}</p>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="page">
                    {{$data->links()}}
                </div>
            </div>

        @include('layouts.ask_right')
    </div>
</div>


@endsection