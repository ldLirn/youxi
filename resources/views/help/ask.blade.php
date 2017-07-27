@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
@section('content')

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
        <div class="Help_seach">
        	<div class="left_ds">您的位置：<span>投诉咨询</span>@if(isset($_GET['type']) && in_array($_GET['type'],[1,2,3]))>><span>@if($_GET['type']==1)咨询@elseif($_GET['type']==2)建议@else投诉@endif</span>@endif</div>
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
        @if(isset($_GET['type']) && in_array($_GET['type'],[1,2,3]))
            <div class="complaints_left">
                <div class="service_content">
                    <h4 class="ts_type_h4">请选择@if($_GET['type']==1)咨询@elseif($_GET['type']==2)建议@else投诉@endif类型</h4>
                    <ul id="ts_typelist" class="select_tstype">
                        @foreach($type_next_data as $k=>$v)
                        <li>
                            <a href="{{url('/help/ask/'.$k.'?type='.$_GET['type'])}}">
                                <span class="til">{{$v['name']}}</span>
                                <div class="rd">
                                    <span class="text_201416">总数</span>
                                    <span class="num_201416">{{$v['num']}}</span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="complaints_left">
                <div class="wy"><a href="{{url('/help/ask?type=1')}}"><img src="{{asset(HOME_IMG.'center/complaints_img01.jpg')}}"></a><a href="{{url('/help/ask?type=3')}}"><img src="{{asset(HOME_IMG.'center/complaints_img02.jpg')}}"></a><a style="margin-right:0;" href="{{url('/help/ask?type=2')}}"><img src="{{asset(HOME_IMG.'center/complaints_img03.jpg')}}"></a></div>
                <div class="centage">
                    <div class="centage_top"><a href="{{url('/help/ask?t=1')}}"><span @if(FilterManager::isActive('t',1) || !isset($_GET['t'])) class="current"  @endif>咨询总量：{{$count_ask}}</span></a><a href="{{url('/help/ask?t=3')}}"><span @if(FilterManager::isActive('t',3)) class="current"  @endif>投诉总量：{{$count_complaint}}</span></a><a href="{{url('/help/ask?t=2')}}"><span @if(FilterManager::isActive('t',2)) class="current"  @endif style="border-right:0;">建议总量：{{$count_advise}}</span></a></div>
                    <ul>
                        @if(isset($_GET['t']))
                        @foreach($next[$_GET['t']] as $k=>$v)
                            <li><a href="{{url('/help/ask/list/'.$k.'?type='.$_GET['t'])}}" target="_blank"><span>{{$v['name']}}</span><i>{{$v['num']}}</i></a></li>
                        @endforeach
                            @else
                            @foreach($ask_next as $k=>$v)
                                <li><a href="{{url('/help/ask/list/'.$k.'?type=1')}}" target="_blank"><span>{{$v['name']}}</span><i>{{$v['num']}}</i></a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        @endif
            @include('layouts.ask_right')
    </div>
</div>


@endsection