@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/user')}}">会员管理</a> &raquo;发送消息
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
        <ul class="tab_title">
            <li class="active">站内消息</li>
            <li>邮件消息</li>
            <li>短信消息</li>

        </ul>
        <div class="tab_content">
            <form method="post">
            <table class="add_tab">
                <tr>
                    <th width="120">站内消息内容：</th>
                    <td>
                        <textarea name="msg_content"></textarea>
                    </td>
                </tr>
            </table>
            <div class="btn_group">
                {!! csrf_field() !!}
                <input type="hidden" name="msg_type" value="1">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick='window.location.href="{{url('admin/user')}}"' value="返回" >
            </div>
            </form>
        </div>
        <div class="tab_content">
            <form method="post">
            <table class="add_tab">
                <tr>
                    <th width="120">主题：</th>
                    <td>
                        <input type="text" name="email_title" class="lg">
                    </td>
                </tr>
            <tr>
                <th width="120">邮件内容：</th>
                <td>
                    <script id="editor" type="text/plain" name="email_content" style="width:1024px;height:500px;"></script>
                </td>
            </tr>
            </table>
            <div class="btn_group">
                {!! csrf_field() !!}
                <input type="hidden" name="msg_type" value="2">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick='window.location.href="{{url('admin/user')}}"' value="返回" >
            </div>
            </form>
        </div>
        <div class="tab_content">
            <form method="post">
            <table class="add_tab">
                <tr>
                    <th width="120">短信内容：</th>
                    <td>
                        <textarea name="tel_content"></textarea>
                    </td>
                </tr>
            </table>
            <div class="btn_group">
                {!! csrf_field() !!}
                <input type="hidden" name="msg_type" value="3">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick='window.location.href="{{url('admin/user')}}"' value="返回" >
            </div>
            </form>
        </div>
    </div>

</body>
<script type="text/javascript" charset="utf-8" src="{{asset('/public/org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('/public/org/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript">
    var ue = UE.getEditor('editor');
</script>
@endsection