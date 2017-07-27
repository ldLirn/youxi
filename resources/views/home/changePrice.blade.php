@extends('layouts.home')
<link href="{{asset(HOME_CSS.'need.css')}}" rel="stylesheet" type="text/css">
@section('content')
@include('layouts.nav')

    <div class="all">
        <div class="place clear_both">
            <p>您现在的位置：{!! Breadcrumbs::render('change_price_form') !!}</p>
        </div>
        <div class="sale-process">
            <div class="wrap">
                <div class="icon1 icon left"></div>
                <div class="line-red left"></div>
                <div class="icon2-red icon left"></div>
                <div class="line-grey left"></div>
                <div class="icon3 icon left"></div>
            </div>
            <div class="text">
                <p class="text1" style="width: 280px">选择需要求降价商品</p>
                <p class="text2">填写求降价信息提交</p>
                <p>卖家同意,立即进行交易</p>
            </div>
        </div>
        <form id="PostFrom" action="" method="post" class="form">
            {{csrf_field()}}
            <div class="message">
                <div class="product">
                    <h3>
                        <span class="tb left"></span>
                        <span class="wz left">变价信息</span>
                    </h3>
                    <div class="form">
                        <ul>
                            <li class="t">
                                <label class="left">已选商品分类:</label>
                                <div class="formright left">
                                    {{$data['game']['game_name']}}&gt; {{$data['da_qu']['qu_name']}}&gt; {{$data['xia_qu']['qu_name']}}&gt; [{{$data['has_many_type']['type']}}]
                                    <input id="goods_id" name="goods_id" type="hidden" value="{{$data['id']}}">
                                </div>
                            </li>
                            <li>
                                <label class="left"><span class="red"></span>原始商品单价:</label>
                                <div class="formright left">
                                    {{$data['goods_price']}} 元
                                    <input id="hfOldPrice" name="old_price" type="hidden" value="{{$data['goods_price']}}">
                                </div>
                            </li>
                            <li>
                                <label class="left"><span class="red">*</span>变价后商品单价:</label>
                                <div class="formright left">
                                    <input class="input2 req money W100 NeedPrice" name="new_price" type="text" datatype="/^[1-9]{1}\d*(\.\d{1,2})?$/">  元
                                    <span id="DPMsg" style="color:Red;font-weight:800">{{trans('home.changePrice')}}</span>
                                </div>
                                <div class="ts icon1 left"></div>
                            </li>
                            <li>
                                <label class="left"><span class="red">*</span>  商品标题:</label>
                                <div class="formright left">
                                    <input class="input2 req GameName"  value="{{$data['goods_name']}}" type="text" style="width:200px;" readonly="readonly">
                                </div>
                                <div class="ts icon1 left"></div>
                            </li>
                            <script type="text/javascript">
                                $(function () {
                                    $(".NeedPrice").blur(function () {
                                        var v3 = $(".NeedPrice").val(); //商品单价
                                        var oldPrice = $("#hfOldPrice").val(); //原商品单价
                                        if (parseFloat(oldPrice) * 0.8 > parseFloat(v3)) {
                                            layer.alert("您的求降价价格过低，请重新尝试");
                                        }
                                    });

                                    $(".fabujian").blur(function () {
                                        var num = $(".fabujian").val();
                                        if (num > "{{$buy_rank['max_changePrice']}}") {
                                            layer.alert("{{trans('home.max_changePrice')}}");
                                        }
                                    });

                                });
                            </script>

                            <li>
                                <label class="left"><span class="red">*</span> 购买件数:</label>
                                <div class="formright left">
                                    <input class="fabujian input2 req int W100" name="buy_number" type="text" value="1" datatype="n">
                                    您当前最多申请价格变动商品数<b>{{$buy_rank['max_changePrice']}}</b>件。
                                </div>
                                <div class="ts icon1 left"></div>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="account clear_both">
                    <div class="form">
                        <h3>
                            <span class="tb left"></span>
                            <span class="wz left">收货信息</span>
                        </h3>
                        <ul>
                            <li>
                                <label class="left"><span class="red">*</span>收货角色名称</label>
                                <div class="formright left">
                                    <input class="input2 left req" name="role_name" type="text" datatype="*">
                                </div>
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">请输入您的收货角色名称。</div>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="account clear_both">
                    <div class="form">
                        <h3>
                            <span class="tb left"></span>
                            <span class="wz left">联系方式</span>
                        </h3>
                        <ul>
                            <li>
                                <label class="left"><span class="red">*</span>联系电话</label>
                                <div class="formright left">
                                    <input class="input2 left hide_phone" name="telphone"  type="text" value="{{$user['telphone']}}"  datatype="/^1[34578]\d{9}$/" errormsg="{{trans('com.error_phone')}}">
                                </div>
                            </li>
                            <li>
                                <label class="left"><span class="red">*</span>您的QQ号码</label>
                                <div class="formright left">
                                    <input class="input2 left hide_qq" name="qq" type="text" value="{{$user['qq']}}"  datatype="n4-13" errormsg="{{trans('com.error_qq')}}" >
                                </div>
                                <div class="ts icon1 left" data-moren="" data-right="" data-error="">请输入您的QQ号码</div>
                            </li>

                        </ul>
                    </div>
                </div>
            <div class="button clear_both">
                <a href="javascript:void(0);" id="BtnSubmit"><strong>确认，提交</strong></a>
            </div>
                </div>
        </form>

    </div>
<script src="{{asset(HOME_JS.'Validform_v5.3.2_ncr_min.js')}}"></script>
<script>
    $("#PostFrom").Validform({
        tiptype:3,
        postonce:true,
        btnSubmit:'#BtnSubmit',
        ajaxPost:true,
        callback:function(data){
            if(data.status=="y"){
                setTimeout(function(){
                    $.Hidemsg();
                    window.location.href="{{url('/user/changePrice')}}";
                },1000);
            }
        }
    });
</script>
@endsection