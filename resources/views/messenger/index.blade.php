@extends('layouts.user')
@section('content')
<style>
    .order_list ul.order li{  height: 60px;  }
    .order_list .ner .bor_l{height: 60px;}
    .order_list .ner .bor_l li.w10{border-right: 1px solid #e0e0e0;}
    .order_list .ner .bor_l li a:hover{color: #00a0e9}
    .order_list .ner .w16, .order_list .ner .w10{line-height: 60px;}
    .order_list .ner .w10 a{color: #00A1CB;}
</style>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('messages') !!}</div>
    <div class="center_box">

        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的站内信</span><p>在这里可以看到发给你的系统信息</p></div>
            </div>
            <div class="money" style="height: auto">

                <div class="record_box" style="margin-top: 0">
                <div class="record">
                    <span  class="current" ><a>所有记录</a></span>
                </div>
                    @if($messages=='1')
                     <h3>没有符合条件的记录，请尝试其他搜索条件</h3>
                    @else
                        <table>
                            <thead>
                            <tr>
                                <th width="60%">内容</th>
                                <th width="20%">时间</th>
                                <th width="20%">操作</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="order_list">
                        <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                        <ul class="order">
                            @foreach($messages as $v)
                                <li>
                                    <div class="ner">
                                        <div class="w16 bor_l left" style="width: 60%">
                                        <ul>
                                            <li class="w10" style="width: 10%"><a class="InlineA" title="点击查看详细" href="{{url('user/messages/detail/'.$v->id)}}"><img src="@if($v->read>0){{asset(HOME_IMG.'center/mail_2.gif')}}@else{{asset(HOME_IMG.'center/mail_1.gif')}}@endif"></a></li>
                                            <li><a href="{{url('user/messages/detail/'.$v->id)}}" title="点击查看详细">{{str_limit($v->text, $limit = 70, $end = '')}}</a> </li>
                                        </ul>
                                        </div>
                                        <div class="w10 bor_l left" style="width: 20%">{{$v->created_at}}</div>
                                        <div class="w10 bor_l left" style="width: 19.5%;border-right: none">
                                            <a href="{{url('user/messages/detail/'.$v->id)}}">【查看详情】</a>
                                            <a href="javascript:delConfig({{$v->id}})">【删除】</a>
                                        </div>
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                </div>
                    @endif
                </div>
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
                url: "{{\Illuminate\Support\Facades\Input::url().'/'}}"+id,
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

