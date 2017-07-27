@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">全部文章分类</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/ArtCate/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href=""><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th class="tc">分类名</th>
                        <th class="tc">级别</th>
                        <th class="tc">描述</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v->cat_order}}" onchange="changeOrder({{$v->id}},this)">
                        </td>
                        <td class="tc">{{$v->id}}</td>
                        <td>{!! $v->cat_name !!}</td>
                        <td class="tc">{{$v->p_id}}</td>
                        <td class="tc">{{$v->cat_desc}}</td>

                        <td class="tc">
                            <a href="{{url('admin/ArtCate/'.$v->id.'/edit')}}">修改</a>
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
        //改变排序AJAX
        function changeOrder(id,code) {
            var val = $(code).val();
            $.post("{{url('admin/ArtCate/changeOrder')}}",{id:id,cat_order:val,_token:'{{csrf_token()}}'},function (msg) {
                if(msg.status==0){
                    layer.alert(msg.info, {icon: 6});
                }else if(msg.status==1){
                    layer.alert(msg.info, {icon: 5});
                }
            })
        }

        //删除
        function delConfig(id) {
            layer.confirm('您确定要删除这个配置项吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/ArtCate/')}}/"+id,
                    data:{'_method':'delete','_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else if(data.status==1){
                            layer.msg(data.info, {icon: 5});
                        }else if(data.status==2){
                            layer.msg(data.info, {icon: 5});
                        }else if(data.status==3){
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