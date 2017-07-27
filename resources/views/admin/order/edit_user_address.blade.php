@extends('layouts.admin')
@section('content')
    <style>
        table.add_tab tr th{font-weight: bold;width: 20%;}
        table.add_tab tr td{width: 30%;}
    </style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/order')}}">订单管理</a> &raquo; 修改买家收货信息
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改买家收货信息</h3>
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
        <form  action="{{url('admin/order/edit_user_info')}}" method="post">
            <table class="add_tab">
                <tbody>


                <tr>
                    <th >联系电话:</th>
                    <td>
                        <input type="text" name="telphone" value="{{$order_address['telphone']}}">
                    </td>
                    <th >QQ:</th>
                    <td>
                        <input type="text" name="qq" value="{{$order_address['qq']}}">
                    </td>
                </tr>
                <tr>
                    <th >角色名称:</th>
                    <td>
                        <input type="text" name="role_name" value="{{$order_address['role_name']}}">
                    </td>
                    <th >区服:</th>


                    <td id="add">
                        <select name="da_qu_id" onchange="selGameQu_x(value)" id="game_cate_id">
                            @foreach($quData as $v)
                                <option value="{{$v->id}}" @if($order_address['da_qu_id']==$v->id)selected="selected"@endif>{{$v->qu_name}}</option>
                            @endforeach
                        </select>
                        <select name="xia_qu_id" id="xia_qu_id">
                            @foreach($xquData as $v)
                                <option value="{{$v->id}}" @if($order_address['xia_qu_id']==$v->id)selected="selected"@endif>{{$v->qu_name}}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>
                  <input type="hidden" name="order_id" value="{{$order_address['order_id']}}">
                <input type="hidden" name="id" value="{{$order_address['id']}}">
                   {!! csrf_field() !!}
                <tr>
                    <td style="text-align: center;" colspan="4">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
<script>
    function selGameQu_x(obj) {
        var da_qu_id =obj;
        $next_b ='';
        $('select[name=xia_qu_id]').remove();
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{qu_id:da_qu_id,'_token':"{{csrf_token()}}"},function (data) {
            $next_b += ' <select name="xia_qu_id">';
            $(data).each(function(k,v){
               $next_b += '<option value="' + v.id + '">' + v.qu_name + '</option>';
            })
            $next_b += '</select>';
            $('#add').append($next_b);   //添加到id=add 的最后
        },'json')
    }
</script>
@endsection