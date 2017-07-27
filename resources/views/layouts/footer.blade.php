<div class="footer">
    <div class="footer_box">
        <div class="footer_list">

            @foreach($footnav as $k=>$v)
                <dl>
                    <dt>{{$v['nav_name']}}</dt>
                    @foreach($v['child'] as $m=>$n)
                        <dd><a href="{{$n['nav_url']}}">{{$n['nav_name']}}</a></dd>
                    @endforeach
                </dl>
            @endforeach
            <div class="erm">{!! $ewm !!}<span>扫二维码</span></div>
        </div>
        <div class="footer_text"></div>
        <div class="cooperation">友情合作：
            @foreach($link_data as $v)
                <a href="{{$v['link_url']}}">{{$v['link_name']}}</a>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>