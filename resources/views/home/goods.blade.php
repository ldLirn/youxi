@extends('layouts.home')
@section('content')
    <link href="{{asset(HOME_CSS.'MagicZoom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'ShopShow.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'lightbox.min.css') }}" />
<section>
 <div class="w_1000">
    <div class="position">您的位置：<a href="#"> 首页</a> ><a href="{{url('/all_game')}}">全部游戏</a> > <a href="{{url('/category/'.Hashids::encode($data['game']['id']))}}">{{$data['game']['game_name']}}</a>  > 商品信息</div>
     <div class="buy-theme">{{$data['goods_name']}}</div>
     <div class="buy-detail-img">
         @if($data['goods_pic'])
             <div id="tsShopContainer">
                 <div id="tsImgS"><a href="{{$data['goods_pic'][0]['picture']}}" title="Images" class="MagicZoom" id="MagicZoom"><img width="300" height="300" src="{{$data['goods_pic'][0]['picture']}}" /></a></div>
                 <div id="tsPicContainer">
                     <div id="tsImgSArrL" onclick="tsScrollArrLeft()"></div>
                     <div id="tsImgSCon">
                         <ul>
                             @foreach($data['goods_pic'] as $k=>$v)
                             <li  rel="MagicZoom" @if($k=='0')class="tsSelectImg"@endif>
                                 <a class="example-image-link"
                                    href="{{$v['picture']}}"
                                    data-lightbox="goods_pic"><img height="42" width="42" src="{{$v['picture']}}" tsImgS="{{$v['picture']}}" /></a>
                             </li>
                             @endforeach
                         </ul>
                     </div>
                     <div id="tsImgSArrR" onclick="tsScrollArrRight()"></div>
                 </div>
                 <img class="MagicZoomLoading" width="16" height="16" src="{{asset(HOME_IMG.'loading.gif') }}" alt="Loading..." />

             </div>
         @else
             <img src="{{asset(HOME_IMG.'shop/buy8.jpg') }}" alt="默认商品图片">
         @endif
     </div>
     <div class="buy-detail-box">
         <p>{{trans('shop.goods_price')}}<span class="big">{{$data['goods_price']}}</span>元 @if($data['is_cut_price']=='1')<a href="{{url('/goods/changePrice/'.Hashids::encode($data['id']))}}" target="_blank" style="color: #4e8efd">求降价</a> @endif</p>
         <p>{{trans('shop.goods_code')}}{{$data['goods_code']}}</p>
         @if($data['one_num'])
         <P>{{trans('shop.one_num')}}{{$data['one_num']}}</P>
         <P>商品单价：<span>1元=33.33万金币</span>  0.0300元/万金币</P>
         @endif
         <P>{{trans('shop.goods_type')}}@if($data['traded_type']=='0'){{TRANSACTION_S}}@elseif($data['traded_type']=='1'){{TRANSACTION_D}}@else{{TRANSACTION_Q}}@endif</P>
         <P>{{trans('shop.goods_game')}}{{$data['game']['game_name']}} / {{$data['da_qu']['qu_name']}} / {{$data['xia_qu']['qu_name']}}</P>
         <P>{{trans('shop.goods_stock')}}{{$data['goods_stock']}}件</P>
         <P>{{trans('shop.sale_end_time')}}{{date('Y-m-d H:i:s',$data['sale_end_time'])}}</P>
         <P>{{trans('shop.best_time')}}{{$data['best_time']}}</P>
         <P>{{trans('shop.security')}}{{$data['security']}} </P>
         <div class="action">
             <input type="button" class="btn-orange"
                    value="@if($data['goods_stock']=='0' || $data['is_on_sale']=='0' || $data['sale_end_time']<time()){{trans('shop.Btn_end_sale')}}@elseif(($data['traded_type']!='2')){{trans('shop.Btn_buy')}}@elseif($data['traded_type']=='2'){{trans('shop.Btn_sell')}}@endif"
                    @if($data['goods_stock']!='0' && $data['is_on_sale']=='1' && $data['sale_end_time']>time())onclick='location.href="{{url('/buy/'.Hashids::encode($data['id']))}}"'@endif>
             <input type="button" class="btn-blue" value="加入收藏" onclick="add_Collection({{$data['id']}})">
         </div>
     </div>
      <div class="buy-detail-right">
          <div class="title">卖家信息</div>
          <div class="box">
              @if($user['id']==0)
             <div class="sdk_text user_ner_l"> <span style="float: left">安全认证:</span>
                  <p class="realName" href="" title="实名认证">官方自营</p>
              </div>
                  @else
                  <div class="sdk_text user_ner_l"> <span style="float: left">安全认证:</span>
                      <a class="@if($user['is_check_datecard']=='1')realName @else realName-grey @endif" href="" title="实名认证"></a>
                      <a class="@if($user['back_bd_img']!='')identity @else identity-grey @endif" href="" title="身份认证"></a>
                      <div class="clear_both"></div>
                  </div>
                  <P>卖家星级：<span><img src="{{$sell_rank['rank_img']}}"> </span></P>
                  <P>作为卖家成功笔数：<span>{{$sell_sum}}笔</span></P>
              @endif
          </div>
          @if($user['id']>0)
          <div class="box2">
              <div class="stitle">作为买家信息</div>
              <P>买家星级：<span><img src=" {{$buy_rank['rank_img']}}"></span></P>
              <P>作为买家成交笔数：<span>{{$buy_sum}}笔</span></P>
          </div>
          @endif
      </div>
     <div class="clear"></div>
    <div class="list-wrapper">
        <ul class="list-tab clearfix">
            <li class="current">商品详情</li>
            <li>购买指南</li>
        </ul>
        <div class="list-main">
            <div class="hide" style=" display: block;">
                <div class="buy-detail">
                    <div class="order-by">
                        <span>发布时间：{{$data['created_at']}} </span>
                        <span> {{trans('shop.goods_code')}}：{{$data['goods_code']}}</span>
                        <span>物品类型：{{$data['has_many_type']['type']}}</span>
                    </div>
                    <div class="goods_content">{!! $data['goods_content'] !!}</div>
                </div>
            </div>
            <div class="hide">
                <div class="buy-detail-zn">
                    <img src="{{asset(HOME_IMG.'shop/buy6.jpg') }}">

                </div>
            </div>
        </div>
    </div>
 </div>
</section>
<div style="height: 20px;"></div>
<script type="text/javascript" src="{{asset(HOME_JS.'ShopShow.js')}}"></script>
<script src="{{asset(PUBLIC_JS.'lightbox-plus-jquery.min.js') }}"></script>
    <script>
        function add_Collection(goods_id) {
            $.post("{{url('/add_Collection')}}",{goods_id:goods_id,'_token':"{{csrf_token()}}"},function (msg) {
                if(msg.status=='30'){
                    layer.msg(msg.info,{icon: 5});
                }else if(msg.status=='1'){
                    layer.msg(msg.info,{icon: 6});
                }else if(msg.status=='2'){
                    layer.msg(msg.info,{icon: 5});
                }else if(msg.status=='40'){
                    layer.msg(msg.info,{icon: 5});
                }
            })
        }
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>
@endsection
