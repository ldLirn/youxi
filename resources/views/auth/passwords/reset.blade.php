@extends('layouts.register')
@section('content')

    <div class="wszl_ner">
        <div class="wszl_title">
            <span class="bt">重置登录密码</span>
        </div>
        <div class="wszl_con">
            <div class="comp_left">
                    <div class="sd_email" name="regbox" style="display: block">
                        <form id="reset_form" action="{{url('password/ResetPassword')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="sd_text"><span>新密码：</span><i><input type="password" class="text" name="password" datatype="s6-18"></i></div>
                            <div class="sd_text"><span>确认密码：</span><i><input type="password" class="text" name="password_confirmation" datatype="*" recheck="password"></i></div>
                            <div class="sd_btn"><a href="javascript:void(0)" id="BtnSubmit">确定</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
    <script>
        $("#reset_form").Validform({
            tiptype:3,
            btnSubmit:'#BtnSubmit',
            postonce:true,
            ajaxPost:true,
            callback:function(data) {
                if(data.status=="y"){
                    $.Hidemsg();
                    setTimeout(function(){
                        layer.msg(data.info,{icon:6})
                        window.location.href="{{url('/login')}}"
                    },1000);
                }else{
                    $.Hidemsg();
                    layer.msg(data.info,{icon:5})
                }
            }
        });
    </script>
@endsection
