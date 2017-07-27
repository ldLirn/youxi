@extends('layouts.admin')
@section('content')
<body>
<script src="{{asset(PUBLIC_JS.'lightbox-plus-jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'lightbox.min.css') }}"/>
<style>
    th{width: 20%}
</style>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/link')}}">异常申请管理</a> &raquo; 修改异常申请
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改异常申请</h3>
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
        <form action="{{url('admin/application/'.$data->id)}}" method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>申请类型：</th>
                        <td>
                            {{$data->type}}
                        </td>
                    </tr>
                    <tr>
                        <th>申请时间：</th>
                        <td>
                            {{date('Y-m-d H:i:s',$data->created_at)}}
                        </td>
                    </tr>
                    <tr>
                        <th>申请会员：</th>
                        <td>
                            {{$data->withUser->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>安全邮箱：</th>
                        <td>
                            <input type="email" name="email" value="{{$data->email}}">
                        </td>
                    </tr>
                    <tr>
                        <th>当前绑定的手机号：</th>
                        <td>
                            <input type="text" name="BindPhone" value="{{$data->BindPhone}}">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证号：</th>
                        <td>
                            <input type="text" name="IdCard" value="{{$data->IdCard}}">
                        </td>
                    </tr>
                    <tr>
                        <th>银行卡号：</th>
                        <td>
                            <input type="text" name="bankNo" value="{{$data->bankNo}}">
                        </td>
                    </tr>
                    <tr>
                        <th>银行卡开户名：</th>
                        <td>
                            <input type="text" name="bankName" value="{{$data->bankName}}">
                        </td>
                    </tr>
                    <tr>
                        <th>异常具体描述：</th>
                        <td>
                            <textarea name="content">{{$data->content}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>联系电话：</th>
                        <td>
                            <input type="text" name="phone" value="{{$data->phone}}">
                        </td>
                    </tr>
                    <tr>
                        <th>联系QQ：</th>
                        <td>
                            <input type="text" name="qq" value="{{$data->qq}}">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证正面（点击可查看大图）：</th>
                        <td> <a class="example-image-link" href="{{$data->CardImg}}" data-lightbox="example-2"><img src="{{$data->CardImg}}"  style="max-width: 300px;max-height: 100px;"></a> </td>
                    </tr>
                    <tr>
                        <th>身份证反面：</th>
                        <td> <a class="example-image-link" href="{{$data->CardFmImg}}" data-lightbox="example-2"><img src="{{$data->CardFmImg}}"  style="max-width: 300px;max-height: 100px;"></a> </td>
                    </tr>
                    <tr>
                        <th>银行卡照片：</th>
                        <td> <a class="example-image-link" href="{{$data->bankCard}}" data-lightbox="example-2"><img src="{{$data->bankCard}}"  style="max-width: 300px;max-height: 100px;"></a></td>
                    </tr>
                    <tr>
                        <th>充值记录截图：</th>
                        <td> <a class="example-image-link" href="{{$data->RecordImg}}" data-lightbox="example-2"><img src="{{$data->RecordImg}}"  style="max-width: 300px;max-height: 100px;"></a> </td>
                    </tr>
                    <tr>
                        <th>注册邮箱截图：</th>
                        <td> <a class="example-image-link" href="{{$data->EmailImg}}" data-lightbox="example-2"><img src="{{$data->EmailImg}}"  style="max-width: 300px;max-height: 100px;"></a></td>
                    </tr>
                    {!! csrf_field() !!}
                    {{method_field('PUT')}}
                    <tr>
                        <th></th>
                        <td>
                           <input type="submit" value="提交"
                            <input type="button" class="back" onclick='window.location.href="{{url('admin/application')}}"' value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection