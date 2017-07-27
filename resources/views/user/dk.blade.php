@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_dk') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我购买的点卡</span><p>在这里你可以查询到已购买的点卡的信息</p></div>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['game_state'])) class="current" @endif><a href="{{url('/user/dk')}}">所有订单</a></span>
                     <span @if(isset($_GET['game_state'])  && $_GET['game_state']==22) class="current" @endif><a href="{{FilterManager::url('game_state', '22')}}">支付成功</a> </span>
                     <span @if(isset($_GET['game_state']) && $_GET['game_state']==1) class="current" @endif><a href="{{FilterManager::url('game_state', '1')}}">交易成功</a></span>
                     <span @if(isset($_GET['game_state']) && $_GET['game_state']==9) class="current" @endif><a href="{{FilterManager::url('game_state', '9')}}">交易取消</a></span>
                     <span @if(isset($_GET['game_state']) && $_GET['game_state']==11) class="current" @endif><a href="{{FilterManager::url('game_state', '11')}}">等待支付</a></span>
                 </div>
                 <table>
               		 <thead>
                  		<tr>
                      		<th width="470">宝贝信息</th>
                      		<th  width="120">数量</th>
                      		<th  width="130">总价</th>
                            <th>充值帐号</th>
                            <th>支付状态</th>
                      		<th>充值状态</th>
                  		</tr>
               		 </thead>
                 </table>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @foreach($data as $v)
                            <li>
                                <p>
                                <span>
                                   <input type="checkbox" class="pay " value="{{$v->sporder_id}}">
                                    &nbsp;订单编号：<a title="查看订单详情" href="{{url('/user/orderDetail?order_sn='.$v->sporder_id)}}" target="_blank">{{$v->sporder_id}}</a>
                                </span>
                                    <span>创建时间：{{date('Y-m-d H:i:s',$v->time)}}</span>
                                <span>
                                </span>
                                </p>
                                <div class="ner">
                                    <div class="w40 bor_l left" style="width: 45%">
                                    <span class="stitle">
                                        <a class="transaction ico_bao" title="点卡订单"></a>
                                        <a class="alink" title="{{$v->cardname}}" href="{{url('/goods/'.Hashids::encode($v->id))}}" target="_blank">{{$v->cardname}}</a>
                                    </span>
                                        <span class="hui2">{{$v->cardname}}</span>
                                    </div>
                                    <div class="w10 bor_l left" style="width: 11%">{{$v->cardnum}}</div>
                                    <div class="w16 bor_l left" style="width: 14%">{{$v->ordercash}}</div>
                                    <div class="w16 bor_l left" style="width: 10%">{{$v->game_userid}}</div>
                                    <div class="w16 bor_l left" style="width: 10%">@if($v->pay_status==1)未支付@elseif($v->pay_status==2)已支付@endif</div>
                                    <div class="w16 left" style="width: 8%">

                                    <span class="nomargin" style="line-height:20px; margin-top:10px;">
                                        @if($v->game_state==0)
                                            <a target="_blank" href="javascript:void(0)">充值中</a><br>
                                        @elseif($v->game_state==1)
                                            <a target="_blank" href="javascript:void(0)">充值成功</a><br>
                                        @elseif($v->game_state==9)
                                            <a target="_blank" href="javascript:void(0)">充值失败
                                            ( @if($v->order_status==2)已退款@endif )
                                            </a><br>
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
                        {{$data->appends($page_path)->links()}}
                    @else
                        {{$data->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection