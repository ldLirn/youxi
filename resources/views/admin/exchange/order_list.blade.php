@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 积分商城订单
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="{{url('admin/exchange/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    {!! csrf_field() !!}
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="商品名称或订单号"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/exchange/deleteAll')}}" method="post" id="delete_all">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                {{--<div class="short_wrap">--}}
                    {{--<a href="{{url('admin/exchange/create')}}"><i class="fa fa-plus"></i>新增商品</a>--}}
                {{--</div>--}}
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
                        <th class="tc">订单编号</th>
                        <th class="tc">商品信息</th>
                        <th class="tc">下单时间</th>
                        <th class="tc">订单积分</th>
                        <th class="tc">订单状态</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v->id}}" class="checkone"></td>

                        <td class="tc">{{$v['order_code']}}</td>
                        <td>
                            <p>{{$v['exchange']['goods_name']}}</p>单价：{{$v['integral']}}积分
                        </td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v['create_time'])}}</td>
                        <td class="tc">{{$v['order_integral']}}</td>
                        <td class="tc">@if($v['order_status']=='1'){{NOT_OPERATE}}@elseif($v['order_status']=='2'){{EXCHANGE_COMPLETE}}@elseif($v['order_status']=='3'){{ORDER_CANCEL}}@endif</td>
                        <td class="tc">
                            <a href="{{url('admin/exchange_order/'.$v->id.'/edit')}}">查看详情</a>
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

<script>
    //删除
    function delConfig(id) {
        layer.confirm('您确定要删除商品吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/exchange/')}}/"+id,
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

    //批量删除
    function delAll() {
        layer.confirm('您确定要删除这些商品吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $('#delete_all').submit();
        }, function(){

        });
    }

</script>
@endsection