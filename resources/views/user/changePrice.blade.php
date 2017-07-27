@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_changePrice') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的求降价@if($type=='sell')申请管理@endif</span><p>在这里你可以查询到我的求降价信息</p></div>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['cut_status'])) class="current" @endif><a href="{{FilterManager::url('cut_status', '')}}">所有申请</a></span>
                     <span @if(isset($_GET['cut_status'])  && $_GET['cut_status']==1) class="current" @endif><a href="{{FilterManager::url('cut_status', '1')}}">等待确认</a> </span>
                     <span @if(isset($_GET['cut_status']) && $_GET['cut_status']==3) class="current" @endif><a href="{{FilterManager::url('cut_status', '3')}}">@if($type=='sell')拒绝@else撤销@endif</a></span>
                     <span @if(isset($_GET['cut_status']) && $_GET['cut_status']==2) class="current" @endif><a href="{{FilterManager::url('cut_status', '2')}}">@if($type=='buyer')卖家@endif同意</a></span>
                 </div>
                 <table>
               		 <thead>
                     <tr>
                         <th width="40%">宝贝信息</th>
                         <th width="16%">原价</th>
                         <th width="16%">现价</th>
                         <th width="16%">数量</th>
                         <th>操作</th>
                     </tr>
               		 </thead>
                 </table>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @foreach($data as $v)
                            <li>
                                <p>
                                <span>
                                   <input type="checkbox" class="pay " value="{{$v->goods['goods_code']}}">
                                    &nbsp;订单编号：<a title="查看商品详情" href="{{url('/goods/'.Hashids::encode($v->goods_id))}}" target="_blank">{{$v->goods['goods_code']}}</a>
                                </span>
                                    <span>创建时间：{{date('Y-m-d H:i:s',$v->created_time)}}</span>
                                <span>
                                </span>
                                </p>
                                <div class="ner">
                                    <div class="w40 bor_l left" style="width: 40%">
                                    <span class="stitle">
                                        <a class="transaction ico_bao" title="担保交易"></a>
                                        <a class="alink" title="{{$v->goods['game']['game_name']}}" href="{{url('/goods/'.Hashids::encode($v->goods_id))}}" target="_blank">{{$v->goods['goods_name']}}</a>
                                    </span>
                                        <span class="hui2">{{$v->goods['game']['game_name']}}/{{$v->goods['da_qu']['qu_name']}}/{{$v->goods['xia_qu']['qu_name']}}/{{$v->goods['has_many_type']['type']}}</span>
                                    </div>
                                    <div class="w16 bor_l left" style="width: 16%">{{$v->old_price}}</div>
                                    <div class="w10 bor_l left" style="width: 16%">{{$v->new_price}}</div>
                                    <div class="w16 bor_l left" style="width: 16%">{{$v->buy_number}}</div>
                                    <div class="w16 left" style="width: 11%">
                                         <span class="nomargin" style="line-height:20px; margin-top:10px;">
                                        @if($type=='sell')
                                             @if($v->status=='1')
                                                 <a target="_blank" style="color: red">等待确认</a><br>
                                                     <a target="_blank" href="javascript:changePriceStatus('{{$v->id}}','2')">同意</a><br>
                                                     <a target="_blank" href="javascript:changePriceStatus('{{$v->id}}','3')">拒绝</a><br>
                                             @elseif($v->status=='3')
                                                 <a target="_blank" style="color: red">已拒绝</a><br>
                                             @elseif($v->status=='2')
                                                 <a target="_blank" style="color: red">已同意</a><br>
                                                 <a target="_blank" href="{{url('/user/SellOrder')}}">查看订单</a><br>
                                             @endif
                                        @else
                                            @if($v->status=='1')
                                                <a target="_blank" style="color: red">等待确认</a><br>
                                                 <a target="_blank" href="javascript:changePriceStatus('{{$v->id}}','3')">撤销</a><br>
                                            @elseif($v->status=='3')
                                                <a target="_blank" style="color: red">已撤销</a><br>
                                            @elseif($v->status=='2')
                                                <a target="_blank" style="color: red">卖家同意</a><br>
                                                <a target="_blank" href="{{url('/user/goods?order_status=11')}}">去查看订单</a><br>
                                            @endif
                                        @endif
                                      </span>

                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changePriceStatus(id,status) {
        layer.confirm("{{trans('home.goods_cancel')}}", {
            btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"] //按钮
        }, function(){
            $.ajax({
                url: "{{url('/user/changePrice/status')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}",'status':status},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if (data.status == 1) {
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    } else if (data.status == -1) {
                        layer.msg(data.info, {icon: 5});
                    } else {
                        layer.msg("{{trans('com.not_find_status')}}", {icon: 5});
                    }
                }
            });
        });
    }
</script>

@endsection