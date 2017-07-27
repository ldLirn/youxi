@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 会员帐户变动明细
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form  action="{{url('admin/account/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    {!! csrf_field() !!}
                    <th width="90">查看类型:</th>
                    <td>
                        <select name="show_type">
                            <option value="0" @if($type=='0')selected="selected" @endif>全部</option>
                            <option value="1" @if($type=='1')selected="selected" @endif>可用资金</option>
                            <option value="2" @if($type=='2')selected="selected" @endif>冻结资金</option>
                            <option value="3" @if($type=='3')selected="selected" @endif>消费积分</option>
                            <option value="4" @if($type=='4')selected="selected" @endif>买家信用积分</option>
                            <option value="5" @if($type=='5')selected="selected" @endif>卖家信用积分</option>
                        </select>
                        <input value="{{$id}}" name="id" type="hidden">
                    </td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/account/all_do')}}" method="post" id="all_do">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <span style="color: #808080">{{$html}}</span>
                    <div style="float: right"><a href="{{url('admin/account/create?id='.$id)}}"><i class="fa fa-plus"></i>调节会员账户</a></div>
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
                        <th class="tc">账户变动时间</th>
                        <th class="tc">账户变动原因</th>
                        <th class="tc">可用资金账户</th>
                        <th class="tc">冻结资金账户</th>
                        <th class="tc">消费积分账户</th>
                        <th class="tc">买家积分账户</th>
                        <th class="tc">卖家积分账户</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->change_time)}}</td>
                        <td class="tc">{{$v->change_desc}}</td>
                        <td class="tc">@if($v->money>0)+{{$v->money}}@else{{$v->money}}@endif</td>
                        <td class="tc">@if($v->frozen_money>0)+{{$v->frozen_money}}@else{{$v->frozen_money}}@endif</td>
                        <td class="tc">@if($v->integral>0)+{{$v->integral}}@else{{$v->integral}}@endif</td>
                        <td class="tc">@if($v->user_point_buy>0)+{{$v->user_point_buy}}@else{{$v->user_point_buy}}@endif</td>
                        <td class="tc">@if($v->user_point_sell>0)+{{$v->user_point_sell}}@else{{$v->user_point_sell}}@endif</td>
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