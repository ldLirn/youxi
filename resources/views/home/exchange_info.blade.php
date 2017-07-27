@extends('layouts.home')
@section('content')
    <style>
        #exchangeNum .num{border:1px solid #e0e0e0;padding:6px 0 4px; width:48px; text-align:center;font-size:12px;}
        #exchangeNum .minus{margin-left:24px;}
        #exchangeNum.excnum .plus{margin-right:10px;}
        .mgb10{margin-bottom:10px;}
        #exchangeNum .m_p{cursor:pointer; border:1px solid #e0e0e0; font-weight:bold;font-size:14px; background-color:#ededed;padding:2px 10px 6px;}
    </style>
<section>
 <div class="w_1000">
    <div class="position">您的位置：{!! Breadcrumbs::render('exchange_info') !!}</div>
     <div class="buy-theme">{{$data['goods_name']}}</div>
     <div class="buy-detail-img">
             <img src="{{$data['pic']}}" alt="{{$data['goods_name']}}">
     </div>
     <div class="buy-detail-box">
         <p></p>
         <p></p>
         <p>{{trans('shop.goods_price')}}<span class="big">{{$data['integral']}}</span>积分</p>
         <P>{{trans('shop.goods_stock')}}{{$data['stock']}}件</P>
         <P>最多兑换:{{$data['max_exchange']}}件</P>
         <form id="exchange_form" method="post">
             {{csrf_field()}}
         <p id="exchangeNum" class="mgb10 excnum">兑换数量：<span class="m_p minus">-</span><input class="num" name="num" id="jf_count" type="text" value="1"><span class="m_p plus">+</span><span>还可兑换<font id="canbuy">{{$sy_count}}</font></span></p>
         <div class="action">
             <input type="button" class="btn-orange"
                    value="@if($data['stock']=='0')商品下架@else立即兑换@endif"
                    @if($data['stock']!='0') onclick="check_exchange()"  @endif>
         </div>
         </form>
     </div>

     <div class="clear"></div>
    <div class="list-wrapper">
        <ul class="list-tab clearfix">
            <li class="current">商品详情</li>
        </ul>
        <div class="list-main">
            <div class="hide" style=" display: block;">
                <div class="buy-detail">
                    <div class="goods_content">{!! $data['content'] !!}</div>
                </div>
            </div>
        </div>
    </div>
 </div>
</section>
<div style="height: 20px;"></div>
<script>
    var max = "{{$data['max_exchange']}}";
    $("#exchangeNum .minus").click(function(){
        var val = $(this).siblings("#jf_count").attr("value");
        if(val>1){
            $(this).siblings("input").attr("value",val-1);
            $(this).siblings("input").val(val-1);
        }
    })
    $("#exchangeNum .plus").click(function(){
        var val = $(this).siblings("#jf_count").attr("value");
        var num = $("#canbuy").text();
        if (parseInt(val) < parseInt(num)) {
            $(this).siblings("#jf_count").attr("value", val * 1 + 1);
            $(this).siblings("input").val(val * 1 + 1);
        }
    })
    function check_exchange() {
        var stock = "{{$data['stock']}}";
        var integral = "{{$data['integral']}}";
        var myscore = "{{$user['integral']}}";
        var num = $("#jf_count").val();
        var sy = "{{$sy_count}}}";
        if (parseInt(integral) *parseInt(num) > parseInt(myscore)) {
            layer.msg('您的可以积分不足');
            return false;
        }
        else if(parseInt(num)>parseInt(stock)){
            layer.msg('兑换数量不能大于库存');
            return false;
        }
        else if(parseInt(num)>parseInt(sy)){
            layer.msg('兑换数量不能大于剩余兑换数量');
            return false;
        }
        else {
            $('#exchange_form').submit();
        }
    }

    $("#exchangeNum #jf_count").bind('input keyup', function () {
        var v = $(this).val();
        if(parseInt(v)>parseInt(max)){
            layer.msg('您的最大兑换数量为'+max);
        }
        $(this).attr("value",max);
    })
</script>
@endsection
