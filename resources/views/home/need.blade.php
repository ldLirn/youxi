@extends('layouts.home')
@section('content')
@include('layouts.nav')
<section>
 <div class="w_1000 clearfix">
   <div class="buying-left">
      <div class="buying-title">求购简介</div>
      <div class="buying-theme">什么是求购？</div>
      <div class="buying-info">
          <div class="one">买家需要某些商品时，可以发布求购；卖家看到发布的求购订单，找到合适的订单下单交易。</div>
          <div class="two">
              <a href="{{url('needsPublish')}}"><span>去发布求购信息</span></a>
              <P>在没有搜索到喜爱的商品时，可通过发布求购信息购买所需物品！</P>
          </div>
          <div class="three">
              <a href="{{url('all_game')}}"><span>去搜索求购信息</span></a>
              <P>只要在求购列表中看到合适自己的求购信息，就可快速出售商品，变被动为主动，再不用苦苦等待！</P>
          </div>
      </div>
      <div class="buying-info-line"></div>
       <div class="buying-theme">买家求购流程</div>
       <div class="buying-process">
           <ul class="clearfix">
               <li>注册登录并充值</li>
               <li>发布求购信息</li>
               <li>卖家出售</li>
               <li>交易员发货</li>
               <li>查收物品</li>
           </ul>
       </div>
       <div class="buying-theme green">卖家出售流程</div>
       <div class="buying-process green">
           <ul class="clearfix">
               <li>注册登录</li>
               <li>搜索求购信息</li>
               <li>填写订单</li>
               <li>发货</li>
               <li>查收货款</li>
           </ul>
       </div>
   </div>
   <div class="buying-right">
       <div class="buying-box1">
           <div class="buying-title red"><span>求购信息</span><a href="">查看更多>></a> </div>
           <ul>
               @foreach($needs as $k=>$v)
               <li @if($k==2) class="last" @endif>
                   <P>{{ $v->created_at->diffForHumans() }}：<span class="red">{{str_limit($v['user']['name'], $limit = 2, $end = '***')}}在【{{$v['game']['game_name']}}】</span></P>
                   <P class="red">求购{{$v['goods_price']}}</P>
                   <P class="blue"><a href="{{url('/category/'.Hashids::encode($v['game_id']).'?traded_type='.$v['traded_type'].'&qu='.$v['DaQu']['qu_name'].'&fwq='.$v['XiaQu']['qu_name'].'&type='.$v['hasManyType']['type'])}}">{{$v['goods_name']}}</a> </P>
               </li>
                @endforeach
           </ul>
       </div>
       <div class="buying-box2">
          <div class="buying-title">常见问题</div>
          <ul>
              @foreach($recommend_art as $v)
              <li><a href="{{url('help/detail/'.$v['id'].'?cat='.$v['cat_id'])}}">{{$v['title']}}</a> </li>
              @endforeach
          </ul>
       </div>
   </div>
 </div>
</section>
<div style="height: 20px;"></div>
@endsection