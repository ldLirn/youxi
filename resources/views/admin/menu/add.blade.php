@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/menu')}}">菜单管理</a> &raquo; 添加菜单
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>添加菜单</h3>
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

    <div class="result_wrap">
        <form action="{{url('admin/menu')}}" method="post">
            <table class="add_tab">
                <tbody>


                <tr>
                    <th width="120"><i class="require">*</i>类型:</th>
                    <td>
                        <select  name="pid" id="pid" onchange="option_permission(this)">
                            <option value="0">顶级菜单</option>
                            @foreach($data as $r)
                                <option value="{{$r->id}}">{{$r->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr style="display: none;" id="bind_permission">
                    <th width="120"><i class="require">*</i>绑定权限:</th>
                    <td>
                        <select  name="bind_permission">
                            <option value="" id="permission">请选择权限</option>
                            @foreach($power as $r)
                                <option value="{{$r->id}}">{{$r->description}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                    <tr>
                        <th><i class="require">*</i>菜单名称：</th>
                        <td>
                            <input type="text" name="name" value="{{old('name')}}">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>地址：</th>
                        <td>
                            <input type="text" name="url" value="{{old('url')}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>当为顶级菜单时不填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th>图标样式：</th>
                        <td>
                            <input type="text" name="ico" value="{{old('ico')}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>css 代码</span>
                        </td>
                    </tr>

                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="order" value="0">
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
    function option_permission(val) {
        var code = $(val).val();
        if(code != '0'){
            $('#bind_permission').show();
        }else{
            $('#bind_permission').hide();
        }
    }
</script>
@endsection