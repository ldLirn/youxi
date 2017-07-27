@extends('layouts.safe_header')
@section('content')
<div class="Help">
    <div class="Help_nav">
        <div class="Help_nav_box">
            @foreach($nav as $v)
            <a href="{{url('/help/safe/news/list/'.$v['id'])}}">{{$v['cat_name']}}</a>
            @endforeach
        </div>
    </div>

<div class="main">
    <div class="mainbox">
        <div class="con-biaoti left">
            @if(!isset($tag))
                <ul class="helpList">
                    <li class="helpList_title">
                        <p class="que_title left">标题</p>
                        <p class="onclick left">类别</p>
                        <p class="date left">时间</p>
                    </li>
                    @foreach($list as $v)
                    <li>
                        <p class="que_title left"><a href="{{url('/help/safe/news/detail/'.$v->id)}}">{{$v->title}}</a></p>
                        <p class="onclick left">
                            <a href="{{url('/help/safe/news/list/'.$v->cat_id)}}">
                               {{$v->cat_name}}
                            </a>
                        </p>
                        <p class="date left">{{$v->created_at}}</p>
                    </li>
                    @endforeach
                </ul>
                <div class="page">
                    {{$list->links()}}
                </div>
            @else
                <div class="con-text">
                    <p class="title"><strong>{{$data['title']}}</strong></p>
                    <p>发布时间：{{$data['created_at']}}</p>
                    <p>
                    </p>
                    <p style="margin-top: 10px; margin-bottom: 10px; line-height: 1.75em; text-indent: 2em;">
                      {!! $data['content'] !!}
                    </p>
                    <p>
                        <a class="return" id="assort_170" href="javascript:window.location=history.go(-1)">返回列表</a>
                    </p>
                </div>
            @endif
        </div>
        <div class="sidebox left">
            <div class="yanzheng left">
                <ul>
                    <li><a class="text a1" href="{{url('help/safe/Verification?tag=bank')}}">银行账户验证</a></li>
                    <li><a class="text a2" href="{{url('help/safe/Verification?tag=url')}}">网址验证</a></li>
                    <li><a class="text a3" href="{{url('help/safe/Verification?tag=mail')}}">邮箱验证</a></li>
                    <li><a class="text a4" href="{{url('help/safe/Verification?tag=qq')}}">客服验证</a></li>
                </ul>
            </div>
            <div class="study left">
                <div class="title"><strong>常见问题</strong></div>
                <div class="nering">
                    <ul>
                        @foreach($recommend as $v)
                        <li><a href="{{url('/help/safe/news/detail/'.$v->id)}}">
                                {{$v->title}} </a>
                        </li>
                         @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>

</div>
    <div class="clear_both"></div>
</div>


@endsection