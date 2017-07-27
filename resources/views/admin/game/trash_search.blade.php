@extends('layouts.admin')
@section('content')

    <body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; <a href="#">回收站</a>
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="{{url('admin/trash/search')}}" method="post">
            <table class="search_tab">
                <tr>
                    <th width="150">商品名称或编号:</th>
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
    <form action="{{url('admin/trash/all_do')}}" method="post" id="all_do">
        <div class="result_wrap">

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
                        <th>最后售卖时间</th>
                        <th>是否议价</th>
                        <th>发布人</th>
                        <th>审核状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data['data'] as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="{{$v['id']}}" class="checkone"></td>
                            <td class="tc">{{$v['goods_code']}}</td>
                            <td class="tc">{{$v['goods_name']}}</td>
                            <td class="tc">{{$v['goods_price']}}</td>
                            <td class="tc">{{$v['game']['game_name']}}</td>
                            <td class="tc">{{$v['da_qu']['qu_name']}}->{{$v['xia_qu']['qu_name']}}</td>
                            <td class="tc">{{$v['has_many_type']['type']}}</td>
                            <td class="tc">{{date('Y-m-d H:i:s',$v['sale_end_time'])}}</td>
                            <td class="tc">@if($v['is_cut_price']=='0')不议价@else可以议价@endif</td>
                            <td class="tc">@if(!$v['user']['name'])官方自营@else{{$v['user']['name']}}@endif</td>
                            <td class="tc">@if($v['is_check']=='0')未审核@elseif($v['is_check']=='1')审核通过@elseif($v['is_check']=='2')审核不通过@endif</td>
                            <td class="tc">
                                <a href="javascript:Recovery({{$v['id']}})">恢复</a>
                                <a href="javascript:delConfig({{$v['id']}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="page_list">
                    <select name="all_do">
                        <option value="">选中项操作</option>
                        <option value="1">删除</option>
                        <option value="2">恢复</option>
                        {!! csrf_field() !!}

                    </select>
                    <input type="button" value="确定" style="margin-left: 20px;" onclick="if($('[name*=all_do]').val()!=''){$('#all_do').submit();}">

                </div>

                <div class="page_list">
                    @if(isset($_GET['type']))
                        {{ $data_all->appends(['type' => $_GET['type']])->links() }}
                    @else
                        {{ $data_all->links() }}
                    @endif
                </div>

            </div>

        </div>
    </form>



    <!--搜索结果页面 列表 结束-->
    <script>

        //删除
        function delConfig(id) {
            layer.confirm('您确定要删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/trash/')}}/"+id,
                    data:{'_method':'delete','_token':"{{csrf_token()}}"},
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


        //还原
        function Recovery(id) {
            layer.confirm('您确定要还原吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url: "{{url('admin/trash')}}",
                    data:{'id':id,'_token':"{{csrf_token()}}"},
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


@endsection