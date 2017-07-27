@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/account')}}">会员资金管理</a> &raquo; 调节资金
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>调节会员帐户</h3>
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
        <form action="{{url('admin/account')}}" method="post">
            <table class="add_tab">
                <tbody>

                    <tr>
                        <th><i class="require">*</i>当前会员：</th>
                        <td>
                           {{$user['name']}}
                            <input type="hidden" name="id" value="{{$id}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>变动原因：</th>
                        <td>
                            <textarea name="change_desc"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>可用资金帐户：</th>
                        <td>
                            <select name="money_do">
                                <option value="add">增加</option>
                                <option value="lost">减少</option>
                            </select>
                            <input type="text" name="money" value=""><span>当前：{{$user['money']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>冻结资金账户：</th>
                        <td>
                            <select name="frozen_money_do">
                                <option value="add">增加</option>
                                <option value="lost">减少</option>
                            </select>
                            <input type="text" name="frozen_money" value=""><span>当前：{{$user['frozen_money']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>消费积分帐户：</th>
                        <td>
                            <select name="integral_do">
                                <option value="add">增加</option>
                                <option value="lost">减少</option>
                            </select>
                            <input type="text" name="integral" value=""><span>当前：{{$user['integral']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>买家信用积分帐户：</th>
                        <td>
                            <select name="user_point_buy_do">
                                <option value="add">增加</option>
                                <option value="lost">减少</option>
                            </select>
                            <input type="text" name="user_point_buy" value=""><span>当前：{{$user['user_point_buy']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>卖家信用积分帐户：</th>
                        <td>
                            <select name="user_point_sell_do">
                                <option value="add">增加</option>
                                <option value="lost">减少</option>
                            </select>
                            <input type="text" name="user_point_sell" value=""><span>当前：{{$user['user_point_sell']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>


@endsection