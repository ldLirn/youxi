@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 订单统计 &raquo; 销售明细
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        @if(session('msg'))
            <div class="result_wrap">
                <div class="result_title">
                    <div class="mark">
                        <p>{{session('msg')}}</p>
                    </div>
                </div>
            </div>
        @endif
    <div class="search_wrap">

            <table class="search_tab">
                <tr>
                    <form name="ymd" action="" method="post">
                    <th width="80">开始日期:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" class="workinput wicon mr25" id="inpstart" name="start_time" value="{{date('Y-m-d',$start_time)}}" readonly>
                        结束日期：
                        <input type="text" class="workinput wicon mr25" id="inpend" name="end_time" value="{{date('Y-m-d',$end_time)}}" readonly>
                    </td>
                    <input type="hidden" name="form" value="y" />
                    <td><input type="submit"  value="查询"></td>
                     </form>
                    <form  action="" method="post" id="down">
                        {{method_field('PUT')}}
                        {!! csrf_field() !!}
                        <input type="hidden" name="start_time" value="{{date('Y-m-d',$start_time)}}">
                        <input type="hidden" name="end_time" value="{{date('Y-m-d',$end_time)}}">
                    <th> <td><a href="javascript:onclick($('#down').submit())"><input type="button"  value="下载销售明细" style="background: #fa8a28;border: 1px solid #fa8a28"></a></td></th>
                    </form>
                </tr>
            </table>

    </div>

     <div class="result_wrap">
         <div class="result_content">
             <table class="list_tab">
                 <tr>
                     <th class="tc">商品名称</th>
                     <th class="tc">订单号</th>
                     <th class="tc">数量</th>
                     <th class="tc">订单总价</th>
                     <th class="tc">售出时间</th>
                 </tr>
                 @foreach($data as $v)
                     <tr>

                         <td class="tc">{{$v->goods_name}}</td>
                         <td class="tc">{{$v->order_sn}}</td>
                         <td class="tc">{{$v->buy_number}}</td>
                         <td class="tc">{{$v->order_amount}}</td>
                         <td class="tc">{{date('Y-m-d H:i:s',$v->created_at)}}</td>
                     </tr>
                 @endforeach
             </table>

             <div class="page_list">
                 {{ $data->links() }}
             </div>
         </div>
     </div>


    <script src="{{asset(PUBLIC_JS.'jquery.jedate.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'jedate.css')}}">
    <script>
        var start = {
            format: 'YYYY-MM-DD',
            minDate: '2016-06-30', //设定最小日期为当前日期
            isinitVal:true,
            festival:false,
            ishmsVal:false,
            maxDate: '2099-06-30', //最大日期
            choosefun: function(elem,datas){
                end.minDate = datas; //开始日选好后，重置结束日的最小日期
            }
        };
        var end = {
            format: 'YYYY-MM-DD',
            minDate: '2016-7-01', //设定最小日期为当前日期
            festival:false,
            maxDate: '2099-06-16', //最大日期
            choosefun: function(elem,datas){
                start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
            }
        };
        $.jeDate('#inpstart',start);
        $.jeDate('#inpend',end);
    </script>
@endsection