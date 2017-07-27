@extends('layouts.home')
@section('content')
<link href="{{asset(HOME_CSS.'buy.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset(HOME_JS.'masonry.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('.masonry').css('display','block');
        $('.masonry').masonry({
            itemSelector : '.grid-item',
            columnWidth : 15,
        });

        $(".grid-item").each(function(){
                $(this).css("background-color",getRandomColor());
            });
        function getRandomColor()
        {
            var c = '#';
            var cArray = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F'];
            for(var i = 0; i < 6;i++)
            {
                var cIndex = Math.round(Math.random()*15);
                c += cArray[cIndex];
            }
            return c;
        }

    });

</script>
<section class="w_960 select" id="hotgame_section">
    <div class="select_left left">选择游戏</div>
    <div class="select_right right">
        <ul id="hotgame_content_tab" class="zimu">
            <li class="wz name"><span onclick="window.location.href = ''">手游</span></li>
            <li class="wz name"><a ref="热门游戏">热门</a></li>
            <li class="wz name"><a ref="免费游戏">免费</a></li>
            @for($i=0;$i<26;$i++)
                <li><a href="javascript:;" ref="{{$str[$i]}}">{{$str[$i]}}</a></li>
            @endfor
        </ul>
        <ul class="list_menu clear_both" id="hotgame_content" style="display:none;"></ul>
    </div>

</section>


<section class="main">
    <div class="main1 left">
        <div class="blue">
            <dl>
                <dt class="yahei14">网络游戏</dt>
                <dd class="f_14">金币</dd>
                @foreach($gold as $v)
                <dd>
                    <a href="{{url('/category/'.Hashids::encode($v['id']))}}" title="{{$v['game_name']}}">{{$v['game_name']}}</a>
                </dd>
                @endforeach
                <dd class="f_14 clear_both  w_30">账号</dd>
                @foreach($zh as $v)
                    <dd>
                        <a href="{{url('/category/'.Hashids::encode($v['id']))}}" title="{{$v['game_name']}}">{{$v['game_name']}}</a>
                    </dd>
                @endforeach

                <dd class="f_14 clear_both  w_30">装备</dd>
                @foreach($zb as $v)
                    <dd>
                        <a href="{{url('/category/'.Hashids::encode($v['id']))}}" title="{{$v['game_name']}}">{{$v['game_name']}}</a>
                    </dd>
                @endforeach

            </dl>
            <dl class="clear_both">
                <dt class="yahei14">手机游戏</dt>
                <dd class="f_14 clear_both">热门</dd>
                @foreach($hotMobile as $k=>$v)
                    @if($k<3)
                <dd>
                    <a href="{{url('/sy/category/'.$v['id'])}}" title="{{$v['game_name']}}" target="_blank">{{$v['game_name']}}</a>
                </dd>
                    @endif
                @endforeach
            </dl>

            <dl class="clear_both">
                <dt class="yahei14">网页游戏</dt>
                <dd class="f_14">热门</dd>
                @foreach($hotWeb as $k=>$v)
                    @if($k<3)
                        <dd>
                            <a href="{{url('/web/category/'.$v['id'])}}" title="{{$v['game_name']}}" target="_blank">{{$v['game_name']}}</a>
                        </dd>
                    @endif
                @endforeach
            </dl>

        </div>
        <div class="orange" id="need_div">
        <div class="text yahei"><a style="color:#fff" href="{{url('/need')}}">我要求购</a></div>
    </div>
    </div>
    <div class="masonry left" style="display: none">
        @foreach($hotGame as $k=>$v)
            @if($k<=9)
            <div class="grid-item @if($k=='1' || $k=='7') grid-item--width2 @elseif($k=='4') grid-item--width3 @elseif($k=='5') grid-item--height3 @endif"><a href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>  </div>
            @endif
        @endforeach
    </div>
    <div class="main4 clear_both">

    </div>
    </div>
</section>
<script type="text/javascript" src="{{asset(HOME_JS.'GameNav.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            new GameNav();
            $("#need_div").click(function () {
                window.location.href = $("a", this).attr("href");
            });

        });

    </script>

@endsection