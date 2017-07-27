@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('bindBank') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>银行卡管理</span><p>在这里你可以查询到已绑定银行卡的信息</p></div>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <div class="record">
                         <span class="current"><a href="{{url('/user/bindBank')}}">银行卡管理</a></span>
                         <span ><a href="{{url('/user/bindBank/add')}}">新增银行卡</a> </span>
                     </div>
                 </div>
                 <table>
               		 <thead>
                  		<tr>
                            <th>序号</th>
                            <th>开户行</th>
                            <th>开户账号</th>
                            <th>开户城市</th>
                            <th>开户名</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
               		 </thead>
                     @foreach($bank_info as $k=>$v)
                         <thead>
                         <tr>
                             <th>{{$k+1}}</th>
                             <th>{{$v['bank_name']}}</th>
                             <th>{{$v['bankNo']}}</th>
                             <th>{{$v['sheng']}}{{$v['city']}}</th>
                             <th>{{$v['name']}}</th>
                             <th>{{date('Y-m-d H:i:s',$v['add_time'])}}</th>
                             <th><a href="">删除</a> </th>
                         </tr>
                         </thead>
                     @endforeach
                 </table>
            </div>
        </div>
    </div>
</div>


@endsection