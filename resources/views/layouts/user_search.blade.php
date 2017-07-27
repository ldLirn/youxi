<div class="fication">
    <div class="fication_text" id="search_ul">游戏区/服：
                    <span class="select" _id="0" ref="game" _gid="@if(FilterManager::has('game') !== false && !empty($_GET['game'])){{$_GET['game']}} @endif">
                        @if(FilterManager::has('game') !== false && !empty($_GET['game']))
                            <span class="w70">{{$game_name['game_name']}}</span>
                        @else
                            游戏名
                        @endif
                    </span>
                    <span class="select" _id="1" ref="area" _gid="@if(FilterManager::has('area') !== false && !empty($_GET['area'])){{$_GET['area']}} @endif">
                        @if(FilterManager::has('area') !== false && !empty($_GET['area']))
                            <span class="w70">{{$qu_name['qu_name']}}</span>
                        @else
                            全部区
                        @endif
                    </span>
                    <span class="select" _id="2" ref="server" _gid="@if(FilterManager::has('server') !== false && !empty($_GET['server'])){{$_GET['server']}} @endif">
                        @if(FilterManager::has('server') !== false && !empty($_GET['server']))
                            <span class="w70">{{$fwq_name['qu_name']}}</span>
                        @else
                            全部服务器
                        @endif
                    </span>
                    <span class="select" _id="3" ref="kind" _gid="@if(FilterManager::has('type') !== false && !empty($_GET['type'])){{$_GET['type']}} @endif">
                        @if(FilterManager::has('type') !== false && !empty($_GET['type']))
                            <span class="w70">{{$type_name['type']}}</span>
                        @else
                            全部分类
                        @endif
                    </span>
                @if($filter=='goods')
                    <span class="select" _id="4" ref="trade" _gid="@if(FilterManager::has('SellType') !== false && !empty($_GET['SellType'])){{$_GET['SellType']}} @endif">
                        @if(FilterManager::has('SellType') !== false && !empty($_GET['SellType']))
                            <span class="w70">{{$jy_type}}</span>
                        @else
                            所有商品
                        @endif
                    </span>
                @endif
    </div>
    <div class="SelectGame" style="display: none;z-index:99;position: absolute" id="game_select">
        <ul class="letter left" id="select_content_tab">
            <li class="hot"><a class="current">热门游戏</a></li>
            @for($i=0;$i<26;$i++)
                <li><a href="javascript:;" ref="{{$str[$i]}}">{{$str[$i]}}</a></li>
            @endfor

        </ul>
        <div class="close left" id="game_select_close" style="float: right;"></div>
        <ul class="game" id="select_content">
        </ul>
    </div>
    <form action="{{$url}}" method="get" id="search_form">
        <input type="hidden" id="searchgame" name="game"  value="@if(FilterManager::has('game') !== false && !empty($_GET['game'])){{$_GET['game']}}@endif" />
        <input type="hidden" id="searcharea" name="area"  value="@if(FilterManager::has('area') !== false && !empty($_GET['area'])){{$_GET['area']}}@endif" />
        <input type="hidden" id="searchserver" name="server"  value="@if(FilterManager::has('server') !== false && !empty($_GET['server'])){{$_GET['server']}}@endif" />
        <input type="hidden" id="searchtype" name="type"  value="@if(FilterManager::has('type') !== false && !empty($_GET['type'])){{$_GET['type']}}@endif" />
        @if($filter=='goods')<input type="hidden" id="SellType" name="SellType"  value="@if(FilterManager::has('SellType') !== false && !empty($_GET['SellType'])){{$_GET['SellType']}}@endif" />@endif
        <input type="hidden" id="base_url" value="{{web_url}}">

        <div class="fication_text">发布时间:
            <input type="text" id="date02" placeholder="YYYY-MM-DD" class="text"
                   value="@if(FilterManager::has('act_start_time') !== false && !empty($_GET['act_start_time'])){{$_GET['act_start_time']}}@else{{date("Y-m-d",strtotime("-30 day"))}}@endif" name="act_start_time">至
            <input type="text" id="date03" placeholder="YYYY-MM-DD" class="text"
                   value="@if(FilterManager::has('act_end_time') !== false && !empty($_GET['act_end_time'])){{$_GET['act_end_time']}}@endif" name="act_end_time">
           @if($filter=='goods') 订单@elseif($filter=='needs' || $filter=='sell')商品@endif编号：<span><input type="text" class="texts" name="order_sn"
                              value="@if(FilterManager::has('order_sn') !== false && !empty($_GET['order_sn'])){{$_GET['order_sn']}}@endif">
                        <a href="javascript:void(0)" id="act_search">搜索</a></span>
        </div>
        <div class="fy">每页显示数量：<a @if(FilterManager::isActive('pageSize','10') || !isset($_GET['pageSize'])) class="current" @endif href="{{FilterManager::url('pageSize', '10')}}">10</a><a @if(FilterManager::isActive('pageSize','20')) class="current"  @endif href="{{FilterManager::url('pageSize', '20')}}">20</a>
            <a @if(FilterManager::isActive('pageSize','30')) class="current"  @endif href="{{FilterManager::url('pageSize', '30')}}">30</a><a @if(FilterManager::isActive('pageSize','40')) class="current"  @endif href="{{FilterManager::url('pageSize', '40')}}">40</a></div>
    </form>
    <script>
        $(function () {
            $('#act_search').click(function () {
                $('#search_form').submit();
            })
        })
    </script>
</div>