@extends('layouts.home')
@section('content')
<section>
 <div class="w_1000">
     <div class="buy-title">订单详细信息</div>
     <div class="buy-tip"></div>
     <div class="order-info clearfix">
         <dl>
             <dt>订单信息：</dt>
             <dd>
                 <table>
                     <tr>
                         <th>{{trans('shop.order_code')}}</th>
                         <th>{{trans('shop.goods_info')}}</th>
                         <th>{{trans('shop.trans_time')}}</th>
                     </tr>
                     <tr>
                         <td>{{$goods_data['order_sn']}}</td>
                         <td>
                             <p>{{trans('shop.goods_name')}}{{$goods_data['goods_name']}}</p>
                             <P>{{trans('shop.goods_game')}}{{$goods_data['game']['game_name']}}/{{$goods_data['da_qu']['qu_name']}}/{{$goods_data['xia_qu']['qu_name']}}/{{$goods_data['has_many_type']['type']}}</P>
                         </td>
                         <td>00.00</td>
                     </tr>
                 </table>
             </dd>
         </dl>
     </div>
     <form action="{{url('/postBuy')}}" method="post" id="buy">
         @if($goods_data['traded_type']!='2')
     <div class="buy-title">联系客服</div>
     <div class="order-list clearfix">
        <ul class="clearfix">
            <li>
                <a href="#"><img src="{{asset(HOME_IMG.'shop/buy10.jpg')}}"> </a>
                <P>寄售客服:名称</P>
                <P>发货速度:<span>3分钟</span></P>
                <P><input type="button"class="btn" value="已选"></P>
            </li>
            <li>
                <a href="#"><img src="{{asset(HOME_IMG.'shop/buy10.jpg')}}"> </a>
                <P>寄售客服:名称</P>
                <P>发货速度:<span>3分钟</span></P>
                <P><input type="button"class="btn" value="已选"></P>
            </li>
        </ul>
     </div>
         @endif
     <div class="fill-info clearfix">
         <dl>
             <dt>填写商品信息:</dt>
             <dd>
                 <table>
                     @if(count($errors)>0)
                     <tr>
                         <th></th>
                         <td width="240">
                             @foreach($errors->all() as $error)
                             <span >{{$error}}</span>
                             @endforeach
                         </td>
                         <td></td>
                     </tr>
                     @endif
                         @if(session('msg'))
                             <tr>
                                 <th></th>
                                 <td width="240">
                                     <span >{{session('msg')}}</span>
                                 </td>
                                 <td></td>
                             </tr>
                         @endif
                     @if($goods_data['pwd']!='')
                         <tr>
                             <th>交易密码：</th>
                             <td><input type="text" class="txt" placeholder="交易密码" name="pwd" datatype="*" nullmsg="此商品需要交易密码才能购买"></td>
                             <td></td>
                         </tr>
                      @endif
                     @if($goods_data['traded_type']!='2')
                     <tr>
                         <th>应支付金额：</th>
                         <td width="240"> <span id="goods_price">{{$goods_data['goods_price']}}</span> 元</td>
                         <td></td>
                     </tr>
                     <tr>
                         <th>购买数量：</th>
                         <td><input type="text" class="txt" placeholder="购买数量" name="buy_number" size="1" datatype="num" nullmsg="请输入购买数量！" errormsg="数量必须是1-999的数字" onkeyup="change_price(this)"></td>
                         <td></td>
                     </tr>
                     <tr>
                         <th>角色名称：</th>
                         <td><input type="text" class="txt" placeholder="角色名称" name="role_name" datatype="*" nullmsg="请填写角色名称！"></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td colspan="3"><div class="line"></div></td>
                     </tr>
                     <tr>
                         <th>您的手机号码：</th>
                         <td><input type="text" class="txt" placeholder="" name="telphone" value="{{Auth::user()->telphone}}" datatype="m" nullmsg="请输入手机号码！" errormsg="手机号码不正确！"></td>
                         <td><div class="tip"></div></td>
                     </tr>
                     <tr>
                         <th>您的QQ号码：</th>
                         <td><input type="text" class="txt" placeholder="" name="qq" value="{{Auth::user()->qq}}" datatype="qq" nullmsg="请输入QQ！" errormsg="QQ格式不正确！"></td>
                         <td><div class="tip"></div></td>
                     </tr>
                     <tr>
                         <th></th>
                         <td colspan="2" style="font-size: 12px;"><input type="checkbox" name="" datatype="*"  nullmsg="请同意寄售交易买家协议！"> 我同意 《<a href="javascript:show()" id="show_buyer_agreement">搜付在线服务网寄售交易买家协议</a>》</td>
                         <td><div class="tip"></div></td>
                     </tr>
                         @else
                             <tr>
                                 <th>游戏帐号：</th>
                                 <td><input type="text" class="txt"  name="game_user_name" datatype="*"></td>
                                 <td></td>
                             </tr>
                             <tr>
                                 <th>帐号密码：</th>
                                 <td><input type="password" class="txt"  name="game_user_pwd" datatype="*"></td>
                                 <td></td>
                             </tr>
                             <tr>
                                 <th>确认密码：</th>
                                 <td><input type="password" class="txt"   datatype="*" recheck="game_user_pwd" name="re_game_user_pwd"></td>
                                 <td><div class="tip"></div></td>
                             </tr>
                             <tr>
                                 <th>游戏角色名称：</th>
                                 <td><input type="text" class="txt" name="game_user"  datatype="*"></td>
                                 <td><div class="tip"></div></td>
                             </tr>
                             <tr>
                                 <th>二级密码：</th>
                                 <td><input type="password" class="txt"  name="two_level_pass" value="" ignore="ignore"  datatype="*"></td>
                                 <td><div class="tip">如没有则不填写</div></td>
                             </tr>
                             <tr>
                                 <th>仓库密码：</th>
                                 <td><input type="text" class="txt"  name="warehouse_pass" ignore="ignore"  datatype="*"></td>
                                 <td><div class="tip">如没有则不填写</div></td>
                             </tr>
                     @endif
                     <tr>
                         <th></th>
                         <td colspan="2"><input type="button" value="下一步" onclick="$('#buy').submit()" id="buy_button" style="cursor: pointer"> </td>
                     </tr>
                 </table>
             </dd>
         </dl>
     </div>
         {!! csrf_field() !!}
         <input type="hidden" name="order_sn" value="{{$goods_data['order_sn']}}">
         <input type="hidden" name="id" value="{{$goods_data['id']}}">
     </form>
 </div>

</section>
<div style="height: 20px;"></div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $.extend($.Datatype,{
        "num" : /^(?!0)[0-9]{1,3}$/,
        'qq' : /^[1-9][0-9]{4,}$/
    });
    var goods_stock = "{{$goods_data['goods_stock']}}";
    function show() {
        //页面层
        layer.open({
            type: 1,
            skin: 'footer_text', //加上边框
            area: ['420px', '240px'], //宽高
            content: 'html内容'
        });
    }
    var a=$("#buy").Validform({
        tiptype:2,
        postonce:true,
        callback:function(form){
            var check=parseInt($('[name=buy_number]').val())<=parseInt(goods_stock);
            if(check){
                form[0].submit();
            }else{
                a.resetStatus();
                layer.msg('最大购买件数为'+goods_stock);
                return false;
            }
        }
    });


    function change_price(obj) {
       var num = $(obj).val();
        if(parseInt(num)>parseInt(goods_stock)){
            layer.msg('最大购买件数为'+goods_stock);
            return false;
        }
       var goods_price = "{{$goods_data['goods_price']}}"
       var total = (Number(num * goods_price)).toFixed(2);
       $('#goods_price').html(total);
    }

</script>
@endsection
