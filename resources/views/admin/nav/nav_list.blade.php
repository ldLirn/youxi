@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">自定义导航</a>
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>新增导航</a>
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
                        <th class="tc" width="10%">导航名</th>
                        <th class="tc" width="10%">是否显示</th>
                        <th class="tc" width="20%">位置</th>
                        <th class="tc" width="20%">操作</th>
                    </tr>

                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v['nav_order']}}" onchange="changeOrder({{$v['id']}},this)">
                        </td>
                        <td class="tc">{{$v['nav_name']}}</td>
                        <td class="tc">@if($v['is_show']=='0')隐藏@else显示@endif</td>
                        <td class="tc">@if($v['nav_wz']=='1')顶部@elseif($v['nav_wz']=='2')主导航@elseif($v['nav_wz']=='3')尾部@endif</td>
                        <td>
                            <a href="{{url('admin/nav/'.$v['id'].'/edit')}}">修改</a>
                            <a href="javascript:delNav({{$v['id']}})">删除</a>
                        </td>
                    </tr>
                        @foreach($v['child'] as $n)
                            <tr>
                                <td class="tc">
                                    <input type="text" name="ord[]" value="{{$n['nav_order']}}" onchange="changeOrder({{$n['id']}},this)">
                                </td>
                                <td style="text-align: left;padding-left: 132px;">└─ {{$n['nav_name']}}</td>
                                <td class="tc">@if($n['is_show']=='0')隐藏@else显示@endif</td>
                                <td class="tc">@if($n['nav_wz']=='1')顶部@elseif($n['nav_wz']=='2')主导航@elseif($n['nav_wz']=='3')尾部@endif</td>
                                <td>
                                    <a href="{{url('admin/nav/'.$n['id'].'/edit')}}">修改</a>
                                    <a href="javascript:delNav({{$n['id']}})">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
                <div class="page_list">
                    {{ $paginator->links() }}
                </div>
            </div>

        </div>
    <!--搜索结果页面 列表 结束-->

<script>
    //改变排序AJAX
    function changeOrder(id,code) {
        var val = $(code).val();
        $.post("{{url('admin/nav/changeOrder')}}",{id:id,nav_order:val,_token:'{{csrf_token()}}'},function (msg) {
            if(msg.status==0){
                layer.alert(msg.info, {icon: 6});
            }else if(msg.status==1){
                layer.alert(msg.info, {icon: 5});
            }
        })
    }

    //删除
    function delNav(id) {
        layer.confirm('您确定要删除这个导航吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/nav/')}}/"+id,
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

</script>
@endsection