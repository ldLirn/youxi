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
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/link')}}">异常申请管理</a> &raquo; 审核异常申请
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>审核异常申请</h3>
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
                            {{$data->email}}
                        </td>
                    </tr>
                    <tr>
                        <th>当前绑定的手机号：</th>
                        <td>
                            {{$data->BindPhone}}
                        </td>
                    </tr>
                    <tr>
                        <th>身份证号：</th>
                        <td>
                            {{$data->IdCard}}
                        </td>
                    </tr>
                    <tr>
                        <th>银行卡号：</th>
                        <td>
                            {{$data->bankNo}}
                        </td>
                    </tr>
                    <tr>
                        <th>银行卡开户名：</th>
                        <td>
                            {{$data->bankName}}
                        </td>
                    </tr>
                    <tr>
                        <th>异常具体描述：</th>
                        <td>
                            {{$data->content}}
                        </td>
                    </tr>
                    <tr>
                        <th>联系电话：</th>
                        <td>
                            {{$data->phone}}
                        </td>
                    </tr>
                    <tr>
                        <th>联系QQ：</th>
                        <td>
                            {{$data->qq}}
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
                    @if($data->result==2 || $data->result==1)
                        <tr>
                            <th>已经审核：</th>
                            <td>
                               <span style="color:red">@if($data->result==2)审核不通过@elseif($data->result==1)审核通过@endif</span>
                            </td>
                        </tr>
                        @if($data->result==2)
                        <tr  id="re_content">
                            <th><i class="require">*</i>不通过原因：</th>
                            <td>
                                <textarea name="re_content"></textarea>
                            </td>
                        </tr>
                        @endif
                    @else
                    <tr>
                        <th><i class="require">*</i>审核结果：</th>
                        <td>
                            <select name="result" id="result">
                                <option value="">请选择审核结果</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核不通过</option>
                            </select>
                        </td>
                    </tr>
                    <tr style="display: none" id="re_content">
                        <th><i class="require">*</i>不通过原因：</th>
                        <td>
                           <textarea name="re_content"></textarea>
                        </td>
                    </tr>
                    @endif
                    {!! csrf_field() !!}
                    <tr>
                        <th></th>
                        <td>
                            @if($data->result==0)<input type="submit" value="提交">@endif
                            <input type="button" class="back" onclick='window.location.href="{{url('admin/application')}}"' value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<script>
    $('#result').change(function(){
        if($(this).val()=='2'){
            $('#re_content').show();
        }else{
            $('#re_content').hide();
        }
    })
</script>

@endsection