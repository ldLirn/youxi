@extends('layouts.user')
@section('content')

<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('check_answer') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
            <div class="password_box">
            	<div class="password_main">
                    <form action="{{$url}}" method="post" id="answer">
                        @if(session('msg'))
                            <div class="password_text"><a>{{session('msg')}}</a></div>
                        @endif
                	<div class="password_text"><span>密保问题：</span><i  style="color:#1a86dc">{{$user['question']}}</i></div>
                    <div class="password_text" id="add"><span>密保答案：</span><input type="text" name="answer"  class="text"></div>
                    <div class="password_btn"><a href="javascript:void(0)" id="password_btn">提交</a></div>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $(function () {
        $('#password_btn').bind('click',function () {
            var answer = $('[name=answer]').val();
            if($.trim(answer)==''){
                return false;
            }else{
                $.post("{{url('/user/check_answer')}}",{answer:answer,'_token':"{{csrf_token()}}"},function (msg) {
                    $('#add').find('i').remove();
                    if(msg.status=='-1'){
                        $html = "<i style='color: red'>"+msg.info+"</i>"
                        $('#add').append($html)
                    }else if(msg.status=='-2'){
                        $html = "<i style='color: red'>"+msg.info+"</i>"
                        $('#add').append($html)
                    }else if(msg.status=='1'){
                        $('#answer').submit();
                    }else if(msg.status=='-3'){
                        var html = "<i style='color: red'>"+msg.info+"</i>"
                        $('#add').append(html)
                    }
                })
            }
        })
    })
</script>

@endsection