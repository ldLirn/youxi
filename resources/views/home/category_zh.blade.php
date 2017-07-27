@extends('layouts.home')
@section('content')
    @include('layouts.nav')

<section>
 <div class="w_1000 clearfix">
   <div class="account-banner">
       <div id="slideBox" class="slideBox">
           <div class="hd">
               <ul><li>1</li><li>2</li><li>3</li></ul>
           </div>
           <div class="bd">
               <ul>
                   <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/accout1.jpg')}}" /></a></li>
                   <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/accout1.jpg')}}" /></a></li>
                   <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/accout1.jpg')}}" /></a></li>
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
               <li>我要买</li>
               <li>我要卖</li>
           </ul>
           <div class="sbox">
               <div class="hide" style="display: block">
                   <ul class="clearfix">
                       <li><a href="#"><img src="{{asset(HOME_IMG.'shop/accout3.png')}}"><span>新手指南</span></a></li>
                       <li><a href="#"><img src="{{asset(HOME_IMG.'shop/accout3.png')}}"><span>帮助中心</span></a></li>
                       <li><a href="#"><img src="{{asset(HOME_IMG.'shop/accout4.png')}}"><span>咨询专区</span></a></li>
                       <li><a href="#"><img src="{{asset(HOME_IMG.'shop/accout5.png')}}"><span>交易安全</span></a></li>
                   </ul>
               </div>
               <div class="hide"></div>
           </div>
       </div>
       <div class="box2">
           <ul class="shop_tb2 clearfix">
               <li class="current">公告</li>
               <li>交易安全</li>
               <li class="last">新手指南</li>
           </ul>
           <div class="shop-new">
               <div class="hide" style="display: block">
                   <ul>
                       <li><a href="#">通知通知通知通知通知</a> <span>【07/06】</span></li>
                       <li><a href="#">通知通知通知通知通知</a> <span>【07/06】</span></li>
                       <li><a href="#">通知通知通知通知通知</a> <span>【07/06】</span></li>
                   </ul>
               </div>
               <div class="hide">22</div>
               <div class="hide">333</div>
           </div>
       </div>
   </div>

     <div class="account-main">
         <div class="title">热门推荐</div>
         <div class="account-tab">
             <ul class="clearfix">
                 <li class="current">全部游戏</li>
                 <li>地下城与勇士</li>
                 <li>新天下无双</li>
                 <li>艾尔之光</li>
                 <li>新天下无双</li>
                 <li>艾尔之光</li>
             </ul>
         </div>
         <div class="account-list">
             <div class="hide" style="display: block;">
                <ul>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a>
                            <div class="devel">
                                <label>安全等级</label>
                                <span></span>
                            </div>
                            <p><a href="#">【帝血弑天 男 …</a> </p>
                            <P class="c-gray">河南区/河南3区</P>
                            <P class="orange">￥5000.00</P>
                        </div>
                    </li>
                </ul>
             </div>
             <div class="hide">地下城与勇士</div>
             <div class="hide">新天下无双</div>
             <div class="hide">艾尔之光</div>
             <div class="hide">新天下无双</div>
             <div class="hide">艾尔之光</div>
         </div>
     </div>

     <div class="account-main case">
         <div class="title success">成功案例</div>
         <div class="account-case">
             <ul>
                 <li>
                     <div class="item">
                         <div class="pic"><a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a></div>
                         <div class="box">
                             <P><a href="#">地下城与勇士</a><span class="orange">￥5000.00</span></P>
                             <div class="info">
                                 <p>纯阳 双天赋 男 90级 恶人谷 成男</p>
                                 <p>90CW赤霄道长，PVE9026，PVP9245，下周14阶</p>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     <div class="item">
                         <div class="pic"><a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a></div>
                         <div class="box">
                             <P><a href="#">地下城与勇士</a><span class="orange">￥5000.00</span></P>
                             <div class="info">
                                 <p>纯阳 双天赋 男 90级 恶人谷 成男</p>
                                 <p>90CW赤霄道长，PVE9026，PVP9245，下周14阶</p>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     <div class="item">
                         <div class="pic"><a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a></div>
                         <div class="box">
                             <P><a href="#">地下城与勇士</a><span class="orange">￥5000.00</span></P>
                             <div class="info">
                                 <p>纯阳 双天赋 男 90级 恶人谷 成男</p>
                                 <p>90CW赤霄道长，PVE9026，PVP9245，下周14阶</p>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     <div class="item">
                         <div class="pic"><a href="#"><img src="{{asset(HOME_IMG.'shop/accout8.jpg')}}"> </a></div>
                         <div class="box">
                             <P><a href="#">地下城与勇士</a><span class="orange">￥5000.00</span></P>
                             <div class="info">
                                 <p>纯阳 双天赋 男 90级 恶人谷 成男</p>
                                 <p>90CW赤霄道长，PVE9026，PVP9245，下周14阶</p>
                             </div>
                         </div>
                     </div>
                 </li>
             </ul>
         </div>

         <div class="account-hot">
             <div class="theme">极品账号TOP 10</div>
             <ul class="hot-hot">
                 <li class="current">未售</li>
                 <li>已售</li>
             </ul>
             <div class="sbox">
                 <div class="hide" style="display: block">
                    <ul>
                     <li><span>1.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>2.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>3.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>4.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>5.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>6.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                     <li><span>7.</span><a href="#">地下城与勇士</a><span>￥5000.00</span></li>
                    </ul>
                 </div>
                 <div class="hide"></div>
             </div>
         </div>

     </div>

 </div>
</section>
<div style="height: 20px;"></div>
@endsection