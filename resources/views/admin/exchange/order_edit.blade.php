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
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/exchange_order')}}">积分商城订单</a> &raquo; 订单详情
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>订单详情</h3>
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
        <form onsubmit="return check_form()" action="{{url('admin/exchange_order/'.$data->id)}}" method="post" >
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>{{trans('shop.goods_name')}}</th>
                        <td>
                            <input type="text" class="lg"  value="{{$data['exchange']['goods_name']}}" disabled>
                        </td>
                    </tr>

                    <tr>
                        <th>商品图片</th>
                        <td><img src="{{$data['exchange']['pic']}}" id="art_img" style="max-width: 300px;max-height: 100px;display: block"> </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>单价：</th>
                        <td>
                            <input type="text"   value="{{$data['integral']}}" disabled>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>兑换数量：</th>
                        <td>
                            <input type="text"  name="num" value="{{$data['num']}}" disabled>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>订单总消费积分：</th>
                        <td>
                            <input type="text"  name="exchange_integral" value="{{$data['order_integral']}}" disabled>
                        </td>
                    </tr>

                    <tr>
                        <th>收货信息：</th>
                        <td>
                           <textarea name="user_info">{{$data['user_info']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>联系电话：</th>
                        <td>
                            <input type="text"  name="tel" value="{{$data['tel']}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>QQ：</th>
                        <td>
                            <input type="text"  name="qq" value="{{$data['qq']}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>买家用户名：</th>
                        <td>
                            <input type="text"  name="qq" value="{{$data['user']['name']}}" disabled>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>备注：</th>
                        <td>
                            <textarea name="note"></textarea>
                        </td>
                    </tr>

                    {!! csrf_field() !!}
                    {{method_field('PUT')}}
                    <tr>
                        <th>当前状态：</th>
                        <td>
                            <p class="red" style="font-size: 18px;">@if($data['order_status']==1){{NOT_OPERATE}}@elseif($data['order_status']==2){{EXCHANGE_COMPLETE}}@elseif($data['order_status']==3){{ORDER_CANCEL}}@endif</p>
                        </td>
                    </tr>
                    <tr>
                        <th>当前可执行操作：</th>
                        <td>
                            @if($data['order_status']==1)
                            <input type="submit" name="act" value="{{EXCHANGE_COMPLETE}}">
                            <input type="submit" name="act" value="{{ORDER_CANCEL}}">
                                @else
                                <p class="red" style="font-size: 18px;">@if($data['order_status']==2){{EXCHANGE_COMPLETE}}@elseif($data['order_status']==3){{ORDER_CANCEL}}@endif</p>
                            @endif
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;font-size: 16px;background-color: #eee;" colspan="4">
                            操作记录
                        </td>
                    </tr>
                    <tr>
                        <table class="list_tab">
                            <tr>
                                <th class="tc">操作人</th>
                                <th class="tc">操作时间</th>
                                <th class="tc">订单状态</th>
                                <th class="tc">备注</th>
                            </tr>

                                <tr>
                                    <td class="tc">{{$data['action_user_name']}}</td>
                                    <td class="tc">@if($data['note_time']){{date('Y-m-d H:i:s',$data['note_time'])}}@endif</td>
                                    <td class="tc">@if($data['order_status']=='1'){{NOT_OPERATE}}@elseif($data['order_status']=='2'){{EXCHANGE_COMPLETE}}@elseif($data['order_status']=='3'){{ORDER_CANCEL}}@endif</td>
                                    <td class="tc">{{$data['note']}}</td>
                                </tr>

                        </table>
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

    function check_form() {
        if($.trim($('[name=note]').val())==''){
            layer.msg('请填写操作备注', {icon: 5});
            return false;
        }
    }

</script>
@endsection