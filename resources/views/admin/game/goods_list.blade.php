@extends('layouts.admin')
@section('content')
    <style>
        table.list_tab tr th{text-align: center}
        table.list_tab tr td{text-align: center;}
    </style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">游戏商品列表</a>
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        @if(isset($_GET['type']))
            <form action="{{url('admin/goodsgame/search?type='.$_GET['type'])}}" method="post">
        @else
            <form action="{{url('admin/goodsgame/search?type=0')}}" method="post">
        @endif

            <table class="search_tab">
                <tr>
                    <th width="120">搜索类型:</th>
                    <td>
                        <select  name="type_id">
                            <option value="0">商品编号</option>
                            <option value="1">商品名称</option>
                        </select>
                    </td>
                    {!! csrf_field() !!}
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/goodsgame/create?js=1')}}"><i class="fa fa-plus"></i>添加寄售商品</a>
                    <a href="{{url('admin/goodsgame/create?db=1')}}"><i class="fa fa-plus"></i>添加担保商品</a>
                    <a href="{{url('admin/goodsgame/create?qg=1')}}"><i class="fa fa-plus"></i>添加求购商品</a>
                    <a href="javascript:clearStock()"><i class="fa fa-trash-o"></i>自动清理0库存商品</a>
                    <a href="javascript:clearExpired()"><i class="fa fa-trash"></i>自动清理到期商品</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        @if(session('msg'))
            <div class="result_wrap">
                <div class="result_title">
                    <div class="mark">
                        <p>{{session('msg')}}</p>
                    </div>
                </div>
            </div>
        @endif
    <form action="{{url('admin/goodsgame/all_do')}}" method="post" id="all_do">
        <div class="result_wrap">
            <ul class="tab">
                @if(isset($_GET['type']))
                    <li @if(isset($_GET['type']) && $_GET['type']=='0')class="active"  @endif><a href="{{url('admin/goodsgame?type=0')}}">寄售交易</a></li>
                    <li @if(isset($_GET['type']) && $_GET['type']=='1')class="active"  @endif><a href="{{url('admin/goodsgame?type=1')}}">担保交易</a></li>
                    <li @if(isset($_GET['type']) && $_GET['type']=='2')class="active" @endif><a href="{{url('admin/goodsgame?type=2')}}">求购交易</a></li>
                @else
                    <li class="active"><a href="{{url('admin/goodsgame?type=0')}}">寄售交易</a></li>
                    <li><a href="{{url('admin/goodsgame?type=1')}}">担保交易</a></li>
                    <li><a href="{{url('admin/goodsgame?type=2')}}">求购交易</a></li>
                @endif

            </ul>
            <div class="tab_content" id="js">
                <table class="list_tab">
                    <tbody>
                    <tr>
                        <th class="tc"><input type="checkbox" name="" id="checkAll"></th>
                        <th>编号</th>
                        <th>商品名</th>
                        <th>单价</th>
                        <th>游戏</th>
                        <th>区服</th>
                        <th>商品类型</th>
                        @if(isset($_GET['type']))
                            @if($_GET['type']=='0' || $_GET['type']=='1')
                                <th>最佳交易时间</th>
                            @endif
                        @else
                            <th>最佳交易时间</th>
                        @endif
                        <th>最后售卖时间</th>
                        <th>是否议价</th>
                        <th>发布人</th>
                        <th>@if(isset($_GET['type']))
                                @if($_GET['type']=='0' || $_GET['type']=='1')
                                    库存
                                @else
                                    求购数量
                                @endif
                            @else
                                库存
                            @endif
                        </th>
                        <th>审核状态</th>
                        <th>上架</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data['data'] as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="{{$v['id']}}" class="checkone"></td>
                            <td class="tc">{{$v['goods_code']}}</td>
                            <td class="tc">{{str_limit($v['goods_name'], $limit = 40, $end = '..')}}</td>
                            <td class="tc">{{$v['goods_price']}}</td>
                            <td class="tc">{{$v['game']['game_name']}}</td>
                            <td class="tc">{{$v['da_qu']['qu_name']}}->{{$v['xia_qu']['qu_name']}}</td>
                            <td class="tc">{{$v['has_many_type']['type']}}</td>
                            @if($v['traded_type']=='0' || $v['traded_type']=='1')
                            <td class="tc">{{$v['best_time']}}</td>
                            @endif
                            <td class="tc">{{date('Y-m-d H:i:s',$v['sale_end_time'])}}</td>
                            <td class="tc">@if($v['is_cut_price']=='0')不议价@else可以议价@endif</td>
                            <td class="tc">@if(!$v['user']['name'])官方自营@else{{$v['user']['name']}}@endif</td>
                            <td class="tc">{{$v['goods_stock']}}</td>
                            <td class="tc">@if($v['is_check']=='0')未审核@elseif($v['is_check']=='1')审核通过@elseif($v['is_check']=='2')审核不通过@endif</td>
                            <td class="tc">@if($v['is_on_sale']=='1')<i class="fa fa-check" style="color: green" onclick="change_status(0,{{$v['id']}})"></i>@else<i class="fa fa-times" style="color: red" onclick="change_status(1,{{$v['id']}})"></i>@endif</td>
                            <td class="tc">
                                <a href="{{url('admin/user/'.$v['user']['id'])}}">查看发布人</a>
                                <a href="{{url('admin/goodsgame/'.$v['id'])}}">审核</a>
                                <a href="{{url('admin/goodsgame/'.$v['id'].'/edit')}}">修改</a>
                                <a href="javascript:delConfig({{$v['id']}})">回收站</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="page_list">
                    <select name="all_do">
                        <option value="">选中项操作</option>
                        <option value="1">回收站</option>
                        <option value="2">审核通过</option>
                        {!! csrf_field() !!}

                    </select>
                        <input type="button" value="确定" style="margin-left: 20px;" onclick="if($('[name*=all_do]').val()!=''){$('#all_do').submit();}">

                </div>

                <div class="page_list">
                    @if(isset($_GET['type']))
                        @if(isset($type))
                            {{ $data_all->appends(['type' => $_GET['type'],'type_id'=>$type,'keywords'=>$keywords])->links() }}
                        @else
                            {{ $data_all->appends(['type' => $_GET['type']])->links() }}
                        @endif
                    @else
                        {{ $data_all->links() }}
                    @endif
                </div>

            </div>

        </div>
    </form>



    <!--搜索结果页面 列表 结束-->
    <script>

        //放入回收站
        function delConfig(id) {
            layer.confirm('您确定要放入回收站吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/goodsgame/')}}/"+id,
                    data:{'_method':'delete','_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else if(data.status==1){
                            layer.msg(data.info, {icon: 5});
                        }else if(data.status==2){
                            layer.msg(data.info, {icon: 5});
                        }else if(data.status==3){
                            layer.msg(data.info, {icon: 5});
                        }
                    },
                    error:function(er){
                        if(er.status==403){
                            layer.msg('您没有此权限', {icon: 5});
                        }
                    }
                });
            });
        }

        //清理库存为0商品
        function clearStock() {
            layer.confirm('您确定要进行此操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/goodsgame/trash')}}",
                    data:{'_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else{
                            layer.msg(data.info, {icon: 5});
                        }
                    },
                    error:function(er){
                        if(er.status==403){
                            layer.msg('您没有此权限', {icon: 5});
                        }
                    }
                });
            });
        }


        //清理库存为0商品
        function clearExpired() {
            layer.confirm('您确定要进行此操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/goodsgame/expired')}}",
                    data:{'_token':"{{csrf_token()}}"},
                    type: "POST",
                    dataType:'json',
                    success:function (data) {
                        if(data.status==0){
                            layer.msg(data.info, {icon: 6});
                            location.reload();
                        }else{
                            layer.msg(data.info, {icon: 5});
                        }
                    },
                    error:function(er){
                        if(er.status==403){
                            layer.msg('您没有此权限', {icon: 5});
                        }
                    }
                });
            });
        }
    </script>

    <script>
        function change_status(status,id) {
            $.post("{{url('admin/goodsgame/sale_on_off')}}",{status:status,id:id,_token:"{{csrf_token()}}"},function (msg) {
                if(msg=='1'){
                    location.reload();
                }else{
                    layer.msg("{{trans('com.system_error')}}", {icon: 5});
                }
            })
        }
    </script>
@endsection