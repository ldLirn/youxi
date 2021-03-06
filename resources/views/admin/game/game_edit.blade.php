@extends('layouts.admin')
@section('content')
    <script src="{{asset('/public/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('/public/org/uploadify/uploadify.css')}}">
    <script src="{{asset('/public/public_style/js/jquery.json-2.4.min.js')}}" type="text/javascript"></script>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/game')}}">游戏管理</a> &raquo; 修改游戏
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>修改游戏</h3>
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
<form action="{{url('admin/game/'.$data['id'])}}" method="post" id="my_form">
    <div class="result_wrap">
        <ul class="tab_title">
            <li class="active">游戏基本信息</li>
            <li>游戏区服</li>
            <li>游戏商品种类</li>
        </ul>
        <div class="tab_content">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>游戏分类：</th>
                    <td>
                        <select name="cate_id">
                            @foreach($cate as $v)
                                <option value="{{$v['id']}}" @if($data['cate_id'] == $v['id'])selected="selected" @endif>{{$v['cat_name']}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>游戏名称：</th>
                    <td>
                        <input type="text" name="game_name" value="{{$data['game_name']}}">
                    </td>
                </tr>

                <tr id="link_logo">
                    <th>游戏图标：</th>
                    <td><input id="file_upload" name="file_upload" type="file" multiple="true">
                        <p>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <input type="hidden" value="{{$data['thumb']}}" name="thumb" id="thumb"/>
                    <td><img src="{{$data['thumb']}}" id="art_img" style="max-width: 300px;max-height: 100px;"> </td>
                </tr>


                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="game_desc">{{$data['game_desc']}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="game_order" value="{{$data['game_order']}}">
                    </td>
                </tr>
                <tr>
                    <th></th>

                </tr>
                </tbody>
            </table>
        </div>
        <div class="tab_content">
            <table class="add_tab">
                <tr>
                    <th width="120"><i class="require">*</i>游戏区服</th>
                    <td> <input type="button" class="back" onclick="add_attr(this)" value="添加区" ></td>
                </tr>
        @foreach($qu as $v)
                <tr>
                    <th width="120"></th>
                    <td>
                        <dl class="attr">
                            <dt><i class="require">*</i>大区名：<input type="text" name="qu_name[]" value="{{$v['qu_name']}}"> <span onclick="add_attr_value(this)"><i class="fa fa-plus-circle"></i></span></dt>
                                                                <input type="hidden" name="qu_id[]" value="{{$v['id']}}">
                            <dd><i class="require"></i>服务器：
                                @foreach($v['child'] as $m)
                                <input type="text" name="qu_fwq[]" onchange="attr_total(this)" value="{{$m['qu_name']}}">
                                    <input type="hidden" name="fwq_id[]" value="{{$m['id']}}">
                                @endforeach
                            </dd>

                        </dl>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">
                <tr>
                    <th width="120"><i class="require">*</i>游戏商品种类</th>
                    <td> <input type="button" class="back" onclick="add_type(this)" value="添加种类" ></td>
                </tr>
                @foreach($type as $v)
                <tr>
                    <th width="120"></th>
                    <td>
                        <dl class="attr_type">
                            <dt><i class="require">*</i>种类名：<input type="text" name="type_name[]" value="{{$v['type']}}">手续费(百分比)：<input type="text" name="fee[]" value="{{$v['fee']}}"> <span onclick="add_type(this)"><i class="fa fa-plus-circle"></i></span>
                                <input type="hidden" name="type_id[]" value="{{$v['id']}}">
                            </dt>

                        </dl>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        {{method_field('PUT')}}
        {!! csrf_field() !!}
        <input type="hidden"  name="data" id="data" value="">
        <input type="hidden"  name="id"  value="{{$data['id']}}">
        <div class="btn_group">
            <input type="button" value="提交" onclick="test()">
            <input type="button" class="back" onclick="history.go(-1)" value="返回" >
        </div>

    </div>
</form>
    <!--TAB切换面板和外置按钮组 结束-->

    <script>
        //点击添加属性框
        function add_attr(obj){
            var attr = '<tr>\
                    <th width="120"></th>\
                    <td>\
                        <dl class="attr">\
                            <dt>大区名：<input type="text" name="qu_name[]"> <span onclick="add_attr_value(this)"><i class="fa fa-plus-circle"></i></span></dt>\
                            <input type="hidden" name="qu_id[]" value="">\
                            <dd>服务器名：<input type="text" name="qu_fwq[]" onchange="attr_total(this)"><input type="hidden" name="fwq_id[]" value=""></dd>\
                        </dl>\
                    </td>\
                </tr>';
            $(obj).parents('tr').eq(0).after(attr);
        }

        function add_type(obj){
            var attr = '<tr>\
                    <th width="120"></th>\
                    <td>\
                        <dl class="attr_type">\
                            <dt>种类名：<input type="text" name="type_name[]">手续费(百分比)：<input type="text" name="fee[]" value="0"> <span onclick="add_type(this)"><i class="fa fa-plus-circle"></i></span> <input type="hidden" name="type_id[]" value=""></dt>\
                        </dl>\
                    </td>\
                </tr>';
            $(obj).parents('tr').eq(0).after(attr);
        }
        //点击添加属性值输入框
        function add_attr_value(obj){
            var input = '<input type="text" name="qu_fwq[]" onchange="attr_total(this)">';
            input +='<input type="hidden" name="fwq_id[]" value="">';
            $(obj).parents('dl').find('dd').append(input);
        }

        //读取全部属性，重组属性数据
        function attr_total(obj){
            //判断当前属性值有对应的属性名称
            if(!$(obj).parents('dl').find('[name*=qu_name]').val()){
                layer.msg('请先输入大区名', {icon: 5});
                return false;
            }

        }

        function test() {
            var attrData = {}; //定义空对象保存数据
            var attrName = []; //大区名
            var attrValue = []; //服务器
            var type =[];       //游戏商品类型
            var qu_id =[];
            var fwq_id =[];
            var game_name = $('input[name*=game_name]').val();
            var cate_id = $('select[name*=cate_id]').val();
            var game_desc = $('[name*=game_desc]').val();
            var game_order= $('[name*=game_order]').val();
            $('.attr').each(function(i) {

                attrName[i] = $(this).find('[name*=qu_name]').val();
                qu_id[i] = $(this).find('[name*=qu_id]').val();
                attrValue[i] = [];
                fwq_id[i] = [];
                //遍历读取所有属性值
                $(this).find('[name*=qu_fwq]').each(function(j) {
                    attrValue[i][j] = $(this).val();
                });
                $(this).find('[name*=fwq_id]').each(function(j) {
                    fwq_id[i][j] = $(this).val();
                });

            });

            $('.attr_type').each(function (i) {
                type[i] = $(this).find('[name*=type_name]').val();
            })

            attrData['name'] = attrName;
            attrData['name_id'] = qu_id;
            attrData['value'] = attrValue;
            attrData['value_id'] = fwq_id;


            var data = $.toJSON(attrData);      //将数组转换成json格式
            $('[name*=data]').val(data);
     //alert(data)
            $('#my_form').submit();

        }
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