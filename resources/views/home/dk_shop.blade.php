@extends('layouts.home')
@section('content')
    @include('layouts.nav')

<section>
 <div class="w_1000">
    <div class="main-box clearfix">
       <div class="recharge-box">
            <ul class="shop_tb clearfix">
                <li>点卡</li>
                <li class="last">QQ</li>
            </ul>
            <div class="shop-box">
                <div class="hide" style="display: block;">
                    <div class="form">
                        <table>
                            <tr>
                                <td>游戏名称：</td>
                                <td><select><option>DOTA2</option></select></td>
                            </tr>
                            <tr>
                                <td>充值面额：</td>
                                <td><select><option>15元</option></select></td>
                            </tr>
                            <tr>
                                <td align="right">价格：</td>
                                <td class="red">14.73元</td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td><input type="button" value="确认购买" class="btn"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="hide">
                    dsdds
                </div>
            </div>
       </div>
       <div class="shop-banner">
           <div id="slideBox" class="slideBox">
               <div class="hd">
                   <ul><li>1</li><li>2</li><li>3</li></ul>
               </div>
               <div class="bd">
                   <ul>
                       <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/banner.jpg')}}" /></a></li>
                       <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/banner.jpg')}}" /></a></li>
                       <li><a href="#" target="_blank"><img src="{{asset(HOME_IMG.'shop/banner.jpg')}}" /></a></li>
                   </ul>
               </div>
           </div>
           <script  type="text/javascript">
               jQuery(".slideBox").slide({mainCell:".bd ul",effect:"fold",autoPlay:true});
           </script>
       </div>
       <div class="shop-right">
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
                        <li><a href="#">通知通知通知通知通知</a> <span>【07/06】</span></li>
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
    <div class="main-box clearfix">
        <div class="shop-search">
            <input type="text" class="txt" placeholder="请输入您要查找的关键字">
            <input  type="button" class="btn" value="快速搜索">
        </div>
        <div class="gamelist left">
            <div class="gamelist-top">
                <div class="title left">
                    <a href="#">查看更多&gt;&gt;</a>
                </div>
                <div class="letter-nav left">
                    <ul class="hua" id="letter">
                        @for($i=0;$i<26;$i++)
                            <li class=""><a>{{$str[$i]}}</a></li>
                        @endfor
                    </ul>
                    <ul class="gamenamebyfirst" id="dk_game_list">
                        @foreach($data as  $k=>$v)
                            @if(!empty($v))
                                @foreach($v as $m)
                                    <li type="{{$k}}"><a href="javascript:void(0)" data-action="{{$m->cardid}}">{{str_limit($m->cardname, $limit = 14, $end = '')}}</a></li>
                                @endforeach
                            @else
                                <li type="{{$k}}"><a href="javascript:" >没有数据</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="dk-box clear_both">
                <ul>
                    @foreach($rand as $v)
                    <li>
                        <dl>
                            <dt><a class="pic" href="{{url('dk_shop/dk_order?cz_dktype='.$v->cardid)}}" target="_blank"><img src="@if($v->thumb!=''){{$v->thumb}}@else{{asset(HOME_IMG.'shop/shop.jpg')}}@endif" width="75" height="75" /></a></dt>
                            <dd type="b">{{$v->cardname}}</dd>
                            <dd class="red">￥{{$v->memberprice}}元</dd>
                            <dd class="hide"><a class="btn" href="{{url('dk_shop/dk_order?cz_dktype='.$v->cardid)}}" target="_blank">立即购买</a></dd>
                        </dl>
                    </li>
                    @endforeach

                </ul>
            </div>
            <!--end-->
        </div>
        <div class="hot-product left">
            <div class="hot-pro-title">热销商品</div>
            <div class="hot-pro-ner">
                <ul>
                    @foreach($hot as $v)
                    <li>
                        <div class="wrap">
                            <div class="tp left"><a href="{{url('dk_shop/dk_order?cz_dktype='.$v->cardid)}}" target="_blank"><img src="@if($v->thumb!=''){{$v->thumb}}@else{{asset(HOME_IMG.'shop/shop2.jpg')}}@endif" width="63" height="54"></a></div>
                            <div class="wz left">
                                <a href="{{url('dk_shop/dk_order?cz_dktype='.$v->cardid)}}" target="_blank"><p>{{str_limit($v->cardname, $limit = 22, $end = '')}}</p></a>
                                <p>面值{{$v->pervalue}}</p>
                                <p class="red">￥{{$v->memberprice}}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
 </div>
</section>
<div style="height: 20px;"></div>
<script>
    $(function(){
        $('#dk_game_list li a').click(function(){
            $cardid = $(this).data('action');
            var url = "{{url('dk_shop/dk_order?cz_dktype=')}}";
            var pic = "{{asset(HOME_IMG.'shop/shop.jpg')}}";
            $.ajax({
                type: 'get',
                url: "{{url('dk/getDkFaceValueList')}}",
                data: { cardid: $cardid },
                dataType: 'jsonp',
                jsonp: "callback",
                success: function (res) {
                    var temp = [];
                    temp = eval(res);
                    var html = "";
                    $.each(temp, function (i, v) {
                        html += '<li>';
                        html += '<dl>';
                        if(v.thumb!=null){
                            html += '<dt><a class="pic" href="'+url+ v.cardid+'" target="_blank"><img src="'+ v.thumb+'" width="75" height="75" /></a></dt>';
                        }else{
                            html += '<dt><a class="pic" href="'+url+ v.cardid+'" target="_blank"><img src="'+pic+'" width="75" height="75" /></a></dt>';
                        }
                        html += '<dd type="b">'+ v.cardname+'</dd>';
                        html += '<dd class="red">￥'+ v.memberprice+'元</dd>';
                        html += '<dd class="hide"><a class="btn" href="'+url+ v.cardid+'" target="_blank">立即购买</a></dd>';
                        html += '</dl>';
                        html += '</li>';
                    });
                    $('.dk-box ul').html(html);
                }

            });
        })
    })

</script>
@endsection