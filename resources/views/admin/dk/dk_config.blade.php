@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">点卡设置</a>
    </div>
    <!--面包屑导航 结束-->



    @if(session('msg'))
        <div class="result_wrap">
        <div class="result_title">
            <div class="mark">
                <p>{{session('msg')}}</p>
            </div>
        </div>
        </div>
    @endif

        <div class="result_wrap">
            <form action="{{url('admin/dk_config')}}" method="post">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="20%">名称</th>
                        <th class="tc" width="60%">内容</th>
                    </tr>

                    <tr>
                        <td class="tc">用户名</td>
                        <td><input type="text" name="userid" class="lg" value="{{config('dk_config.userid')}}"></td>
                    </tr>
                    <tr>
                        <td class="tc">密码:</td>
                        <td><input type="text" name="userpws" class="lg" value="{{config('dk_config.userpws')}}"></td>
                    </tr>
                    <tr>
                        <td class="tc">加密字段:</td>
                        <td><input type="text" name="keystr" class="lg" value="{{config('dk_config.keystr')}}"></td>
                    </tr>

                        {!! csrf_field() !!}
                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                </div>
            </div>
            </form>
        </div>
    <!--搜索结果页面 列表 结束-->

<script>
    //改变排序AJAX
    function changeOrder(id,code) {
        var val = $(code).val();
        $.post("{{url('admin/config/changeOrder')}}",{id:id,config_order:val,_token:'{{csrf_token()}}'},function (msg) {
            if(msg.status==0){
                layer.alert(msg.info, {icon: 6});
            }else if(msg.status==1){
                layer.alert(msg.info, {icon: 5});
            }
        })
    }

    //删除
    function delConfig(id) {
        layer.confirm('您确定要删除这个配置项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url: "{{url('admin/config/')}}/"+id,
                data:{'_method':'delete','_token':"{{csrf_token()}}"},
                type: "POST",
                dataType:'json',
                success:function (data) {
                    if(data.status==0){
                        layer.msg(data.info, {icon: 6});
                        location.reload();
                    }else if(data.status==1){
                        layer.msg(data.info, {icon: 5});
                    }
                },
                error:function(er){
                    if(er.status==403){
                        layer.msg('您没有此权限', {icon: 5});
                    }
                }
            });
        });
    }

</script>
@endsection