@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 点卡充值列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <!--结果页快捷搜索框 开始-->
        <div class="search_wrap">
                <form id="search_form" action="{{url('admin/dk_order/search')}}" method="post">
                    <table class="search_tab">
                        <tr>
                            <th width="80">订单号:</th>
                            {!! csrf_field() !!}
                            <td><input type="text" name="order_sn" placeholder="">
                                充值会员:
                                <input type="text" name="user_name" placeholder="">
                                订单状态：
                                <select name="order_status">
                                    <option value="">请选择</option>
                                    <option value="0">充值中</option>
                                    <option value="1">充值成功</option>
                                    <option value="9">充值失败</option>
                                </select>
                            </td>
                            {!! csrf_field() !!}
                            <td><input type="button" name="sub" value="查询" id="submit_btn"></td>
                        </tr>
                    </table>
                </form>
                <script>
                    $('#submit_btn').click(function(){
                        if($('input[name=order_sn]').val()=='' && $('input[name=user_name]').val()=='' && $('[name=order_status]').val()==''){
                            layer.msg('请输入查询条件', {icon: 5});
                            return false;
                        }else{
                            console.log( $('#search_form'))
                            $('#search_form').submit();
                        }
                    })
                </script>
        </div>
        <!--结果页快捷搜索框 结束-->

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
                        <th class="tc">订单号</th>
                        <th class="tc">商品名称</th>
                        <th class="tc">商品数量</th>
                        <th class="tc">订单金额</th>
                        <th class="tc">充值账号</th>
                        <th class="tc">充值会员</th>
                        <th class="tc">订单时间</th>
                        <th class="tc">支付状态</th>
                        <th class="tc">订单状态</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v['sporder_id']}}</td>
                        <td class="tc">{{$v['cardname']}}</td>
                        <td class="tc">{{$v['cardnum']}}</td>
                        <td class="tc">{{$v['ordercash']}}</td>
                        <td class="tc">{{$v['game_userid']}}</td>
                        <td class="tc">{{$v['user']['name']}}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v['time'])}}</td>
                        <td class="tc">@if($v['order_status']==2)已退款@else @if($v['pay_status']==1)未支付@elseif($v['pay_status']==2)已支付@endif @endif</td>
                        <td class="tc">@if($v['game_state']==0)充值中@elseif($v['game_state']==1)充值成功@elseif($v['game_state']==9)充值失败@else状态未知@endif</td>
                        <td class="tc">
                            <a href="{{url('admin/dk_sure/'.$v['sporder_id'].'?game_state='.$v['game_state'])}}">更新状态</a>
                            <a href="{{url('admin/dk_order_detail/'.$v['id'])}}">订单详情</a>
                            @if($v['game_state']!=0 && $v['game_state']!=1 && $v['order_status']==1)<a href="{{url('admin/dk_order_refund/'.$v['id'])}}">退款</a>@endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
@endsection