@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/'.$url)}}">投诉咨询管理</a> &raquo; 回复问题
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>回复问题</h3>
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
        <form  method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cate_id" readonly="true">
                                    <option value="{{$data['cate_id']}}" >{{$cate[$data['cate_id']]}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>问题标题：</th>
                        <td>
                            <input type="text" readonly="true"  name="ask_title" value="{{$data['ask_title']}}">
                        </td>
                    </tr>


                    <tr>
                        <th><i class="require">*</i>问题描述：</th>
                        <td>
                            <textarea name="ask_content" readonly="true">{{$data['ask_content']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>图片：</th>
                        <td>
                            <img src="{{$data['pic']}}" width="400">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>联系电话：</th>
                        <td>
                            <input type="text"  name="tel" value="{{$data['tel']}}" readonly="true">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>QQ：</th>
                        <td>
                            <input type="text"  name="qq" value="{{$data['qq']}}" readonly="true">
                        </td>
                    </tr>
                    {!! csrf_field() !!}
                    <tr>
                        <th><i class="require">*</i>回复：</th>
                        <td>
                            <textarea name="answer">{{$data['answer']}}</textarea>
                        </td>
                    </tr>
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

@endsection