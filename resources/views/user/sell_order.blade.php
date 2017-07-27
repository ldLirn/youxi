@extends('layouts.user')
@section('content')
    <link href="{{asset(HOME_CSS.'select-game.css') }}" rel="stylesheet" type="text/css">
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_sell_order') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我出售的商品</span><p>在这里你可以查询到出售的商品的信息</p></div>
            </div>
            @include('layouts.user_search')
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['order_status'])) class="current" @endif><a href="{{url('/user/SellOrder')}}">所有订单</a></span>
                     <span @if(isset($_GET['order_status'])  && $_GET['order_status']==12) class="current" @endif><a href="{{FilterManager::url('order_status', '12')}}">支付成功</a> </span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==1) class="current" @endif><a href="{{FilterManager::url('order_status', '1')}}">正在发货</a></span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==3) class="current" @endif><a href="{{FilterManager::url('order_status', '3')}}">交易成功</a></span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==4) class="current" @endif><a href="{{FilterManager::url('order_status', '4')}}">交易取消</a></span>
                 </div>
                 <table>
               		 <thead>
                     <tr>
                         <th width="40%">宝贝信息</th>
                         <th width="16%">单价</th>
                         <th width="16%">数量</th>
                         <th width="16%">总价</th>
                         <th>交易状态</th>
                     </tr>
               		 </thead>
                 </table>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @foreach($goodsShow as $v)
                            <li>
                                <p>
                                <span>
                                   <input type="checkbox" class="pay " value="{{$v->order_sn}}">
                                    &nbsp;订单编号：<a title="查看订单详情" href="{{url('/user/orderDetail?order_sn='.$v->order_sn)}}" target="_blank">{{$v->order_sn}}</a>
                                </span>
                                    <span>创建时间：{{date('Y-m-d H:i:s',$v->created_at)}}</span>
                                <span>
                                </span>
                                </p>
                                <div class="ner">
                                    <div class="w40 bor_l left" style="width: 40%">
                                    <span class="stitle">
                                        <a class="transaction ico_bao" title="担保交易"></a>
                                        <a class="alink" title="{{$v->goods_name}}" href="{{url('/goods/'.Hashids::encode($v->id))}}" target="_blank">{{$v->goods_name}}</a>
                                    </span>
                                        <span class="hui2">{{$v->game_name}}/{{$v->da_qu}}/{{$v->qu_name}}/{{$v->type}}@if($v->flag)（<i style="color: red">{{$v->flag}}</i>）@endif</span>
                                    </div>
                                    <div class="w16 bor_l left" style="width: 16%">{{$v->goods_price}}</div>
                                    <div class="w10 bor_l left" style="width: 16%">{{$v->buy_number}}</div>
                                    <div class="w16 bor_l left" style="width: 16%">{{$v->order_amount}}</div>
                                    <div class="w16 left" style="width: 11%">
                                    <span class="nomargin" style="line-height:20px; margin-top:10px;">
                                        <a href="{{url('/user/orderDetail?order_sn='.$v->order_sn)}}">查看详情</a><br>
                                        @if($v->pay_status=='0' && $v->order_status!='4' && $v->order_status!='5')
                                            <a target="_blank">未支付</a><br>
                                        @elseif($v->order_status=='0' && $v->pay_status=='1')
                                            <a target="_blank" style="color: red">已支付</a><br>
                                        @if($v->order_status=='0' && $v->pay_status=='1' && $v->order_type=='1')
                                            <a target="_blank" style="color: red"  href="javascript:sure({{$v->order_id}})">立即发货</a><br>
                                            @endif
                                        @elseif($v->order_status=='1')
                                            <a target="_blank" style="color: red">等待确认</a><br>
                                        @elseif($v->order_status=='3')
                                            <a target="_blank" style="color: red">交易成功</a><br>
                                        @elseif($v->order_status=='4')
                                            <a target="_blank" style="color: red">交易取消</a><br>
                                            <a class="spstate" oid="{{$v->order_id}}" os="4">查看原因</a><br>
                                        @elseif($v->order_status=='5')
                                            <a target="_blank" style="color: red">订单无效</a><br>
                                            <a class="spstate" oid="{{$v->order_id}}" os="5">查看原因</a><br>
                                        @endif
                                        @if($v->order_status=='0' && $v->pay_status=='0' && $v->order_type=='1')
                                            <a class="nopaycancel" href="javascript:delConfig({{$v->order_id}})">取消交易</a>
                                        @endif
                                    </span>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <script>
                            var cacheReason = {};
                            $(function () {
                                $(".spstate").mouseover(function (e) {
                                    var orderId = $(this).attr("oid");
                                    var orderSt = $(this).attr("os");
                                    var cache = cacheReason["OrderId" + orderId];
                                    if (cache) {
                                        $("#failinfo").html(cache).show().css({ top: e.pageY + 15 + "px", left: e.pageX - 50 + "px" });
                                    } else {
                                        $.ajax({
                                            type: 'get',
                                            url: '{{web_url}}/center/GetOrderReason',
                                            data: { OrderId: orderId, orderSt: orderSt },
                                            dataType: 'jsonp',
                                            jsonp: "callback",
                                            success: function (res) {
                                                cacheReason["OrderId" + orderId] = res.action_note;
                                                $("#failinfo").html(res.action_note).show().css({ top: e.pageY + 15 + "px", left: e.pageX - 50 + "px" });
                                            }
                                        });
                                    }
                                });
                                $(".spstate").mouseleave(function (e) {
                                    $("#failinfo").hide();
                                });

                            });
                        </script>
                        <li style="height:30px;line-height:28px;">
                            {{--<span style="color:Red; font-weight:bold; margin-left:50px;">--}}
                            {{--订单总额：<span style="color:Blue;">200.00</span> 元--}}
                            {{--</span>--}}
                            <span style="color:Red;margin-right:25px;font-size:12px; float:right;">
                                    {{trans('home.order_remarks')}}
                                </span>
                        </li>
                    </ul>
                </div>
                <div class="page">
                    @if(isset($page_path))
                        {{$goodsShow->appends($page_path)->links()}}
                    @else
                        {{$goodsShow->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset(PUBLIC_JS.'jedate.min.js')}}"></script>
<script type="text/javascript" src="{{asset(HOME_JS.'center_game.js')}}"></script>
<script type="text/javascript">

    jeDate({
        dateCell: '#date02',
        isinitVal:true,
        format: 'YYYY-MM-DD'
    });

    jeDate({
        dateCell: '#date03',
        isinitVal:true,
        format: 'YYYY-MM-DD'
    });

    function delConfig(id) {
        layer.prompt({
            title: "请输入取消原因",
            formType: 2
        }, function(pass){
            $.ajax({
                url: "{{url('/user/goods/cancel')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}",'note':pass},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if (data.status == 1) {
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    } else if (data.status == -1) {
                        layer.msg(data.info, {icon: 5});
                    } else {
                        layer.msg('{{trans('com.not_find_status')}}', {icon: 5});
                    }
                }
            });
        });
    }

    function sure(id) {
        layer.confirm("{{trans('home.sure_goods')}}", {
            btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"] //按钮
        }, function(){
            $.ajax({
                url: "{{url('/user/goods/sure')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}",'t':"{{trans('com.sure')}}"},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if (data.status == 1) {
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    } else if (data.status == -1) {
                        layer.msg(data.info, {icon: 5});
                    } else {
                        layer.msg("{{trans('com.not_find_status')}}", {icon: 5});
                    }
                }
            });
        });
    }
</script>

@endsection


