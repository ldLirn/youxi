@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 菜单列表
    </div>
    <!--面包屑导航 结束-->



    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/menu/deleteAll')}}" method="post" id="delete_all">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/menu/create')}}"><i class="fa fa-plus"></i>新增菜单</a>
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
                        <th class="tc">菜单名称</th>
                        <th class="tc">所属</th>
                        <th class="tc">地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v->order}}" onchange="changeOrder({{$v->id}},this)">
                        </td>
                        <td>{{$v->name}}</td>
                        <td class="tc">@if($v->pid=='0')<span style="color:#1963aa">顶级菜单</span>@endif</td>
                        <td class="tc">{{$v->url}}</td>
                        <td>
                            <a href="{{url('admin/menu/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delAd({{$v->id}})">删除</a>
                        </td>
                    </tr>
                        @foreach($v->child as $m)
                            <tr>
                                <td class="tc">
                                    <input type="text" name="ord[]" value="{{$m->order}}" onchange="changeOrder({{$m->id}},this)">
                                </td>
                                <td style="padding-left: 50px;">└─{{$m->name}}</td>
                                <td class="tc">{{$v->name}}</td>
                                <td class="tc">{{$m->url}}</td>
                                <td>
                                    <a href="{{url('admin/menu/'.$m->id.'/edit')}}">修改</a>
                                    <a href="javascript:delAd({{$m->id}})">删除</a>
                                </td>
                            </tr>
                        @endforeach

                    @endforeach
                </table>


            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<style>
    .result_content ul li span{
        padding: 6px 12px;
        font-size: 15px;
    }
</style>
<script>
    //删除
    function delAd(id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/menu/')}}/"+id,
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

    //改变排序AJAX
    function changeOrder(id,code) {
        var val = $(code).val();
        $.post("{{url('admin/menu/changeOrder')}}",{id:id,order:val,_token:'{{csrf_token()}}'},function (msg) {
            if(msg.status==0){
                layer.alert(msg.info, {icon: 6});
            }else if(msg.status==1){
                layer.alert(msg.info, {icon: 5});
            }
        })
    }
</script>
@endsection