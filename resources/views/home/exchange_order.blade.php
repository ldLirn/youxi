@extends('layouts.home')
@section('content')
<section>
 <div class="w_1000">
     <div class="buy-title">订单详细信息</div>

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
                         <td>{{$order_code}}</td>
                         <td>
                             <p>{{trans('shop.goods_name')}}{{$data['goods_name']}}</p>
                             <P>{{trans('shop.goods_price')}}{{$data['integral']}}积分</P>
                         </td>
                         <td>{{date('Y-m-d H:i:s',time())}}</td>
                     </tr>
                 </table>
             </dd>
         </dl>
     </div>
     <form action="{{$url.'?o='.$order_code}}" method="post" id="buy">
         <input type="hidden" name="_method" value="delete">
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

                     <tr>
                         <th>消耗积分：</th>
                         <td width="240"> <span id="goods_price">{{$data['integral']*$num}}</span> </td>
                         <td></td>
                     </tr>
                     <tr>
                         <th>购买数量：</th>
                         <td><input type="text" class="txt" placeholder="购买数量" value="{{$num}}" disabled="disabled" name="buy_number" size="1" datatype="num" nullmsg="请输入购买数量！" errormsg="数量必须是1-999的数字"></td>
                         <td></td>
                     </tr>
                     <tr>
                         <th>收货信息：</th>
                         <td>
                             <textarea style="width: 300px;height: 100px;" name="user_info"></textarea>
                            </td>
                         <td><div class="tip">请备注您的收货信息（如是游戏商品，请备注游戏，游戏区服，收货角色等）</div></td>
                     </tr>
                     <tr>
                         <td colspan="3"><div class="line"></div></td>
                     </tr>
                     <tr>
                         <th>您的联系手机：</th>
                         <td><input type="text" class="txt" placeholder="" name="telphone" value="{{Auth::user()->telphone}}" datatype="m" nullmsg="请输入手机号码！" errormsg="手机号码不正确！"></td>
                         <td><div class="tip"></div></td>
                     </tr>
                     <tr>
                         <th>您的QQ号码：</th>
                         <td><input type="text" class="txt" placeholder="" name="qq" value="{{Auth::user()->qq}}" datatype="qq" nullmsg="请输入QQ！" errormsg="QQ格式不正确！"></td>
                         <td><div class="tip"></div></td>
                     </tr>
                         <tr>
                             <th>支付密码：</th>
                             <td><input type="password" class="txt" placeholder="" name="pay_password" value="" datatype="s6-6" ajaxurl="{{url('/user/check_old_pass?_token='.csrf_token().'&t=1')}}" errormsg="支付密码格式不正确"></td>
                             <td><div class="tip"></div></td>
                         </tr>
                     <tr>
                         <th></th>
                         <td colspan="2"><input type="button" value="提交" onclick="$('#buy').submit()" id="buy_button"> </td>
                     </tr>
                 </table>
             </dd>
         </dl>
     </div>
         {!! csrf_field() !!}
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

    var a=$("#buy").Validform({
        tiptype:2,
        postonce:true,
        ajaxPost:true,
        callback:function(data){

            if(data.status=="y"){
                setTimeout(function(){
                    $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                },2000);
                window.location.href="{{url('/user/exchange/list')}}";
            }
        }
    });


</script>
@endsection
