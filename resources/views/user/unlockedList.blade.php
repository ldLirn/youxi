@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('AbnormalCapital') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>{{$type}}申请管理</span><p>在这里你可以查询到申请的信息</p></div>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <div class="record">
                         <span class="current"><a href="javascript:void(0)">申请记录</a></span>
                         <span ><a href="{{str_replace('/list','',$url)}}">{{$type}}</a> </span>
                     </div>
                 </div>
                 <table>
                     @if(session('msg'))
                         <div class="basic_text"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
                     @endif
               		 <thead>
                  		<tr>
                            <th>序号</th>
                            <th>申请时间</th>
                            @if($type!='换绑邮箱' || $type!='修改开户名')
                            <th>申请原因</th>
                            @endif
                            @if($type=='修改开户名')
                                <th>申请修改的卡号</th>
                            @endif
                            <th>审核结果</th>
                            <th>操作</th>
                        </tr>
               		 </thead>
                     @foreach($data as $k=>$v)
                         <thead>
                         <tr>
                             <th>{{$k+1}}</th>
                             <th>{{date('Y-m-d H:i:s',$v->created_at)}}</th>
                             @if($type!='换绑邮箱' || $type!='修改开户名')
                             <th>{{$v->content}}</th>
                             @endif
                             @if($type=='修改开户名')
                             <th>{{$v->bankNo}}</th>
                             @endif
                             <th>@if($v->result==0)未处理@elseif($v->result==1)处理通过，@elseif($v->result==2)审核不通过，{{$v->re_content}}@endif</th>
                             <th><a href="javascript:delConfig({{$v->id}})">删除</a> </th>
                         </tr>
                         </thead>
                     @endforeach
                 </table>
            </div>
        </div>
    </div>
</div>

<script>
    function delConfig(id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{$url}}/"+id,
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
                        layer.msg('未知状态', {icon: 5});
                    }
                }
            });
        });
    }
</script>
@endsection