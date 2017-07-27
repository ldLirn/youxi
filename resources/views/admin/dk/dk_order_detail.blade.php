@extends('layouts.admin')
@section('content')
<body>

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/dk_list')}}">点卡订单列表</a> &raquo; 订单详情
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>订单详情</h3>
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
        <form action="{{url('admin/power')}}" method="post">
            <table class="add_tab">
                <tbody>

                    <tr>
                        <th>订单编号：</th>
                        <td>
                            {{$data['sporder_id']}}
                        </td>
                    </tr>

                    <tr>
                        <th>商品名称：</th>
                        <td>
                           {{$data['cardname']}}
                        </td>
                    </tr>

                    <tr>
                        <th>购买数量：</th>
                        <td>
                            {{$data['cardnum']}}
                        </td>
                    </tr>

                    <tr>
                        <th>商品总额：</th>
                        <td>
                            {{$data['ordercash']}}
                        </td>
                    </tr>

                    <tr>
                        <th>点卡编号：</th>
                        <td>
                           {{$data['cardid']}}
                        </td>
                    </tr>

                    <tr>
                        <th>购买人：</th>
                        <td>
                           {{$data['user']['name']}}
                        </td>
                    </tr>

                    <tr>
                        <th>收货帐号：</th>
                        <td>
                           {{$data['game_userid']}}
                        </td>
                    </tr>

                    <tr>
                        <th>联系电话：</th>
                        <td>
                           {{$data['telphone']}}
                        </td>
                    </tr>

                    <tr>
                        <th>联系QQ：</th>
                        <td>
                            {{$data['qq']}}
                        </td>
                    </tr>

                    <tr>
                        <th>下单时间：</th>
                        <td>
                            {{date('Y-m-d H:i:s',$data['time'])}}
                        </td>
                    </tr>

                    <tr>
                        <th>支付状态：</th>
                        <td>
                            @if($data['pay_status']==1) 未支付@elseif($data['pay_status']==2)已支付@endif
                        </td>
                    </tr>

                    <tr>
                        <th>订单状态：</th>
                        <td>
                            @if($data['game_state']==0)充值中@elseif($data['game_state']==1)充值成功@elseif($data['game_state']==9)充值失败@else状态未知@endif
                        </td>
                    </tr>

                    {!! csrf_field() !!}
                    <tr>
                        <th></th>
                        <td>
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection