@extends('layouts.admin')
@section('content')
<script src="{{asset(ADMIN_JS.'echarts.js')}}"></script>

<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 订单统计
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
                    <th width="80">年走势:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" class="workinput wicon mr25" id="inpstart" name="start_time" value="{{$start_time}}" readonly>-
                        <input type="text" class="workinput wicon mr25" id="inpend" name="end_time" value="{{$end_time}}" readonly>
                    </td>
                    <input type="hidden" name="form" value="y" />
                    <td><input type="submit"  value="查询"></td>
                     </form>
                    <form  action="" method="post" id="down">
                        {{method_field('PUT')}}
                        {!! csrf_field() !!}
                        <input type="hidden" name="start_time" value="{{$start_time}}">
                        <input type="hidden" name="end_time" value="{{$end_time}}">
                        <input type="hidden" name="act" value="y">
                        <th> <td><a href="javascript:onclick($('#down').submit())"><input type="button"  value="下载年销售概况报表" style="background: #fa8a28;border: 1px solid #fa8a28"></a></td></th>
                    </form>
                </tr>
            </table>
        </form>
    </div>

    <div class="search_wrap">

            <table class="search_tab">
                <tr>
                    <form  action="" name="ym" method="post">
                    <th width="80">月走势:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" class="workinput wicon mr25" id="ym1" name="ym1" value="{{$start_time}}">
                        -
                        <input type="text" class="workinput wicon mr25" id="ym2" name="ym2" value="{{$end_time}}">
                    </td>
                    <input type="hidden" name="form" value="ym" />
                    <td><input type="submit" value="查询"></td>
                    </form>
                    <form  action="" method="post" id="down_m">
                        {{method_field('PUT')}}
                        {!! csrf_field() !!}
                        <input type="hidden" name="ym1" value="{{$start_time}}">
                        <input type="hidden" name="ym2" value="{{$end_time}}">
                        <input type="hidden" name="act" value="ym">
                        <th> <td><a href="javascript:onclick($('#down_m').submit())"><input type="button"  value="下载月销售概况报表" style="background: #fa8a28;border: 1px solid #fa8a28"></a></td></th>
                    </form>
                </tr>
            </table>
    </div>
     <div class="result_wrap">
            <ul class="tab_title">
                <li class="active">订单走势</li>
                <li>销售额走势</li>
            </ul>

            <div class="tab_content">
                <div @if(isset($type)) id="main_order_ym" @else id="main_order" @endif style="width: 800px;height:400px;margin: 60px auto"></div>
            </div>
            <div class="tab_content">
                <div  @if(isset($type)) id="main_money_ym" @else id="main_money" @endif  style="width: 800px;height:400px;margin: 60px auto"></div>
            </div>


            </div>


    <script src="{{asset(PUBLIC_JS.'jquery.jedate.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(PUBLIC_CSS.'jedate.css')}}">
    <script>
        var start = {
            format: 'YYYY',
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
            format: 'YYYY',
            minDate: '2016-7-01', //设定最小日期为当前日期
            festival:false,
            maxDate: '2099-06-16', //最大日期
            choosefun: function(elem,datas){
                start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
            }
        };
        $.jeDate('#inpstart',start);
        $.jeDate('#inpend',end);
        for(var i=1;i<=2;i++){
            $.jeDate("#ym"+i,{
                format:"YYYY-MM",
                isTime:false,
                festival: false,
            })
        }
    </script>
    <script>
        @if(!isset($type))
            var myChart = echarts.init(document.getElementById('main_order'));
            myChart.setOption({
                title: {
                    text: '订单数(单位:个)',
                    subtext: "{{$start_time}}年-----{{$end_time}}年",
                    x:'center'
                },
                color: ['#3398DB'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : {!! $category !!},
                        axisTick: {
                            alignWithLabel: true
                        }
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'订单数(单位:个)',
                        type:'bar',
                        barWidth: '60%',
                        data:{!! $num !!}
                    }
                ]
            });

            var myChart_money = echarts.init(document.getElementById('main_money'));
            myChart_money.setOption({
                title: {
                    text: '销售额(单位:元)',
                    subtext: "{{$start_time}}年-----{{$end_time}}年",
                    x:'center'
                },
                color: ['#3398DB'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : {!! $category !!},
                        axisTick: {
                            alignWithLabel: true
                        }
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'销售额(单位:元)',
                        type:'bar',
                        barWidth: '30%',
                        data:{!! $money !!}
                    }
                ]
            });
            @else
            var myChart_order_ym = echarts.init(document.getElementById('main_order_ym'));
            myChart_order_ym.setOption({
                title: {
                    text: '销售额(单位:元)',
                    subtext: "{{$start_time}}-----{{$end_time}}",
                    x:'center'
                },
                color: ['#3398DB'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {
                        type : 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : {!! $category !!},
                        axisTick: {
                            alignWithLabel: true
                        }
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'销售额(单位:元)',
                        type:'bar',
                        barWidth: '30%',
                        data:{!! $num !!}
                    }
                ]
            });


            var myChart_money_ym = echarts.init(document.getElementById('main_money_ym'));
            myChart_money_ym.setOption({
                title: {
                    text: '销售额(单位:元)',
                    subtext: "{{$start_time}}-----{{$end_time}}",
                    x:'center'
                },
                color: ['#3398DB'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        data : {!! $category !!},
                        axisTick: {
                            alignWithLabel: true
                        }
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'销售额(单位:元)',
                        type:'bar',
                        barWidth: '20%',
                        data:{!! $money !!}
                    }
                ]
            });
        @endif
    </script>
@endsection