@extends('layouts.admin')
@section('content')
<body>
<script src="{{asset('/public/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/public/org/uploadify/uploadify.css')}}">
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/user_rank')}}">会员等级管理</a> &raquo; 修改会员等级
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改会员等级</h3>
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
    <form action="{{url('admin/user_rank/'.$data->id)}}" method="post">
        <table class="add_tab">
            <tbody>

            <tr>
                <th><i class="require">*</i>会员等级名称：</th>
                <td>
                    <input type="text" name="rank_name" value="{{$data->rank_name}}">
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>积分下限：</th>
                <td>
                    <input type="text" name="min_points" value="{{$data->min_points}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>积分上限：</th>
                <td>
                    <input type="text" name="max_points" value="{{$data->max_points}}">
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>手续费折扣率：</th>
                <td>
                    <input type="text" name="discount" value="{{$data->discount}}">
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>最多发布条数：</th>
                <td>
                    <input type="text" name="max_issue" value="{{$data->max_issue}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>最长有效期天数：</th>
                <td>
                    <input type="text" name="max_time" value="{{$data->max_time}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>最大求降价数量：</th>
                <td>
                    <input type="text" name="max_changePrice" value="{{$data->max_changePrice}}">
                </td>
            </tr>
            <tr>
                <th>等级图片：</th>
                <td>
                    <input id="file_upload" name="file_upload" type="file" multiple="false">
                    <p>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                    <input type="hidden" name="rank_img" value="{{$data->rank_img}}">
                    <img src="{{$data->rank_img}}" id="rank_img" style="max-width: 300px;max-height: 100px;">
                </td>
            </tr>

            <tr>
                <th></th>
                <input type="hidden" name="id" value="{{$data->id}}">
                {!! csrf_field() !!}
                {{method_field('PUT')}}
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
            $('#rank_img').attr('src',data);
            $('[name*=rank_img]').val(data);
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