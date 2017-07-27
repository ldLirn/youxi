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
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <p style="margin: 10px">
                        <strong>有效订单总金额</strong>:&nbsp;&nbsp;{{$all_money}}&nbsp;&nbsp;&nbsp;
                    </p>
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
    <div class="search_wrap">
            <table class="search_tab">
                <tr>
                    <form name="ymd" action="" method="post">
                    <th width="80">开始日期:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" class="workinput wicon mr25" id="inpstart" name="start_time" value="{{$start_time}}" readonly>
                        结束日期:
                        <input type="text" class="workinput wicon mr25" id="inpend" name="end_time" value="{{$end_time}}" readonly>
                    </td>
                    <input type="hidden" name="form" value="ymd" />
                    <td><input type="submit"  value="查询"></td>
                    </form>
                    <form  action="" method="post" id="down">
                        {{method_field('PUT')}}
                        {!! csrf_field() !!}
                        <input type="hidden" name="start_time" value="{{$start_time}}">
                        <input type="hidden" name="end_time" value="{{$end_time}}">
                        <th> <td><a href="javascript:onclick($('#down').submit())"><input type="button"  value="下载订单统计报表" style="background: #fa8a28;border: 1px solid #fa8a28"></a></td></th>
                    </form>
                </tr>
            </table>
    </div>

    <div class="search_wrap">
        <form  action="" name="ym" method="post">
            <table class="search_tab">
                <tr>
                    <th width="80">月份比较:</th>
                    {!! csrf_field() !!}
                    <td><input type="text" class="workinput wicon mr25" id="ym1" name="ym1" value="@if(isset($category_time[0])){{$category_time[0]}}@endif">
                        +
                        <input type="text" class="workinput wicon mr25" id="ym2" name="ym2" value="@if(isset($category_time[1])){{$category_time[1]}}@endif">
                        +
                        <input type="text" class="workinput wicon mr25" id="ym3" name="ym3" value="@if(isset($category_time[2])){{$category_time[2]}}@endif">
                        +
                        <input type="text" class="workinput wicon mr25" id="ym4" name="ym4" value="@if(isset($category_time[3])){{$category_time[3]}}@endif">
                        +
                        <input type="text" class="workinput wicon mr25" id="ym5" name="ym5" value="@if(isset($category_time[4])){{$category_time[4]}}@endif">
                    </td>
                    <input type="hidden" name="form" value="ym" />
                    <td><input type="submit" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
     <div class="result_wrap">
            <ul class="tab_title">
                <li class="active">订单概况</li>
                <li>寄售订单</li>
                <li>担保订单</li>
            </ul>

            <div class="tab_content">
                <div @if(isset($category)) id="main1_ym" @else id="main1" @endif style="width: 800px;height:400px;margin: 60px auto"></div>
            </div>
            <div class="tab_content">
                <div  id="main_js"  style="width: 800px;height:400px;margin: 60px auto"></div>
            </div>
            <div class="tab_content">
                <div  id="main_db"  style="width: 800px;height:400px;margin: 60px auto"></div>
            </div>

            </div>
        <input type="hidden" value="{!! $data !!}" id="data">
    <!--搜索结果页面 列表 结束-->
<style>
    .result_content ul li span{
        padding: 6px 12px;
        font-size: 15px;
    }
</style>
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

        for(var i=0;i<=5;i++){
            $.jeDate("#ym"+i,{
                format:"YYYY-MM",
                isTime:false,
                festival: false,
            })
        }
    </script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var data = $('#data').val();
    if(data!=''){
        var myChart = echarts.init(document.getElementById('main1'));
        myChart.setOption({
            title: {
                text: '订单统计',
                subtext: "{{$start_time}}-----{{$end_time}}",
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:['交易完成','未操作','无效或取消','待确认收货']
            },

            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'left',
                                max: 1548
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            series : [
                {
                    name:'订单数量',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:{!! $data !!}
                }
            ]
        });


        var myChart_js = echarts.init(document.getElementById('main_js'));
        myChart_js.setOption({
            title: {
                text: '订单统计',
                subtext: "{{$start_time}}-----{{$end_time}}",
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:['交易完成','未操作','无效或取消','待确认收货']
            },

            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'left',
                                max: 1548
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            series : [
                {
                    name:'订单数量',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:{!! $data_js !!}
                }
            ]
        });

        var myChart_db = echarts.init(document.getElementById('main_db'));
        myChart_db.setOption({
            title: {
                text: '订单统计',
                subtext: "{{$start_time}}-----{{$end_time}}",
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:['交易完成','未操作','无效或取消','待确认收货']
            },

            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'left',
                                max: 1548
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            series : [
                {
                    name:'订单数量',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:{!! $data_db !!}
                }
            ]
        });
    }
</script>
<script>
    @if(isset($category))
    var myChart1_ym = echarts.init(document.getElementById('main1_ym'));
    var option = {
        tooltip : {
            show: true,
            trigger: 'item'
        },
        legend: {
            data:{!! $category !!}
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['交易完成','未操作','无效或取消','待确认收货']
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series :{!! $data !!}
    };
    myChart1_ym.setOption(option);
    @endif
</script>
@endsection