@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 异常申请列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/application')}}" method="post" id="delete_all">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/application/create')}}"><i class="fa fa-plus"></i>添加异常申请</a>
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
                        <th class="tc">申请会员</th>
                        <th class="tc">申请类型</th>
                        <th class="tc">申请时间</th>
                        <th class="tc">申请原因</th>
                        <th class="tc">状态</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->withUser->name}}</td>
                        <td class="tc">{{$v->type}}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->created_at)}}</td>
                        <td class="tc">{{str_limit($v->content, $limit = 70, $end = '...')}}</td>
                        <td class="tc">@if($v->result==0)未处理 @elseif($v->result==1) 已经处理,通过审核 @elseif($v->result==2) 申请不通过 @endif</td>
                        <td class="tc">
                            <a href="{{url('admin/application/'.$v->id)}}">审核</a>
                            <a href="{{url('admin/application/'.$v->id.'/edit')}}">修改</a>
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

<script>
    //删除
    function delLink(id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/application/')}}/"+id,
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