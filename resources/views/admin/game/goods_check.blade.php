@extends('layouts.admin')
@section('content')

<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/game')}}">游戏管理</a> &raquo; 审核商品
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>审核 @if($data['traded_type']=='0')寄售@elseif($data['traded_type']=='1')担保@elseif($data['traded_type']=='2')求购@endif商品</h3>
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
    <form action="{{url('admin/goodsgame/is_check')}}" method="post">
    <div class="result_wrap">
        <ul class="tab_title">
            <li class="active">商品基本信息</li>
            <li>游戏帐号信息</li>
            <li>商品相册</li>
            <li>详细描述</li>
            <li>审核结果</li>
        </ul>
        <div class="tab_content">
            <table class="add_tab">
                <tbody>
                <tr>
                    <input name="id" value="{{$data['id']}}" type="hidden">
                    <th width="120"><i class="require">*</i>游戏：</th>
                    <td id="add">
                        <select name="game_cate_id">
                            <option value="1">{{$data['game_cate']['cat_name']}}</option>
                        </select>
                        <select>
                            <option value="1">{{$data['game']['game_name']}}</option>
                        </select>
                        <select>
                            <option value="1">{{$data['da_qu']['qu_name']}}</option>
                        </select>
                        <select>
                            <option value="1">{{$data['xia_qu']['qu_name']}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>商品类型：</th>
                    <td id="type">
                        <select>
                            <option value="1">{{$data['has_many_type']['type']}}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th width="120"><i class="require">*</i>发布用户：</th>
                    <td id="add">
                        <select name="user_id">
                                <option value="{{$data['user']['id']}}">@if(!$data['user']['name'])官方自营@else{{$data['user']['name']}}@endif</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>商品名称：</th>
                    <td>
                        <input type="text" name="goods_name" value="{{$data['goods_name']}}" readonly="readonly">
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>单价：</th>
                    <td>
                        <input type="text" name="goods_price" value="{{$data['goods_price']}}" readonly="readonly">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i> @if($data['traded_type']=='2')求购数量:@else库存：@endif</th>
                    <td>
                        <input type="text" name="goods_stock" value="{{$data['goods_stock']}}" readonly="readonly">
                    </td>
                </tr>

                @if($data['traded_type']=='0' || $data['traded_type']=='1')

                <tr>
                    <th>安保措施：</th>
                    <td>
                        <select name="security">
                            <option>{{$data['security']}}</option>
                        </select>
                    </td>
                </tr>
                    <tr>
                        <th>最佳交易时间：</th>
                        <td>
                            <select name="best_time">
                                <option >{{$data['best_time']}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>汇款方式</th>
                        <td>
                            <input type="radio" name="to_money" value="0"  @if($data['to_money']=='0')checked="checked"@endif>平台
                            <input type="radio" name="to_money" value="1"  @if($data['to_money']=='1')checked="checked"@endif>银行
                            <input type="radio" name="to_money" value="2"  @if($data['to_money']=='2')checked="checked"@endif>支付宝
                        </td>
                    </tr>

                    <tr style="display: none" id="account">
                        <th>汇款帐号</th>
                        <td>
                            <input type="text" name="account" class="lg" value="{{$data['account']}}" readonly="readonly">
                            <span><i class="fa fa-exclamation-circle yellow"></i>选择平台时不用填写</span>
                        </td>
                    </tr>
                @endif


                <tr>
                    <th><i class="require">*</i>交易截至时间</th>
                    <td>
                        <input type="text" name="sale_end_time" class="datainp" id="dateinfo" value="{{date('Y-m-d H:i:s',$data['sale_end_time'])}}"    readonly="readonly">
                    </td>
                </tr>


                @if($data['traded_type']=='1')
                <tr>
                    <th><i class="require">*</i>设置交易暗号</th>
                    <td>
                        <input type="text" name="code" value="{{$data['code']}}" readonly="readonly">
                    </td>
                </tr>
                    <tr>
                        <th><i class="require">*</i>是否支持议价</th>
                        <td>
                            <input type="radio" name="is_cut_price" value="0" @if($data['is_cut_price']=='0')checked="checked"@endif  readonly="readonly">不议价
                            <input type="radio" name="is_cut_price" value="1" @if($data['is_cut_price']=='1')checked="checked"@endif  readonly="readonly">可以议价
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>设置密码</th>
                    <td>
                        <input type="text" name="pwd" value="{{$data['pwd']}}" readonly="readonly">
                        <span><i class="fa fa-exclamation-circle yellow"></i>设置密码后有密码才能购买</span>
                    </td>
                </tr>


                </tbody>
            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab" id="add_tab" >

                @if($data['traded_type']=='0' || $data['traded_type']=='2')
                <tr>
                    <th width="120"><i class="require">*</i>游戏帐号</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_name']}}" name="game_user_name" readonly="readonly"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>帐号密码</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_pwd']}}" name="game_user_pwd" readonly="readonly"></td>
                </tr>
                @if($data['traded_type']=='0')
                <tr>
                    <th><i class="require">*</i>是否绑定身份证</th>
                    <td>
                        <input type="radio" name="is_datacard" value="0" @if($data['game_user_info']['is_datacard']=='0')checked="checked"@endif readonly="readonly">否
                        <input type="radio" name="is_datacard" value="1" @if($data['game_user_info']['is_datacard']=='1')checked="checked"@endif readonly="readonly">是
                    </td>
                </tr>
                    @endif
                <tr>
                    <th width="200"><i class="require">*</i>是否绑定密保卡</th>
                    <td>
                        <input type="radio" name="is_secretcard" value="0" onchange="showSecretcard()" @if($data['game_user_info']['is_secretcard']=='0')checked="checked"@endif readonly="readonly">否
                        <input type="radio" name="is_secretcard" value="1" onchange="showSecretcard()" @if($data['game_user_info']['is_secretcard']=='1')checked="checked"@endif readonly="readonly">是
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <input type="hidden" value="{{$data['game_user_info']['secretcard_img']}}" name="secretcard_img" id="thumb" readonly="readonly"/>
                    <td><img src="{{$data['game_user_info']['secretcard_img']}}" id="art_img" style="max-width: 300px;max-height: 100px;" readonly="readonly"> </td>
                </tr>
                    @if($data['traded_type']=='0')
                <tr>
                    <th width="200"><i class="require">*</i>是否绑定手机</th>
                    <td>
                        <input type="radio" name="is_bind_tel" value="0" onchange="showBindTel()" @if($data['game_user_info']['is_bind_tel']=='0')checked="checked"@endif readonly="readonly">否
                        <input type="radio" name="is_bind_tel" value="1" onchange="showBindTel()" @if($data['game_user_info']['is_bind_tel']=='1')checked="checked"@endif readonly="readonly">是
                    </td>
                </tr>
                <tr id="bind_tel" style="display: none">
                    <th width="200"><i class="require">*</i>绑定天数</th>
                    <td>
                        <input type="radio" name="is_man_day" value="0" @if($data['game_user_info']['is_man_day']=='0')checked="checked"@endif readonly="readonly">绑定未满15天
                        <input type="radio" name="is_man_day" value="1" @if($data['game_user_info']['is_man_day']=='1')checked="checked"@endif readonly="readonly">绑定满15天
                    </td>
                </tr>

                <tr>
                    <th width="120">密保电话</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_tel']}}" name="mb_tel" readonly="readonly"></td>
                </tr>

                <tr>
                    <th width="120">密保问题</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_question']}}" name="mb_question" readonly="readonly"></td>
                </tr>
                <tr>
                    <th width="120">密保答案</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['mb_answer']}}" name="mb_answer" readonly="readonly"></td>
                </tr>
                    @endif
                @endif


                <tr >
                    <th width="120"><i class="require">*</i>角色名称</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user']}}" name="game_user" readonly="readonly"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>@if($data['traded_type']=='2')求购人@else出售人@endif手机</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_tel']}}" name="game_user_tel" readonly="readonly"></td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>@if($data['traded_type']=='2')求购人@else出售人@endif手机QQ</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_qq']}}" name="game_user_qq" readonly="readonly"></td>
                </tr>
                <tr>
                    <th width="120">@if($data['traded_type']=='2')求购人@else出售人@endif手机座机</th>
                    <td> <input type="text"  value="{{$data['game_user_info']['game_user_phone']}}" name="game_user_phone" readonly="readonly"></td>
                </tr>

            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">

                <tr >
                    <th></th>
                     <td id="img_more">
                    @foreach($data['goods_pic'] as $v)
                    <div style="width: 100px;height:100px;float: left;margin-left: 10px;position: relative">
                        <input type="hidden" value="{{$v['picture']}}" name="picture[]" />
                        <input type="hidden" value="{{$v['id']}}" name="picture_id[]" />
                        <img src="{{$v['picture']}}"  style="max-width: 300px;max-height: 100px;">
                    </div>
                    @endforeach
                     </td>

                </tr>
            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">
                <tr>
                    <th>详细内容：</th>
                    <td>
                        <script id="editor" type="text/plain" name="goods_content" style="width:1024px;height:500px;" >{!!$data['goods_content']  !!}</script>
                    </td>
                </tr>
            </table>
        </div>

        <div class="tab_content">
            <table class="add_tab">
                <tr>
                    <th>审核结果：</th>
                    <td>
                        <select name="is_check">
                            <option value="0">没有审核</option>
                            <option value="1">审核通过</option>
                            <option value="2">审核不通过</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>原因(审核不通过时填写)：</th>
                    <td>
                        <textarea name="error_reson">{{$data['error_reson']}}</textarea>
                    </td>
                </tr>
            </table>
        </div>
        {!! csrf_field() !!}

        <div class="btn_group">
            <input type="submit" value="提交" >
            <input type="button" class="back" onclick="history.go(-1)" value="返回" >
        </div>

    </div>
</form>
    <!--TAB切换面板和外置按钮组 结束-->
    <script type="text/javascript" charset="utf-8" src="{{asset(ORG.'ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset(ORG.'ueditor/ueditor.all.min.js')}}"> </script>
<script>
    showAccount()
    showSecretcard()
    showBindTel()
    var ue = UE.getEditor('editor');
</script>

    <script>
        function goods_type(obj){
           var type_id =  obj;

            if({{$data['game_id']}} && $('#game_id').val()==undefined){
                var game_id = {{$data['game_id']}} ;
            }else{
                var game_id =  $('#game_id').val();
            }

            $.post("{{url('admin/goodsgame/AjaxGame')}}",{type_id:type_id,id:game_id,'_token':"{{csrf_token()}}"},function (data) {
                $('.addSele').remove();
                $('#add_tab').append(data)
            })
        }
        goods_type({{$data['goods_type_id']}})
    </script>
@endsection