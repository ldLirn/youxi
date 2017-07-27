@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 广告列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="{{url('admin/ad/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    {!! csrf_field() !!}
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/ad/deleteAll')}}" method="post" id="delete_all">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/ad/create')}}"><i class="fa fa-plus"></i>新增广告</a>
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

                        <th class="tc">ID</th>
                        <th class="tc">广告名称</th>
                        <th class="tc">缩略图</th>
                        <th class="tc">广告位</th>
                        <th class="tc">类型</th>
                        <th class="tc">开始时间</th>
                        <th class="tc">结束时间</th>
                        <th class="tc">状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->id}}</td>
                        <td class="tc">{{$v->ad_name}}</td>
                        <td class="tc">@if($v->type=='1')<img src="{{$v->ad_code}}" style="max-width: 100px;max-height: 50px;"/>@elseif($v->type=='2')<textarea>{{$v->ad_code}}</textarea>@endif</td>
                        <td class="tc">{{$v->adp_name}}</td>
                        <td class="tc">@if($v->type=='1')图片@elseif($v->type=='2')代码@endif</td>
                        <td class="tc">{{$v->start_time}}</td>
                        <td class="tc">{{$v->end_time}}</td>
                        <td class="tc">@if($v->is_open=='0')开启@elseif($v->is_open=='1')关闭@endif</td>
                        <td>
                            <a href="{{url('admin/ad/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delAd({{$v->id}})">删除</a>
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
    function delAd(id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                 url: "{{url('admin/ad/')}}/"+id,
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
        }

        );
    }


</script>
@endsection