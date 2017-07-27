@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">系统设置</a> &raquo; 添加导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>新增导航</h3>
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
        <form action="{{url('admin/nav')}}" method="post">
            <table class="add_tab">
                <tbody>

                <tr>
                    <th width="120"><i class="require">*</i>选择分类:</th>
                    <td>
                        <select  name="p_id">
                            <option value="0">顶级分类</option>
                            @foreach($cate as $r)
                                <option value="{{$r->id}}">{{$r->nav_name}}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>


                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" name="nav_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名称必须填写</span>
                        </td>
                    </tr>
                    <tr>

                        <th><i class="require">*</i>链接地址：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url">
                            <p><i class="fa fa-exclamation-circle yellow"></i>字母和数字，以及破折号和下划线</p>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>是否显示：</th>
                        <td>
                            <label for=""><input type="radio" name="is_show" value="1" checked="checked">显示</label>
                            <label for=""><input type="radio" name="is_show" value="0" >隐藏</label>
                            <span><i class="fa fa-exclamation-circle yellow"></i>必选</span>
                        </td>
                    </tr>

                    <tr>
                        <th width="120">位置:</th>
                        <td>
                            <select  name="nav_wz">
                                <option value="1">顶部</option>
                                <option value="2">主导航</option>
                                <option value="3">尾部</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="0">
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

@endsection