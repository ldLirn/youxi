@extends('layouts.home')
@section('content')
    @include('layouts.nav')
<style>
    .account-list ul li p{text-align: center}
</style>
<section>
 <div class="w_1000 clearfix">
   <div class="account-banner">
       <div id="slideBox" class="slideBox">
           <div class="hd">
               <ul>
                   @foreach($ads as $k=>$v)
                   <li>{{$k+1}}</li>
                   @endforeach
               </ul>
           </div>
           <div class="bd">
               <ul>
                   @foreach($ads as $v)
                   <li>{!! $v !!}}</li>
                    @endforeach
               </ul>
           </div>
       </div>
       <script  type="text/javascript">
           jQuery(".slideBox").slide({mainCell:".bd ul",effect:"fold",autoPlay:true});
       </script>
   </div>
   <div class="account-buy">
       <div class="box">
           <ul class="box-tab clearfix">
               <li><a href="{{url('all_game')}}">我要买</a> </li>
               <li><a href="{{url('user/sell')}}"> 我要卖</a> </li>
           </ul>
           <div class="sbox">
               <div class="hide" style="display: block">
                   <ul class="clearfix">
                       <li><a href="{{url('help/help')}}"><img src="{{asset(HOME_IMG.'shop/accout3.png')}}"><span>新手指南</span></a></li>
                       <li><a href="{{url('help/help')}}"><img src="{{asset(HOME_IMG.'shop/accout3.png')}}"><span>帮助中心</span></a></li>
                       <li><a href="{{url('help/ask')}}"><img src="{{asset(HOME_IMG.'shop/accout4.png')}}"><span>咨询专区</span></a></li>
                       <li><a href="{{url('help/safe/news/list')}}"><img src="{{asset(HOME_IMG.'shop/accout5.png')}}"><span>交易安全</span></a></li>
                   </ul>
               </div>
               <div class="hide"></div>
           </div>
       </div>
       <div class="box2">
           <ul class="shop_tb2 clearfix">
               <li class="current">公告</li>
               <li>交易安全</li>
               <li class="last" onclick='window.location.href="{{url('/help/help')}}"'>新手指南</li>
           </ul>
           <div class="shop-new">
               <div class="hide" style="display: block">
                   <ul>
                       @foreach($notice as $v)
                       <li><a href="{{url('/news/detail/'.Hashids::encode($v['id']))}}">{{str_limit($v['title'], $limit = 20, $end = '..')}}</a> <span>【{{$v->created_at->diffForHumans()}}】</span></li>
                       @endforeach
                   </ul>
               </div>
               <div class="hide">
                   <ul>
                       @foreach($help as $k=>$v)
                           <li><a href="{{url('/help/safe/news/detail/'.$v['id'])}}">{{str_limit($v['title'], $limit = 20, $end = '..')}}</a>
                               <span>【{{$v->created_at->diffForHumans()}}】</span></li>
                       @endforeach
                   </ul>
               </div>
               <div class="hide"></div>
           </div>
       </div>
   </div>

     <div class="account-main">
         <div class="title">兑换商品</div>
         <div class="account-tab">
             <ul class="clearfix">
                 <li class="current">全部商品</li>
             </ul>
         </div>
         <div class="account-list">
             <div class="hide" style="display: block;">
                <ul>
                @foreach($data as $v)
                    <li>
                        <div class="item">
                            <a href="{{url('/exchange/'.Hashids::encode($v['id']))}}"><img src="{{$v['pic']}}"> </a>
                            <p><a href="{{url('/exchange/'.Hashids::encode($v['id']))}}">{{$v['goods_name']}}</a> </p>
                            <P class="c-gray">剩余{{$v['stock']}}</P>
                            <P class="orange">{{$v['integral']}}积分</P>
                        </div>
                    </li>
                @endforeach
                </ul>
             </div>
         </div>
         <div class="page">
             {{$data->links()}}
         </div>
     </div>


 </div>
</section>
<div style="height: 20px;"></div>
@endsection