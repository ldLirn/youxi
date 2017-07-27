@extends('layouts.home')
<link href="{{asset(HOME_CSS.'need.css')}}" rel="stylesheet" type="text/css">
@section('content')
    <script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>

@include('layouts.nav')
<style>
    .img_left {
        margin-right: 9px;
    }

    .img_left{
        float: left;
        text-align: center;
    }

    .img_left{
        position: relative;
    }

    .img_left .div_img {
        background-color: #fff;
        border: 1px solid #ccc;
        color: #ccc;
        height: 74px;
        line-height: 74px;
        margin-bottom: 10px;
    }
    ._file{
        width: 100px;
        float: left !important;
    }
    .uploadify-button{
        width: 70px !important;
        height: 20px !important;
        border-radius:0px !important;
        border: 1px solid #156f4e !important;
        line-height: 22px !important;
        margin: 0 auto;
        background-color: #fff !important;
        background-image: none;
        text-shadow:none;
        text-align: center;
        display: none;
    }
    .uploadify-button-text{
        color:#3781e8 !important;
    }
    .uploadify{
        float: left;
    }
    .uploadify-queue{display:none !important;}
    .swfupload{left: 0;top:0 }
    #imageupload0,#imageupload1,#imageupload2{
        position: absolute;
        top: 0;
        width: 85px !important;
    }
</style>
<div class="all">
    <div class="place">
        <p>您现在的位置：{!! Breadcrumbs::render('sell_form') !!}</p>
    </div>
    <div class="sale-tip top_ts clear_both">
        <p>友情提示：</p>
        <p>1.有客服联系您时，请点击<a href="" target="_blank">客服验证中心</a>输入客服真实QQ号码验证客服真假。（
            <a href="" target="_blank">如何识别真假客服？</a>）
        </p>
        <p>2.客服QQ联系您时，请仔细核实信息中是否包含您完整的用户名，客服暗号是否与您设置的一致。未能提供此信息者，必为骗子！请谨防被骗！<p>
    </div>
    <form id="PostFrom" action="{{url('/user/sell/next')}}" method="post" class="form" target="_blank">
        <input type="hidden" name="game_qu_id" value="{{Hashids::encode($fwq['id'])}}" >
        <input type="hidden" name="game_goods_type_id" value="{{Hashids::encode($type['id'])}}" >
        <input type="hidden" name="game_id" value="{{Hashids::encode($game['id'])}}" >
        <input type="hidden" name="qu_id" value="{{Hashids::encode($qu['id'])}}" >
        <input type="hidden" name="traded_type" value="{{$traded_type}}">
        {{csrf_field()}}
        <div class="message">
            <div class="product">
                <h3>
                    <span class="tb left"></span>
                    <span class="wz left">商品信息</span>
                </h3>
                <div class="form">
                    <ul>
                        <li class="t">
                            <label class="left">已选商品分类:</label>
                            <div class="formright left">
                                {{$game['game_name']}}&gt; {{$qu['qu_name']}}&gt; {{$fwq['qu_name']}}&gt; [{{$type['type']}}]
                            </div>
                        </li>
                            @if(strstr($type['type'],"币"))
                                <li>
                                    <label class="left"><span class="red">*</span>  单件数量:</label>
                                    <div class="formright left">
                                        <input class="input2 req W100 money NeedNum" name="one_num" type="text" datatype="n">

                                        <select name="NeedNumUnit" class="req NeedNumUnit">
                                            @foreach($arr_data[0] as $v)
                                                <option value="{{$v}}">{{$v}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="ts icon1 left"></div>
                                </li>
                            @endif
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
                        @if(!strstr($type['type'],"帐号"))
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
                                @endif
                        <li>
                            <label class="left"><span class="red">*</span>  发布件数:</label>
                            <div class="formright left">
                                <input class="input2 req int W100 fabujian" name="goods_stock" type="text" value="1" datatype="n">
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span> 商品描述:</label>
                            <div class="formright left">
                                <textarea style="width:76%;height:120px;font-size:12px;line-height:20px" name="goods_content" datatype="*"></textarea>
                                <br>请如实填写商品描述（切勿填写与本商品无关的广告信息和联系方式等）
                            </div>
                        </li>
                        <li>
                            <label class="left">商品图片</label>
                            <div class="img_left">
                            <span>
                               <div class="FileUpload" style="background: none;padding: 0">
                                   <div class="FUItem">
                                       <div class="Btn">上传图片 <input id="file_upload_more" name="file_upload_more" type="file" class="_file" multiple="true"></div>
                                   </div>
                               </div>
                                <div class="ts icon1 left" style="margin-left: 10px;">只允许上传以gif，jpg，png结尾的图片,可以一次上传多张</div>
                            </span>
                            </div>
                        </li>
                        <li>
                            <label class="left">图片预览</label>
                            <div class="formright left" id="img_more">

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="account clear_both">
                <div class="form">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">帐号信息</span>
                    </h3>
                    <ul>
                        <li>
                            <label class="left"><span class="red">*</span>出售商品角色名称</label>
                            <div class="formright left">
                                <input class="input2 left req" name="game_user" type="text" datatype="*">
                            </div>
                        </li>
                        @if(strstr($type['type'],"帐号"))
                            @foreach ($accounts as $k=>$v)
                                <li>
                                    <label class="left"><span class="red">*</span>  {{$v[0]}}:</label>
                                    <div class="formright left">
                                        <select name="attr_value[]" class="req">
                                            @foreach ($v[1]['son'] as $i)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ts icon1 left"></div>
                                </li>
                            @endforeach
                            <input type="hidden" name="is_acc" value="1">
                        @endif
                        @if($traded_type=='s')
                        <li>
                            <label class="left"><span class="red">*</span>游戏帐号</label>
                            <div class="formright left">
                                 <input class="input2 left req" name="game_user_name" type="text" datatype="*">
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>帐号密码</label>
                            <div class="formright left">
                                <input class="input2 left req" name="game_user_pwd" type="password" datatype="*">
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>注册帐号身份证</label>
                            <div class="formright left">
                                <input class="input2 left req" name="datacard" type="text" ignore="ignore" datatype="idcard" >
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如没有则不填写</div>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>密保图片</label>
                            <div class="formright left" style="position:relative">
                                <div class="FileUpload" style="background: none;padding: 0">
                                    <div class="FUItem">
                                        <div class="Btn">上传图片  <input id="secretcard_img" name="secretcard_img" type="file" class="_file" multiple="false" ></div>
                                    </div>
                                </div>

                                <div class="ts icon1 left" style="margin-left: 56px;">如没有则不填写</div>
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="" id="secretcard_img_p" style="display:none">
                                    <img style="max-width: 100px;max-height:100px" src="">
                                    <input  name="secretcard_img" type="hidden"  id="secretcard_img_i">
                                </div>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>密保电话</label>
                            <div class="formright left">
                                <input class="input2 left req" name="mb_tel" type="text" ignore="ignore" datatype="*">
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如没有则不填写</div>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>密保问题</label>
                            <div class="formright left">
                                <input class="input2 left req" name="mb_question" type="text" ignore="ignore" datatype="*">
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如没有则不填写</div>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>密保答案</label>
                            <div class="formright left">
                                <input class="input2 left req" name="mb_answer" type="text" ignore="ignore" datatype="*">
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如没有则不填写</div>
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>二级密码</label>
                            <div class="formright left">
                                <input class="input2 left req" name="two_level_pass" type="password" ignore="ignore" datatype="*">
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如没有则不填写</div>
                            </div>
                        </li>
                        @endif
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
                                <input class="input2 left hide_phone" name="game_user_tel"  type="text" value="{{$user['telphone']}}"  datatype="/^1[34578]\d{9}$/" errormsg="{{trans('com.error_phone')}}">
                            </div>
                        </li>
                        <li>
                            <label class="left"><span class="red">*</span>您的QQ号码</label>
                            <div class="formright left">
                                <input class="input2 left hide_qq" name="game_user_qq" type="text" value="{{$user['qq']}}"  datatype="n4-13" errormsg="{{trans('com.error_qq')}}" >
                            </div>
                            <div class="ts icon1 left" data-moren="" data-right="" data-error="">请输入您的QQ号码</div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="account clear_both">
                <div class="form">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">安全服务</span>
                    </h3>
                    <ul>
                        <li>
                            <label class="left"><span class="red">*</span>安保措施</label>
                            <div class="formright left">
                                <select class="input2"  name="security" datatype="*">
                                    @foreach(trans('security') as $v)
                                    <option value="{{$v}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ts icon1 left" data-moren="" data-right="" data-error="">请选择对买家的安保措施</div>
                        </li>
                        @if($traded_type=='d')
                        <li>
                            <label class="left"><span class="red">*</span>交易暗号</label>
                            <div class="formright left">
                                <input class="input2 left hide_phone" name="code"  type="text" value="" ignore="ignore"  datatype="*" errormsg="{{trans('com.error_phone')}}">
                            </div>
                            <div class="ts icon1 left" data-moren="" data-right="" data-error="">客服联系时会验证此信息</div>
                        </li>
                            <li>
                                <label class="left"><span class="red">*</span>是否议价</label>
                                <div class="formright left">
                                    <input type="radio" name="is_cut_price" value="0" checked="checked">不议价
                                    <input type="radio" name="is_cut_price" value="1">可以议价
                                </div>
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">客服联系时会验证此信息</div>
                            </li>
                        @endif
                        <li>
                            <label class="left"><span class="red">*</span>指定买家购买</label>
                            <div class="formright left">
                                <input class="input2 left hide_phone" name="pwd"  type="text" value="" ignore="ignore"  datatype="*" errormsg="{{trans('com.error_phone')}}">
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">如指定买家，请设置购买密码</div>
                            </div>
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
                        <li>
                            <label class="left"><span class="red">*</span>资金转账到</label>
                            <div class="formright left">
                                <input type="radio" name="to_money" value="0" checked="checked" onchange="showAccount()">平台账户
                                <input type="radio" name="to_money" value="1" onchange="showAccount()">我的银行卡
                            </div>
                        </li>
                        <li id="bank" style="display:none">
                            <label class="left"><span class="red">*</span>选择银行卡</label>
                            <div class="formright left">
                                <select name="account">
                                    @foreach($bank_info as $v)
                                    <option value="{{$v['name']}},{{$v['bankNo']}},{{$v['bank_name']}},{{$v['sheng']}}{{$v['city']}}">{{$v['name']}},{{$v['bankNo']}},{{$v['bank_name']}},{{$v['sheng']}}{{$v['city']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        @if(strstr($type['type'],"帐号"))
                            <li>
                                <label class="left"><span class="red">*</span>身份认证</label>
                                <div class="formright left">
                                    <div class="FileUpload">
                                        <div class="FUItem">
                                            <div class="img">
                                                @if(old('CardImg'))
                                                    <img style="width: 100%;height:100%" src="{{old('CardImg')}}">
                                                @else
                                                    <p>正面图片</p>
                                                @endif
                                            </div>
                                            <div class="Btn">上传图片<input type="file" size="1" class="_file" id="imageupload12" name="CardImg" multiple="false"></div>
                                        </div>
                                        <div class="FUItem">
                                            <div class="img">
                                                @if(old('CardImgBack'))
                                                    <img style="width: 100%;height:100%" src="{{old('CardImgBack')}}">
                                                @else
                                                    <p>反面图片</p>
                                                @endif
                                            </div>
                                            <div class="Btn">上传图片<input type="file" size="1" class="_file"  id="imageupload13" name="CardImgBack" multiple="false"></div>
                                        </div>
                                        <div class="FUItem">
                                            <div class="img">
                                                @if(old('CardImgBack'))
                                                    <img style="width: 100%;height:100%" src="{{old('CardImgBack')}}">
                                                @else
                                                    <p>手持图片</p>
                                                @endif
                                            </div>
                                            <div class="Btn">上传图片<input type="file" size="1" class="_file"  id="imageupload13" name="CardImgHand" multiple="false"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
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
            btnSubmit:'.button',
            datatype:{//传入自定义datatype类型【方式二】;
                "idcard":function(gets,obj,curform,datatype){

                    var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子;
                    var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值，10代表X;

                    if (gets.length == 15) {
                        return isValidityBrithBy15IdCard(gets);
                    }else if (gets.length == 18){
                        var a_idCard = gets.split("");// 得到身份证数组
                        if (isValidityBrithBy18IdCard(gets)&&isTrueValidateCodeBy18IdCard(a_idCard)) {
                            return true;
                        }
                        return false;
                    }
                    return false;

                    function isTrueValidateCodeBy18IdCard(a_idCard) {
                        var sum = 0; // 声明加权求和变量
                        if (a_idCard[17].toLowerCase() == 'x') {
                            a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
                        }
                        for ( var i = 0; i < 17; i++) {
                            sum += Wi[i] * a_idCard[i];// 加权求和
                        }
                        valCodePosition = sum % 11;// 得到验证码所位置
                        if (a_idCard[17] == ValideCode[valCodePosition]) {
                            return true;
                        }
                        return false;
                    }

                    function isValidityBrithBy18IdCard(idCard18){
                        var year = idCard18.substring(6,10);
                        var month = idCard18.substring(10,12);
                        var day = idCard18.substring(12,14);
                        var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
                        // 这里用getFullYear()获取年份，避免千年虫问题
                        if(temp_date.getFullYear()!=parseFloat(year) || temp_date.getMonth()!=parseFloat(month)-1 || temp_date.getDate()!=parseFloat(day)){
                            return false;
                        }
                        return true;
                    }

                    function isValidityBrithBy15IdCard(idCard15){
                        var year =  idCard15.substring(6,8);
                        var month = idCard15.substring(8,10);
                        var day = idCard15.substring(10,12);
                        var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
                        // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
                        if(temp_date.getYear()!=parseFloat(year) || temp_date.getMonth()!=parseFloat(month)-1 || temp_date.getDate()!=parseFloat(day)){
                            return false;
                        }
                        return true;
                    }

                }

            },
            postonce:true,
            ajaxPost:true,
            callback:function(data){
                if(data.status=="1"){
                     setTimeout(function(){
                        $.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
                        window.location.href="{{url('/user/MySell')}}";
                    },500);
                }else{
                    $.Showmsg(data);
                }
            }
        });
        $('#file_upload_more').uploadify({
            'buttonText':'请选择图片',
            'formData'     : {
                '_token'     :"{{csrf_token()}}"
            },
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
            'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
            'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $html = '';
                $html += '<div style="width: 100px;height:100px;float: left;margin-left: 10px;position: relative">',
                        $html +='<span onclick="del_pic_this(this)" style="position: absolute;right: 0;cursor: pointer;"><i class="fa-minus-square-o"></i></span>',
                        $html +='<input type="hidden" value="'+data+'" name="pictrue[]" />',
                        $html +='<td><img src="'+data+'"  style="max-width: 100px;max-height: 100px;"> </td>',
                        $html += '</div>'
                        $('#img_more').append($html);
//                    $('#pictrue').attr('src',data);
//                    $('#pictrue_more').val(data);
            },
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError': function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        alert("上传的文件数量已经超出系统限制的" + $('#file_upload_more').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case -110:
                        alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload_more').uploadify('settings', 'fileSizeLimit') + "大小！");
                        break;
                    case -120:
                        alert("文件 [" + file.name + "] 大小异常！");
                        break;
                    case -130:
                        alert("文件 [" + file.name + "] 类型不正确！");
                        break;
                }
                return false;
            },

            //检测FLASH失败调用
            'onFallback': function () {
                alert("您未安装FLASH控件，无法上传！请安装FLASH控件后再试。");
            }
        });
        $('#secretcard_img').uploadify({
            'buttonText':'请上传',
            'formData'     : {
                '_token'     :"{{csrf_token()}}"
            },
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
            'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
            'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $('#secretcard_img_p').find('img').attr('src',data);
                $('#secretcard_img_p').show();
                $('#secretcard_img_i').val(data);
            },
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError': function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        alert("上传的文件数量已经超出系统限制的" + $('#secretcard_img').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case -110:
                        alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#secretcard_img').uploadify('settings', 'fileSizeLimit') + "大小！");
                        break;
                    case -120:
                        alert("文件 [" + file.name + "] 大小异常！");
                        break;
                    case -130:
                        alert("文件 [" + file.name + "] 类型不正确！");
                        break;
                }
                return false;
            },

            //检测FLASH失败调用
            'onFallback': function () {
                alert("您未安装FLASH控件，无法上传！请安装FLASH控件后再试。");
            }
        });
        //删除图片
        function del_pic_this(obj) {
            var img = $(obj).parent("div");
            $(img).remove();
        }

        function showAccount() {
            var code = $('input[name*=to_money]:checked').val()
            if(code=='1'){
                $('#bank').show();
            }else{
                $('#bank').hide();
            }
        }
    </script>

    <script type="text/javascript">
        function Atte() {
            $("._file").each(function (i, v) {
                $(v).attr("id", "imageupload" + i).attr("name", "imageupload" + i);
                var objbox = $(this).parent().prev();
                var objinput = $(this).parent().next();
                $(v).uploadify({
                    <?php $timestamp = time();?>
                    'buttonText':'上传图片',
                    'removeTimeout':0,
                    'formData'     : {
                        'timestamp' : '<?php echo $timestamp;?>',
                        '_token'     :"{{csrf_token()}}"
                    },
                    'fileTypeDesc' : 'Image Files',
                    'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
                    'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
                    'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
                    'uploader' : '{{url('/img/upload')}}',
                    'onUploadSuccess' : function(file, data, response) {
                        objbox.html('<img style="height:100%;width:100%;" src="'+data+'"/>');
                        objinput.val(data);
                    },
                    'overrideEvents': ['onSelectError', 'onDialogClose'],
                    //返回一个错误，选择文件的时候触发
                    'onSelectError': function (file, errorCode, errorMsg) {
                        switch (errorCode) {
                            case -100:
                                alert("上传的文件数量已经超出系统限制的" + $(v).uploadify('settings', 'queueSizeLimit') + "个文件！");
                                break;
                            case -110:
                                alert("文件 [" + file.name + "] 大小超出系统限制的" + $(v).uploadify('settings', 'fileSizeLimit') + "大小！");
                                break;
                            case -120:
                                alert("文件 [" + file.name + "] 大小异常！");
                                break;
                            case -130:
                                alert("文件 [" + file.name + "] 类型不正确！");
                                break;
                        }
                        return false;
                    },

                    //检测FLASH失败调用
                    'onFallback': function () {
                        alert("您未安装FLASH控件，无法上传！请安装FLASH控件后再试。");
                    }
                });
            });
        }
        Atte();
    </script>
 @endsection