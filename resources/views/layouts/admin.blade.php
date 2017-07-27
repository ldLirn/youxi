<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{config('web.web_title')}}后台管理系统</title>
    <link rel="stylesheet" href="{{asset(ADMIN_CSS.'ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{asset(ADMIN_FONT.'font-awesome.min.css') }}">
    <script type="text/javascript" src="{{asset(ADMIN_JS.'jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset(ADMIN_JS.'ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset(ORG.'layer/layer.js')}}"></script>
</head>
<body>
@yield('content')

</body>
</html>