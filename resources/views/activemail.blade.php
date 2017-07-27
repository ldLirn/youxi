<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
<a href="{{url('auth/activation?t='.csrf_token().'&jh=1&m='.$email.'&code='.$activationcode) }}" target="_blank">点击激活你的账号</a>
</body>
</html>