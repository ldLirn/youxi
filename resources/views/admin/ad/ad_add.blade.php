@extends('layouts.admin')
@section('content')
<body>
<script type="text/javascript" charset="utf-8" src="{{asset(ORG.'laydate/laydate.js')}}"> </script>
<script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset(ORG.'uploadify/uploadify.css')}}">
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/ad')}}">广告管理</a> &raquo; 添加广告
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>新增广告</h3>
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
        <form action="{{url('admin/ad')}}" method="post">
            <table class="add_tab">
                <tbody>

                    <tr>
                        <th><i class="require">*</i>广告名称：</th>
                        <td>
                            <input type="text" name="ad_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>广告名称必须填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>类型：</th>
                        <td>
                            <select  name="type" onchange="showTr()">
                                    <option value="1">图片</option>
                                     <option value="2">代码</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th width="120"><i class="require">*</i>广告位置:</th>
                        <td>
                            <select  name="position_id">
                                @foreach($cate as $r)
                                    <option value="{{$r->id}}">{{$r->adp_name}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <th>开始日：</th>
                        <td>
                            <li class="laydate-icon" id="start" style="width:200px; margin-right:10px;" ></li>
                            <input type="hidden" name="start_time" value="" id="start_time">
                        </td>
                    </tr>

                    <tr>
                        <th> 结束日：</th>
                        <td>
                            <li class="laydate-icon" id="end" style="width:200px;" ></li>
                            <input type="hidden" name="end_time" value="" id="end_time">
                        </td>
                    </tr>

                    <tr>
                        <th>链接地址：</th>
                        <td>
                            <input type="text" class="lg" name="ad_url">
                            <p><i class="fa fa-exclamation-circle yellow"></i>字母和数字，以及破折号和下划线</p>
                        </td>
                    </tr>

                    <tr id="ad_img">
                        <th>缩略图：</th>
                        <td><input id="file_upload" name="file_upload" type="file" multiple="true">
                            <p>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                        </td>

                    </tr>

                    <tr style="display:none" id="ad_code">
                        <th>代码：</th>
                        <td>
                            <textarea name="ad_code"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <input type="hidden" value="" name="ad_img" id="thumb"/>
                        <td><img src="" id="art_img" style="max-width: 300px;max-height: 100px;"> </td>
                    </tr>


                    <tr>
                        <th><i class="require">*</i>是否开启：</th>
                        <td>
                            <label for=""><input type="radio" name="is_open" value="0" checked="checked">开启</label>
                            <label for=""><input type="radio" name="is_open" value="1" >关闭</label>
                            <span><i class="fa fa-exclamation-circle yellow"></i>必选</span>
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
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            $('#start_time').val(datas);
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function(datas){
            $('#end_time').val(datas);
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
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

<script>
    function showTr() {
        var code = $('[name=type]').val();
       if(code==1){
           $('#ad_code').hide();
           $('#ad_img').show();
       }else if(code==2){
           $('#ad_code').show();
           $('#ad_img').hide();
       }
    }
</script>
@endsection