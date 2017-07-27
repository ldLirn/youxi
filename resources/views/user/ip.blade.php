@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('ip') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>我的登录IP信息</span><p>在这里你可以查询ip绑定信息</p></div>
            </div>
            <div class="setIP" style="display:block;">
                <ul>

                    <li class="text">
                        <span class="red label_l left"><strong>IP绑定设置：</strong></span>
                        <p class="left">1、IP绑定只绑定前两段，最多绑定三个IP。</p>
                        <p class="left">2、绑定IP后您只能在您绑定的IP段上进行正常登录。</p>
                        <p class="left">3、如果不是在您绑定的IP段上登录,需要邮箱或者手机验证码进行二次验证,验证通过方可登录。</p>
                        <p class="left">4、请您务必根据自己最近的登录IP判断自己所要绑定IP</p>
                    </li>

                </ul>
            </div>
            <div class="buyers">
           		 <div class="record">
                     <span @if(!isset($_GET['status'])) class="current" @endif><a href="{{url('/user/ip')}}">登录IP明细</a></span>
                     <span @if(isset($_GET['status'])) class="current" @endif><a href="{{FilterManager::url('status', '1')}}">绑定IP</a></span>
                 </div>
                 <table style="width: 100%">
               		 <thead>
                  		<tr>
                            @if(!isset($_GET['status']))
                      		<th width="20%">登录时间</th>
                      		<th width="30%">归属地</th>
                            @endif
                            <th width="30%">IP</th>
                            <th width="20%">操作</th>
                  		</tr>
               		 </thead>
                 </table>
                <style>
                    .order_list ul.order li{height: 40px;}
                    .order_list .ner .bor_l{height: 40px;line-height: 40px}
                </style>
                <div class="order_list">
                    <div id="failinfo" style="width: 100px; height: 50px; position: absolute; z-index: 999; padding: 10px; top: 599px; left: 1277px; border: 1px solid rgb(247, 142, 87); display: none; background-color: rgb(157, 212, 251);"></div>
                    <ul class="order">
                        @if(!isset($_GET['status']))
                        @foreach($ip_info as $k=>$v)
                            <li>
                                <div class="ner">
                                    <div class="w16 bor_l left" style="width: 20%">{{date('Y-m-d H:i:s',$v['time'])}}</div>
                                    <div class="w16 bor_l left" style="width: 30%">{{$v['address']}}</div>
                                    <div class="w10 bor_l left" style="width: 30%">{{$v['ip']}}</div>
                                    <div class="w16 bor_l left" style="width: 19%;border-right: none">
                                    <span class="nomargin" style="line-height: 40px">
                                        <a href="javascript:delConfig({{$k}})" style="font-size: 16px;color: #1668ba">申请绑定</a><br>
                                    </span>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @else
                            @foreach($ip_info as $k=>$v)
                                <li>
                                    <div class="ner">
                                        <div class="w10 bor_l left" style="width: 60%">{{$v}}</div>
                                        <div class="w16 bor_l left" style="width: 39%;border-right: none">
                                    <span class="nomargin" style="line-height: 40px">
                                        <a href="javascript:delConfig({{$k}})" style="font-size: 16px;color: #1668ba">解绑</a><br>
                                    </span>

                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .Validform_wrong,.Validform_right{display: none}
</style>
<div id="phone_code" style="display: none">
    <form id="phone_form" method="post">
        {{csrf_field()}}
    <span>手机验证码：</span><input type="text" class="text" name="verifyCode" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}">
        <input type="hidden" name="k" id="k" value="">
        <input  id="btnSendCode" value="发送验证码" readonly="readonly"><button id="btnSendCode">提交</button>
    </form>
</div>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    function delConfig(id) {
        $('#k').val(id);
        layer.open({
            type: 1,
            shade: false,
            title: false, //不显示标题
            area: ['420px', '140px'], //宽高
            content: $('#phone_code'), //捕获的元素
            cancel: function(index){
                layer.close(index);
                this.content.show();
                $('#phone_code').hide();
            }
        });
    }

    $('#btnSendCode').sms({
        token       : "{{csrf_token()}}",
        interval    : 60,
        voice       : false,
        requestData : {
            mobile : function () {
                return "{{$user['telphone']}}";
            },
            mobile_rule : 'mobile_required'
        },
        alertMsg : function (msg, type) {
            alert(msg);
        }
    });

    if("{{isset($_GET['status'])}}"){
        $("#phone_form").Validform({
            tiptype:3,
            postonce:true,
            callback:function(form){
                var k = $('#k').val();
                $.ajax({
                    url: "{{url('/user/ip')}}",
                    data:{'_method':'delete','_token':"{{csrf_token()}}",'k':k},
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
                return false;
            }
        });
    }else{
        $("#phone_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            postonce:true,
            ajaxPost:true,
            callback:function(data){
                if(data.status=="y"){
                    $.Hidemsg();
                    setTimeout(function(){
                        layer.msg(data.info,{icon:6});
                        window.location.href="{{url('/user/ip?status=1')}}";
                    },1500);
                }else{
                    $.Hidemsg();
                    layer.alert(data.info,{icon:5});
                }
            }
        });
    }



</script>
@endsection