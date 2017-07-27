<div class="indexnav_wrap">
    <nav class="indexnav">
        <ul>
            <li class="line_l"><h2><a href="{{web_url}}" target="_blank">首页</a></h2></li>
            @foreach($middnav as $k=>$v)
                <li class="@if($k=='6')line_none @else line_l @endif"><h2><a href="{{web_url.'/'.$v['nav_url']}}" target="_blank">{{$v['nav_name']}}</a></h2></li>
            @endforeach
        </ul>
    </nav>
</div>