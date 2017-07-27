@extends('layouts.home')
@section('content')
    @include('layouts.nav')
<section>
 <div class="w_1000">
    <div class="main-box clearfix">
        <div class="main_top">
            <div class="main_top_l" id="maintop_blue9">
                <!--title-->
                <div class="wrap" id="blue9_change_wrap">
                    <div class="m_r_12 left common" name="dk">
                        <div class="icon_dk icon" id="blue9_icon_dk"></div>
                        <div class="text" id="blue9_text_dk">
                            点卡充值
                        </div>
                    </div>
                    <div class="m_r_12 left common" name="qq">
                        <div class="icon_qq icon" id="blue9_icon_qq"></div>
                        <div class="text" id="blue9_text_qq">
                            QQ服务
                        </div>
                    </div>
                    <div class="hf left common" name="yx">
                        <div class="icon_hf icon" id="blue9_icon_hf"></div>
                        <div class="text" id="blue9_text_hf">
                            手机话费
                        </div>
                    </div>
                </div>
                <div class="wrap hh">
                    <div class="common m_r_12 left" href="#">
                        <img class="hot_tip2" src="{{asset(HOME_IMG.'shop/new_hot.png') }}" />
                        <div class="icon_sy ">
                            <img src="{{asset(HOME_IMG.'shop/indexsy_icon.jpg') }}" />
                        </div>
                        <div class="text">
                            <a href="#" target="_blank">首充号</a>
                        </div>
                    </div>
                    <div class="common m_r_12 left" href="#">
                        <img class="hot_tip2" src="{{asset(HOME_IMG.'shop/new_new.gif') }}" />
                        <div class="icon_sc">
                            <img width="29" height="25" src="{{asset(HOME_IMG.'shop/yx1.jpg') }}" />
                        </div>
                        <div class="text">
                            <a href="#" target="_blank">游戏代练</a>
                        </div>
                    </div>
                    <div class="hf common left" href="#">
                        <div class="icon_lb">
                            <img src="{{asset(HOME_IMG.'shop/indexlb_icon.jpg') }}" />
                        </div>
                        <div class="text">
                            <a href="#" target="_blank">游戏礼包</a>
                        </div>
                    </div>
                </div>
                <div class="wrap hh">
                    <div class="common m_r_12 left">
                        <a href="{{url('help/safe/Verification?tag=qq')}}">
                        <div class="icon icon_qq">
                        </div>
                        <div class="text">
                            <a href="{{url('help/safe/Verification?tag=qq')}}">客服验证</a>
                        </div>
                        </a>
                    </div>
                    <div class="common m_r_12 left">
                        <a href="{{url('help/safe/Verification?tag=url')}}">
                        <div class="icon icon_wz">
                        </div>
                        <div class="text">
                            <a href="{{url('help/safe/Verification?tag=url')}}">网址验证</a>
                        </div>
                        </a>
                    </div>
                    <div class="hf common left">
                        <div class="icon icon_zzfw">
                        </div>
                        <div class="text">
                            <a href="">增值服务</a>
                        </div>
                    </div>
                </div>
                <!--dk-nering-->
                <form action="{{url('dk_shop/dk_order')}}"  name="diankaform" id="diankaform">
                    <div class="dk_nr" style="display: none;" id="blue9_hide_dk">
                        <div class="name">
                            <div class="name-l left">
                                游戏名称：
                            </div>
                            <div class="name-r left">
                                <select name="cz_gameid" id="cz_gameid">
                                    <option value="">请选择</option>
                                    @foreach($dk_game_list as $v)
                                    <option value="{{$v->cardid}}">{{$v->cardname}}</option>
                                    @endforeach
                                 </select>
                            </div>
                        </div>
                        <div class="name">
                            <div class="name-l left">
                                充值类型：
                            </div>
                            <div class="name-r left">
                                <select name="cz_dktype" id="cz_dktype"><option value="">无</option></select>
                            </div>
                        </div>

                        <div class="jiage">
                            <div class="left name-l">
                                价格：
                            </div>
                            <div class="left">
                                <span class="yahei14 red"><strong id="SalePrice_dk">0.00</strong></span> 元
                            </div>
                        </div>
                        <div class="button">
                            <a class="red_btn" href="javascript:void(0)" target="_blank"  id="dkbiz_a">确认购买</a>
                        </div>
                    </div>
                </form>
                <!--QQ-nering-->
                <div class="QQ_nr" style="display: none;" id="blue9_hide_qq">
                    <form action="#" id="qbform" target="_blank" autocomplete="off" method="get">
                        <div class="name mr-t">
                            <div class="name-l left">
                                QQ号码：
                            </div>
                            <div class="name-r left">
                                <input class="kuang" placeholder="请输入您的QQ号码" type="text" name="qq" maxlength="14" id="qbbiz_input" />
                            </div>
                        </div>
                        <div class="name">
                            <div class="name-l left">
                                类型：
                            </div>
                            <div class="name-r left">
                                <select id="qbbiz_type"> 
                                    <option>Q币</option> 
                                    <option>QQ会员</option> 
                                    <option>红钻贵族</option> 
                                    <option>黄钻贵族</option> 
                                    <option>绿钻贵族</option> 
                                    <option>蓝钻贵族</option> 
                                </select>
                            </div>
                        </div>
                        <div class="name">
                            <div class="name-l left">
                                面值：
                            </div>
                            <div class="name-r left">
                                <select id="qbbiz_value" name="i"><option mp="0.96" value="620">1元Q币</option><option mp="96.96" value="651">100元Q币</option></select>
                            </div>
                        </div>
                    </form>
                    <div class="jiage">
                        <div class="left name-l">
                            价格：
                        </div>
                        <div class="left">
                            <span class="yahei14 red"><strong id="qqdk_price">0.96</strong></span> 元
                        </div>
                    </div>
                    <div class="button">
                        <a class="red_btn" bizref="" id="qbbiz_a">立即充值</a>
                    </div>
                </div>
                <!--iphone-->
                <div class="iphone_nr" style="display: none;" id="blue9_hide_hf">
                    <div class="name" style="margin-bottom:0px;">
                        <div class="name-l left">
                            手机号码：
                        </div>
                        <div class="name-r left">
                            <input class="kuang" placeholder="请输入您的手机号码" maxlength="11" type="text" id="Phonerecharge" />
                        </div>
                    </div>
                    <div id="phonedeteil" class="icon1" style="color:red; text-align:center;"></div>
                    <div class="name" style="margin-bottom:0px;">
                        <div class="name-l left">
                            充值类型：
                        </div>
                        <div class="name-r left">
                            <input type="radio" checked="checked" name="Phonetype" value="Phone" />话费 &nbsp;&nbsp;
                            <input type="radio" name="Phonetype" value="Flow" />流量
                        </div>
                    </div>
                    <div class="name" style="margin-bottom:0px;display:none" id="Flow">
                        <div class="name-l left" style="margin-left:11px;">
                            <select class="kuang" id="Provice"> <option>全国流量</option> </select>
                        </div>
                        <div class="name-l left">
                            <select class="kuang" id="FlowList" style="width:150px;"> <option>请先输入充值号码</option> </select>
                        </div>
                    </div>
                    <div class="name" id="phonemoney">
                        <div class="name-l left">
                            金额：
                        </div>
                        <div class="name-r left">
                            <select name="" id="Phonemianzhi"> <option>10元&nbsp;&nbsp;&nbsp;</option> <option>20元&nbsp;&nbsp;&nbsp;&nbsp;</option> <option>50元&nbsp;&nbsp;&nbsp;&nbsp;</option> <option selected="selected">100元&nbsp;&nbsp;&nbsp;&nbsp;</option> </select>
                        </div>
                    </div>
                    <div class="jiagephone" style="height:25px;width:250px;">
                        <div class="left name-l">
                            价格：
                        </div>
                        <div id="SalePrice" style="color:#ff6600;line-height:26px;">
                            0.00元
                        </div>
                    </div>
                    <div class="button">
                        <a class="red_btn" target="_blank" href="javascript:void(0);" id="Phonesubmit">立即充值</a>
                    </div>
                </div>
            </div>
        </div>
		<div class="shop-banner">
           <div id="slideBox" class="slideBox">
               <div class="hd">
                   <ul>
                       @foreach($banner as $k=>$v)
                       <li>{{$k+1}}</li>
                       @endforeach
                   </ul>
               </div>
               <div class="bd">
                   <ul>
                       @foreach($banner as $v)
                       <li><a href="{{$v['banner_url']}}" target="_blank"><img src="{{$v['banner_img']}}"  alt="{{$v['banner_name']}}"/></a></li>
                       @endforeach
                   </ul>
               </div>
           </div>
           <script  type="text/javascript">
               jQuery(".slideBox").slide({mainCell:".bd ul",effect:"fold",autoPlay:true});
           </script>
       </div>
        <div class="account-buy game-right">
            <div class="box">
                <ul class="box-tab clearfix">
                    <li><a href="{{url('/login')}}">登录</a></li>
                    <li><a href="{{url('/register')}}">注册</a></li>
                    <li><a href="{{url('/all_game')}}">我要买</a></li>
                    <li><a href="{{url('/user/sell')}}">我要卖</a></li>
                </ul>
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
                            @foreach($notice as $k=>$v)
                            <li><a href="{{url('/news/detail/'.Hashids::encode($v['id']))}}">{{str_limit($v['title'], $limit = 20, $end = '..')}}</a>
                                <span>【{{$v->created_at->diffForHumans()}}】</span></li>
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
    </div>
    <div class="game-box clearfix">
        <dl class="clearfix">
            <dt>
               <p>真假客服验证 <span>识别假客服</span></p>
                <div>
                    <input type="text" class="txt" value="" placeholder="请输入客服QQ"  id="test_qq">
                    <input type="button" class="btn" value="验证" onclick="test()">
                    <script>
                        function test(){
                            var qq = $("#test_qq").val();
                            var reg = /^[1-9][0-9]{4,16}$/;
                            if(!reg.test(qq)){
                                layer.msg("{{trans('com.error_qq')}}");
                                return false;
                            }
                            window.location.href="{{url('/help/safe/Verification?tag=qq')}}"+'&qq='+$("#test_qq").val();
                        }
                    </script>
                </div>
            </dt>
            <dd>
                <div class="box">
                    <div class="left">最新动态</div>
                    <div class="info">
                        @foreach($new as $v)
                            <P><span class="blue">发布</span><a href="{{url('/goods/'.Hashids::encode($v->id))}}">{{$v->goods_name}}</a></P>
                            <P><span class="red">成交</span><a href="{{url('/goods/'.Hashids::encode($v->new['id']))}}"> {{$v->new['goods_name']}}</a></P>
                        @endforeach
                    </div>
                </div>
            </dd>
            <script>
                jQuery(".box").slide({mainCell:".info",autoPage:true,effect:"top",scroll:2,autoPlay:true,vis:2,easing:"easeOutCirc"});
            </script>
        </dl>
    </div>
    <div class="main-box clearfix">
        <div class="game-title">热门推荐</div>
        <div class="gamelist game-hot">
            <div class="gamelist-top">
                <div class="title left">
                    <a href="javascript:void(0)" name="select-game">选择游戏</a>
                </div>
                <div class="letter-nav left">
                    <ul class="hua" name="gm-yx">

                        @for($i=0;$i<26;$i++)
                        <li class=""><a>{{$str[$i]}}</a></li>
                        @endfor
                    </ul>
                    <ul class="gamenamebyfirst" name="cagegory">
                        @foreach($gameData as  $k=>$v)

                            @foreach($v as $m)
                                <li type="{{$k}}"><a href="{{url('/category/'.$m['id'])}}" @if($m['is_hot']=='1')style="color: #ff6600" @endif>{{$m['game_name']}}</a></li>
                            @endforeach

                       @endforeach
                    </ul>
                </div>
            </div>
            <div class="dk-box" name="dk-box">
                <ul>
                @foreach($recommendGame as $k=>$v)
                    <li>
                       <div class="item">
                           <div  class="pic"><a href="{{url('/category/'.Hashids::encode($v['id']))}}"><img src="{{$v['thumb']}}" alt="{{$v['game_name']}}"> </a></div>
                           <div class="box">
                               @foreach($v['has_many_type'] as $m=>$n)
                                   @if($m<3)
                                <a href="{{url('/category/'.Hashids::encode($v['id']).'?type='.$n['type'])}}" class="account">{{$n['type']}}</a>
                                   @endif
                               @endforeach
                           </div>
                       </div>
                    </li>
                @endforeach

                </ul>
            </div>
            <!--end-->
        </div>

    </div>
    <div class="game_list">
    	<div class="game-titlee">游戏列表</div>
        <div class="game_list_box">
        	<div class="game_list_left">
            	<div class="game_top">
                	<ul>

                        @for($i=0;$i<26;$i++)
                            <li class=""><a>{{$str[$i]}}</a></li>
                        @endfor

                    </ul>
                </div>
                <div class="warriors">
                	<div class="warr">
                    	<ul>
                            @foreach($gameData as  $k=>$v)
                                @if(!empty($v))
                                    @foreach($v as $m)
                                        <li type="{{$k}}"><a href="{{url('/category/'.$m['id'])}}" @if($m['is_hot']=='1')style="color: #ff6600" @endif>{{$m['game_name']}}</a></li>
                                    @endforeach
                                @else
                                    <li type="{{$k}}"><a href="javascript:" >没有数据</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
 				<div class="zb_box">
                	<ul>
                        @foreach($recommendGame as $k=>$v)
                            @if($k<5)
                    	<li>
                        	<div class="zb_img"><a href="{{url('/category/'.Hashids::encode($v['id']))}}"><img src="{{$v['thumb']}}" style="max-width: 120px" alt="{{$v['game_name']}}"></a></div>

                            <div class="zb_box">
                                @foreach($v['has_many_type'] as $m=>$n)
                                @if($m<3)
                                    <a href="{{url('/category/'.Hashids::encode($v['id']).'?type='.$n['type'])}}" >{{$n['type']}}</a>
                                @endif
                                @endforeach
                            </div>
                        </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="gl_game">
                	<div class="gl_box">
                    	<h3>网络游戏</h3>
                        <ul>
                        	<li><span>金币</span>
                                @foreach($jb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>新游</span>
                                @foreach($xy as $v)
                                <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>激活码</span>
                                @foreach($jhm as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>装备</span>
                                @foreach($zb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>账号</span>
                                @foreach($zh as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>元宝</span>
                                @foreach($yb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="gl_box">
                    	<h3>手机游戏</h3>
                        <ul>
                        	<li><span>热门</span>
                                @foreach($s_hot as $k=>$v)
                                    @if($k<=1)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                    @endif
                                @endforeach
                            </li>
                            <li><span>账号</span>
                                @foreach($s_zh as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>游戏币</span>
                                @foreach($s_yxb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>装备</span>
                                @foreach($s_zb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="gl_box">
                    	<h3>网页游戏</h3>
                        <ul>
                        	<li><span>热门</span>
                                @foreach($s_hot as $k=>$v)
                                    @if($k<=1)
                                        <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                    @endif
                                @endforeach</li>
                            <li><span>新游</span>
                                @foreach($w_xy as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>游戏币</span>
                                @foreach($w_yxb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>账号</span>
                                @foreach($w_zh as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>装备</span>
                                @foreach($w_zb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                            <li><span>元宝</span>
                                @foreach($w_yb as $v)
                                    <a @if($v['is_hot']=='1')class="col" @endif href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}}</a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="game_list_right">
            	<div class="phb_box">
                	<h3>排行榜</h3>
                    <div class="phb_img"><a href="#"><img src="{{asset(HOME_IMG.'shop/phb_img.png') }}"></a></div>
                    <div class="pbbs">
                    	<ul>
                            @foreach($top5 as $k=>$v)
                        	<li><a href="{{url('/category/'.Hashids::encode($v['id']))}}">{{$k+1}}. {{$v['game_name']}} </a><span>11-26</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="phb_box" style="margin-bottom:0;" id="phb_box">
                	<h3>免费游戏<a href="#">更多>></a></h3>
                    <div class="pbbs" id="FGame" style="height: 168px;">
                    	<ul id="free_game">
                            @foreach($freeGame as $k=>$v)
                        	<li><a href="{{url('/category/'.$v['id'])}}">{{$v['game_name']}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <script>
                        jQuery("#phb_box").slide({mainCell:"#FGame ul",autoPlay:true,effect:"topMarquee",vis:6,pnLoop:false,interTime:50,trigger:"click"});
                    </script>
                </div>
            </div>
        </div>
     </div>
    <div class="dk_box">
     	<div class="game-tit">点卡商城</div>
        <div class="dk_cent">
        	<div class="dk_cent_left">
            	<div class="zqz_img">
                    <a href="#"><img src="{{asset(HOME_IMG.'shop/dk_img01.jpg') }}"></a>
                    <a href="#"><img src="{{asset(HOME_IMG.'shop/dk_img02.jpg') }}"></a>
                    <a href="#"><img src="{{asset(HOME_IMG.'shop/dk_img03.jpg') }}"></a>
                </div>
                <div class="ckk_box">
                	<div class="account-tab" name="jksc">
             			<ul class="clearfix">
                 			<li class="current">客服代充</li>
                 			<li class="">卖家直充</li>
                 			<li class="">自动卡密</li>
                			<li class="">免费发卡</li>
             			</ul>
         		 	</div>
                    <div class="ckk">
                    	<div class="hide" style="display:block;">
                        	<div class="asdd"><span class="curren">100元</span><span>50元</span><span>30元</span><span>10元</span></div>
                            <ul>
                            	<li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                    <a href="#">立即购买</a>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                            </ul>
                        </div>
                        <div class="hide">
                        	<div class="asdd"><span class="curren">100元</span><span>50元</span><span>30元</span><span>10元</span></div>
                            <ul>
                            	<li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                    <a href="#">立即购买</a>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="hide">
                        	<div class="asdd"><span class="curren">100元</span><span>50元</span><span>30元</span><span>10元</span></div>
                            <ul>
                            	<li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                    <a href="#">立即购买</a>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                             
                            </ul>
                        </div>
                        <div class="hide">
                        	<div class="asdd"><span class="curren">100元</span><span>50元</span><span>30元</span><span>10元</span></div>
                            <ul>
                            	<li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                    <a href="#">立即购买</a>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                                <li>
                                	<div class="ckk_img"><img src="{{asset(HOME_IMG.'shop/ckk_img.jpg') }}"></div>
                                    <p>永恒之塔100元</p>
                                    <span>￥99.5</span>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dk_cent_right">
            	<div class="consulting">
                	<h3>咨询/建议/投诉</h3>
                    <ul>
                    @foreach($ask as $v)
                    	<li>
                        	<div class="consulting_text"><i></i><a href="{{url('help/ask/detail/'.$v['id'].'?type='.$v['type_id'])}}">[{{trans('ask_category.'.$v['type_id'])}}]{{str_limit($v['ask_title'], $limit = 20, $end = '...')}}</a></div>
                            <div class="consulting_text"><i class="cur"></i><a href="{{url('help/ask/detail/'.$v['id'].'?type='.$v['type_id'])}}">{{str_limit($v['answer'], $limit = 30, $end = '...')}}</a></div>
                       </li>
                    @endforeach
                    </ul>
                    <div class="consulting_btn"><a href="{{url('/help/ask?type=1')}}">我要咨询</a><a class="cec" href="{{url('/help/ask?type=2')}}">我要建议</a><a class="csc" href="{{url('/help/ask?type=3')}}">我要投诉</a></div>
                </div>
            </div>
        </div>
     </div>
    <div class="trading">
    	<div class="game-titc">交易信息</div>
        <div class="trading_box">
        	<div class="trading_left">
            	<div class="account-tab" name="zhjy">
             	  <ul class="clearfix">
                 	<li class="current">寄售信息</li>
                 	<li class="">担保信息</li>
                 	<li class="">求购信息</li>
                	<li class="">账号信息</li>
             	  </ul>
         		</div>
                <div class="yield">
                	<div class="hide" style="display:block;">
                    	<ul>
                        	<li>
                            	<h3>游戏区服</h3>
                                @foreach($s_data as $v)
                                <p><a href="{{url('/category/'.Hashids::encode($v['game']['id']).'?qu='.$v['da_qu']['qu_name'].'&fwq='.$v['xia_qu']['qu_name'])}}">{{$v['game']['game_name']}}/{{$v['da_qu']['qu_name']}}/{{$v['xia_qu']['qu_name']}}</a> </p>
                                @endforeach
                            </li>
                            <li class="curr">
                            	<h3>商品标题</h3>
                                @foreach($s_data as $v)
                                    <p><a href="{{url('/goods/'.Hashids::encode($v['id']))}}">{{str_limit($v['goods_name'], $limit = 40, $end = '..')}}</a> </p>
                                @endforeach

                            </li>
                            <li>
                            	<h3>价格</h3>
                                @foreach($s_data as $v)
                                    <p class="cdsl">{{$v['goods_price']}} </p>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="hide">
                    	<ul>
                        	<li>
                            	<h3>游戏区服</h3>
                                @foreach($d_data as $v)
                                    <p><a href="{{url('/category/'.Hashids::encode($v['game']['id']).'?qu='.$v['da_qu']['qu_name'].'&fwq='.$v['xia_qu']['qu_name'])}}">{{$v['game']['game_name']}}/{{$v['da_qu']['qu_name']}}/{{$v['xia_qu']['qu_name']}}</a> </p>
                                @endforeach
                                
                            </li>
                            <li class="curr">
                            	<h3>商品标题</h3>
                                @foreach($d_data as $v)
                                    <p><a href="{{url('/goods/'.Hashids::encode($v['id']))}}">{{str_limit($v['goods_name'], $limit = 40, $end = '..')}}</a> </p>
                                @endforeach
                                
                            </li>
                            <li>
                            	<h3>价格</h3>
                                @foreach($d_data as $v)
                                    <p class="cdsl">{{$v['goods_price']}} </p>
                                @endforeach
                                
                            </li>
                        </ul>
                    </div>
                    <div class="hide">
                    	<ul>
                        	<li>
                            	<h3>游戏区服</h3>
                                @foreach($q_data as $v)
                                    <p><a href="{{url('/category/'.Hashids::encode($v['game']['id']).'?qu='.$v['da_qu']['qu_name'].'&fwq='.$v['xia_qu']['qu_name'])}}">{{$v['game']['game_name']}}/{{$v['da_qu']['qu_name']}}/{{$v['xia_qu']['qu_name']}}</a> </p>
                                @endforeach
                                
                            </li>
                            <li class="curr">
                            	<h3>商品标题</h3>
                                @foreach($q_data as $v)
                                    <p><a href="{{url('/goods/'.Hashids::encode($v['id']))}}">{{str_limit($v['goods_name'], $limit = 40, $end = '..')}}</a> </p>
                                @endforeach
                               
                                
                            </li>
                            <li>
                            	<h3>价格</h3>
                                @foreach($q_data as $v)
                                    <p class="cdsl">{{$v['goods_price']}} </p>
                                @endforeach
                              	
                                
                            </li>
                        </ul>
                    </div>
                    <div class="hide">
                    	<ul>
                        	<li>
                            	<h3>游戏区服</h3>
                                @foreach($zhxx as $v)
                                    <p><a href="{{url('/category/'.Hashids::encode($v['game']['id']).'?qu='.$v['da_qu']['qu_name'].'&fwq='.$v['xia_qu']['qu_name'])}}">{{$v['game']['game_name']}}/{{$v['da_qu']['qu_name']}}/{{$v['xia_qu']['qu_name']}}</a> </p>
                                @endforeach


                            </li>
                            <li class="curr">
                            	<h3>商品标题</h3>
                                @foreach($zhxx as $v)
                                    <p><a href="{{url('/goods/'.Hashids::encode($v['id']))}}">{{str_limit($v['goods_name'], $limit = 40, $end = '..')}}</a> </p>
                                @endforeach
                                
                            </li>
                            <li>
                            	<h3>价格</h3>
                                @foreach($zhxx as $v)
                                    <p class="cdsl">{{$v['goods_price']}} </p>
                                @endforeach
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="trading_right">
            	<div class="reliable">
                	<h3>最新出售</h3>
                    <ul>
                        @foreach($new as $k=>$v)
                            @if($k<3)
                            <li>
                                <p>{{str_limit($v->goods_name, $limit = 20, $end = '..')}}</p>
                                <span>购买数量:{{$v->buy_number}}</span>
                                <div class="mpren">{{$v->order_amount}}元</div>
                            </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div> 
 </div>
</section>
<script>
    $(function(){
        $('#cz_gameid').change(function(){
            var game_id = $(this).val();
            if(game_id!=''){
                $.ajax({
                    type: 'get',
                    url: "{{web_url}}/dk/dk_game_info_local?game_id="+game_id,
                    dataType: 'jsonp',
                    jsonp: "callback",
                    success: function (temp) {
                       // console.log(temp);
                        var html = "";
                        $.each(temp, function (i, v) {
                            html += "<option mp='" + v.memberprice + "' value='" + v.cardid + "'>" + v.cardname + "</option>";
                        });
                        html = html == "" ? "<option value=''>无</option>" : html;
                        $('#cz_dktype').html(html);
                        $('#cz_dktype').change();
                    }
                });
            }
        });
        $('#cz_dktype').change(function(){
            var price = $(this).find('option:selected').attr('mp');
            $('#SalePrice_dk').html(price);
        });

        $('#dkbiz_a').click(function(){
            var gameid = $('[name=cz_gameid]').val();
            var cztype = $('[name=cz_dktype]').val();
            if($.trim(gameid)=='' || $.trim(cztype)==''){return false}
            $('#diankaform').submit();
        })
    })

</script>
@endsection