@extends('layouts.admin')
@section('content')
    <style>
        table.add_tab tr th{font-weight: bold;width: 20%;}
        table.add_tab tr td{width: 30%;}
    </style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/order')}}">订单管理</a> &raquo; 修改金额
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改金额</h3>
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
        <form  action="{{url('admin/order/edit_money')}}" method="post">
            <table class="add_tab">
                <tbody>


                <tr>
                    <th >商品总金额:</th>
                    <td>
                        {{$data['goods_amount']}}
                    </td>
                    <th >商品单价:</th>
                    <td>
                        {{$data['goods_price']}}
                    </td>

                </tr>
                <tr>
                    <th >订单总金额:</th>
                    <td>
                        <input type="text" name="order_amount" value="{{$data['order_amount']}}">
                    </td>
                    <th>购买数量:</th>
                    <td>
                       {{$data['buy_number']}}
                    </td>
                </tr>
                <input type="hidden" name="order_id" value="{{$data['order_id']}}">
                   {!! csrf_field() !!}
                <input name="order_id" value="{{$data['id']}}" type="hidden">
                <tr>
                    <td style="text-align: center;" colspan="4">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection