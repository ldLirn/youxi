@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 点卡充值列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <!--结果页快捷搜索框 开始-->
        <div class="search_wrap">
                <form onsubmit="return check_form()" action="{{url('admin/dk/search')}}" method="post">
                    <table class="search_tab">
                        <tr>
                            <th width="80">游戏名:</th>
                            {!! csrf_field() !!}
                            <td><input type="text" name="cardname" placeholder="">
                             <a href="{{url('admin/dk/search?is_show=1')}}">可充值</a>
                             <a href="{{url('admin/dk/search?is_show=2')}}">不能充值</a>
                            </td>
                            <td><input type="submit" name="sub" value="查询"></td>
                            <td><input type="button"  value="同步点卡游戏列表" id="update_dk_game_list"></td>
                        </tr>
                    </table>
                </form>
                <script>
                    function check_form() {
                        if($('input[name=cardname]').val()==''){
                            layer.msg('请输入查询条件', {icon: 5});
                            return false;
                        }
                    }
                    $('#update_dk_game_list').click(function(){
                        layer.confirm('您确定要进行此操作？同步后游戏图片,名称会缺失,请慎重操作', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var index = layer.load(1, {
                                shade: [0.1,'#fff'] //0.1透明度的白色背景
                            });
                            window.location.href = "{{url('admin/dk/update_dk_game_list')}}";
                        }, function(){

                        });
                    })
                </script>
        </div>
        <!--结果页快捷搜索框 结束-->

        @if(session('msg'))
            <div class="result_wrap">
                <div class="result_title">
                    <div class="mark">
                        <p>{{session('msg')}}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="10%">游戏充值id</th>
                        <th class="tc" width="50%">游戏充值名称</th>
                        <th>游戏图片</th>
                        <th class="tc">显示</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->cardid}}</td>
                        <td class="tc">{{$v->cardname}}</td>
                        <td><img src="{{$v->cardimg}}" alt="图片" style="max-width: 100px;"> </td>
                        <td class="tc">@if($v->is_show=='1')<i class="fa fa-check" style="color: green;cursor: pointer" onclick="change_status(1,{{$v->id}},1)"></i>@else<i class="fa fa-times" style="color: red;cursor: pointer" onclick="change_status(2,{{$v->id}},2)"></i>@endif</td>
                        <td class="tc"><a href="{{url('admin/dk_game_edit/'.$v->cardid)}}">修改</a>
                            <a href="{{url('admin/dk_game_faceValue/'.$v->cardid)}}">充值面值</a>
                        </td>

                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
        <div class="page_list">
            @if(isset($keywords))
                {{ $data->appends(['cat_id' => $cat_id,'keywords'=>$keywords])->links() }}
            @else
                {{ $data->links() }}
            @endif
        </div>
    <!--搜索结果页面 列表 结束-->

<script>

    //改变状态
    function change_status(status,id,type) {
        $.post("{{url('admin/dk/change')}}",{status:status,id:id,_token:"{{csrf_token()}}",type:type},function (msg) {
            if(msg=='1'){
                location.reload();
            }else{
                layer.msg('改变状态失败了', {icon: 5});
            }
        })
    }
</script>
@endsection