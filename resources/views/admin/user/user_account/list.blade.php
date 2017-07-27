@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 充值和提现申请
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form  action="{{url('admin/user_account/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    {!! csrf_field() !!}
                    <th width="90">会员名称:</th>
                    <td><input type="text" name="user_name"  style="width: 180px"></td>
                    <td>
                       <select name="process_type">
                           <option value="">类型</option>
                           <option value="0">充值</option>
                           <option value="1">提现</option>
                       </select>
                    </td>
                    <td>
                        <select name="payment">
                            <option value="">支付方式</option>
                            <option value="支付宝">支付宝</option>
                            <option value="银行卡">银行卡</option>
                        </select>
                    </td>
                    <td>
                        <select name="result">
                            <option value="">审核结果</option>
                            <option value="0">未处理</option>
                            <option value="1">处理成功</option>
                            <option value="2">无效</option>
                        </select>
                    </td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/user_account/all_do')}}" method="post" id="all_do">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">


                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        @if(session('msg'))
            <div class="result_wrap">
                <div class="result_title">
                    <div class="mark">
                        <p>{{session('msg')}}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">会员名称</th>
                        <th class="tc">申请日期</th>
                        <th class="tc">类型</th>
                        <th class="tc">金额</th>
                        <th class="tc">支付方式</th>
                        <th class="tc">支付状态</th>
                        <th class="tc">审核状态</th>
                        <th class="tc">审核结果</th>
                        <th class="tc">操作员</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->user->name}}</td>
                        <td class="tc">{{$v->created_at}}</td>
                        <td class="tc">@if($v->process_type=='0')充值@elseif($v->process_type=='1')提现@endif</td>
                        <td class="tc">{{$v->amount}}</td>
                        <td class="tc">{{$v->payment}}</td>
                        <td class="tc">@if($v->pay_status=='0')未支付@elseif($v->pay_status=='1')<span style="color:green">支付成功</span>@endif</td>
                        <td class="tc">@if($v->is_paid=='0')未处理@elseif($v->is_paid=='1')<span style="color:green">处理成功</span>@endif</td>
                        <td class="tc">@if($v->result=='0')未处理@elseif($v->result=='1')<span style="color:green">处理成功</span>@elseif($v->result=='2')<span style="color:darkred">无效</span>@endif</td>
                        <td class="tc">{{$v->admin_user}}</td>
                        <td>
                            <a href="{{url('admin/user_account/'.$v->id.'/edit')}}">审核</a>
                            @if($v->process_type=='1' && $v->result!='1')
                            <a href="javascript:delAd({{$v->id}})">删除</a>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
@endsection
    <script>
        function delAd(id) {
            layer.confirm('您确定要删除吗？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        $.ajax({
                            url: "{{url('admin/user_account/')}}/"+id,
                            data:{'_method':'delete','_token':"{{csrf_token()}}"},
                            type: "POST",
                            dataType:'json',
                            success:function (data) {
                                if(data.status==0){
                                    layer.msg(data.info, {icon: 6});
                                    location.reload();
                                }else if(data.status==1){
                                    layer.msg(data.info, {icon: 5});
                                }
                            },
                            error:function(er){
                                if(er.status==403){
                                    layer.msg('您没有此权限', {icon: 5});
                                }
                            }
                        });
                    }
            );
        }
    </script>