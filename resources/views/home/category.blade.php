@extends('layouts.home')
@section('content')
<section>
 <div class="w_1000">
    <div class="position">您的位置：<a href="{{web_url}}"> 首页</a> ><a href="{{url('/all_game')}}">全部游戏</a> ><a href="#">@if(isset($condition['game_name'])){{$condition['game_name']}}@else 搜索商品 @endif</a> </div>
     @if(isset($condition))
    <div class="list-category">
        @if(FilterManager::has('type') !== false || FilterManager::has('qu') !== false)
        <dl>
            <dt><span class="blue">您的选择</span></dt>
            <dd class="last">
                <ul name="shop-area">
                    @if(FilterManager::has('type') !== false && !empty($_GET['type']))
                        <li class="select">{{FilterManager::has('type')}}
                            <a href="{{FilterManager::url('type', FM_SELECT_ALL)}}" type="button" class="close">×</a>
                        </li>
                    @endif
                    @if(FilterManager::has('qu') !== false && !empty($_GET['qu']))
                        <li class="select">{{FilterManager::has('qu')}}
                            <a href="{{FilterManager::url('qu', FM_SELECT_ALL, false, ['fwq'])}}" type="button" class="close">×</a>
                        </li>
                    @endif
                    @if(FilterManager::has('fwq') !== false && !empty($_GET['fwq']))
                        <li class="select">{{FilterManager::has('fwq')}}
                            <a href="{{FilterManager::url('fwq', FM_SELECT_ALL)}}" type="button" class="close">×</a>
                        </li>
                    @endif

                    @foreach($type_s_title as $v)
                            @if(FilterManager::has($v) !== false && !empty($_GET[$v]))
                                <li class="select">{{FilterManager::has($v)}}
                                    <a href="{{FilterManager::url($v, FM_SELECT_ALL)}}" type="button" class="close">×</a>
                                </li>
                            @endif
                    @endforeach

                </ul>
            </dd>
        </dl>
        @endif
        <dl>
            <dt><span>商品选择类型</span></dt>
            <dd>
                <ul name="shop-cate">
                    <li class="{{FilterManager::isActive('type', \Toplan\FilterManager\FilterManager::ALL, 'current', ' ')}}" ><a href="{{FilterManager::url('type',\Toplan\FilterManager\FilterManager::ALL)}}">全部</a> </li>
                   @if(isset($condition['has_many_type']))
                    @foreach($condition['has_many_type'] as $k=>$v)
                    <li @if(FilterManager::isActive('type',$v['type'])) class="current"  @endif><a href="{{FilterManager::url('type', $v['type'],false,$type_s_title)}}">{{$v['type']}}</a></li>
                    @endforeach
                    @endif
                    <li class="red"><a name="list-more" href="javascript:void(0)">查看更多></a></li>
                </ul>
            </dd>
        </dl>
            @if(isset($condition['has_many_s_type']) && $type_id && isset($_GET['type']))
                @if(is_numeric(stripos($_GET['type'],"帐号")) || is_numeric(stripos($_GET['type'],"装备")))
                @foreach($condition['has_many_s_type'] as $k=>$v)
                    @if($v['game_goods_type_id']==$type_id)
                    @foreach($v['data'] as $n=>$m)
            <dl>
                <dt><span class="blue">{{$m[0]}}</span></dt>
                <dd class="last">
                    <ul name="shop-area_{{$n}}">
                            @foreach($m[1]['son'] as $l=>$p)
                                <li @if(FilterManager::isActive($m[0],$p)) class="current"  @endif><a href="{{FilterManager::url($m[0], $p)}}">{{$p}}</a></li>
                            @endforeach
                        <li class="red"><a name="area-more_{{$l}}" href="javascript:void(0)">查看更多></a></li>
                    </ul>
                </dd>
            </dl>
                        @endforeach
                    @else
                    @endif
                @endforeach
            @endif
            @endif
        <dl>
            <dt><span class="blue">游戏区选择</span></dt>
            <dd class="last">
                <ul name="shop-area">
                    @if(isset($condition['has_many_qu']))
                    @foreach($condition['has_many_qu'] as $k=>$v)
                        @if($v['pid']=='0')
                    <li @if(FilterManager::isActive('qu',$v['qu_name'])) class="current"  @endif><a href="{{FilterManager::url('qu', $v['qu_name'])}}">{{$v['qu_name']}}</a> </li>
                        @endif
                    @endforeach
                    @endif
                    <li class="red"><a name="area-more" href="javascript:void(0)">查看更多></a></li>
                </ul>
            </dd>
        </dl>
        @if(FilterManager::has('qu'))
            <dl>
                <dt><span class="blue">服务器选择</span></dt>
                <dd class="last">
                    <ul name="shop-area">
                        @if(isset($condition['has_many_qu']))
                        @foreach($condition['has_many_qu'] as $k=>$v)
                            @if($v['pid']==$da_qu_id)
                                <li @if(FilterManager::isActive('fwq',$v['qu_name'])) class="current"  @endif><a href="{{FilterManager::url('fwq', $v['qu_name'])}}">{{$v['qu_name']}}</a> </li>
                            @endif
                        @endforeach
                        @endif
                        <li class="red"><a name="area-more" href="javascript:void(0)">查看更多></a></li>
                    </ul>
                </dd>
            </dl>
        @endif
    </div>
     @endif
    <div class="list-wrapper">
        <ul class="list-tab clearfix">
            <li class="{{FilterManager::isActive('traded_type', \Toplan\FilterManager\FilterManager::ALL, 'current', ' ')}}"><a href="{{FilterManager::url('traded_type',\Toplan\FilterManager\FilterManager::ALL)}}">出售信息</a></li>
            <li @if(FilterManager::isActive('traded_type','s')) class="current"  @endif><a href="{{FilterManager::url('traded_type', 's')}}"> 寄售信息</a></li>
            <li @if(FilterManager::isActive('traded_type','d')) class="current"  @endif><a href="{{FilterManager::url('traded_type', 'd')}}">担保信息</a></li>
            <li @if(FilterManager::isActive('traded_type','q')) class="current"  @endif><a href="{{FilterManager::url('traded_type', 'q')}}">求购信息</a></li>
            <li @if(FilterManager::isActive('traded_type','2')) class="current"  @endif>账号信息</li>
            <li @if(FilterManager::isActive('traded_type','')) class="current"  @endif>点卡交易</li>
        </ul>
        <div class="list-main">
            <div class="hide" style=" display: block;">
                <div class="order-by">排序：
                    <select name="order_by" style="width: auto">
                        <option value="zh" @if(isset($_GET['order_by']) && $_GET['order_by']=='zh') selected="selected"  @endif>综合排序</option>
                        <option value="time" @if(isset($_GET['order_by']) && $_GET['order_by']=='time') selected="selected"  @endif>按发布时间排序</option>
                        <option value="pd" @if(isset($_GET['order_by']) && $_GET['order_by']=='pd') selected="selected"  @endif>按价格 从高到低</option>
                        <option value="pa" @if(isset($_GET['order_by']) && $_GET['order_by']=='pa') selected="selected"  @endif>按价格 从低到高</option>
                    </select>
                </div>
                <div class="tb">
                    <table>
                        <tr>
                            <th width="400">信息标题/物品类型/游戏/区/服</th>
                            <th>
                                <div class="jiage @if(isset($_GET['order_by']) && ($_GET['order_by']=='pa' || $_GET['order_by']=='pd')) current @else current_no  @endif " style="cursor: pointer;">
                                    <div class="@if(isset($_GET['order_by']) && $_GET['order_by']=='pa') up @elseif(isset($_GET['order_by']) && $_GET['order_by']=='pd') down  @endif"  id="price_sort">
                                        <div class="left text"><a>@if(isset($_GET['order_by']) && $_GET['order_by']=='pa') 价格 从低到高 @elseif(isset($_GET['order_by']) && $_GET['order_by']=='pd') 价格 从高到低 @else 价格排序  @endif</a></div>
                                        <div class="right line"></div>
                                    </div>
                                </div>
                            </th>

                            <th>库存</th>
                            <th>平均交易时间</th>
                            <th>服务保障类型</th>
                        </tr>
                        @foreach($goods as $v)

                        <tr>
                            <td>
                                <div class="box">
                                    <div class="title"><a href="{{url('/goods/'.Hashids::encode($v['id']))}}">【{{$v['has_many_type']['type']}}】{{$v['goods_name']}}【{{$v['security']}}】【邮寄交易，快速发货】</a> </div>
                                    <p>商品种类：{{$v['has_many_type']['type']}}</p>
                                    <P>游戏/区/服： {{$condition['game_name']}} / {{$v['da_qu']['qu_name']}} / {{$v['xia_qu']['qu_name']}}</P>
                                </div>
                            </td>
                            <td class="red">{{$v['goods_price']}}元</td>
                            <td>{{$v['goods_stock']}}</td>
                            <td></td>
                            <td>{{$v['security']}}</td>
                        </tr>

                        @endforeach

                    </table>
                </div>
                <div class="page">
                    @if(isset($page_path))
                    {{$paginator->appends($page_path)->links()}}
                    @else
                     {{$paginator->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
 </div>
</section>
<div style="height: 20px;"></div>
<script>

        $('[name=order_by]').change(function(){
            var value = $(this).val();
            if(GetQueryString('order_by')){
                replaceParamVal('order_by',value)
            }else{
                var url = window.location.href;
                if(url.indexOf('?')>-1){
                    window.location.href += '&order_by='+value;
                }else{
                    window.location.href += '?order_by='+value;
                }
            }
        });


        $('#price_sort').unbind('click').bind('click',function(){

            if($(this).hasClass('up')){
                var value= 'pd';
            }else{
                var value= 'pa';
            }

            if(GetQueryString('order_by')){
                replaceParamVal('order_by',value)
            }else{
                var url = window.location.href;
                if(url.indexOf('?')>-1){
                    window.location.href += '&order_by='+value;
                }else{
                    window.location.href += '?order_by='+value;
                }
            }
        });

        function replaceParamVal(paramName,replaceWith) {
            var oUrl = this.location.href.toString();
            var re=eval('/('+ paramName+'=)([^&]*)/gi');
            var nUrl = oUrl.replace(re,paramName+'='+replaceWith);
            this.location = nUrl;
        }
        function GetQueryString(name){
            var reg=eval("/"+name+"/g");
            var r = window.location.search.substr(1);
            var flag=reg.test(r);
            if(flag){
                return true;
            }else{
                return false;
            }
        }

</script>
@endsection