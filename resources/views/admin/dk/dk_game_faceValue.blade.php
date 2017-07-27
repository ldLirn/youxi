@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 点卡面值列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <!--结果页快捷搜索框 开始-->
        <div class="search_wrap">

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
                        <th class="tc" width="10%">面值id</th>
                        <th class="tc" width="50%">面值名称</th>
                        <th class="tc" width="10%">库存</th>
                        <th class="tc" width="10%">单价</th>
                        <th>缩略图</th>
                        <th class="tc">上架</th>
                        <th class="tc">推荐</th>
                        <th class="tc">热销</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->cardid}}</td>
                        <td class="tc">{{$v->cardname}}</td>
                        <td class="tc">{{$v->innum}}</td>
                        <td class="tc">{{$v->memberprice}}</td>
                        <td><img src="{{$v->thumb}}" alt="图片" style="max-width: 100px;"> </td>
                        <td class="tc">@if($v->is_on_sale=='1')<i class="fa fa-check" style="color: green;cursor: pointer" onclick="change_status(1,{{$v->id}},{{$v->pid}},1)"></i>@else<i class="fa fa-times" style="color: red;cursor: pointer" onclick="change_status(2,{{$v->id}},{{$v->pid}},1)"></i>@endif</td>
                        <td class="tc">@if($v->is_recommend=='2')<i class="fa fa-check" style="color: green;cursor: pointer" onclick="change_status(2,{{$v->id}},{{$v->pid}},2)"></i>@else<i class="fa fa-times" style="color: red;cursor: pointer" onclick="change_status(1,{{$v->id}},{{$v->pid}},2)"></i>@endif</td>
                        <td class="tc">@if($v->is_hot=='2')<i class="fa fa-check" style="color: green;cursor: pointer" onclick="change_status(2,{{$v->id}},{{$v->pid}},3)"></i>@else<i class="fa fa-times" style="color: red;cursor: pointer" onclick="change_status(1,{{$v->id}},{{$v->pid}},3)"></i>@endif</td>
                        <td class="tc"><a href="{{url('admin/dk/dk_game_faceValue_edit/'.$v->cardid)}}">修改</a>
                        </td>

                    </tr>
                    @endforeach
                </table>

            </div>
        </div>

    <!--搜索结果页面 列表 结束-->

<script>
    /**
     * 改变状态
     * @param status   当前状态
     * @param id
     * @param pid
     * @param type     1为上下架，2为推荐，3为热销
     */
    function change_status(status,id,pid,type) {
        $.post("{{url('admin/dk/change_on_sale')}}",{status:status,id:id,pid:pid,_token:"{{csrf_token()}}",type:type},function (msg) {
            if(msg=='1'){
                location.reload();
            }else{
                layer.msg('改变状态失败了', {icon: 5});
            }
        })
    }
</script>
@endsection