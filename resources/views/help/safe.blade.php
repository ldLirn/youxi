@extends('layouts.safe_header')
@section('content')
    <style>
        .main{width: 1000px;margin: 0 auto;height: auto}
        .yz ul li a{ width:240px; height:45px; display:block; background:url({{HOME_IMG}}safe_icon.jpg) no-repeat; }
        .yz ul li a.brank{ background-position:0px -137px;}
        .yz ul li a.ie{ background-position:0px -226px;}
        .yz ul li a.exmail{ background-position:0px -48px;}
        .yz ul li a.QQ{ background-position:0px -316px;}
        .yz ul li a:hover.brank{ background-position:0px -94px;}
        .yz ul li a:hover.ie{ background-position:0px -182px;}
        .yz ul li a:hover.exmail{ background-position:0px 1px;}
        .yz ul li a:hover.QQ{ background-position:-1px -269px;}
    </style>
<section class="banner">
    <div class=""></div>
    <div class="banner1">
        <div class="tu">
           @foreach($ads as $v)
               {!! $v !!}
           @endforeach
        </div>
    </div>
</section>

<div class="main">
    <section>
        <div class="nering">
            <div class="conmmonProblem">
                <p class="left ya">常见问题</p>
                <p class="right"><a href="{{url('help/safe/news/list')}}">更多</a></p>
            </div>
            <ul>
                @foreach($recommend as $v)
                <li><a href="{{url('help/safe/news/detail/'.$v['id'])}}">{{$v['title']}}</a></li>
                @endforeach
            </ul>
        </div>
    </section>
    <section class="yz">
        <div class="yz">
            <ul>
                <li><a class="brank" href="{{url('help/safe/Verification?tag=bank')}}"></a></li>
                <li><a class="ie" href="{{url('help/safe/Verification?tag=url')}}"></a></li>
                <li><a class="exmail" href="{{url('help/safe/Verification?tag=mail')}}"></a></li>
                <li><a class="QQ" href="{{url('help/safe/Verification?tag=qq')}}"></a></li>
            </ul>
        </div>
    </section>
</div>





@endsection