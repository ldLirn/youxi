@extends('layouts.user')
@section('content')
    <link href="{{asset(HOME_CSS.'select-game.css') }}" rel="stylesheet" type="text/css">
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_needs') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我发布的求购</span><p>在这里你可以查询到发布的求购信息</p></div>
            </div>
            @include('layouts.user_search')
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['goods_status'])) class="current" @endif><a href="{{FilterManager::url('goods_status', '')}}">所有商品</a></span>
                     <span @if(isset($_GET['goods_status'])  && $_GET['goods_status']=='d') class="current" @endif><a href="{{FilterManager::url('goods_status', 'd')}}">等待审核</a> </span>
                     <span @if(isset($_GET['goods_status']) && $_GET['goods_status']=='s') class="current" @endif><a href="{{FilterManager::url('goods_status', 's')}}">审核成功</a></span>
                     <span @if(isset($_GET['goods_status']) && $_GET['goods_status']=='e') class="current" @endif><a href="{{FilterManager::url('goods_status', 'e')}}">审核失败</a></span>
                     <span @if(isset($_GET['goods_status']) && $_GET['goods_status']=='x') class="current" @endif><a href="{{FilterManager::url('goods_status', 'x')}}">用户下架</a></span>
                 </div>
                 <table>
                     <thead>
                     <tr>
                         <th width="40%">宝贝信息</th>
                         <th width="16%">单价</th>
                         <th width="16%">求购数量</th>
                         <th width="16%">最后求购时间</th>
                         <th>交易状态</th>
                     </tr>
                     </thead>
                 </table>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @foreach($goodsShow as $v)
                            <li>
                                <p>
                                <span>
                                   <input type="checkbox" class="pay " value="{{$v->goods_code}}">
                                    &nbsp;订单编号：<a title="查看商品" href="{{url('/goods/'.Hashids::encode($v->id))}}" target="_blank">{{$v->goods_code}}</a>
                                </span>
                                    <span>创建时间：{{date('Y-m-d H:i:s',$v->sale_start_time)}}</span>
                                <span>
                                </span>
                                </p>
                                <div class="ner">
                                    <div class="w40 bor_l left" style="width: 40%">
                                    <span class="stitle">
                                        <a class="transaction ico_bao" title=""></a>
                                        <a class="alink" title="{{$v->goods_name}}" href="{{url('/goods/'.Hashids::encode($v->id))}}" target="_blank">{{$v->goods_name}}</a>
                                    </span>
                                        <span class="hui2">{{$v->game_name}}/{{$v->da_qu}}/{{$v->qu_name}}/{{$v->type}}</span>
                                    </div>
                                    <div class="w16 bor_l left" style="width: 16%">{{$v->goods_price}}</div>
                                    <div class="w10 bor_l left" style="width: 16%">{{$v->goods_stock}}</div>
                                    <div class="w16 bor_l left" style="width: 16%">{{date('Y-m-d H:i:s',$v->sale_end_time)}}</div>
                                    <div class="w16 left" style="width: 11%">
                                    <span class="nomargin" style="line-height:20px; margin-top:10px;">
                                        <a href="{{url('/goods/'.Hashids::encode($v->id))}}">查看商品</a><br>
                                        @if($v->is_on_sale=='0' && $v->is_check=='1')
                                            商品已下架
                                        @endif
                                        @if($v->is_check=='0')
                                            等待审核
                                            @elseif($v->is_check=='2')
                                            审核失败
                                        @endif
                                        @if($v->is_check=='1' && $v->is_on_sale=='1')
                                        <a href="javascript:delConfig({{$v->id}})">下架商品</a>
                                        @endif
                                    </span>

                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="page">
                    @if(isset($page_path))
                        {{$goodsShow->appends($page_path)->links()}}
                    @else
                        {{$goodsShow->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset(PUBLIC_JS.'jedate.min.js')}}"></script>
<script type="text/javascript" src="{{asset(HOME_JS.'center_game.js')}}"></script>
<script type="text/javascript">

    jeDate({
        dateCell: '#date02',
        isinitVal:true,
        format: 'YYYY-MM-DD'
    });

    jeDate({
        dateCell: '#date03',
        isinitVal:true,
        format: 'YYYY-MM-DD'
    });

    function delConfig(id) {
        layer.confirm('{{trans('home.goods_cancel')}}', {
            btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"] //按钮
        }, function(){
            $.ajax({
                url: "{{url('/user/goods/goodsOffSale')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}"},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if (data.status == 1) {
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    } else if (data.status == -1) {
                        layer.msg(data.info, {icon: 5});
                    } else {
                        layer.msg('{{trans('com.not_find_status')}}', {icon: 5});
                    }
                }
            });
        });
    }
</script>
@endsection


