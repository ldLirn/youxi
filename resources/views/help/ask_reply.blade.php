@extends('layouts.home')
<link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
@section('content')

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
        <div class="Help_seach">
        	<div class="left_ds">您的位置：<span>投诉咨询</span>@if(isset($_GET['type']) && in_array($_GET['type'],[1,2,3]))>><span>@if($_GET['type']==1)咨询@elseif($_GET['type']==2)建议@else投诉@endif</span>@endif>><span>{{$cate}}列表</span>>><span>{{$data['ask_title']}}</span> </div>
        </div>
    </div>
    <div class="complaints">
        @if(isset($_GET['type']) && in_array($_GET['type'],[1,2,3]))
            <div class="complaints_left">
                <div class="content">
                    <div class="wt-list">
                        <div class="nering">
                            <p class="n_title">{{$data['ask_title']}}</p>
                            <p class="grey">
                                提问时间：{{date('Y-m-d H:i:s',$data['ask_time'])}}

                            </p>
                            <p class="wz">{{$data['ask_content']}}</p>
                        </div>
                    </div>
                    <div class="hf-list">
                        <div class="title">
                                <span class="left">
                                        客服回复
                            </span>
                        </div>
                        <div class="nering">
                            <p class="wz">
                                尊敬的客户：<br>

                                欢迎光临{{config('web.web_title')}}客服中心
                            </p>
                            <div class="wz line">
                                <p>{{$data['answer']}}</p>
                            </div>
                            <div class="wz line">
                                <img src="http://cdnimg.dd373.com/Upload/SitePic/2016-06-12/158a9130-c84a-4e64-a1c7-b2a714361ef5.jpg" style="margin-left:515px;" width="85" height="85">
                                <p style="margin-left:520px;line-height:20px;">
                                    客服：{{$data['answer_user_name']}}
                                    <br>
                                </p>
                                <p style="margin-left:410px; line-height:20px;">
                                    客服寄语：{{$data['answer_user_name']}}很开心为您服务^_^
                                </p>

                            </div>
                            <p class="dibu">
                                感谢您对{{config('web.web_title')}}的关注与支持，预祝您有一个愉悦的{{config('web.web_title')}}之旅！☆⌒_⌒☆
                            </p>
                            <p><a class="blue_btn" href="javascript:location.href=history.go(-1);">返回列表</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('layouts.ask_right')
    </div>
</div>


@endsection