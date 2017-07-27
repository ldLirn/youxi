@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/user_account')}}">充值提现</a> &raquo; 审核
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>审核充值提现</h3>
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
        <form action="{{url('admin/user_account/'.$data->id)}}" method="post">
            <table class="add_tab">
                <tbody>
                @if($data->is_paid=='1')
                <tr>
                    <th><i class="require">*</i>已审核：</th>
                    <td>
                        <span style="color: red">已审核</span>
                    </td>
                </tr>
                @endif
                @if($data->process_type=='0')
                    <tr>
                        <th>会员名称：</th>
                        <td>
                            {{$data->user->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>金额：</th>
                        <td>
                            {{$data->amount}}
                        </td>
                    </tr>
                    <tr>
                        <th>申请时间：</th>
                        <td>
                            {{$data->created_at}}
                        </td>
                    </tr>
                    <tr>
                        <th>支付方式：</th>
                        <td>
                            {{$data->payment}}
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            充值
                        </td>
                    </tr>

                    @elseif($data->process_type=='1')
                    <tr>
                        <th>信息：</th>
                        <td>
                            会员名称：{{$data->user->name}}   金额：<span style="color: red">-{{$data->amount}}</span>   操作日期 ： {{$data->created_at}}   类型：提现
                        </td>
                    </tr>


                    @endif
                <tr>
                    <th>会员备注：</th>
                    <td>
                        <textarea name="user_note" readonly="readonly">{{$data->user_note}}</textarea>
                    </td>
                </tr>
                    <tr>
                        <th>审核结果：</th>
                        <td>
                            <input type="radio" name="result" value="1" @if($data->result=='1')checked="checked"@endif>确认
                            <input type="radio" name="result" value="2" @if($data->result=='2')checked="checked"@endif>无效
                            <p class="red">请谨慎操作，此操作不可逆</p>
                        </td>
                    </tr>
                    <tr>
                        <th>管理备注：</th>
                        <td>
                            <textarea name="admin_note">{{$data->admin_note}}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        {{method_field('PUT')}}
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