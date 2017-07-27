@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">配置管理</a> &raquo; 添加配置
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>新增配置</h3>
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
        <form action="{{url('admin/config')}}" method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>配置名称：</th>
                        <td>
                            <input type="text" name="config_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置名称必须填写</span>
                        </td>
                    </tr>
                    <tr>

                        <th><i class="require">*</i>变量名：</th>
                        <td>
                            <input type="text" name="config_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>字母和数字，以及破折号和下划线</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>类型：</th>
                        <td>
                            <label for=""><input type="radio" name="field_type" value="input" onclick="showTr()">文本类型</label>
                            <label for=""><input type="radio" name="field_type" value="radio" onclick="showTr()">单选类型</label>
                            <label for=""><input type="radio" name="field_type" value="textarea" onclick="showTr()">文本域类型</label>
                            <span><i class="fa fa-exclamation-circle yellow"></i>必选</span>
                        </td>
                    </tr>

                    <tr style="display: none" id="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" name="field_value" class="lg" value="">
                            <p><i class="fa fa-exclamation-circle yellow"></i>例如: 0|关闭,1|开启 (逗号请使用英文半角)</p>
                        </td>
                    </tr>


                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="config_tips"></textarea>
                        </td>
                    </tr>


                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="config_order" value="0">
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
        function showTr() {
            var code = $('input[name=field_type]:checked').val();
             if(code=='radio'){
                $('#field_value').show();
            }else{
                 $('#field_value').hide();
             }
        }
    </script>
@endsection