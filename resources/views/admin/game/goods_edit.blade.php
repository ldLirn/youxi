@extends('layouts.admin')
@section('content')

<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/game')}}">游戏管理</a> &raquo; 修改商品
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>修改 @if($data['traded_type']=='0')寄售@elseif($data['traded_type']=='1')担保@elseif($data['traded_type']=='2')求购@endif商品</h3>
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
    <form action="{{url('admin/goodsgame/'.$data['id'])}}" method="post">
    <div class="result_wrap">
        <ul class="tab_title">
            <li class="active">商品基本信息</li>
            <li>游戏帐号信息</li>
            <li>商品相册</li>
            <li>详细描述</li>
        </ul>
        <div class="tab_content">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>游戏：</th>
                    <td id="add">
                        <select name="game_cate_id" onchange="selGame(this)" id="game_cate_id">
                            <option value="">==请选择游戏分类==</option>
                            @foreach($CateGameDate as $v)
                                <option value="{{$v->id}}" @if($data['cate_id']==$v->id)selected="selected"@endif>{{$v->cat_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>商品类型：</th>
                    <td id="type">

                    </td>
                </tr>

                <tr>
                    <th width="120"><i class="require">*</i>发布用户：</th>
                    <td id="add">
                        <select name="user_id">
                            <option value="0">官方自营</option>
                            @foreach($userData as $v)
                                <option value="{{$v->id}}" @if($data['user_id']==$v->id)selected="selected"@endif>{{$v->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>商品名称：</th>
                    <td>
                        <input type="text" name="goods_name" value="{{$data['goods_name']}}">
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>单价：</th>
                    <td>
                        <input type="text" name="goods_price" value="{{$data['goods_price']}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i> @if($data['traded_type']=='2')求购数量:@else库存：@endif</th>
                    <td>
                        <input type="text" name="goods_stock" value="{{$data['goods_stock']}}">
                    </td>
                </tr>

                @if($data['traded_type']=='0' || $data['traded_type']=='1')

                <tr>
                    <th>安保措施：</th>
                    <td>
                        <select name="security">
                            <option value="">==请选择==</option>
                            <option value="卖家资金延迟到账"  @if($data['security']=='卖家资金延迟到账')selected="selected"@endif>卖家资金延迟到账</option>
                            <option value="找回包赔" @if($data['security']=='找回包赔')selected="selected"@endif>找回包赔</option>
                        </select>
                    </td>
                </tr>
                    <tr>
                        <th>最佳交易时间：</th>
                        <td>
                            <select name="best_time">
                                <option value="00:00-24:00" @if($data['best_time']=='00:00-24:00')selected="selected"@endif>00:00-24:00</option>
                                <option value="6:00-12:00" @if($data['best_time']=='6:00-12:00')selected="selected"@endif> 6:00-12:00</option>
                                <option value="12:00-18:00" @if($data['best_time']=='12:00-18:00')selected="selected"@endif>12:00-18:00</option>
                                <option value="18:00-24:00" @if($data['best_time']=='18:00-24:00')selected="selected"@endif>18:00-24:00</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>汇款方式</th>
                        <td>
                            <input type="radio" name="to_money" value="0" onchange="showAccount()" @if($data['to_money']=='0')checked="checked"@endif>平台
                            <input type="radio" name="to_money" value="1" onchange="showAccount()" @if($data['to_money']=='1')checked="checked"@endif>银行
                            <input type="radio" name="to_money" value="2" onchange="showAccount()" @if($data['to_money']=='2')checked="checked"@endif>支付宝
                        </td>
                    </tr>

                    <tr style="display: none" id="account">
                        <th>汇款帐号</th>
                        <td>
                            <input type="text" name="account" class="lg" value="{{$data['account']}}" >
                            <span><i class="fa fa-exclamation-circle yellow"></i>选择平台时不用填写</span>
                        </td>
                    </tr>
                @endif


                <tr>
                    <th><i class="require">*</i>交易截至时间</th>
                    <td>
                        <input type="text" name="sale_end_time" class="datainp" id="dateinfo" value="{{date('Y-m-d H:i:s',$data['sale_end_time'])}}"  placeholder="请点击选择"  readonly>
                    </td>
                </tr>


                @if($data['traded_type']=='1')
                <tr>
                    <th><i class="require">*</i>设置交易暗号</th>
                    <td>
                        <input type="text" name="code" name="code" value="{{$data['code']}}">
                    </td>
                </tr>
                    <tr>
                        <th><i class="require">*</i>是否支持议价</th>
                        <td>
                            <input type="radio" name="is_cut_price" value="0" @if($data['is_cut_price']=='0')checked="checked"@endif>不议价
                            <input type="radio" name="is_cut_price" value="1" @if($data['is_cut_price']=='1')checked="checked"@endif>可以议价
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>设置密码</th>
                    <td>
                        <input type="password" name="pwd" value="{{$data['pwd']}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>设置密码后有密码才能购买</span>
                    </td>
                </tr>


                </tbody>
            </table>
        </div>
            <input type="hidden"  value="{{$data['traded_type']}}" name="traded_type">

        <div class="tab_content">
            <table class="add_tab" id="add_tab" >

                @if($data['traded_type']=='0' || $data['traded_type']=='2')
                <tr>
                    <th width="120"><i class="require">*</i>游戏帐号</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_name']}}" name="game_user_name"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>帐号密码</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_pwd']}}" name="game_user_pwd"></td>
                </tr>
                @if($data['traded_type']=='0')
                <tr>
                    <th><i class="require">*</i>是否绑定身份证</th>
                    <td>
                        <input type="radio" name="is_datacard" value="0" @if($data['game_user_info']['is_datacard']=='0')checked="checked"@endif>否
                        <input type="radio" name="is_datacard" value="1" @if($data['game_user_info']['is_datacard']=='1')checked="checked"@endif>是
                    </td>
                </tr>
                    @endif
                <tr>
                    <th width="200"><i class="require">*</i>是否绑定密保卡</th>
                    <td>
                        <input type="radio" name="is_secretcard" value="0" onchange="showSecretcard()" @if($data['game_user_info']['is_secretcard']=='0')checked="checked"@endif>否
                        <input type="radio" name="is_secretcard" value="1" onchange="showSecretcard()" @if($data['game_user_info']['is_secretcard']=='1')checked="checked"@endif>是
                    </td>
                </tr>

                <tr id="link_logo" style="display: none">
                    <th>密保卡图片：</th>
                    <td><input id="file_upload" name="file_upload" type="file" multiple="true">
                        <p><i class="fa fa-exclamation-circle yellow"></i>只允许上传以gif，jpg，png结尾的图片，最大尺寸4MB</p>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <input type="hidden" value="{{$data['game_user_info']['secretcard_img']}}" name="secretcard_img" id="thumb"/>
                    <td><img src="{{$data['game_user_info']['secretcard_img']}}" id="art_img" style="max-width: 300px;max-height: 100px;"> </td>
                </tr>
                    @if($data['traded_type']=='0')
                <tr>
                    <th width="200"><i class="require">*</i>是否绑定手机</th>
                    <td>
                        <input type="radio" name="is_bind_tel" value="0" onchange="showBindTel()" @if($data['game_user_info']['is_bind_tel']=='0')checked="checked"@endif>否
                        <input type="radio" name="is_bind_tel" value="1" onchange="showBindTel()" @if($data['game_user_info']['is_bind_tel']=='1')checked="checked"@endif>是
                    </td>
                </tr>
                <tr id="bind_tel" style="display: none">
                    <th width="200"><i class="require">*</i>绑定天数</th>
                    <td>
                        <input type="radio" name="is_man_day" value="0" @if($data['game_user_info']['is_man_day']=='0')checked="checked"@endif>绑定未满15天
                        <input type="radio" name="is_man_day" value="1" @if($data['game_user_info']['is_man_day']=='1')checked="checked"@endif>绑定满15天
                    </td>
                </tr>

                <tr>
                    <th width="120">密保电话</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_tel']}}" name="mb_tel"></td>
                </tr>

                <tr>
                    <th width="120">密保问题</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_question']}}" name="mb_question"></td>
                </tr>
                <tr>
                    <th width="120">密保答案</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_answer']}}" name="mb_answer"></td>
                </tr>
                    @endif
                @endif


                <tr >
                    <th width="120"><i class="require">*</i>角色名称</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user']}}" name="game_user"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>@if($data['traded_type']=='2')求购人@else出售人@endif手机</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_tel']}}" name="game_user_tel"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>@if($data['traded_type']=='2')求购人@else出售人@endif手机QQ</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_qq']}}" name="game_user_qq"></td>
                </tr>
                <tr>
                    <th width="120">@if($data['traded_type']=='2')求购人@else出售人@endif手机座机</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_phone']}}" name="game_user_phone"></td>
                </tr>

            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">
                <tr >
                    <th>商品图片：</th>
                    <td><input id="file_upload_more" name="file_upload_more" type="file" multiple="true">
                        <p><i class="fa fa-exclamation-circle yellow"></i>只允许上传以{{IMG_TYPE}}结尾的图片，最大尺寸{{IMG_SIZE}}</p>
                    </td>
                </tr>

                <tr >
                    <th></th>
                     <td id="img_more">
                    @foreach($data['goods_pic'] as $v)
                    <div style="width: 100px;height:100px;float: left;margin-left: 10px;position: relative">
                        <span onclick="del_pic_this(this)" style="position: absolute;right: 0;top:-13px;cursor: pointer;"><i class="fa fa-minus-square-o"></i></span>
                        <input type="hidden" value="{{$v['picture']}}" name="picture[]" />
                        <input type="hidden" value="{{$v['id']}}" name="picture_id[]" />
                        <img src="{{$v['picture']}}"  style="max-width: 300px;max-height: 100px;">
                    </div>
                    @endforeach
                     </td>

                </tr>
            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">
                <tr>
                    <th>详细内容：</th>
                    <td>
                        <script id="editor" type="text/plain" name="goods_content" style="width:1024px;height:500px;">{!!$data['goods_content']  !!}</script>
                    </td>
                </tr>
            </table>
        </div>
        {!! csrf_field() !!}
        {{method_field('PUT')}}

        <div class="btn_group">
            <input type="submit" value="提交">
            <input type="button" class="back" onclick="history.go(-1)" value="返回" >
        </div>

    </div>
</form>
    <!--TAB切换面板和外置按钮组 结束-->
<script>
    //ajax 获取游戏数据
    function selGame() {
        var cate_id = $('#game_cate_id').val();
        $next ='';
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{cate_id:cate_id,'_token':"{{csrf_token()}}"},function (data) {
            $('#game_cate_id').nextAll().remove();   //移除后面所有的
            $next += ' <select name="game_id" id="game_id"  onchange="selGameQu(value),showType(value);">';
            $next += '<option value="" selected="selected">请选择游戏</option>';
            $(data).each(function(k,v){
                $(data).each(function(k,v){
                    if(v.id=={{$data['game_id']}}){
                        $next += '<option value="'+v.id+'"selected="selected">'+v.game_name+'</option>';
                    }else{
                        $next += '<option value="'+v.id+'">'+v.game_name+'</option>';
                    }
                });
            })
            $next += '</select>';
            $('#add').append($next);   //添加到id=add 的最后
        },'json')
    }
    selGame()

    //ajax 获取游戏大区数据
    function selGameQu(obj) {
        var cate_id = obj;
        $next_a ='';
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{game_id:cate_id,'_token':"{{csrf_token()}}"},function (data) {
            $('#game_id').nextAll().remove();   //移除后面所有的
            $next_a += ' <select name="qu_id" id="qu_id" onchange="selGameQu_x(value)">';
            $next_a += '<option value="" selected="selected">请选择游戏大区</option>';
            $(data).each(function(k,v){
                if(v.id=={{$data['qu_id']}}) {
                    $next_a += '<option value="' + v.id + '"selected="selected">' + v.qu_name + '</option>';
                }else{
                    $next_a += '<option value="' + v.id + '">' + v.qu_name + '</option>';
                }
            })
            $next_a += '</select>';
            $('#add').append($next_a);   //添加到id=add 的最后
        },'json')
    }

    selGameQu({{$data['game_id']}})
    //ajax 获取游戏服务器数据
    function selGameQu_x(obj) {
        var cate_id =obj;
        $next_b ='';
        $('#game_qu_id').remove();   //移除后面所有的
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{qu_id:cate_id,'_token':"{{csrf_token()}}"},function (data) {
            $next_b += ' <select name="game_qu_id" id="game_qu_id">';
            $next_b += '<option value="" selected="selected">请选择游戏区服</option>';
            $(data).each(function(k,v){
                if(v.id=={{$data['game_qu_id']}}) {
                    $next_b += '<option value="' + v.id + '"selected="selected">' + v.qu_name + '</option>';
                }else{
                    $next_b += '<option value="' + v.id + '">' + v.qu_name + '</option>';
                }
            })
            $next_b += '</select>';
            $('#add').append($next_b);   //添加到id=add 的最后
        },'json')
    }
    selGameQu_x({{$data['qu_id']}});

    function showType(obj) {
        var game_id = obj;
        $type ='';
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{show_id:game_id,'_token':"{{csrf_token()}}"},function (data) {
            $type += ' <select name="game_goods_type_id" id="game_goods_type_id" onchange="goods_type(value)">';
            $type += '<option value="" selected="selected">请选择游戏商品类型</option>';
            $(data).each(function(k,v){
                if(v.id=={{$data['goods_type_id']}}) {
                    $type += '<option value="' + v.id + '"selected="selected">' + v.type + '</option>';
                }else{
                    $type += '<option value="' + v.id + '">' + v.type + '</option>';
                }
            })
            $type += '</select>';
            $('#type').html($type);
        },'json')
    }
    showType({{$data['game_id']}})
    showAccount()
    showSecretcard()
    showBindTel()
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


            $('#file_upload_more').uploadify({
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
                         $html = '';
                         $html += '<div style="width: 100px;height:100px;float: left;margin-left: 10px;position: relative">',
                         $html +='<span onclick="del_pic_this(this)" style="position: absolute;right: 0;top:-13px;cursor: pointer;"><i class="fa fa-minus-square-o"></i></span>',
                         $html +='<input type="hidden" value="'+data+'" name="picture[]" />',
                         $html+=' <input type="hidden" value="'+data+'" name="picture_id[]" />',
                         $html +='<td><img src="'+data+'"  style="max-width: 300px;max-height: 100px;"> </td>',
                         $html += '</div>'
                    $('#img_more').append($html);
//                    $('#pictrue').attr('src',data);
//                    $('#pictrue_more').val(data);
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
        });
    </script>
    <script src="{{asset(PUBLIC_JS.'jedate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset(ORG.'uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(ORG.'uploadify/uploadify.css')}}">
    <script type="text/javascript" charset="utf-8" src="{{asset(ORG.'ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset(ORG.'ueditor/ueditor.all.min.js')}}"> </script>

    <script type="text/javascript">
        var ue = UE.getEditor('editor');

        jeDate({
            dateCell:"#dateinfo",
            format:"YYYY-MM-DD hh:mm:ss",
           // isinitVal:true,
            isTime:true, //isClear:false,
            minDate:"{{date('Y-m-d H:i:s',time())}}",
           // okfun:function(val){alert(val)}
        })
    </script>
    <script>
        function goods_type(obj){
           var type_id =  obj;

            if({{$data['game_id']}} && $('#game_id').val()==undefined){
                var game_id = {{$data['game_id']}} ;
            }else{
                var game_id =  $('#game_id').val();
            }

            $.post("{{url('admin/goodsgame/AjaxGame')}}",{type_id:type_id,id:game_id,'_token':"{{csrf_token()}}"},function (data) {
                $('.addSele').remove();
                $('#add_tab').append(data)
            })
        }
        goods_type({{$data['goods_type_id']}})
    </script>
@endsection