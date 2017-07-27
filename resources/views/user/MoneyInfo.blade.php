@extends('layouts.user')
@section('content')
<style>
    .order_list ul.order li{  height: 60px;  }
    .order_list .ner .bor_l{height: 60px;}
    .order_list .ner .w16, .order_list .ner .w10, .order_list .ner .w08, .order_list .ner .w12{line-height: 60px;}
     .mingxi{ font-size:14px;margin:10px auto;padding:10px 0 10px 10px;border:1px solid #cacaca; background-color:#f0f0f0;width: 100%;float: left }
    .mingxi .jiangexian2{margin:0 15px;}
     .mingxi .green{color:#256f20;}
     .mingxi .orange{color:#fe6601;}
</style>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('MoneyInfo') !!}</div>
    <div class="center_box">

        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的资金明细</span><p>在这里你可以看到资金的详细记录</p></div>
            </div>
            <div class="money" style="height: auto">
            	<div class="withdrawal">
                	<div class="sdc01">当前余额：<span>{{$user['money']}}</span>元</div>
                    <div class="sdc01 sdc02">可提现金额：<span>{{$user['money']}}</span>元</div>
                    <div class="sdc03"><a class="curr" href="{{url('/user/money/recharge')}}">我要充值</a><a href="{{url('/user/money/Withdrawal')}}">我要提现</a></div>
                </div>
                <div class="time" style="width: 100%;float: left;min-height: 55px;">
                    <form>
                	<div class="time01">起止时间：
                        <input type="text" id="date02" placeholder="YYYY-MM-D" class="text" value="@if(FilterManager::has('act_start_time') !== false && !empty($_GET['act_start_time'])){{$_GET['act_start_time']}}@else{{date("Y-m-d",strtotime("-30 day"))}}@endif" name="act_start_time"><span>至</span>
                        <input type="text" id="date03" placeholder="" class="text" value="@if(FilterManager::has('act_end_time') !== false && !empty($_GET['act_end_time'])){{$_GET['act_end_time']}}@endif" name="act_end_time"></div>
                    <div class="time02"><a href="{{FilterManager::url('act_start_time',date("Y-m-d",time()) )}}">今天</a><a href="{{FilterManager::url('act_start_time',date("Y-m-d",strtotime("-7 day")))}}">7天</a><a href="{{FilterManager::url('act_start_time',date("Y-m-d",strtotime("-30 day")))}}">30天</a></div>
                    <div class="time03"><a href="javascript:void(0)" onclick="$('form').submit()">查询</a><a href="javascript:MoneyCount()">统计</a><a href="@if($data=='1') javascript:alert('没有数据') @else {{url('excel/exportMoneyInfo')}} @endif" target="_blank">导出</a></div>
                    </form>
                    <div class="mingxi" style="text-align: center; display: none;" id="tongji_mingxi">
                        支付：<span ref="zf" class="orange">{{$count_buy}}</span>元<span class="jiangexian2">|</span>
                        售得：<span ref="sd" class="green">{{$count_sell}}</span>元<span class="jiangexian2">|</span>
                        充值：<span ref="cz">{{$count_recharge}}</span>元<span class="jiangexian2">|</span>
                        提现：<span ref="tx">{{$count_withdrawals}}</span>元<span class="jiangexian2"></span>
                    </div>
                </div>
                <div class="record_box">
                <div class="record">
                    <span @if(!isset($_GET['status'])) class="current" @endif><a href="{{FilterManager::url('status', '')}}">所有记录</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==3) class="current" @endif><a href="{{FilterManager::url('status', '3')}}">支付记录</a> </span>
                    <span @if(isset($_GET['status']) && $_GET['status']==10) class="current" @endif><a href="{{FilterManager::url('status', '10')}}">充值记录</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==1) class="current" @endif><a href="{{FilterManager::url('status', '1')}}">提现记录</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==5) class="current" @endif><a href="{{FilterManager::url('status', '5')}}">退款记录</a></span>
                    <span @if(isset($_GET['status']) && $_GET['status']==4) class="current" @endif><a href="{{FilterManager::url('status', '4')}}">收款记录</a></span>
                </div>
                    @if($data=='1')
                     <h3>没有符合条件的记录，请尝试其他搜索条件</h3>
                    @else
                        <table>
                            <thead>
                            <tr>
                                <th width="20%">记录时间</th>
                                <th width="20%">余额</th>
                                <th width="20%">冻结资金</th>
                                <th width="40%">变动原因</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="order_list">
                        <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                        <ul class="order">
                            @foreach($data as $v)
                                <li>
                                    <div class="ner">
                                        <div class="w16 bor_l left" style="width: 20%">
                                           {{date('Y-m-d H:i:s',$v->change_time)}}
                                        </div>
                                        <div class="w16 bor_l left" style="width: 20%">@if($v->money>=0)+{{$v->money}}@else{{$v->money}}@endif</div>
                                        <div class="w10 bor_l left" style="width: 20%">@if($v->frozen_money>=0)+{{$v->frozen_money}}@else{{$v->frozen_money}}@endif</div>
                                        <div class="w16 bor_l left" style="width: 40%">{{$v->change_desc}}</div>
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
    function MoneyCount() {
        $('#tongji_mingxi').slideToggle(200);
    }

</script>
@endsection

