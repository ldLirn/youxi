@extends('layouts.admin')
<link rel="stylesheet" type="text/css" href="{{asset('/public/org/uploadify/uploadify.css')}}">
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/start')}}">首页</a> &raquo; 修改个人资料
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改个人资料</h3>
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
    <form method="post" action="">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>

            <tr>
                <th width="120"><i class="require">*</i>QQ：</th>
                <td>
                    <input type="text" name="qq" value="{{$data['qq']}}"> </i>请输入QQ号码</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>寄语：</th>
                <td>
                    <textarea name="question">
                        {!!$data['question']!!}
                    </textarea>
                    </i>会显示在问答回复中</i>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>头像：</th>
                <td>
                    <input id="file_upload" name="file_upload" type="file" multiple="false">
                    <p>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                </td>
            </tr>
            <tr>
                <th></th>
                <input type="hidden" value="{{$data['head_img']}}" name="head_img" id="thumb"/>
                <td><img src="{{$data['head_img']}}" id="art_img" style="max-width: 300px;max-height: 100px;"> </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script src="{{asset('/public/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
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
            'swf'      : '{{asset('/public/org/uploadify/uploadify.swf')}}',
            'uploader' : '{{url('admin/img/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
                $('#art_img').attr('src',data);
                $('#thumb').val(data);
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

    });
</script>
@endsection