@extends('layouts.user')
@section('content')
    <script type="text/javascript" src="{{asset(HOME_JS.'city.js')}}"></script>
<div class="content">
	<div class="center_title">我的位置：{!! Breadcrumbs::render('bindBank_add') !!}</div>
    <div class="center_box">
        @include('layouts.user_left_menu')
        <div class="center_right">
        	<div class="qq_up_top">
            	<div class="fssc"></div>
                <div class="fw_c"><span>提交银行卡绑定信息</span><p>获取验证码信息，验证进入银行卡绑定</p></div>
            </div>
            <div class="record">
                <span><a href="{{url('/user/bindBank')}}">银行卡管理</a></span>
                <span class="current"><a href="{{url('/user/bindBank/add')}}">新增银行卡</a> </span>
            </div>
            <div class="Bank">
            	<div class="Bank_box">
                    <form name="form1" method="post" id="MemberFrm">
                	<div class="Bank_text"><span>开户名：</span><i><input type="text" class="text" value="{{$user['rel_name']}}" name="name" datatype="*" readonly></i><a href="#">修改开户名</a></div>
                    <div class="Bank_text"><span>开户行：</span><i>
                            <select name="bank_name" datatype="*">
                                <option value="">请选择开户行</option>
                                <option value="中国工商银行">中国工商银行</option>
                                <option value="招商银行">招商银行</option>
                                <option value="中国农业银行">中国农业银行</option>
                                <option value="中国建设银行 ">中国建设银行 </option>
                                <option value="中国银行">中国银行</option>
                                <option value="交通银行">交通银行</option>
                                <option value="中国邮政储蓄银行">中国邮政储蓄银行</option>
                                <option value="兴业银行">兴业银行</option>
                                <option value="中国光大银行">中国光大银行</option>
                                <option value="中信银行 ">中信银行</option>
                                <option value="兴业银行">兴业银行</option>
                                <option value="上海浦东发展银行">上海浦东发展银行</option>
                            </select></i><a>必填</a></div>
                    <div class="Bank_text"><span>开户账号：</span><i><input type="text" class="textt" datatype="n16-20" errormsg="银行卡位数16到20位" name="bankNo"></i><em></em></div>
                    <div class="Bank_text"><span>确认账号：</span><i><input type="text" class="textt" datatype="*" recheck="bankNo"></i><em> </em></div>
                    <div class="Bank_text"><span>开户省份：</span>
                        <i><select name="selectp" onChange="selectcityarea('selectp','selectc','form1');" datatype="*">
                                <option value=""  selected>--请选择省份--</option>
                            </select></i>
                        <a>必填</a>
                    </div>
                    <div class="Bank_text"><span>开户城市：</span><i>
                            <select name="selectc" datatype="*">
                                <option value=""  selected>--请选择城市--</option>
                            </select>
                        {{csrf_field()}}
                        </i></div>
                    <div class="account_btn"><a href="javascript:void(0)" id="account_btn">完成，提交</a><a href="#">返回列表页面</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script language="javascript">
        first("selectp","selectc","form1",0,0);
        $("#MemberFrm").Validform({
            btnSubmit:"#account_btn",
            tiptype:3,
        });
    </script>

@endsection
