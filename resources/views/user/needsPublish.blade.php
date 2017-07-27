@extends('layouts.home')
<link href="{{asset(HOME_CSS.'need.css')}}" rel="stylesheet" type="text/css">
@section('content')
@include('layouts.nav')
<div class="all">
    <div class="place">
        <p>您现在的位置：{!! Breadcrumbs::render('needsPublish_select_game') !!}</p>
    </div>
    <div class="Sell">
        <p class="Stilte">请选择商品分类，点击继续发布进入下一步： </p>
        <div class="SGameType">
            <div class="Box">
                <div class="Bitem" id="GameDiv">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div>

                   </div>
                </div>
                <div class="Bitem" id="TypeDiv" style="">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div>

                    </div>
                </div>
                <div class="Bitem" id="AreaDiv" style="">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div>

                    </div>
                </div>
                <div class="Bitem" id="ServerDiv" style="">
                    <input type="text" value="请输入字母" onfocus="this.value='';">
                    <div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <div class="SelectGame">
            您当前选择的是：
        </div>
        <div>
            <form action="{{url('/needs/FillNeedsOrder')}}" method="post" id="NeedForm">
                <input type="text" name="HG" id="HG" style="display:none">
                <input type="text" name="G" id="G" style="display:none">
                <input type="text" name="TP" id="TP" style="display:none">
                {!! csrf_field() !!}
                <center id="center_need"><a id="NeedGameBtn" href="javascript:void(0);">
                        选好了，继续
                    </a>
                </center>
            </form>
            <div style="display:none;">
                <input id="reqobj" type="hidden" data-game="" data-area="" data-server="" data-type="">
                <input type="hidden" id="base_url" value="{{web_url}}">
            </div>
        </div>
    </div>
</div>
<script src="{{asset(HOME_JS.'NeedGame.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $("#NeedGameBtn").click(function () {
            if ($("#G").val() != "" && $("#TP").val() != "") {
                $("#NeedForm").submit();
                return false;
            }
            else {
                alert("请选择游戏服务器.");
                return false;
            }
        });
    });
</script>

@endsection