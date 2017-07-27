@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('Withdrawal') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
            <div class="qq_up_top">
                <div class="fssc"></div>
                <div class="fw_c"><span>提现申请</span><p>在这里你可以申请提现</p></div>
            </div>
            <div class="money">
                <div class="withdrawal">
                    <div class="sdc01">当前余额：<span>{{$user['money']}}</span>元</div>
                    <div class="sdc01 sdc02">可提现金额：<span>{{$user['money']}}</span>元</div>
                </div>
                <form id="form_tx" action="" method="post">
                    {{csrf_field()}}
                <div class="record_box" style="margin: 50px auto;width: 838px;">
                    <div class="password_text"><span>提现平台：</span>
                        <select name="withdrawal" datatype="*" onchange="check_bank(value)">
                            <option value="">请选择提现平台</option>
                            <option value="{{BANK}}">{{BANK}}</option>
                            <option value="{{ALIPAY}}">{{ALIPAY}}</option>
                        </select>
                    </div>
                    <div class="password_text add"  style="display: none"><span>支付宝姓名：</span><input type="text" name="alipay_name"  class="text" datatype="*"><i>请务必正确填写</i></div>
                    <div class="password_text add"  style="display: none"><span>支付宝帐号：</span><input type="text" name="alipay_zh"  class="text" datatype="*"><i>请务必正确填写</i></div>
                    <div class="password_text" id="bank" style="display: none"><span>选择银行卡：</span>
                       <select name="bank_id" datatype="*">
                           @foreach($bank_info as $v)
                           <option value="{{$v['name']}},{{$v['bankNo']}},{{$v['bank_name']}},{{$v['sheng']}}{{$v['city']}}">{{$v['name']}},{{$v['bankNo']}},{{$v['bank_name']}},{{$v['sheng']}}{{$v['city']}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class="password_text"><span>提现金额：</span><input type="text" name="money"  class="text" datatype="/^[1-9]{1}\d*(\.\d{1,2})?$/,need2" nullmsg="请输入要提现的金额" errormsg="请输入正确格式的金额，小数点后最多两位且不能小于1元"></div>
                    <div class="password_text"><span>支付密码：</span><input type="PASSWORD" name="pay_password"  class="text" datatype="s6-6" ajaxurl="{{url('/user/check_old_pass?_token='.csrf_token().'&t=1')}}" errormsg="支付密码格式不正确"></div>
                    <div class="password_text"><span style="float: left">短信验证码：</span><input type="text" name="verifyCode"  class="text" style="float: left" datatype="n6-6" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" errormsg="验证码格式不正确"><input  id="btnSendCode" value="发送验证码" readonly="readonly"></div>
                    <div class="bd_zt" style="width: 100%;float: left;margin-top: 35px;"><input type="submit" class="submit"   value="提交"></div>
                </div>
                </form>
                <script>
                    function check_bank(o) {
                        if(o=="{{BANK}}"){
                           if("{{$is_empty}}"==''){
                               layer.confirm('您还未绑定银行卡，是否马上去绑定？', {
                                   btn: ['是','算了'] //按钮
                               }, function(){
                                   window.location.href="{{url('/user/bindBank/add')}}";
                               }, function(){

                               });
                           }else{
                               $('.add').hide();
                               $('#bank').show();
                           }
                        }else if(o=="{{ALIPAY}}"){
                            $('#bank').hide();
                            $('.add').show();
                        }
                    }


                    $("#form_tx").Validform({
                        tiptype:3,
                        ignoreHidden:true,
                        ajaxPost:true,
                        postonce:true,
                        datatype:{
                            "need2":function(gets,obj,curform,regxp){
                                var money="{{$user['money']}}";
                                var m = $(obj).val();
                                return  m > parseInt(money) ? "提现金额不能大于"+money+"！" : true;
                            },
                        callback:function(data){
                            if(data.status=="y"){
                                setTimeout(function(){
                                    $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                                    window.location.href="{{url('/user/money/info')}}";
                                },2000);
                            }
                        }

                        }
                    });

                </script>
            </div>
        </div>
    </div>
</div>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
<script>
    $('#btnSendCode').sms({
        token       : "{{csrf_token()}}",
        //请求间隔时间
        interval    : 60,
        //是否请求语音验证码
        voice       : false,
        //请求参数
        requestData : {
            //手机号
            mobile : function () {
                return "{{$user['telphone']}}";
            },
            //手机号的检测规则
            mobile_rule : 'mobile_required'
            //定义服务器有消息返回时如何展示，默认为alert
        },
        alertMsg : function (msg, type) {
            alert(msg);
        }
    });
</script>
@endsection