@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 会员等级
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->

    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/user_account/all_do')}}" method="post" id="all_do">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/user_rank/create')}}"><i class="fa fa-plus"></i>添加等级</a>
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
                        <th class="tc">会员等级名称</th>
                        <th class="tc">积分下限</th>
                        <th class="tc">积分上限</th>
                        <th class="tc">手续费折扣率</th>
                        <th class="tc">最多发布条数</th>
                        <th class="tc">最长有效期天数</th>
                        <th class="tc">最大求降价数量</th>
                        <th class="tc">等级图片</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->rank_name}}</td>
                        <td class="tc">{{$v->min_points}}</td>
                        <td class="tc">{{$v->max_points}}</td>
                        <td class="tc">{{$v->discount}}</td>
                        <td class="tc">{{$v->max_issue}}</td>
                        <td class="tc">{{$v->max_time}}</td>
                        <td class="tc">{{$v->max_changePrice}}</td>
                        <td class="tc"><img src="{{$v->rank_img}}" style="max-width: 100px;max-height: 30px"> </td>
                        <td>
                            <a href="{{url('admin/user_rank/'.$v->id.'/edit')}}">修改</a>
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
@endsection
    <script>
        function delAd(id) {
            layer.confirm('您确定要删除吗？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        $.ajax({
                            url: "{{url('admin/user_rank/')}}/"+id,
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