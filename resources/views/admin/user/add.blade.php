@extends('layouts.admin')
@section('content')
<body>
<script type="text/javascript" charset="utf-8" src="{{asset('/public/org/laydate/laydate.js')}}"> </script>
<script src="{{asset('/public/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/public/org/uploadify/uploadify.css')}}">
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/user')}}">会员管理</a> &raquo; 新增会员
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>新增会员</h3>
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
        <form action="{{url('admin/user')}}" method="post">
            <table class="add_tab">
                <tbody>

                    <tr>
                        <th><i class="require">*</i>会员名称：</th>
                        <td>
                            <input type="text" name="name" value="{{old('name')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>邮箱：</th>
                        <td>
                            <input type="email" name="email" value="{{old('email')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>手机：</th>
                        <td>
                            <input type="text" name="telphone" value="{{old('telphone')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>QQ号码：</th>
                        <td>
                            <input type="text" name="qq" value="{{old('qq')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>登录密码：</th>
                        <td>
                            <input type="password" name="password" value="{{old('password')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>确认密码：</th>
                        <td>
                            <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>支付密码：</th>
                        <td>
                            <input type="password" name="pay_password" value="{{old('pay_password')}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>信用积分：</th>
                        <td>
                            <input type="text" name="integral" value="0">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>密保问题：</th>
                        <td>
                            <select name="question">
                                <option value="">请选择</option>
                                <option value="您最喜欢的游戏是什么?">您最喜欢的游戏是什么?</option>
                                <option value="您的出生地是？">您的出生地是？</option>
                                <option value="您的暗号?">您的暗号?</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>密保答案：</th>
                        <td>
                            <input type="text" name="answer" value="">
                        </td>
                    </tr>

                    <tr>
                        <th>出生日期：</th>
                        <td>
                            <li class="laydate-icon" id="start" style="width:200px; margin-right:10px;" ></li>
                            <input type="hidden" name="birthday" value="{{old('birthday')}}" id="start_time">
                        </td>
                    </tr>

                    <tr>
                        <th>真实姓名：</th>
                        <td>
                            <input type="text" name="rel_name" value="{{old('rel_name')}}">
                        </td>
                    </tr>

                    <tr>
                        <th>身份证号：</th>
                        <td>
                            <input type="text" name="datecard" value="{{old('datecard')}}">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证正面：</th>
                        <td>
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <p>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                            <input type="hidden" name="bd_img" value="">
                            <img src="" id="bd_img" style="max-width: 300px;max-height: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证反面：</th>
                        <td>
                            <input id="file_upload_back" name="file_upload" type="file" multiple="true">
                            <input type="hidden" name="back_bd_img" value="">
                            <img src="" id="back_bd_img" style="max-width: 300px;max-height: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证手持：</th>
                        <td>
                            <input id="file_upload_hand" name="file_upload" type="file" multiple="true">
                            <input type="hidden" name="hand_bd_img" value="">
                            <img src="" id="hand_bd_img" style="max-width: 300px;max-height: 100px;">
                        </td>
                    </tr>

                    <tr>
                        <th>实名审核状态：</th>
                        <td>
                           <select name="is_check_datecard">
                               <option value="">请选择</option>
                               <option value="0">未审核</option>
                               <option value="1">通过</option>
                               <option value="2">不通过</option>
                           </select>
                        </td>
                    </tr>


                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>


<script>
    var start = {
        elem: '#start',
        format: 'YYYY-MM-DD',
       // min: laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16', //最大日期
        istime: false,
        istoday: false,
        choose: function(datas){
            $('#start_time').val(datas);
        }
    };
    laydate(start);
</script>

<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadify({
            'buttonText':'请选择图片',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     :"{{csrf_token()}}"
            },
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
            'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
            'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $('#bd_img').attr('src',data);
                $('[name*=bd_img]').val(data);
            },
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError': function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        alert("上传的文件数量已经超出系统限制的" + $('#file_upload').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case -110:
                        alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload').uploadify('settings', 'fileSizeLimit') + "大小！");
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

        $('#file_upload_back').uploadify({
            'buttonText':'请选择图片',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     :"{{csrf_token()}}"
            },
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
            'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
            'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $('#back_bd_img').attr('src',data);
                $('[name*=back_bd_img]').val(data);
            },
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError': function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        alert("上传的文件数量已经超出系统限制的" + $('#file_upload_back').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case -110:
                        alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload_back').uploadify('settings', 'fileSizeLimit') + "大小！");
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

        $('#file_upload_hand').uploadify({
            'buttonText':'请选择图片',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     :"{{csrf_token()}}"
            },
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '{{IMG_TYPE}}',  //允许上传的类型
            'fileSizeLimit' : '{{IMG_SIZE}}',  //允许上传大小
            'swf'      : '{{asset(ORG.'uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $('#hand_bd_img').attr('src',data);
                $('[name*=hand_bd_img]').val(data);
            },
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError': function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case -100:
                        alert("上传的文件数量已经超出系统限制的" + $('#file_upload_hand').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case -110:
                        alert("文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload_hand').uploadify('settings', 'fileSizeLimit') + "大小！");
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
</script>

@endsection