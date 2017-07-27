@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/ad')}}">广告管理</a> &raquo; 添加广告位
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>添加广告位</h3>
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
        <form action="{{url('admin/ad_position')}}" method="post">
            <table class="add_tab">
                <tbody>

                    <tr>
                        <th><i class="require">*</i>广告位名称：</th>
                        <td>
                            <input type="text" name="adp_name" class="lg">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>广告位宽度：</th>
                        <td>
                            <input type="text" name="adp_width">
                            <span><i class="fa fa-exclamation-circle yellow"></i>只能是数字</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>广告位高度：</th>
                        <td>
                            <input type="text" name="adp_height">
                            <span><i class="fa fa-exclamation-circle yellow"></i>只能是数字</span>
                        </td>
                    </tr>

                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="adp_desc"></textarea>
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