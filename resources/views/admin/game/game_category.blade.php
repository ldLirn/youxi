@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">全部游戏分类</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/cate_game/create')}}"><i class="fa fa-plus"></i>新增分类</a>
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

                        <th class="tc">分类名</th>
                        <th class="tc">游戏数量</th>
                        <th class="tc">描述</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>

                        <td class="tc">{!! $v->cat_name !!}</td>
                        <td class="tc">{{$v->num}}</td>
                        <td class="tc">{{$v->desc}}</td>

                        <td class="tc">
                            <a href="{{url('admin/cate_game/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delConfig({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>




            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>

        //删除
        function delConfig(id) {
            layer.confirm('您确定要删除这个配置项吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/cate_game/')}}/"+id,
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


@endsection