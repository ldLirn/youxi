@extends('layouts.admin')
@section('content')
<body>
<script type="text/javascript" charset="utf-8" src="{{asset('/public/org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('/public/org/ueditor/ueditor.all.min.js')}}"> </script>
<script src="{{asset('/public/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/public/org/uploadify/uploadify.css')}}">
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/power')}}">文章管理</a> &raquo; 修改管理员
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改管理员</h3>
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
        <form action="{{url('admin/power/'.$data['id'])}}" method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>角色：</th>
                        <td>
                            <select name="role_id">
                                @foreach($cate as $v)
                                    <option value="{{$v->id}}" @if($data['role']==$v->id)selected="selected"@endif>{{$v->description}}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>用户名：</th>
                        <td>
                            <input type="text"  name="name" value="{{$data['name']}}">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>邮箱：</th>
                        <td>
                            <input type="email"  name="email" value="{{$data['email']}}">
                        </td>
                    </tr>

                    {!! csrf_field() !!}
                    {{method_field('PUT')}}
                    <input type="hidden" value="{{$data['id']}}" name="id">
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

<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
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