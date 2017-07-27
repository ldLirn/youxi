@extends('layouts.admin')
@section('content')
    <style>
        table.list_tab tr th{text-align: center}
        table.list_tab tr td{text-align: center;}
    </style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">订单列表</a>
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        @if(isset($_GET['type']))
            <form onsubmit="return check_form()" action="{{url('admin/order/search?type='.$_GET['type'])}}" method="post">
                @else
                    <form onsubmit="return check_form()" action="{{url('admin/order/search?type=0')}}" method="post">
                        @endif
            <table class="search_tab">
                <tr>
                    <th width="80">订单号:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" name="order_sn" placeholder="">
                        买家:
                    <input type="text" name="user_name" placeholder="">
                        订单状态：
                        <select name="order_status">
                            <option value="">请选择</option>
                            <option value="0">未操作</option>
                            <option value="1">正在发货</option>
                            <option value="2">待确认收货</option>
                            <option value="3">交易成功</option>
                            <option value="4">交易取消</option>
                            <option value="5">无效</option>
                        </select>
                        @if(isset($_GET['type']))
                        <a href="{{url('admin/order/search?pay_status=0&type='.$_GET['type'])}}">未付款</a>
                        <a href="{{url('admin/order/search?pay_status=1&type='.$_GET['type'])}}">已付款</a>
                        @else
                            <a href="{{url('admin/order/search?pay_status=0&type=0')}}">未付款</a>
                            <a href="{{url('admin/order/search?pay_status=1&type=0')}}">已付款</a>
                        @endif
                    </td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
            <script>
                function check_form() {
                    if($('input[name=order_sn]').val()=='' && $('input[name=user_name]').val()=='' && $('[name=order_status]').val()==''){
                        layer.msg('请输入查询条件', {icon: 5});
                        return false;
                    }
                }
            </script>
    </div>
    <!--结果页快捷搜索框 结束-->
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/order/create')}}"><i class="fa fa-plus"></i>创建订单</a>
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
    <form action="{{url('admin/order/all_do')}}" method="post" id="all_do">
        <div class="result_wrap">
            <ul class="tab">
                @if(isset($_GET['type']))
                    <li @if(isset($_GET['type']) && $_GET['type']=='0')class="active"  @endif><a href="{{url('admin/order?type=0')}}">寄售订单</a></li>
                    <li @if(isset($_GET['type']) && $_GET['type']=='1')class="active"  @endif><a href="{{url('admin/order?type=1')}}">担保订单</a></li>
                    <li @if(isset($_GET['type']) && $_GET['type']=='2')class="active" @endif><a href="{{url('admin/order?type=2')}}">求购订单</a></li>
                @else
                    <li class="active"><a href="{{url('admin/order?type=0')}}">寄售订单</a></li>
                    <li><a href="{{url('admin/order?type=1')}}">担保订单</a></li>
                    <li><a href="{{url('admin/order?type=2')}}">求购订单</a></li>
                @endif

            </ul>
            <div class="tab_content" id="js">
                <table class="list_tab">
                    <tbody>
                    <tr>
                        <th class="tc"><input type="checkbox" name="" id="checkAll"></th>
                        <th>订单编号</th>
                        <th>商品信息</th>
                        <th>下单时间</th>
                        <th>订单金额</th>
                        <th>发布人</th>
                        <th>买家</th>
                        <th>支付状态</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data['data'] as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="{{$v['id']}}" class="checkone"></td>
                            <td class="tc">{{$v['order_sn']}}</td>
                            <td class="tc"><p>{{$v['goods_info']['goods_name']}}</p>{{$v['goods_info']['game']['game_name']}}/{{$v['goods_info']['da_qu']['qu_name']}}/{{$v['goods_info']['xia_qu']['qu_name']}}/{{$v['goods_info']['has_many_type']['type']}}</td>
                            <td class="tc">{{date('Y-m-d H:i:s',$v['created_at'])}}</td>
                            <td class="tc">{{$v['order_amount']}}</td>
                            <td class="tc">@if(!$v['goods_info']['user']['name'])官方自营@else{{$v['goods_info']['user']['name']}}@endif</td>
                            <td class="tc">{{$v['user_name']}}</td>
                            <td class="tc">@if($v['pay_status']=='0')未支付@elseif($v['pay_status']=='1')已支付@endif</td>
                            <td class="tc">@if($v['order_status']=='0')未操作@elseif($v['order_status']=='1')正在发货@elseif($v['order_status']=='2')待确认收货@elseif($v['order_status']=='3')交易成功@elseif($v['order_status']=='4')取消@elseif($v['order_status']=='5')无效@endif</td>
                            <td class="tc">
                                <a href="{{url('admin/order/'.$v['id'].'/edit')}}">查看详情</a>
                                @if($v['order_status']=='5')
                                    <a href="javascript:delConfig({{$v['id']}})">删除</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="page_list">
                    <select name="all_do">
                        <option value="">选中项操作</option>
                        <option value="1">无效</option>
                        <option value="2">取消订单</option>
                        <option value="3">导出订单</option>
                        {!! csrf_field() !!}

                    </select>
                        <input type="button" value="确定" style="margin-left: 20px;" onclick="if($('[name*=all_do]').val()!=''){$('#all_do').submit();}">

                </div>

                <div class="page_list">
                    @if(isset($_GET['type']))
                        @if(isset($where))
                          {{ $data_all->appends(['type' => $_GET['type'],'pay_status'=>$where])->links() }}
                            @elseif(isset($order_sn))
                            {{ $data_all->appends(['type' => $_GET['type'],'order_sn'=>$order_sn,'user_name'=>$user_name,'order_status'=>$order_status])->links() }}
                        @else
                            {{ $data_all->appends(['type' => $_GET['type']])->links() }}
                        @endif

                    @else
                        {{ $data_all->links() }}
                    @endif
                </div>

            </div>

        </div>
    </form>



    <!--搜索结果页面 列表 结束-->
    <script>

        //放入回收站
        function delConfig(id) {
            layer.confirm('您确定要放入删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/order/')}}/"+id,
                    data:{'_method':'delete','_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else if(data.status==1){
                            layer.msg(data.info, {icon: 5});
                        }else{
                            layer.msg('未知状态', {icon: 5});
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

        //清理库存为0商品
        function clearStock() {
            layer.confirm('您确定要进行此操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/goodsgame/trash')}}",
                    data:{'_token':"{{csrf_token()}}"},
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


        //清理库存为0商品
        function clearExpired() {
            layer.confirm('您确定要进行此操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/goodsgame/expired')}}",
                    data:{'_token':"{{csrf_token()}}"},
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