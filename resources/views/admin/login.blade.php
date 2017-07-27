<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="{{asset('/public/admin_style/css/style.css') }}" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="{{asset('/public/admin_style/js/jquery.js') }}"></script>

<script src="{{asset('/public/admin_style/js/Particleground.js') }}"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
});
</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong>搜付在线后台管理系统</strong>
    @if(session('error'))
         <em>{{session('error')}}</em>
    @endif
 </dt>
    <form action="" method="post">
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx" name="admin_name" value="{{old('admin_name')}}"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx" name="admin_pass"/>
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input type="text" id="J_codetext" placeholder="验证码" maxlength="6" class="login_txtbx" name="verify">

      <img src="{{url('admin/verify')}}" alt="验证码" onclick="this.src='{{url('admin/verify')}}?'+Math.random()" style="cursor: pointer;" class="J_codeimg">
  </div>
     {!! csrf_field() !!}
 </dd>

 <dd>
  <input type="submit" value="立即登陆" class="submit_btn"/>
 </dd>
    </form>
 <dd>
  <p>© 2015-2016 炉石 版权所有</p>

 </dd>
</dl>
</body>
</html>
