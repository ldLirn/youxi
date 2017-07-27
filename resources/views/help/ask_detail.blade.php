@extends('layouts.home')
@section('content')
    <link href="{{asset(HOME_CSS.'center.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset(HOME_CSS.'service.css') }}" rel="stylesheet" type="text/css">
    <style>
        #imageupload{position: absolute;
            top:0;left: -19px;}
        .btn{border: none}
    </style>
<body>

<div class="Help">
    <div class="Help_nav">
        @include('layouts.HelpNav')
    </div>
    <div class="box1000 m_t_10 clear_both" style="height: 850px;">
        <div class="zx_location">您的位置：<a href="{{url('/help')}}">客服中心首页</a>>><a href="{{url('/help/ask')}}">选择问题类型</a>>><a href="{{url('help/ask?type='.$type)}}">选择@if($type==1)咨询@elseif($type==2)建议@elseif($type==3)投诉@endif类型</a>>><span>填写问题</span></div>
        <div class="service_content">
            @if(session('msg'))
            <dl class="update_service clearfix">
                <dt class="heit30"></dt>
                <dd>
                    <div id="J_cpt_ts" class="f_left like_select">
                        <span class="text">{{session('msg')}}</span>
                    </div>
                </dd>
            </dl>
            @endif
            <dl class="update_service clearfix">
                <dt class="heit30">咨询类型：</dt>
                <dd>
                    <div id="J_cpt_ts" class="f_left like_select">
                        <span class="text">{{$cate}}</span>
                    </div>
                </dd>
            </dl>
            <form method="post" id="ask_form" >
            <dl class="update_service clearfix">
                <dt class="heit30">问题标题：<s>*</s></dt>
                <dd class="contact_num">
                    <input type="text" placeholder="请输入需要处理的问题的标题" id="user_txt" name="ask_title" datatype="*" class="long_2 holderfont" value="">
                </dd>
            </dl>
            <dl class="update_service clearfix">
                <dt>咨询内容：<s>*</s></dt>
                <dd>
                    <div class="write_ques">
                        <textarea class="ques_t J_relation holderfont" id="complaints" name="ask_content" placeholder="请详细描述您要咨询的内容 ，为确保您的个人信息安全 ，请勿在问题内容中填写帐号、密码、联系方式等信息" datatype="*"></textarea>
                        <ul class="operate">
                            <li id="J_sctp"><i class="sctp"></i><span class="on">上传图片</span></li>
                            <li style="float: right"><span class="on">还可以输入<span style="color: red" id="len">200字</span></span></li>
                        </ul>
                        <ul class="upload_img" style="display: none;">
                            <li class="loadimgbox">
                               <div class="FileUpload">
                                <div class="FUItem">
                                    <div class="img">
                                        @if(old('CardImg'))
                                            <img style="width: 100%;height:100%" src="{{old('CardImg')}}">
                                        @else
                                            <p>暂无图片</p>
                                        @endif
                                    </div>
                                    <input type="hidden" name="pic" value="" id="pic">
                                    <div class="Btn">上传图片<input type="file" size="1" class="_file" id="imageupload" name="CardImg" multiple="false"></div>
                                </div>
                            </div>
                            </li>
                        </ul>
                    </div>
                </dd>
            </dl>
            <dl class="update_service clearfix">
                <dt class="heit30">我的用户名：<s>*</s></dt>
                <dd class="contact_num">
                    <input type="text" placeholder="请输入您的登录用户名" id="user_txt" name="name" datatype="*" class="long_2 holderfont" value="{{$user['name']}}">
                </dd>
            </dl><dl class="update_service clearfix">
                <dt class="heit30">我的联系方式：</dt>
                <dd class="contact_num">
                    <ul class="contact_txt">
                        <li>
                            <input type="text" class="long_2 holderfont" placeholder="手机号" id="moblephone" value="{{$user['telphone']}}" name="telphone" datatype="/^1[34578]\d{9}$/">
                            <s class="must">*</s>
                        </li>
                        <li>
                            <input type="text" class="long_2 holderfont" placeholder="QQ号" id="qqNumber" value="{{$user['qq']}}" name="qq" datatype="n4-13">
                            <s class="must">*</s>
                        </li>
                    </ul>
                </dd>
            </dl>
        <dl class="update_service clearfix">
                <dt class="heit30" style="line-height: 58px">验证码：  <s class="must">*</s></dt>
                <dd class="upcode">
                    <input type="text" id="J_code" name="J_code" value="" class="code" maxlength="6" title="验证码"  ajaxurl="{{url('/common/VerifyPicCode?_token='.csrf_token())}}" datatype="s6-6" errormsg="{{trans('com.error_code')}}">
                    <img src="{{url('login/verify')}}" id="yzm_img" onclick="this.src='{{url('login/verify')}}?'+Math.random()" style="cursor:pointer">
                <span class="exchange_a" style="cursor:pointer;font-size: 12px;" onclick="document.getElementById('yzm_img').src='{{url('login/verify')}}?'+Math.random()">看不清，换一张
                </span>
                </dd>
            {{csrf_field()}}
            {{method_field('PUT')}}
            </dl><div class="sumbit_loca">
                <a class="submit_ques">提交咨询</a>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $(function () {
        $('#J_sctp').click(function () {
            $('.upload_img').show();
        })
        $("#complaints").keyup(function(){
            var length = 200;
            var content_len = $("#complaints").val().length;
            var in_len = length-content_len;
            if(in_len >=0){
                $("#len").html(in_len+'字');
            }else{
                $("#len").html('0字');
                $(this).val( $(this).val().substring(0, length));
                return false;
            }
        });
    })
    $("#ask_form").Validform({
        tiptype:3,
        btnSubmit:".submit_ques"
    })
    $('#imageupload').uploadify({
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
            $('.img').html('<img style="height:100%;width:100%;" src="'+data+'"/>');
            $('#pic').val(data);
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
</script>
@endsection

