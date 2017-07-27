@extends('layouts.user')
@section('content')
<style>
    .line_height{line-height: 25px !important;margin-top: 18px;}
</style>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('ExchangeList') !!}</div>
    <div class="center_box">

        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的兑换商品</span><p>在这里你可以看到兑换商品的详细记录</p></div>
            </div>
            <div class="money" style="height: auto">
                <div class="time" style="width: 100%;float: left;min-height: 55px;">
                    <form>
                	<div class="time01">起止时间：
                        <input type="text" id="date02" placeholder="YYYY-MM-D" class="text" value="@if(FilterManager::has('act_start_time') !== false && !empty($_GET['act_start_time'])){{$_GET['act_start_time']}}@else{{date("Y-m-d",strtotime("-30 day"))}}@endif" name="act_start_time"><span>至</span>
                        <input type="text" id="date03" placeholder="" class="text" value="@if(FilterManager::has('act_end_time') !== false && !empty($_GET['act_end_time'])){{$_GET['act_end_time']}}@endif" name="act_end_time"></div>
                    <div class="time02"><a href="{{FilterManager::url('act_start_time',date("Y-m-d",time()) )}}">今天</a><a href="{{FilterManager::url('act_start_time',date("Y-m-d",strtotime("-7 day")))}}">7天</a><a href="{{FilterManager::url('act_start_time',date("Y-m-d",strtotime("-30 day")))}}">30天</a></div>
                    <div class="time03"><a href="javascript:void(0)" onclick="$('form').submit()">查询</a></div>
                    </form>
                </div>
                <div class="record_box">
                <div class="record">
                    <span @if(!isset($_GET['status'])) class="current" @endif><a href="{{FilterManager::url('status', '')}}">所有记录</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==1) class="current" @endif><a href="{{FilterManager::url('status', '1')}}">处理中</a> </span>
                    <span @if(isset($_GET['status']) && $_GET['status']==2) class="current" @endif><a href="{{FilterManager::url('status', '2')}}">交易成功</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==3) class="current" @endif><a href="{{FilterManager::url('status', '3')}}">交易取消</a></span>

                </div>
                    @if($data=='1')
                     <h3>没有符合条件的记录，请尝试其他搜索条件</h3>
                    @else
                        <table>
                            <thead>
                            <tr>
                                <th width="30%">商品名</th>
                                <th width="10%">消费积分</th>
                                <th width="10%">兑换数量</th>
                                <th width="38%">收货信息</th>
                                <th width="12%">状态</th>
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
                                           <input type="checkbox" class="pay " value="{{$v->order_code}}">
                                            &nbsp;订单编号：{{$v->order_code}}
                                        </span>
                                                <span>创建时间：{{date('Y-m-d H:i:s',$v->create_time)}}</span>
                                        <span>
                                        </span>
                                    </p>
                                    <div class="ner">
                                        <div class="w16 bor_l left" style="width: 30%">
                                            <a class="alink" title="{{$v->goods_name}}" href="{{url('/exchange/'.Hashids::encode($v->goods_id))}}" target="_blank">{{$v['exchange']['goods_name']}}</a>
                                        </div>
                                        <div class="w16 bor_l left" style="width: 10%">{{$v->order_integral}}</div>
                                        <div class="w10 bor_l left" style="width: 10%"> {{$v->num}}</div>
                                        <div class="w10 bor_l left" style="width: 38%"> {{$v->user_info}}</div>
                                        <div class="w16 bor_l left line_height" style="width: 12%">
                                            @if($v->order_status==1){{NOT_OPERATE}}
                                            @elseif($v->order_status==2){{EXCHANGE_COMPLETE}}
                                            @elseif($v->order_status==3)
                                             <a> {{ORDER_CANCEL}}</a><br>
                                            <a class="spstate" oid="{{$v->id}}" os="-2">查看原因</a><br>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                </div>
                        <div class="page">
                            @if(isset($page_path))
                                {{$data->appends($page_path)->links()}}
                            @else
                                {{$data->links()}}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
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
                        cacheReason["OrderId" + orderId] = res.note;
                        $("#failinfo").html(res.note).show().css({ top: e.pageY + 15 + "px", left: e.pageX - 50 + "px" });
                    }
                });
            }
        });
        $(".spstate").mouseleave(function (e) {
            $("#failinfo").hide();
        });

    });
</script>
<script type="text/javascript" src="{{asset(PUBLIC_JS.'jedate.min.js')}}"></script>
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

</script>
@endsection

