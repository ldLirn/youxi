@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_order_detail') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>订单详情</span><p></p></div>
            </div>
            <div class="buyers">

                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SpTable">
                    <tbody><tr>
                        <td align="right"  style="color:#3384bc;width: 15%">订单编号：</td>
                        <td style="width:35%"><span style="color:Red;">{{$order['order_sn']}}</span></td>
                        <td align="right" style="color:#3384bc;width:15%;">商品标题：</td>
                        <td style="width:35%">{{$data['goods_name']}}</td>
                    </tr>
                    <tr>
                        <td align="right" style="color:#3384bc;">游戏区服：</td>
                        <td>{{$data['game']['game_name']}} / {{$data['da_qu']['qu_name']}} / {{$data['xia_qu']['qu_name']}}/{{$data['has_many_type']['type']}}</td>
                        <td align="right" style="color:#3384bc;">订单数量：</td>
                        <td><span style="color:Red;">{{$order['buy_number']}}</span></td>
                    </tr>
                    <tr>
                        <td align="right" style="color:#3384bc;">订单金额：</td>
                        <td><span style="color:Red;font-weight:bold;">{{$order['order_amount']}}</span> 元</td>
                    </tr>
                    <tr>
                        <td align="right" style="color:#3384bc;">购买时间：</td>
                        <td>{{date('Y-m-d H:i:s',$order['created_at'])}}</td>
                        <td align="right" style="color:#3384bc;">订单状态：</td>
                        <td>
                            @if($order['order_status']=='1')正在发货@elseif($order['order_status']=='2')待确认收货@elseif($order['order_status']=='3')交易成功
                            @elseif($order['order_status']=='4')交易取消@elseif($order['pay_status']=='0')等待支付@elseif($order['pay_status']=='1')支付成功，等待发货
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="color:#3384bc;">收货角色名称：</td>
                        <td>
                            <span style="color:Red;font-weight:bold;">
                                {{$info->role_name}}
                            </span>
                        </td>
                        <td align="right" style="color:#3384bc;">收货联系电话：</td>
                        <td>
                            <span style="color:Red;font-weight:bold;">
                                {{$info->telphone}}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="color:#3384bc;">处理进度：</td>
                        <td colspan="3" style="line-height:30px;">
                            <span style="color:#999999">{{date('Y-m-d H:i:s',$order['created_at'])}}   买家购买商品生成订单</span><br>
                            @if(!empty($order_act))
                            @foreach($order_act as $v)
                                @if($v['order_status']=='1' && $v['order_status']=='0')<span style="color:#999999">{{date('Y-m-d H:i:s',$v['log_time'])}}   完成支付</span><br>
                                    @elseif($v['order_status']=='1')
                                        <span style="color:#999999">{{date('Y-m-d H:i:s',$v['log_time'])}}   正在发货中</span><br>
                                    @endif
                            @endforeach
                            @endif
                        </td>
                    </tr>

                    <tr style="height:60px;line-height:60px;">
                        <td></td>
                        <td colspan="3"><span style="color:Red;font-weight:bold; width:250px;">请您一定要核对收获角色名是否一致，不一致请不要确认收货并及时联系客服</span></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="padding-top:22px !important; height:60px; line-height:60px;">
                            <a href="{{url('/user/goods')}}" class="blue_btn" style="width:60px;height:20px;line-height:20px;display: inline-block;background-color: #0d91dc;color: #fff">返回列表</a>
                            <span style="color:red;font-weight:bold;"></span><br>
                            <span>若是收到的货物不正确，请联系客服QQ </span>
                            {{--<a href="tencent://message/?uin="><img border="0" title="联系客服" src="http://cdnimg.dd373.com/Content/styles/images/gi1.jpg"></a>--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection