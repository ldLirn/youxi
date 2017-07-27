@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/news')}}">游戏管理</a> &raquo; 添加游戏属性
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>添加游戏属性</h3>
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

    <div class="result_wrap">
        <form action="{{url('admin/attribute')}}" method="post">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>游戏商品类型：</th>
                        <td id="add">
                            <select name="game_cate_id" onchange="selGame(this)" id="game_cate_id">
                                <option value="">==请选择游戏分类==</option>
                                @foreach($CateGameDate as $v)
                                    <option value="{{$v->id}}">{{$v->cat_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <input type="hidden"  name="data" id="data" value="">
                    <tr>
                        <th width="120"><i class="require">*</i>属性</th>
                        <td> <input type="button" class="back" onclick="add_attr(this)" value="添加属性" ></td>
                    </tr>

                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script src="{{asset(PUBLIC_JS.'jquery.json-2.4.min.js')}}" type="text/javascript"></script>
<script>
    //ajax 获取游戏数据
    function selGame(obj) {
        var cate_id = $(obj).val();
        $next ='';
        $('#game_cate_id').nextAll().remove();   //移除后面所有的

        $.post("{{url('admin/goodsgame/AjaxGame')}}",{cate_id:cate_id,'_token':"{{csrf_token()}}"},function (data) {
            $next += ' <select name="game_id" id="game_id"  onchange="showType();">';
            $next += '<option value="" selected="selected">请选择游戏</option>';
            $(data).each(function(k,v){
                $next += '<option value="'+v.id+'">'+v.game_name+'</option>';
            })
            $next += '</select>';
            $('#add').append($next);   //添加到id=add 的最后
        },'json')
    }

    function showType() {
        var game_id = $('#game_id').val();
        $('#game_goods_type_id').remove();
        $type ='';
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{show_id:game_id,'_token':"{{csrf_token()}}"},function (data) {
            $type += ' <select name="game_goods_type_id" id="game_goods_type_id">';
            $type += '<option value="" selected="selected">请选择游戏商品类型</option>';
            $(data).each(function(k,v){
                $type += '<option value="'+v.id+'">'+v.type+'</option>';
            })
            $type += '</select>';
            $('#add').append($type);
        },'json')
    }


    function add_attr(obj){
        var attr = '<tr>\
                    <th width="120"></th>\
                    <td>\
                        <dl class="attr">\
                            <dt>字段名：<input type="text" name="attr_field[]">  <i class="fa fa-exclamation-circle yellow"></i>只能输入英文\
                            <dt>属性名：<input type="text" name="attr_name[]"> <span onclick="add_attr_value(this)"><i class="fa fa-plus-circle"></i></span></dt>\
                            <dd>属性值：<input type="text" name="attr_value[]" onchange="attr_total(this)"></dd>\
                        </dl>\
                    </td>\
                </tr>';
        $(obj).parents('tr').eq(0).after(attr);
    }
    //点击添加属性值输入框
    function add_attr_value(obj){
        var input = '<input type="text" name="attr_value[]" onchange="attr_total(this)">';
        $(obj).parents('dl').find('dd').append(input);
    }

    //读取全部属性，重组属性数据
    function attr_total(obj){
        //判断当前属性值有对应的属性名称
        if(!$(obj).parents('dl').find('[name*=attr_name]').val()){
            layer.msg('请先输入属性名', {icon: 5});
            return false;
        }
        var attrData = {}; //定义空对象保存属性数据
        var attrName = []; //规格名称
        var attrValue = []; //规格值
        var attrField =[];
        var attrKey =[];
        $('.attr').each(function(i) {
            attrName[i] = $(this).find('[name*=attr_name]').val();
            attrField[i] = $(this).find('[name*=attr_field]').val();
            attrValue[i] = [];
            attrKey[i] = [];
            //遍历读取所有属性值
            $(this).find('[name*=attr_value]').each(function(j) {
                attrValue[i][j] = $(this).val();
                attrKey[i][j] = j;
            });
        });

        attrData['name'] = attrName;
        attrData['value'] = attrValue;
        attrData['field'] = attrField;
        attrData['key'] = attrKey;
        var data = $.toJSON(attrData);      //将数组转换成json格式
        $('[name*=data]').val(data);
    }
</script>
@endsection