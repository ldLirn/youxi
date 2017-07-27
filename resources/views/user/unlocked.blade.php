@extends('layouts.user')
@section('content')
    <script type="text/javascript" src="{{asset(HOME_JS.'jquery.cookie.js')}}"></script>
    <div class="content">
        <div class="center_title">我的位置：{!! Breadcrumbs::render('AbnormalCapital') !!}</div>
        <div class="center_box">
            @include('layouts.user_left_menu')
            <div class="center_right">
                <div class="qq_up_top" style="height: auto;">
                    <div class="fssc"></div>
                    <div class="fw_c"><span>{{$type}}申请</span>
                        <p>1.申请人填写信息需真实有效，如所提交信息与实际查询结果不符，则申请无效。</p>
                        <p>2.申请人在线填写申请表（带*为必填项目）。</p>
                        <p>3.{{web_url}}仅对申请人提供的资料进行形式审核。因信息内容而引发的任何纠纷，一概与{{web_url}}无关。</p>
                    </div>
                </div>
                <div class="bor">

                    <form method="post" id="MemberFrm" class="form" enctype="multipart/form-data">

                        <div class="MoneyDuration">
                            <div class="tip">
                                <p class="red">为保障{{$type}}申请顺利进行，请确保以下填写信息真实有效。</p>
                            </div>
                            <div>
                                <div class="title"><span class="f14"><strong>个人信息</strong></span>&nbsp;&nbsp;<span
                                            class="hui">审核过程中，我们将与您进行信息确认，请保持联系方式畅通。</span></div>
                                <div class="SpeT">
                                    <ul>
                                        @if(count($errors)>0)
                                            @foreach($errors->all() as $error)
                                                <div class="basic_text"><p style="color: red; text-align: center;">{{$error}}</p></div>
                                            @endforeach
                                        @endif
                                        @if(session('msg'))
                                            <div class="basic_text"><p style="color: red; text-align: center;">{{session('msg')}}</p></div>
                                        @endif
                                        <li>
                                            <span class="text left">用户名：<span class="red">*</span></span>
                                            <input class="input1 req kuang left" id="MU_Name" name="username" type="text"
                                                   value="{{old('username')}}" datatype="*" >
                                            <span class="grey">请输入您的用户名</span>
                                        </li>

                                            @if($type=='换绑邮箱')
                                                <li>
                                                    <span class="text left">原邮箱：<span class="red">*</span></span>
                                                    <input class="input1 email kuang" id="MU_RegEmail" name="email"
                                                           type="text" value="{{$user['email']}}" datatype="e" errormsg="邮箱地址不正确">
                                                    <span class="grey">请输入您的原邮箱</span>
                                                </li>
                                                <li>
                                                    <span class="text left">现邮箱：<span class="red">*</span></span>
                                                    <input class="input1 email kuang" id="MU_RegEmail" name="n_email"
                                                           type="text" value="" datatype="e" errormsg="邮箱地址不正确">
                                                </li>
                                                <li>
                                            @else
                                                <li>
                                                    <span class="text left">安全邮箱：<span class="red">*</span></span>
                                                    <input class="input1 email kuang" id="MU_RegEmail" name="email"
                                                           type="text" value="{{old('email')}}" datatype="e" errormsg="邮箱地址不正确">
                                                    <span class="grey">请输入您的邮箱</span>
                                                </li>
                                            @endif
                                            <li>
                                                <span class="text left">当前绑定的手机号码：<span class="red">*</span></span>
                                                <input class="input1 req phones kuang left" id="MU_BindPhone"
                                                       name="BindPhone" title="请填写您帐号绑定的手机号码" type="text" value="{{old('BindPhone')}}" datatype="/^1[34578]\d{9}$/"   errormsg="手机号码格式不正确">
                                                <span class="grey">请输入您帐号绑定的手机号码</span>
                                            </li>
                                            <li>
                                                <span class="text left">身份证号：<span class="red">*</span></span>
                                                <input class="input1 cradid kuang left" id="MU_IdCard" name="IdCard"
                                                       type="text" value="{{old('IdCard')}}" datatype="idcard" errormsg="身份证格式不正确">
                                                &nbsp;<span style="color:red;"></span>
                                                <span class="grey">请输入您身份证号</span>

                                            </li>
                                        <li>
                                            <span class="text left">银行卡号：<span class="red">*</span></span>
                                            <input class="input1 req kuang left" id="MU_CardNo" name="bankNo"
                                                   type="text" value="{{old('bankNo')}}" datatype="n16-20" errormsg="银行卡号格式不正确">
                                            <span class="grey">请输入您的银行卡号</span>
                                        </li>

                                        @if($type=='开户名修改')
                                                <li>
                                                    <span class="text left">原银行卡开户名：<span class="red">*</span></span>
                                                    <input class="input1 req kuang left" id="MU_CardName" name="bankName"
                                                           type="text" value="" datatype="/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,5}$/">
                                                    <span class="grey">请输入您银行卡开户名</span>
                                                </li>
                                                <li>
                                                    <span class="text left">新银行卡开户名：<span class="red">*</span></span>
                                                    <input class="input1 req kuang left" id="MU_CardName" name="n_bankName"
                                                           type="text" value="" datatype="/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,5}$/">
                                                    <span class="grey">请输入您银行卡开户名</span>
                                                </li>
                                        @else
                                            <li>
                                                <span class="text left">银行卡开户名：<span class="red">*</span></span>
                                                <input class="input1 req kuang left" id="MU_CardName" name="bankName"
                                                       type="text" value="{{old('bankName')}}" datatype="/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,5}$/">
                                                <span class="grey">请输入您银行卡开户名</span>
                                            </li>
                                        @endif
                                        <li class="area">
                                            <span class="text left">{{$type}}@if($type=='资金异常')具体描述@else原因@endif：<span class="red">*</span></span>
                                            <textarea class="input1 req area300" cols="20" id="MU_Content"
                                                      name="content"
                                                      onkeyup="checkLength(this, 'MU_Content', '500');"
                                                      rows="2" datatype="*">{{old('content')}}</textarea>
                                            <img src="{{asset(HOME_IMG.'center/Notepad.gif')}}" width="12">还可以输入 <font
                                                    id="ls_MU_Content" color="#ff0000;">500</font> 个字符！

                                        </li>
                                        <li>
                                            <span class="text left">联系电话：<span class="red">*</span></span>
                                            <input class="input1 req phones kuang left" id="MU_Phone" name="phone"
                                                   title="请填写您现在正在使用的手机号码" type="text" value="{{old('phone')}}" datatype="/^1[34578]\d{9}$/"   errormsg="手机号码格式不正确">
                                            <span class="grey">请输入您的联系电话</span>
                                        </li>
                                        <li>
                                            <span class="text left">联系QQ：<span class="red">*</span></span>
                                            <input class="input1 int kuang left" id="MU_QQ" name="qq" type="text"
                                                   value="{{old('qq')}}" datatype="n4-13"   errormsg="QQ号码格式不正确">
                                            <span class="grey">请输入您的QQ号码</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="scpz clear_both">
                                <div class="fileinfo">
                                    <div class="l_fileinfo">
                                        上传凭证信息：
                                        <label class="red"><strong>*</strong></label>
                                    </div>
                                    <div class="r_fileinfo">
                                        <span class="cardcontent">照片支持{{IMG_TYPE}}格式，图片最大不要超过{{IMG_SIZE}}
                                            。下面至少选择两项。为确保资金异常核对顺利，建议提交更多信息。</span>
                                        <div class="fanben">
                                            <a class="example-image-link"
                                               href="{{asset(HOME_IMG.'center/sqsqtbfb.png')}}"
                                               data-lightbox="example-1">查看范本</a>
                                        </div>
                                        <script src="{{asset(PUBLIC_JS.'lightbox-plus-jquery.min.js') }}"></script>
                                        <link rel="stylesheet" type="text/css"
                                              href="{{asset(PUBLIC_CSS.'lightbox.min.css') }}"/>

                                        <div class="div_photo">

                                            <ul class="photo_left photo_box">
                                                <li style="font-weight:bold;color:Black;" class="li_title">身份证正面照</li>
                                                <li style="color:Red;" class="normal_tip">需要能看清姓名、身份证号码等信息。</li>
                                                <li class="li_img">
                                                    <div class="img_left">
                                                        <div id="upload1_box" class="div_img">
                                                            @if(old('CardImg'))
                                                                <img style="width: 100%;height:100%" src="{{old('CardImg')}}">
                                                                @else
                                                                <p>暂无图片</p>
                                                                @endif
                                                        </div>
                                                    <span>
                                                        {{--<input id="imageupload0" name="imageupload0" type="file"  multiple="false">--}}
                                                        <input type="file" size="1" class="_file" id="imageupload0" name="imageupload0"  multiple="false">
                                                    </span>
                                                     <input type="hidden" id="CardImg" name="CardImg" value="{{old('CardImg')}}" >
                                                    </div>
                                                    <div class="img_right">
                                                        <div id="left_card" class="div_img sltbg idcardfront"></div>
                                                        <a class="example-image-link"
                                                           href="{{asset(HOME_IMG.'center/idcardfront_b.jpg')}}"
                                                           data-lightbox="example-2">示例</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="photo_right photo_box">
                                                <li style="font-weight:bold;color:Black;" class="li_title">身份证反面照</li>
                                                <li style="color:Red;" class="normal_tip">需要看清身份证有效期等信息。</li>
                                                <li class="li_img">
                                                    <div class="img_left">
                                                        <div id="upload2_box" class="div_img">
                                                            @if(old('CardFmImg'))
                                                                <img style="width: 100%;height:100%" src="{{old('CardFmImg')}}">
                                                            @else
                                                                <p>暂无图片</p>
                                                            @endif
                                                        </div>
                            <span>
                                 {{--<input id="imageupload1" name="imageupload1" type="file" size="1"  multiple="false">--}}
                                <input type="file" size="1" class="_file" id="imageupload1" name="imageupload1"  multiple="false">
                            </span>
                                                        <input type="hidden" id="CardFmImg" name="CardFmImg" value="{{old('CardFmImg')}}">
                                                    </div>
                                                    <div class="img_right">
                                                        <div id="right_card" class="div_img sltbg idcardback"></div>
                                                        <a class="example-image-link"
                                                           href="{{asset(HOME_IMG.'center/idcardback_b.jpg')}}"
                                                           data-lightbox="example-3">示例</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="div_photo">
                                            {{csrf_field()}}
                                            <ul class="photo_left photo_box">
                                                <li style="font-weight:bold;color:Black;" class="li_title">银行卡照片</li>
                                                <li style="color:Red;" class="normal_tip">需要能看清银行卡号、所属银行等信息。</li>
                                                <li class="li_img">
                                                    <div class="img_left">
                                                        <div id="upload1_box" class="div_img">
                                                            @if(old('BankCard'))
                                                                <img style="width: 100%;height:100%" src="{{old('BankCard')}}">
                                                            @else
                                                                <p>暂无图片</p>
                                                            @endif
                                                        </div>
                            <span>
                                 {{--<input id="imageupload2" name="imageupload2" type="file" size="1"  multiple="false">--}}
                                <input type="file" size="1" class="_file" id="imageupload2" name="imageupload2"  multiple="false">
                            </span>
                                  <input type="hidden" id="BankCard" name="BankCard" value="{{old('BankCard')}}">
                                                    </div>
                                                    <div class="img_right">
                                                        <div id="left_card" class="div_img sltbg bankcard"></div>
                                                        <a class="example-image-link"
                                                           href="{{asset(HOME_IMG.'center/bankcard_b.jpg')}}"
                                                           data-lightbox="example-4">示例</a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="photo_right photo_box">
                                                <li style="font-weight:bold;color:Black;" class="li_title">充值记录截图</li>
                                                <li style="color:Red;" class="normal_tip">需要看清充值单号，充值金额时间等信息。</li>
                                                <li class="li_img">
                                                    <div class="img_left">
                                                        <div id="upload2_box" class="div_img">
                                                            @if(old('RecordImg'))
                                                                <img style="width: 100%;height:100%" src="{{old('RecordImg')}}">
                                                            @else
                                                                <p>暂无图片</p>
                                                            @endif
                                                        </div>
                            <span>
                                 {{--<input id="imageupload0" name="imageupload0" type="file"  multiple="false">--}}
                                <input type="file" size="1" class="_file" id="imageupload3" name="imageupload3"  multiple="false">
                            </span>
                                                        <input type="hidden" id="RecordImg" name="RecordImg" value="{{old('RecordImg')}}">
                                                    </div>
                                                    <div class="img_right">
                                                        <div id="right_card" class="div_img sltbg bankrec"></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="div_photo">

                                            <ul class="photo_left photo_box">
                                                <li style="font-weight:bold;color:Black;" class="li_title">注册邮箱截图</li>
                                                <li style="color:Red;" class="normal_tip">需要看清邮箱地址等信息。</li>
                                                <li class="li_img">
                                                    <div class="img_left">
                                                        <div id="upload2_box" class="div_img">
                                                            @if(old('EmailImg'))
                                                                <img style="width: 100%;height:100%" src="{{old('EmailImg')}}">
                                                            @else
                                                                <p>暂无图片</p>
                                                            @endif
                                                        </div>
                            <span>
                                  {{--<input id="imageupload0" name="imageupload0" type="file"  multiple="false">--}}
                                <input type="file" size="1" class="_file" id="imageupload4" name="imageupload4"  multiple="false">
                            </span>
                                                        <input type="hidden" id="EmailImg" name="EmailImg" value="{{old('EmailImg')}}">
                                                    </div>
                                                    <div class="img_right">
                                                        <div id="right_card" class="div_img sltbg picemail"></div>
                                                        <a href=""
                                                           target="_blank">示例</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span style="padding-left:220px;color:Red;margin-top:10px;font-weight:bold;"></span>
                            <div class="clear_both anniu">
                                <a id="ImgMUOne" href="javascript:void(0)" class="tijiao">完成，提交</a>
                                <a href="{{$url.'/list'}}" class="tijiao fanhui">返回列表页面</a>
                            </div>

                        </div>
                    </form>

                </div>


                <script type="text/javascript">
                    $(function () {
                        $("#MemberFrm").Validform({
                        btnSubmit:'#ImgMUOne',
                            tiptype: 3,
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
                            callback: function (form) {
                                var a=0;
                                var CardImg = $('#CardImg').val();
                                if($.trim(CardImg)!='')a++;
                                var CardFmImg = $('#CardFmImg').val();
                                if($.trim(CardFmImg)!='')a++;
                                var BankCard = $('#BankCard').val();
                                if($.trim(BankCard)!='')a++;
                                var RecordImg = $('#RecordImg').val();
                                if($.trim(RecordImg)!='')a++;
                                var EmailImg = $('#EmailImg').val();
                                if($.trim(EmailImg)!='')a++;
                               if(a>=2){
                               }else{
                                   layer.alert('请至少上传2项凭证',{icon:5});
                                   return false;
                               }
                            }
                        });
                    });
                    function checkLength(obj, name, max) {
                        var maxChars = max;
                        var ch_length = obj.value.length;
                        for (var i = Math.floor(maxChars / 2); i < ch_length; i++) {
                            var content = obj.value.substring(0, i);
                            if (content.replace(/([\u0391-\uFFE5])/ig, '11').length >= maxChars) {
                                obj.value = obj.value.substring(0, i);
                                document.getElementById("ls_" + name).innerHTML = curr.toString(0);
                                break;
                            }
                        }
                        test = obj.value.replace(/([\u0391-\uFFE5])/ig, '11');
                        var curr = maxChars - test.length;
                        document.getElementById("ls_" + name).innerHTML = curr.toString();
                    }
                </script>

            </div>
        </div>
    </div>

    <script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
    <script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        function Atte() {
            $("._file").each(function (i, v) {
                $(v).attr("id", "imageupload" + i).attr("name", "imageupload" + i);
                var objbox = $(this).parent().prev();
                var objinput = $(this).parent().next();
                        $(v).uploadify({
                            <?php $timestamp = time();?>
                            'buttonText':'点击上传',
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