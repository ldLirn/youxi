@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'lightbox.min.css') }}" />
    <style>
        table.add_tab tr th{font-weight: bold;width: 20%;}
        table.add_tab tr td{width: 30%;}
    </style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/order')}}">订单管理</a> &raquo; 查看订单
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>查看订单</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
            @if(session('msg'))
                <div class="mark">
                    <p>{{session('msg')}}</p>
                </div>
            @endif
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form onsubmit="return check_form()" action="{{url('admin/order/'.$data['id'])}}" method="post">
            <table class="add_tab">
                <tbody>

                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        商品信息
                    </td>
                </tr>

                <tr>
                    <th>商品名:</th>
                    <td>
                       {{$goods_info['goods_name']}}
                    </td>
                    <th >商品编号:</th>
                    <td>
                        {{$goods_info['goods_code']}}
                    </td>
                </tr>

                <tr>
                    <th >商品单价:</th>
                    <td>
                        {{$goods_info['goods_price']}}
                    </td>
                    <th >交易截止日期:</th>
                    <td>
                        {{date('Y-m-d H:i:s',$goods_info['sale_end_time'])}}
                    </td>
                </tr>
                <tr>
                    <th >商品所属游戏:</th>
                    <td>
                        {{$goods_info['game_cate']['cat_name']}}/{{$goods_info['game']['game_name']}}
                    </td>
                    <th >区服:</th>
                    <td>
                        {{$goods_info['da_qu']['qu_name']}}/{{$goods_info['xia_qu']['qu_name']}}
                    </td>
                </tr>
                <tr>
                    <th >商品类型:</th>
                    <td>
                        {{$goods_info['has_many_type']['type']}}
                    </td>
                    <th >库存:</th>
                    <td>
                        {{$goods_info['goods_stock']}}
                    </td>
                </tr>
                <tr>
                    <th >商品交易类型:</th>
                    <td>
                        @if($goods_info['traded_type']=='0')寄售商品@elseif($goods_info['traded_type']=='1')担保商品
                            @elseif($goods_info['traded_type']=='2')求购商品@endif
                    </td>
                    <th >保障措施:</th>
                    <td>
                        {{$goods_info['security']}}
                    </td>
                </tr>
                <tr>
                    <th >交易成功汇款方式:</th>
                    <td>
                        @if($goods_info['to_money']=='0')账户余额@elseif($goods_info['to_money']=='1')银行卡@elseif($goods_info['to_money']=='2')支付宝@endif
                    </td>
                    <th >汇款帐号:</th>
                    <td>
                        {{$goods_info['account']}}
                    </td>
                </tr>
                <tr>
                    <th >商品登录名:</th>
                    <td>
                        {{$goods_info['game_user_info']['game_user_name']}}
                    </td>
                    <th >密码:</th>
                    <td>
                        {{$goods_info['game_user_info']['game_user_pwd']}}
                    </td>
                </tr>
                <tr>
                    <th >商品游戏昵称:</th>
                    <td>
                        {{$goods_info['game_user_info']['game_user']}}
                    </td>
                    <th >密保手机:</th>
                    <td>
                        {{$goods_info['game_user_info']['mb_tel']}}
                    </td>
                </tr>
                <tr>
                    <th >密保问题及答案:</th>
                    <td>
                        {{$goods_info['game_user_info']['mb_question']}}/{{$goods_info['game_user_info']['mb_answer']}}
                    </td>
                    <th >密保卡:</th>
                    <td>
                        @if($goods_info['game_user_info']['secretcard_img'])
                        <a class="example-image-link" href="{{$goods_info['game_user_info']['secretcard_img']}}" data-lightbox="example-1">
                            <img class="example-image" src="{{$goods_info['game_user_info']['secretcard_img']}}" alt="image-1" style="max-width: 120px;max-height: 100px;" ></a>
                        @else

                        @endif
                    </td>

                </tr>

                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        发布人信息
                    </td>
                </tr>
                @if($goods_info['user'])
                <tr>
                    <th >用户名:</th>
                    <td>
                        {{$goods_info['user']['name']}}
                    </td>
                    <th >邮箱:</th>
                    <td>
                        {{$goods_info['user']['email']}}
                    </td>
                </tr>
                <tr>
                    <th >手机:</th>
                    <td>
                        {{$goods_info['user']['telphone']}}
                    </td>
                    <th >QQ:</th>
                    <td>
                        {{$goods_info['user']['qq']}}
                    </td>
                </tr>
                    @else
                <tr>
                    <th ></th>
                    <td width="50%">
                        官方自营
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        买家信息及收货信息
                    </td>
                </tr>
                <tr>
                    <th >用户名:</th>
                    <td>
                        {{$user_info['name']}}
                    </td>
                    <th >邮箱:</th>
                    <td>
                        {{$user_info['email']}}
                    </td>
                </tr>
                <tr>
                    <th >联系电话:</th>
                    <td>
                        {{$order_address['telphone']}}
                    </td>
                    <th >QQ:</th>
                    <td>
                        {{$order_address['qq']}}
                    </td>
                </tr>
                <tr>
                    <th >角色名称:</th>
                    <td>
                       {{$order_address['role_name']}}
                    </td>
                    <th >游戏名/区服:</th>
                    <td>
                        {{$order_address['game_name']['game_name']}}<br/>
                        {{$order_address['da_qu_name']['qu_name']}}/{{$order_address['xia_qu_name']['qu_name']}}
                    </td>
                </tr>
                <tr>
                    <th >订单附言:</th>
                    <td>
                        {{$data['postmsg']}}
                    </td>
                </tr>


                <tr>
                    @if($data['order_status']!='2' && $data['order_status']!='3')
                    <td style="text-align: center;" colspan="4">
                        <a href="{{url('admin/order/edit_user_info_view?user_id='.$user_info['id'].'&order_id='.$data['id'])}}"><input type="button" value="修改收货信息" name="act"></a>
                    </td>
                    @endif
                </tr>

                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        费用信息
                    </td>
                </tr>
                <tr>
                    <th >商品单价:</th>
                    <td>
                        {{$goods_info['goods_price']}}
                    </td>
                    <th >购买数量:</th>
                    <td>
                        {{$data['buy_number']}}
                    </td>
                </tr>
                <tr>
                    <th >订单总价:</th>
                    <td>
                        {{$data['order_amount']}}
                    </td>
                    <th >付款状态:</th>
                    <td>
                        <p class="red">@if($data['pay_status']=='0')未付款@elseif($data['pay_status']=='1')已付款@endif</p>
                    </td>
                </tr>
                <tr>
                @if($data['order_status']!='2' && $data['order_status']!='3' && $data['pay_status']=='0')
                    <td style="text-align: center;" colspan="4">
                        <a href="{{url('admin/order/edit_money?order_id='.$data['id'])}}"><input type="button" value="修改费用" name="act"></a>
                    </td>
                @endif
                </tr>
                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        操作信息
                    </td>
                </tr>
                <tr>
                    <th ><i class="require">*</i>操作备注:</th>
                    <td>
                        <textarea name="action_note"></textarea>
                    </td>
                </tr>
                <script>
                    function check_form() {

                        if($.trim($('[name=action_note]').val())==''){
                            layer.msg('请填写操作备注', {icon: 5});
                            return false;
                        }
                    }
                </script>
                <input name="pay_status" value="{{$data['pay_status']}}" type="hidden">
                <tr>
                    <th >当前状态:</th>
                    <td>
                        <p class="red" style="font-size: 18px;">@if($data['order_status']=='0'){{NOT_OPERATE}}@elseif($data['order_status']=='1'){{DELIVER}}@elseif($data['order_status']=='2'){{CONFIRM}}@elseif($data['order_status']=='3'){{COMPLETE}}@elseif($data['order_status']=='4'){{ORDER_CANCEL}}@elseif($data['order_status']=='5'){{INVALID}}@endif</p>
                    </td>
                </tr>
                <tr>
                    <th >当前可执行操作:</th>
                    <td>
                        @if($data['pay_status']=='0')
                            <input type="submit" name="act" value="{{PAYMENT}}">
                        @endif

                        @if($data['order_status']=='5')
                                <input type="submit" name="act" value="{{NOT_OPERATE}}">
                                <input type="submit" name="act" value="删除">
                        @endif

                        @if($data['order_status']=='4')
                            已取消交易
                                <input type="submit" name="act" value="删除">
                        @endif

                        @if($data['order_status']=='3')
                            交易已完成
                        @endif

                        @if($data['order_status']=='2' || $data['order_status']=='1')
                                <input type="submit" name="act" value="{{COMPLETE}}">
                        @endif

                        @if($data['order_status']=='0')
                                <input type="submit" name="act" value="{{DELIVER}}">
                                <input type="submit" name="act" value="{{COMPLETE}}">
                                <input type="submit" name="act" value="{{INVALID}}">
                                @if($data['pay_status']=='1')
                                    <input type="submit" name="act" value="{{UNPAID}}">
                                @endif
                        @endif

                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>

                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        {{method_field('PUT')}}
                    </tr>
                <tr>
                    <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                        操作记录
                    </td>
                </tr>
                <tr>
                    <table class="list_tab">
                        <tr>

                            <th class="tc">操作人</th>
                            <th class="tc">操作时间</th>
                            <th class="tc">订单状态</th>
                            <th class="tc">付款状态</th>
                            <th class="tc">备注</th>

                        </tr>
                        @foreach($order_action as $v)
                            <tr>
                                <td class="tc">{{$v['action_user_name']}}</td>
                                <td class="tc">{{date('Y-m-d H:i:s',$v['log_time'])}}</td>
                                <td class="tc">@if($v['order_status']=='0'){{NOT_OPERATE}}@elseif($v['order_status']=='1'){{DELIVER}}@elseif($v['order_status']=='2'){{CONFIRM}}@elseif($v['order_status']=='3'){{COMPLETE}}@elseif($v['order_status']=='4'){{ORDER_CANCEL}}@elseif($v['order_status']=='5'){{INVALID}}@endif</td>
                                <td class="tc">@if($v['pay_status']=='0')未付款@elseif($v['pay_status']=='1')已付款@endif</td>
                                <td class="tc">{{$v['action_note']}}</td>
                            </tr>
                        @endforeach
                    </table>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script src="{{asset(PUBLIC_JS.'lightbox-plus-jquery.min.js') }}"></script>
@endsection