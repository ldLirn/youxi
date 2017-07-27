@extends('layouts.user')
@section('content')
    <link href="{{asset(HOME_CSS.'recharge.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'select2.css')}}" rel="stylesheet" />
    <script src="{{asset(HOME_JS.'select2.min.js')}}"></script>
<div class="all">

    <div class="chong">
        <div class="chong-l h-750 left">
            <ul class="menu">
                <li class="yuan"><a href="{{url('user/money/recharge?menu=103')}}" target="_blank">账户充值</a></li>
                <li class="yuan"><a href="#">手机话费</a></li>
                <li class="yuan"><a href="#">手机流量</a></li>
                <li class="chong-l-ahover">游戏点卡</li>
            </ul>
        </div>

        <div class="chong-r h-750 left">
            <!--dianka-->
            <form method="post"  id="succesform" class="form">
                <div class=" wrap2 left" style="display: block;">
                    <div class="dk left">
                        <div class="biaoti">{{$data['cardname']}}</div>

                        <div style="margin-top:12px;margin-left:103px">
                            <span class="w-150" style="color: red; font-weight: bold;"></span>
                        </div>
                        <ul class="dk-order">
                            <li>
                                <div class="w-150 left">帐号余额：</div>
                                <div class="w-150 left">
                                    <font style="color:red;">{{$user['money']}} 元</font>
                                </div>
                            </li>
                            <li>
                                <div class="w-150 left">充值面额：</div>
                                <div class="w-150 left">
                                    <select style="width: 200px;height: 25px;" id="PriceList">
                                        <option value="{{$data['pervalue']}}">{{$data['pervalue']}}元</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="w-150 left">游戏帐号：</div>
                                <div class="w-150 left">
                                    <input type="text" name="game_userid" size="20" class="bginput" datatype="*" min="1" max="50" errormsg="请输入充值用户名">
                                </div>
                            </li>
                            <li style="width:498px;">
                                <div class="w-150 left">确认帐号：</div>
                                <div class="w-150 left">
                                    <input type="text" name="Regame_userid" size="20" class="bginput" datatype="*" recheck="game_userid"  errormsg="两次输入用户名不一致，请重输">
                                </div>
                            </li>
                            <li style="margin-top: -10px;height: auto;">

                                <table id="chtb" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 10px;">
                                    <tbody>
                                    @if($data['accountdesc'])
                                    <tr id="accounttype_tr">
                                        <td style="color:#333333;height:40px;width:24.2%;text-align:right;padding-right:10px" width="25%;">
                                            <span style="width:0px;float:left"></span>帐户类型：
                                        </td>
                                        <td id="accounttype_td" style="text-align:left;background-color: #fff;height:40px;width:75.8%;" width="75%;">
                                            <span style="width:10px;float:left"></span>
                                            <input id="accounttype_0" type="radio" name="accounttype1" datatype="*" errormsg="必须选定一种帐户类型" value="1">
                                            <label for="accounttype_0">{{$data['accountdesc']}}</label>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr id="buynumber_tr">
                                        <td style="color:#333333;height:40px;width:24.2%;text-align:right;padding-right:10px" width="25%;">
                                            <span style="width:0px;float:left"></span>充值数量：
                                        </td>
                                        <td id="buynumber_td" style="text-align:left;background-color: #fff;height:40px;width:75.8%;" width="75%;">
                                            <span style="width:20px;float:left"></span>
                                            @if(strstr($data['cardname'],trans('com.cardname_keywords')))
                                                <input name="cardnum" id="buynumber_r" datatype="*" errormsg="请选择充值数量" class="kuang">
                                            @else
                                                <select name="cardnum" id="buynumber" datatype="*" errormsg="请选择充值数量" style="width: 100px;">
                                                    <option value="">请选择</option>
                                                    @foreach($amounts_arr as $v)
                                                        <option value="{{$v}}">{{$v}}张</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                         </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </li>
                            <li>
                                <div class="w-150 left">销售单价：</div>
                                <div class="w-150 left">
                                    <input type="text" name="SalePrice" id="SalePrice" readonly="readonly" value="{{$data['memberprice']}}" class="kuang">元
                                </div>
                            </li>
                            <li>
                                <div class="w-150 left">应收金额：</div>
                                <div class="w-150 left">
                                    <input type="text" name="TotalMoney" id="TotalMoney" class="kuang" size="10" readonly="readonly">元
                                </div>
                            </li>


                            <li><div style="background-color:#e7e7e7;height:2px;width:480px;margin-left:5px;"></div></li>
                            <li style="position:relative;">
                                <div class="w-150 left" style="width:100px;text-align:right;">您的联系电话：</div>
                                <div class="w-150 left">
                                    <input id="PhoneNo" class="kuang hide_phone" type="text" datatype="/^1[34578]\d{9}$/" errormsg="手机号码格式不正确" name="telphone" value="{{$user['telphone']}}">
                                </div>
                                <span class="left" style="color:Red">*</span>
                            </li>
                            <li style="position:relative;">
                                <div class="w-150 left" style="width:100px;text-align:right;">您的QQ号码：</div>
                                <div class="w-150 left">
                                    <input id="M_QQ" class="kuang hide_qq" type="text" name="qq" value="{{$user['qq']}}"  datatype="n4-13"   errormsg="QQ号码格式不正确">
                                </div>
                                <span class="left" style="color:Red">*</span>
                            </li>

                            <li style="position:relative;">
                                <div class="w-150 left" style="width:100px;text-align:right;">支付密码：</div>
                                <div class="w-150 left">
                                    <input id="M_QQ" class="kuang hide_qq" type="password" name="pay_password" value=""  datatype="s6-6"   errormsg="支付密码错误">
                                </div>
                                <span class="left" style="color:Red">*</span>
                            </li>

                            <li style="margin-left:27px;">
                                <div class="MVerify" style="position:relative;"><span style="font-size:1em; width:85px; text-align:right; display: inline-block;" class="spanleft">手机验证码：</span>
                                    <input type="text" name="verifyCode" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" datatype="n6-6" errormsg="{{trans('com.error_code')}}" class="input2 req" style="width:160px;height:30px;font-size:16px;text-indent:0.5em;border:1px solid #d0d0ce;">
                                    <input type="button" id="BtnPhoneCode" class="BtnPhoneCode" value="获取验证码" style="cursor: pointer;margin-left:10px;">
                                </div>
                            </li>
                            <li>
                                {{csrf_field()}}
                            <div class="w-150 btn">
                                <input id="Submit" name="Submit" class="dk-btn" type="Submit" value="立即充值">
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
            <div class="nering-r left">
                <div class="gg">
                    <img src="//cdnimg.dd373.com/file/general/images/gg.jpg" width="170" height="328">
                </div>
                <div class="text">
                    <p>常见问题：</p>
                    <p><a href="//help.dd373.com/Help/Detail/138.html" target="_blank">1.如何购买点卡订单？</a></p>
                    <p><a href="//help.dd373.com/Help/Detail/135.html" target="_blank">2.客服教你如何手机话费充值</a></p>
                    <p><a href="//help.dd373.com/Help/Detail/136.html" target="_blank">3.买家如何查收点卡？</a></p>
                    <p><a href="//help.dd373.com/Help/Detail/137.html" target="_blank">4.如何查看账户资金详细？</a></p>
                    <p><a href="//help.dd373.com/Help/Detail/134.html" target="_blank">5.过户中的巨人账号为何不能充值点数。</a></p>
                </div>
            </div>
            <!--dianka end-->
        </div>
    </div>
</div>
    <script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
    <script>
        var oMenuIcon = $("#buynumber").select2({
            placeholder: "请选择"
        });
        $('#buynumber').change(function(){
            var num = $('#buynumber').val();
            var p = "{{$data['pervalue']}}";
            var price = (Number(p)*Number(num)).toFixed(2)
            $('#TotalMoney').val(price);
        });

        $('#buynumber_r').keyup(function(){
            var num = $('#buynumber_r').val();
            var p = "{{$data['pervalue']}}";
            var price = (Number(p)*Number(num)).toFixed(2)
            $('#TotalMoney').val(price);
        })

        $('#BtnPhoneCode').sms({
            token       : "{{csrf_token()}}",
            interval    : 60,
            voice       : false,
            requestData : {
                mobile : function () {
                    return $('#PhoneNo').val();
                },
                mobile_rule : 'mobile_required'
            },
            alertMsg : function (msg, type) {
                alert(msg);
            }
        });

        $("#succesform").Validform({
            tiptype:3,
            btnSubmit:'#Submit',
            postonce:true,
            ajaxPost:true,
            callback:function(data){
                if(data.status=="y"){
                    $.Hidemsg();
                        layer.msg(data.info,{icon:6});
                        window.location.href="{{url('user/dk?menu=100')}}";
                }else{
                    $.Hidemsg();
                    layer.alert(data.info,{icon:5});
                }
            }
        });
    </script>

@endsection