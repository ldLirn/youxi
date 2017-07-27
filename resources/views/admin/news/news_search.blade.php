@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 文章搜索
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="{{url('admin/news/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select  name="cat_id">
                            <option value="">全部</option>
                            @foreach($cate as $r)
                            <option value="{{$r->id}}">{{$r->cat_name}}</option>
                                @endforeach
                        </select>
                    </td>
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
    <form action="{{url('admin/news/deleteAll')}}" method="post" id="delete_all">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/news/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="javascript:void(0)" onclick="delAll()"><i class="fa fa-recycle"></i>批量删除</a>
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
                        <th class="tc" width="5%"><input type="checkbox" name="" id="checkAll"></th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>简介</th>
                        <th>文章分类</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v->id}}" class="checkone"></td>

                        <td class="tc">{{$v->id}}</td>
                        <td>
                            <a href="#">{{$v->title}}</a>
                        </td>
                        <td>{{$v->desc}}</td>
                        <td>{{$v->cat_name}}</td>
                        <td>{{$v->updated_at}}</td>
                        <td>
                            <a href="{{url('admin/news/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:delConfig({{$v->id}})">删除</a>
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
    function delConfig(id) {
        layer.confirm('您确定要删除这篇文章吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/news/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status==0){
                    layer.msg(data.info, {icon: 6});
                    location.reload();
                }else if(data.status==1){
                    layer.msg(data.info, {icon: 5});
                }
            });
        }, function(){

        });
    }

    //批量删除
    function delAll() {
        layer.confirm('您确定要删除这些文章吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $('#delete_all').submit();
        }, function(){

        });
    }

</script>
@endsection