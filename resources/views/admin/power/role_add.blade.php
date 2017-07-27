@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/role')}}">角色管理</a> &raquo; 添加角色
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>新增角色</h3>
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
        <form action="{{url('admin/role')}}" method="post">
            <table class="add_tab">
                <tbody>


                    <tr>
                        <th><i class="require">*</i>角色名称：</th>
                        <td>
                            <input type="text" name="name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>角色名称必须是字母组成</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>中文名：</th>
                        <td>
                            <input type="text" class="lg" name="description">
                        </td>
                    </tr>

                    <tr>
                        <th>级别：</th>
                        <td>
                            <select name="level">
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <span><i class="fa fa-exclamation-circle yellow"></i>级别越高拥有的权限越大</span>
                        </td>
                    </tr>

                    @foreach($power as $k=>$v)
                    <tr align="left">
                        <th align="left"> <input type="checkbox" id="checkAll{{$k}}">全选</th>
                        <td align="left">
                            <div style="width: 200px;float: left">
                                <input type="checkbox"  name="permission[]" value="{{$v->id}}" class="item{{$k}}" id="itemMain{{$k}}">{{$v->description}}
                            </div>

                            @foreach($v->child as $m)
                                <div style="width: 200px;float: left">
                                    <input type="checkbox"  name="permission1[]" value="{{$m->id}}" class="item{{$k}}" id="item{{$m->id}}">{{$m->description}}
                                </div>
                                <script>
                                    $('#item{{$m->id}}').click(function () {
                                        if($(this).prop('checked')){
                                            $('#itemMain{{$k}}').prop('checked','checked')
                                        }else{
                                            $('#itemMain{{$k}}').prop('checked','')
                                        }
                                    })
                                </script>
                                @endforeach
                        </td>
                    </tr>
                    <script>
                        $('#checkAll{{$k}}').click(function () {
                            if($(this).prop('checked')){
                                $('.item{{$k}}').prop('checked','checked')
                            }else{
                                $('.item{{$k}}').prop('checked','')
                            }
                        })
                    </script>
                    @endforeach
                    <tr>
                        <th></th>
                        <td>
                            <p style="color:red"><i class="fa fa-exclamation-circle red"></i>当勾选列表后面的权限时，请务必勾选列表权限</p>
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