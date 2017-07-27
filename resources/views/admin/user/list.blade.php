@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 会员列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form onsubmit="return check_search()" action="{{url('admin/user/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    {!! csrf_field() !!}
                    <th width="90">消费积分大于:</th>
                    <td><input type="text" name="dyjf" placeholder="积分数"></td>
                    <th width="90">消费积分小于:</th>
                    <td><input type="text" name="xyjf" placeholder="积分数"></td>
                    <th width="90">用户名或邮箱:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
        <script>
            function check_search() {
                if($('[name*=dyjf]').val()=='' && $('[name*=xyjf]').val()=='' && $('[name*=keywords]').val()==''){
                    return false;
                }
            }
        </script>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/user/all_do')}}" method="post" id="all_do">
        {!! csrf_field() !!}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/user/create')}}"><i class="fa fa-plus"></i>新增会员</a>
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
                        <th class="tc"><input type="checkbox" name="" id="checkAll"></th>
                        <th class="tc">用户名</th>
                        <th class="tc">邮箱</th>
                        <th class="tc">邮箱验证</th>
                        <th class="tc">手机验证</th>
                        <th class="tc">可以余额</th>
                        <th class="tc">冻结资金</th>
                        <th class="tc">消费积分</th>
                        <th class="tc">买家信用积分</th>
                        <th class="tc">卖家信用积分</th>
                        <th class="tc">注册时间</th>
                        <th class="tc">状态</th>
                        <th class="tc">实名审核</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="{{$v->id}}" class="checkone"></td>
                        <td class="tc">{{$v->name}}</td>
                        <td class="tc">{{$v->email}}</td>
                        <td class="tc">@if($v->is_check_email=='1')<i class="fa fa-check" style="color: green"></i>@else<i class="fa fa-times" style="color: red"></i>@endif</td>
                        <td class="tc">@if($v->is_check_phone=='1')<i class="fa fa-check" style="color: green"></i>@else<i class="fa fa-times" style="color: red"></i>@endif</td>
                        <td class="tc">{{$v->money}}</td>
                        <td class="tc">{{$v->frozen_money}}</td>
                        <td class="tc">{{$v->integral}}</td>
                        <td class="tc">{{$v->user_point_buy}}</td>
                        <td class="tc">{{$v->user_point_sell}}</td>
                        <td class="tc">{{date('Y-m-d H:i:s',$v->reg_time)}}</td>
                        <td class="tc">@if($v->status=='0')正常@else冻结@endif</td>
                        <td class="tc">@if($v->is_check_datecard=='0')未审核@elseif($v->is_check_datecard=='1')审核通过@elseif($v->is_check_datecard=='2')不通过@endif</td>
                        <td>
                            <a href="{{url('admin/user/'.$v->id.'/edit')}}">修改</a>
                            <a href="{{url('admin/account/'.$v->id)}}">账目</a>
                            <a href="{{url('admin/order/search?type=0&user_name='.$v->id)}}">订单</a>
                            <a href="{{url('admin/user/msg/'.$v->id)}}">发送消息</a>
                            <a href="javascript:delAd({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                    <select name="all_do">
                        <option value="">选中项操作</option>
                        <option value="1">删除</option>
                        <option value="2">冻结</option>
                        <option value="3">解除冻结</option>
                        {!! csrf_field() !!}

                    </select>
                    <input type="button" value="确定" style="margin-left: 20px;" onclick="check_this()">
                </div>
                <script>
                    function check_this() {
                        if($('[name*=all_do]').val()!='' && $('[name*=id]:checked').length>0){
                            $('#all_do').submit();
                        }
                    }
                </script>
                <div class="page_list">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<style>
    .result_content ul li span{
        padding: 6px 12px;
        font-size: 15px;
    }
</style>
    <script type="text/javascript" charset="utf-8" src="{{asset(ORG.'laydate/laydate.js')}}"> </script>
<script>
    //删除
    function delAd(id) {
        layer.confirm('您确定要删除吗？删除后所有有关该会员的信息都将删除', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                 url: "{{url('admin/user/')}}/"+id,
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
@endsection