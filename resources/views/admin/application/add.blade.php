@extends('layouts.admin')
@section('content')
<body>
<script src="{{asset(PUBLIC_JS.'lightbox-plus-jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'lightbox.min.css') }}"/>
<style>
    th{width: 20%}
    #username{position: absolute;border: 1px solid #ccc;width: 360px;height: auto;background: #fff;z-index: 6}
    #username li{cursor: pointer;padding: 0 8px;line-height: 22px;}
    #username li:hover{background: #eee;}
    .div_img {background-color: #fff;border: 1px solid #ccc;color: #ccc;height: 102px;line-height: 102px;margin-bottom: 10px;width: 158px;margin-top: 20px;}
    .div_img p{height: 100%;text-align: center;line-height: 102px;}
    .uploadify-button{background: #fff !important;  width: 70px !important;  height: 22px !important;  border-radius:0px !important;  border: 1px solid #cdcdcd !important;  line-height: 22px !important;  margin: 0 auto;  }
    .uploadify-button-text{color: #666 !important;}
    .swfupload{left: 0;top: 0 }
</style>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/link')}}">异常申请管理</a> &raquo; 添加异常申请
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>添加异常申请</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
            @if(session('msg'))
                <div class="mark">
                    <p>{{session('msg')}}</p>
                </div>
            @endif
        </div>
    </div>

    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/application/')}}" method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>申请类型：</th>
                        <td>
                           <select name="type">
                               @foreach(trans('application') as $v)
                               <option value="{{$v}}">{{$v}}</option>
                               @endforeach
                           </select>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>申请会员：</th>
                        <td>
                            <input type="text" placeholder="请输入会员关键字，用户名，邮箱，绑定手机" id="user_name"><span><input type="button" value="搜索" onclick="username();"></span>
                            <input type="hidden"  name="user_id">
                            <div id="username" style="display: none">
                                <ul>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>安全邮箱：</th>
                        <td>
                            <input type="email" name="email" value="{{old('email')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>当前绑定的手机号：</th>
                        <td>
                            <input type="text" name="BindPhone" value="{{old('BindPhone')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>身份证号：</th>
                        <td>
                            <input type="text" name="IdCard" value="{{old('IdCard')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>银行卡号：</th>
                        <td>
                            <input type="text" name="bankNo" value="{{old('bankNo')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>银行卡开户名：</th>
                        <td>
                            <input type="text" name="bankName" value="{{old('bankName')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>异常具体描述：</th>
                        <td>
                            <textarea name="content">{{old('content')}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>联系电话：</th>
                        <td>
                            <input type="text" name="phone" value="{{old('phone')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>联系QQ：</th>
                        <td>
                            <input type="text" name="qq" value="{{old('qq')}}">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证正面：</th>
                        <td>
                            <div class="img_left">
                                <div id="upload1_box" class="div_img">
                                    @if(old('CardImg'))
                                        <img style="width: 100%;height:100%" src="{{old('CardImg')}}">
                                    @else
                                        <p>暂无图片</p>
                                    @endif
                                </div>
                                <span>
                                    <input type="file" size="1" class="_file" id="imageupload1" name="imageupload1"  multiple="false">
                                </span>
                                <input type="hidden" id="CardImg" name="CardImg" value="{{old('CardImg')}}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>身份证反面：</th>
                        <td>
                            <div class="img_left">
                                <div id="upload2_box" class="div_img">
                                    @if(old('CardFmImg'))
                                        <img style="width: 100%;height:100%" src="{{old('CardFmImg')}}">
                                    @else
                                        <p>暂无图片</p>
                                    @endif
                                </div>
                                <span>
                                    <input type="file" size="1" class="_file" id="imageupload2" name="imageupload2"  multiple="false">
                                </span>
                                <input type="hidden" id="CardFmImg" name="CardFmImg" value="{{old('CardFmImg')}}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>银行卡照片：</th>
                        <td>
                            <div class="img_left">
                                <div id="upload3_box" class="div_img">
                                    @if(old('bankCard'))
                                        <img style="width: 100%;height:100%" src="{{old('bankCard')}}">
                                    @else
                                        <p>暂无图片</p>
                                    @endif
                                </div>
                                <span>
                                    <input type="file" size="1" class="_file" id="imageupload3" name="imageupload3"  multiple="false">
                                </span>
                                <input type="hidden" id="bankCard" name="bankCard" value="{{old('bankCard')}}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>充值记录截图：</th>
                        <td>
                            <div class="img_left">
                                <div id="upload4_box" class="div_img">
                                    @if(old('RecordImg'))
                                        <img style="width: 100%;height:100%" src="{{old('RecordImg')}}">
                                    @else
                                        <p>暂无图片</p>
                                    @endif
                                </div>
                                <span>
                                    <input type="file" size="1" class="_file" id="imageupload4" name="imageupload4"  multiple="false">
                                </span>
                                <input type="hidden" id="RecordImg" name="RecordImg" value="{{old('RecordImg')}}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>注册邮箱截图：</th>
                        <td>
                            <div class="img_left">
                                <div id="upload5_box" class="div_img">
                                    @if(old('EmailImg'))
                                        <img style="width: 100%;height:100%" src="{{old('EmailImg')}}">
                                    @else
                                        <p>暂无图片</p>
                                    @endif
                                </div>
                                <span>
                                    <input type="file" size="1" class="_file" id="imageupload5" name="imageupload5"  multiple="false">
                                </span>
                                <input type="hidden" id="EmailImg" name="EmailImg" value="{{old('EmailImg')}}">
                            </div>
                        </td>
                    </tr>
                    {!! csrf_field() !!}
                    <tr>
                        <th></th>
                        <td>
                           <input type="submit" value="提交">
                            <input type="button" class="back" onclick='window.location.href="{{url('admin/application')}}"' value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset(ORG.'uploadify/uploadify.css')}}">
    <script>
        function username(){
            var keywords = $.trim($('#user_name').val());
            if(keywords==''){
                layer.msg('请填写搜索关键词');
                return false;
            }
            $.get("{{url('/admin/common/GetUsername')}}",{'keywords': keywords},function(data){
                var html = '';
                $(data).each(function(k,v){
                    html += '<li rid='+ v.id+'>'+ v.name+'</li>';
                });
                $('#username ul').append(html);
                $('#username').show();
            })
        }

        $('#username ul').on('click','li',function(){
            var id = $(this).attr('rid');
            $('[name=user_id]').val(id);
            $('#user_name').val($(this).html());
            $('#username').hide();
        })

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