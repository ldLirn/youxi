@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('my_address') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的收货信息</span><p>在这里你可以查询到收货信息</p></div>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['order_status'])) class="current" @endif><a href="javascript:void(0)">收货信息</a></span>
                 </div>
                 <table>
               		 <thead>
                  		<tr>
                      		<th width="20%">角色名称</th>
                      		<th width="20%">游戏</th>
                      		<th width="20%">所在区</th>
                      		<th width="20%">所在服</th>
                      		<th width="20%">操作</th>
                  		</tr>
               		 </thead>
                 </table>
                <style>
                    .order_list ul.order li{height: 90px;}
                </style>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @foreach($data as $v)
                            <li>
                                <div class="ner">
                                    <div class="w16 bor_l left" style="width: 20%">{{$v->role_name}}</div>
                                    <div class="w10 bor_l left" style="width: 20%">{{$v->game_name}}</div>
                                    <div class="w16 bor_l left" style="width: 20%">{{$v->qu_name}}</div>
                                    <div class="w16 bor_l left" style="width: 20%">{{$v->fwq}}</div>
                                    <div class="w16 left" style="width: 18%">
                                    <span class="nomargin" style="margin-top: 19%">
                                        <a href="javascript:delConfig({{$v->id}})" style="font-size: 16px;color: #1668ba">删除</a><br>

                                    </span>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="page">
                        {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function delConfig(id) {
        layer.confirm('{{trans('home.goods_cancel')}}', {
            btn: ["{{trans('com.sure')}}","{{trans('com.cancel')}}"] //按钮
        }, function(){
            $.ajax({
                url: "{{url('/user/address')}}/"+id,
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