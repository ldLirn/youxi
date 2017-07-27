@extends('layouts.home')
<link href="{{asset(HOME_CSS.'need.css')}}" rel="stylesheet" type="text/css">
@section('content')
@include('layouts.nav')
<div class="all">
    <div class="place">
        <p>您现在的位置：{!! Breadcrumbs::render('needsPublish_form') !!}</p>
    </div>
    <form id="PostFrom" action="{{url('/user/needs/Finish')}}" method="post" class="form" target="_blank">
        <input type="hidden" name="game_qu_id" value="{{Hashids::encode($fwq['id'])}}" >
        <input type="hidden" name="goods_type_id" value="{{Hashids::encode($type['id'])}}" >
        <input type="hidden" name="game_id" value="{{Hashids::encode($game['id'])}}" >
        <input type="hidden" name="qu_id" value="{{Hashids::encode($qu['id'])}}" >
        {{csrf_field()}}
        <div class="message">
            <div class="product">
                <h3>
                    <span class="tb left"></span>
                    <span class="wz left">求购信息</span>
                </h3>
                <div class="form">
                    <ul>
                        <li class="t">
                            <label class="left">已选商品分类:</label>
                            <div class="formright left">
                                {{$game['game_name']}}&gt; {{$qu['qu_name']}}&gt; {{$fwq['qu_name']}}&gt; [{{$type['type']}}]
                            </div>
                        </li>

                                <li>
                                    <label class="left"><span class="red">*</span>  单件数量:</label>
                                    <div class="formright left">
                                        <input class="input2 req W100 money NeedNum" name="one_num" type="text" datatype="n">
                                        @if($type['type']=='金币' || $type['type']=='游戏币')
                                        <select name="NeedNumUnit" class="req NeedNumUnit">
                                                <option value="1" selected="selected">万金</option>
                                        </select>
                                        @endif
                                    </div>
                                    <div class="ts icon1 left"></div>
                                </li>

                                <li>
                                    <label class="left"><span class="red">*</span>  商品单价:</label>
                                    <div class="formright left">
                                        <input class="input2 req money W100 NeedPrice" name="goods_price" type="text" datatype="/^[1-9]{1}\d*(\.\d{1,2})?$/" errormsg="{{trans('com.error_goods_price')}}">  元
                                    </div>
                                    <div class="ts icon1 left"></div>
                                </li>

                                <li>
                                    <label class="left"><span class="red">*</span>  商品标题:</label>
                                    <div class="formright left">
                                        <input class="input2 req GameName" name="goods_name" type="text" style="width:200px;" datatype="*">
                                    </div>
                                    <div class="ts icon1 left"></div>
                                </li>
                                <script type="text/javascript">
                                    $(function () {
                                        $(".NeedNum").blur(function () {
                                            $(".NeedPrice").blur();
                                        });
                                        $(".NeedNumUnit").blur(function () {
                                            $(".NeedPrice").blur();
                                        });
                                        $(".NeedPrice").blur(function () {
                                            var v1 = $(".NeedNum").val(); //单件数量
                                            var v2 = $(".NeedNumUnit").val();//单位
                                            var v4 = $(".NeedNumUnit option:selected").text();
                                            var v5 = $('.NeedNumUnit option:first').text();
                                            var v3 = $(".NeedPrice").val(); //商品单价
                                            $(".NeedSinglePriceHtml").html("");
                                            $(".NeedSinglePriceUnitHtml").html("");
                                            $(".NeedSinglePrice").val("");
                                            $(".NeedSinglePriceUnit").val("");
                                            $(".GameName").val("");
                                            if (v1 != "" && v2 != "" && v3 != "") {
                                                $(".NeedSingle").show();
                                                var vsp = parseFloat(v3) / (parseFloat(v1) * parseFloat(v2));
                                                $(".NeedSinglePriceHtml").html(Math.round((Math.floor(vsp * 100000))) / 100000);
                                                $(".NeedSinglePriceUnitHtml").html("元/" + v5);
                                                $(".NeedSinglePrice").val(Math.round((Math.floor(vsp * 100000))) / 100000)
                                                $(".NeedSinglePriceUnit").val("元/" + v5);
                                                $(".GameName").val(v1 + "" + v4 + "=" + v3 + "元");
                                                $("#NumUnit").val(v4);
                                            } else
                                                $(".NeedSingle").hide();
                                        });

                                    });

                                </script>

                        <li>
                            <label class="left"><span class="red">*</span>  求购件数:</label>
                            <div class="formright left">
                                <input class="input2 req int W100 fabujian" name="goods_stock" type="text" value="1" datatype="n">
                            </div>
                            <div class="ts icon1 left">您当前最多发布件数为{{$vip_level['max_issue']}}件。</div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>  求购描述:</label>
                            <div class="formright left">
                                <textarea style="width:76%;height:120px;font-size:12px;line-height:20px" name="goods_content" datatype="*"></textarea>
                                <br>请如实填写求购描述（切勿填写与本求购无关的广告信息和联系方式等）
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="account clear_both">
                <div class="form">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">收货信息</span>
                    </h3>
                    <ul>

                        <li>
                            <label class="left"><span class="red">*</span>收货角色名称</label>
                            <div class="formright left">
                                 <input class="input2 left req" name="role_name" type="text" datatype="*">
                            </div>
                            <div class="ts icon1 left" data-moren="" data-right="" data-error="">请输入您的收货角色名称。</div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="account clear_both">
                <div class="form">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">联系方式</span>
                    </h3>
                    <ul>
                        <li>
                            <label class="left"><span class="red">*</span>联系电话</label>
                            <div class="formright left">
                                <input class="input2 left hide_phone" name="phone"  type="text" value="{{$user['telphone']}}"  datatype="/^1[34578]\d{9}$/" errormsg="{{trans('com.error_phone')}}">
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>您的QQ号码</label>
                            <div class="formright left">
                                <input class="input2 left hide_qq" name="qq" type="text" value="{{$user['qq']}}"  datatype="n4-13" errormsg="{{trans('com.error_qq')}}" >
                            </div>
                            <div class="ts icon1 left" data-moren="" data-right="" data-error="">请输入您的QQ号码</div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="transaction clear_both">
                <div class="form">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">交易选项</span>
                    </h3>
                    <ul>
                        <li class="t">
                            <label class="left"><span class="red">*</span>有效期:</label>
                            <div class="formright left">
                                <select name="sale_end_time" id="OverDay" datatype="*">
                                    @for($i=1;$i<=$vip_level['max_time'];$i++)
                                    <option value="{{$i}}" @if($i==$vip_level['max_time'])selected="selected"@endif>{{$i}}天</option>
                                    @endfor
                                </select>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>  方便交易时间:</label>
                            <div class="formright left">
                                <select class="input2"  name="best_time" datatype="*">
                                    <option value="00:00-24:00">00:00-24:00</option>
                                    <option value="6:00-12:00"> 6:00-12:00</option>
                                    <option value="12:00-18:00">12:00-18:00</option>
                                    <option value="18:00-24:00">18:00-24:00</option>
                                </select>
                                如不选择，系统将默认为全天24小时方便交易。
                            </div>
                        </li>
                        <li class="MVerify">   <label class="ner-l left"> <span class="red">*</span> 手机验证码：</label>
                            <div class="shuru left" style="position:relative;">
                               <input type="text" name="verify_mobileCode" class="kuang int" style="margin-top: 5px;border: 1px solid #ccc" ajaxurl="{{url('/common/VerifyMobileCode?_token='.csrf_token().'&')}}" datatype="n6-6" errormsg="验证码格式不正确">
                                <input type="button" id="BtnPhoneCode" class="BtnPhoneCode" value="获取验证码" style="margin-top: 5px;border: 1px solid #ccc;cursor: pointer;background: #fff">

                                <div class="tipinner" style="display: none; top: -80px; left: 160px;" id="tsk">
                                    <div class="cont">
                                        <div>{{trans('home.phone_code_msg')}}</div>
                                        <div class="arrow"><em></em><span style=""></span></div>
                                    </div>
                                </div>
                            </div>
                            <span style="color:#006699;margin-left:10px;" class="verifyresult"></span>
                        </li>
                        <script type="text/javascript">
                            $('#BtnPhoneCode').click(function () {
                                $('.tipinner').show();
                            })
                            $('#tsk').css({top:-80,left:160});
                        </script>
                        <li>
                            <label class="left">&nbsp;</label>
                            <div class="formright left"><input name="" type="checkbox" value="" checked="checked" datatype="*">&nbsp;&nbsp;{{trans('home.Agree')}}<a href="">{{trans('home.Agreement_qg')}}</a></div>
                        </li>
                        <li>
                            <label class="left">&nbsp;</label>
                            <div class="formright left"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="button clear_both">
            <a href="javascript:void(0);" id="BtnSubmit"><strong>确认，提交发布</strong></a>
        </div>
    </form>
</div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script src="{{asset(HOME_JS.'laravel-sms.js')}}"></script>
    <script>
        $("#PostFrom").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            postonce:true,
            ajaxPost:true,
            callback:function(data){
                if(data.status=="y"){
                     setTimeout(function(){
                        $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                        window.location.href="{{url('/user/needs')}}";
                    },500);
                }
            }
        });

    $('#BtnPhoneCode').sms({
        token       : "{{csrf_token()}}",
        interval    : 120,
        voice       : false,
        requestData : {
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