@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">全部游戏列表</a>
    </div>
    <!--面包屑导航 结束-->
    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="{{url('admin/game/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择类型:</th>
                    <td>
                        <select  name="cat_id">
                            <option value="">全部</option>
                            @foreach($cate as $r)
                                <option value="{{$r->id}}">{{$r->cat_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <th width="70">游戏名称:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/game/create')}}"><i class="fa fa-plus"></i>新增游戏</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
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

                        <th class="tc">游戏名称</th>
                        <th class="tc">图标</th>
                        <th class="tc">商品数量</th>
                        <th class="tc">描述</th>
                        <th class="tc">游戏类型</th>
                        <th class="tc">推荐</th>
                        <th class="tc">热门</th>
                        <th class="tc">免费</th>
                        <th class="tc">搜索热门词</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>

                        <td class="tc">{{ $v->game_name }}</td>
                        <td class="tc"><img src="{{$v->thumb}}" width="100"></td>
                        <td class="tc">{{$v->num}}</td>
                        <td class="tc">{{$v->game_desc}}</td>
                        <td class="tc">{{$v->cat_name}}</td>
                        <td class="tc">@if($v->is_recommend=='1')<i class="fa fa-check" style="color: green" onclick="change_status(1,{{$v->id}},1)"></i>@else<i class="fa fa-times" style="color: red" onclick="change_status(0,{{$v->id}},1)"></i>@endif</td>
                        <td class="tc">@if($v->is_hot=='1')<i class="fa fa-check" style="color: green" onclick="change_status(1,{{$v->id}},2)"></i>@else<i class="fa fa-times" style="color: red" onclick="change_status(0,{{$v->id}},2)"></i>@endif</td>
                        <td class="tc">@if($v->is_free=='1')<i class="fa fa-check" style="color: green" onclick="change_status(1,{{$v->id}},3)"></i>@else<i class="fa fa-times" style="color: red" onclick="change_status(0,{{$v->id}},3)"></i>@endif</td>
                        <td class="tc">@if($v->is_keyword=='1')<i class="fa fa-check" style="color: green" onclick="change_status(1,{{$v->id}},4)"></i>@else<i class="fa fa-times" style="color: red" onclick="change_status(0,{{$v->id}},4)"></i>@endif</td>
                        <td class="tc">
                            <a href="{{url('admin/game/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delConfig({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>




            </div>
            <div class="page_list">
                @if(isset($keywords))
                    {{ $data->appends(['cat_id' => $cat_id,'keywords'=>$keywords])->links() }}
                @else
                    {{ $data->links() }}
                @endif
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>

        //删除
        function delConfig(id) {
            layer.confirm('您确定要删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/game/')}}/"+id,
                    data:{'_method':'delete','_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else{
                            layer.msg(data.info, {icon: 5});
                        }
                    },
                    error:function(er){
                        if(er.status==403){
                            layer.msg('您没有此权限', {icon: 5});
                        }
                    }
                });
            });
        }

    </script>

    <script>
        function change_status(status,id,type) {
            $.post("{{url('admin/game/change')}}",{status:status,id:id,_token:"{{csrf_token()}}",type:type},function (msg) {
                if(msg=='1'){
                    location.reload();
                }else{
                    layer.msg('改变状态失败了', {icon: 5});
                }
            })
        }
    </script>
@endsection