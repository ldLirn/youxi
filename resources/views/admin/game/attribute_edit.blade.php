@extends('layouts.admin')
@section('content')

<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="{{url('admin/news')}}">游戏管理</a> &raquo; 修改游戏属性
    </div>
    <!--面包屑导航 结束-->

    <div class="result_wrap">
        <div class="result_title">
            <h3>修改游戏属性</h3>
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
        <form action="{{url('admin/attribute/'.$data->id)}}" method="post" id="my_form">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>游戏商品类型：</th>
                        <td id="add">
                            <select name="game_cate_id" onchange="selGame(this)" id="game_cate_id">
                                <option value="">==请选择游戏分类==</option>
                                @foreach($CateGameDate as $v)
                                    <option value="{{$v->id}}" @if($data->game_cate_id == $v->id)selected="selected"@endif>{{$v->cat_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <input type="hidden"  name="data" id="data" value="{{$data->data}}">
                    <tr>
                        <th width="120"><i class="require">*</i>属性</th>
                        <td> <input type="button" class="back" onclick="add_attr(this)" value="添加属性" ></td>
                    </tr>
                    @foreach($attr as $v)
                    <tr>
                        <th width="120"> <span onclick="del_this(this)" style="cursor: pointer;" title="删除"><i class="fa fa-minus-square-o"></i></span></th>
                        <td>
                            <dl class="attr">
                                <dt>属性名：<input type="text" name="attr_name[]" value="{{$v[0]}}" onchange="attr_total(this)"> <span onclick="add_attr_value(this)"><i class="fa fa-plus-circle"></i></span></dt>

                                <dd>属性值：
                                    @foreach($v[1]['son'] as $i)
                                    <input type="text" name="attr_value[]" value="{{$i}}" onchange="attr_total(this)">
                                    @endforeach
                                </dd>
                            </dl>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th></th>
                        {!! csrf_field() !!}
                        {{method_field('PUT')}}
                        <td>
                            <input type="button" value="提交" onclick="check_form()">
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
    function selGame() {
        var cate_id = $('#game_cate_id').val();
        $next ='';
        $('#game_cate_id').nextAll().remove();   //移除后面所有的

        $.post("{{url('admin/goodsgame/AjaxGame')}}",{cate_id:cate_id,'_token':"{{csrf_token()}}"},function (data) {
            $next += ' <select name="game_id" id="game_id"  onchange="showType(value);">';
            $next += '<option value="" selected="selected">请选择游戏</option>';
            $(data).each(function(k,v){
                if(v.id=={{$data->game_id}}){
                    $next += '<option value="'+v.id+'"selected="selected">'+v.game_name+'</option>';
                }else{
                    $next += '<option value="'+v.id+'">'+v.game_name+'</option>';
                }
            })
            $next += '</select>';
            $('#add').append($next);   //添加到id=add 的最后
        },'json')
    }
    selGame()
    function showType(id) {
        var game_id = id;
        $('#game_goods_type_id').remove();
        $type ='';
        $.post("{{url('admin/goodsgame/AjaxGame')}}",{show_id:game_id,'_token':"{{csrf_token()}}"},function (data) {
            $type += ' <select name="game_goods_type_id" id="game_goods_type_id">';
            $type += '<option value="" selected="selected">请选择游戏商品类型</option>';
            $(data).each(function(k,v){
                if(v.id=={{$data->game_goods_type_id}}){
                    $type += '<option value="'+v.id+'"selected="selected">'+v.type+'</option>';
                }else{
                    $type += '<option value="'+v.id+'">'+v.type+'</option>';
                }
            })
            $type += '</select>';
            $('#add').append($type);
        },'json')
    }
    showType({{$data->game_id}})

function check_form() {
    var attrValue =[];
    $('.attr').each(function(i) {
        if(!$(this).find('[name*=attr_name]').val()){
            layer.alert('属性名不能为空', {icon: 5});
            return false;
        }
        $(this).find('[name*=attr_value]').each(function(j) {
            if($(this).val()!=''){
                attrValue[j] = $(this).val();
            }
        });
       if(attrValue==''){
           layer.alert('属性值必须有一项，多余的请留空', {icon: 5});
           return false;
       }else{
           $('#my_form').submit();
       }
    });
}
    function add_attr(obj){
        var attr = '<tr>\
                    <th width="120">  <span onclick="del_this(this)" style="cursor: pointer;"><i class="fa fa-minus-square-o"></i></span></th>\
                    <td>\
                        <dl class="attr">\
                        <dt>字段名：<input type="text" name="attr_field[]">  <i class="fa fa-exclamation-circle yellow"></i>只能输入英文\
                            <dt>属性名：<input type="text" name="attr_name[]" onchange="attr_total(this)"> <span onclick="add_attr_value(this)"><i class="fa fa-plus-circle"></i></span></dt>\
                            <dd>属性值：<input type="text" name="attr_value[]" onchange="attr_total(this)"></dd>\
                        </dl>\
                    </td>\
                </tr>';
        $(obj).parents('tr').eq(0).after(attr);
    }
    //点击添加属性值输入框
    function add_attr_value(obj){
        var input = '<input type="text" name="attr_value[]" onchange="attr_total(this)"> ';
        $(obj).parents('dl').find('dd').append(input);
    }

    //读取全部属性，重组属性数据
    function attr_total(obj){

        //判断当前属性值有对应的属性名称
//        if(!$(obj).parents('dl').find('[name*=attr_name]').val()){
//            layer.msg('请先输入属性名', {icon: 5});
//            return false;
//        }
        var attrData = {}; //定义空对象保存属性数据
        var attrName = []; //规格名称
        var attrValue = []; //规格值

        $('.attr').each(function(i) {
                attrName[i] = $(this).find('[name*=attr_name]').val();
                attrValue[i] = [];
                //遍历读取所有属性值
                $(this).find('[name*=attr_value]').each(function(j) {
                    attrValue[i][j] = $(this).val();
                });
        });

        attrData['name'] = attrName;
        attrData['value'] = attrValue;

        var data = $.toJSON(attrData);      //将数组转换成json格式
        $('[name*=data]').val(data);
    }

    function del_this(obj) {
        $(obj).parents('tr').remove();
    }


</script>
@endsection