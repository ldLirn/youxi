@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 友情链接列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/link/deleteAll')}}" method="post" id="delete_all">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
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
                        <th class="tc">标题</th>
                        <th class="tc">链接地址</th>
                        <th class="tc">链接LOGO</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v->link_order}}" onchange="changeOrder({{$v->id}},this)">
                        </td>

                        <td class="tc">{{$v->link_name}}</td>
                        <td class="tc">{{$v->link_url}}</td>
                        <td class="tc">@if($v->link_logo)<img src="{{$v->link_logo}}" style="max-width: 300px;max-height: 100px;"/> @else 文字链接@endif</td>
                        <td class="tc">
                            <a href="{{url('admin/link/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delLink({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


                <div class="page_list">
                    {{ $data->links() }}
                </div>
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
    function delLink(id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/link/')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}"},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if(data.status==0){
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    }else if(data.status==1){
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