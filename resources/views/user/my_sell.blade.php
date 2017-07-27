@extends('layouts.user')
@section('content')
    <link href="{{asset(HOME_CSS.'select-game.css') }}" rel="stylesheet" type="text/css">
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_sell') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我发布的商品</span><p>在这里你可以查询到发布的商品的信息</p></div>
            </div>

            @include('layouts.user_search')
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['order_status'])) class="current" @endif><a href="{{url('/user/MySell')}}">所有商品</a></span>
                     <span @if(isset($_GET['order_status'])  && $_GET['order_status']==11) class="current" @endif><a href="{{FilterManager::url('order_status', '11')}}">正在出售</a> </span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==12) class="current" @endif><a href="{{FilterManager::url('order_status', '12')}}">等待审核</a></span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==1) class="current" @endif><a href="{{FilterManager::url('order_status', '1')}}">审核成功</a></span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==2) class="current" @endif><a href="{{FilterManager::url('order_status', '2')}}">审核失败</a></span>
                     <span @if(isset($_GET['order_status']) && $_GET['order_status']==10) class="current" @endif><a href="{{FilterManager::url('order_status', '10')}}">下架</a></span>
                 </div>
                 <table>
               		 <thead>
                     <tr>
                         <th width="35%">宝贝信息</th>
                         <th width="15%">单价</th>
                         <th width="15%">数量</th>
                         <th width="15%">总价</th>
                         <th width="10%">状态</th>
                         <th>操作</th>
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
                                   <input type="checkbox" class="pay " value="{{$v->goods_code}}">
                                    &nbsp;商品编号：<a title="查看详情">{{$v->goods_code}}</a>
                                </span>
                                    <span>创建时间：{{$v->created_at}}</span>
                                <span>
                                </span>
                                </p>
                                <div class="ner">
                                    <div class="w40 bor_l left" style="width: 35%">
                                    <span class="stitle">
                                        <a class="transaction ico_bao" title="担保交易"></a>
                                        <a class="alink" title="{{$v->goods_name}}" href="{{url('/goods/'.Hashids::encode($v->id))}}" target="_blank">{{$v->goods_name}}</a>
                                    </span>
                                        <span class="hui2">{{$v->game_name}}/{{$v->da_qu}}/{{$v->qu_name}}/{{$v->type}}</span>
                                    </div>
                                    <div class="w16 bor_l left" style="width: 15%">{{$v->goods_price}}</div>
                                    <div class="w10 bor_l left" style="width: 15%">{{$v->goods_stock}}</div>
                                    <div class="w16 bor_l left" style="width: 15%">{{$v->goods_price*$v->goods_stock}}</div>
                                    <div class="w16 left" style="width: 10%;border-right: 1px solid #e6e6e6;height: 90px;">
                                    <span class="nomargin" style="line-height:20px; margin-top:20px;">
                                         @if($v->is_check=='0')
                                            <a target="_blank">{{trans('home.goods_check_0')}}</a>
                                         @elseif($v->is_check=='1')
                                            <a target="_blank" class="blue">{{trans('home.goods_check_1')}}</a></br>
                                            @if($v->is_check=='1' && $v->is_on_sale=='1')
                                                <a>正在售卖</a>
                                            @elseif($v->sale_end_time>time() || $v->is_on_sale=='0')
                                                <a>商品下架</a>
                                            @endif
                                         @elseif($v->is_check=='2')
                                            <a target="_blank" class="red">{{trans('home.goods_check_2')}}</a><br>
                                            <a class="spstate" oid="{{$v->id}}" os="-1">{{trans('home.goods_check_error')}}</a><br>
                                         @endif
                                    </span>

                                    </div>
                                    <div class="w16 left" style="width: 10%" style="line-height:20px; margin-top:20px;">
                                    <span class="nomargin" style="line-height:20px; margin-top:20px;">
                                         @if($v->is_check=='2')
                                         <a class="nopaycancel" href="{{url('/user/EditGoods?goods_id='.$v->id.'&uid='.$user['id'])}}">编辑</a>
                                         @endif
                                             @if($v->is_check=='1' && $v->is_on_sale=='1')
                                                <a class="nopaycancel" href="javascript:delConfig({{$v->id}},0)">下架</a>
                                                 @elseif(($v->is_check=='1' && $v->is_on_sale=='0' && $v->sale_end_time>time()))
                                                 <a class="nopaycancel" href="javascript:delConfig({{$v->id}},1)">上架</a>
                                             @endif
                                        <a class="nopaycancel" href="javascript:delConfig({{$v->id}},2)">删除</a>
                                    </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <script>
                            var cacheReason = {};
                            $(function () {
                                $(".spstate").mouseover(function (e) {
                                    var goodsId = $(this).attr("oid");
                                    var orderSt = $(this).attr("os");
                                    var cache = cacheReason["GoodsId" + goodsId];
                                    if (cache) {
                                        $("#failinfo").html(cache).show().css({ top: e.pageY + 15 + "px", left: e.pageX - 50 + "px" });
                                    } else {
                                        $.ajax({
                                            type: 'get',
                                            url: '{{web_url}}/center/GetOrderReason',
                                            data: { OrderId: goodsId, orderSt: orderSt },
                                            dataType: 'jsonp',
                                            jsonp: "callback",
                                            success: function (res) {
                                                cacheReason["GoodsId" + goodsId] = res.error_reson;
                                                $("#failinfo").html(res.error_reson).show().css({ top: e.pageY + 15 + "px", left: e.pageX - 50 + "px" });
                                            }
                                        });
                                    }
                                });
                                $(".spstate").mouseleave(function (e) {
                                    $("#failinfo").hide();
                                });

                            });

                            function delConfig(id,type) {
                                layer.confirm('{{trans('home.goods_cancel')}}', {
                                    btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"] //按钮
                                }, function(){
                                    $.ajax({
                                        url: "{{url('/user/goods/goodsOffSale')}}/"+id,
                                        data:{'_method':'delete','_token':"{{csrf_token()}}",'type':type},
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
                        </script>

                    </ul>
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
</script>
@endsection


