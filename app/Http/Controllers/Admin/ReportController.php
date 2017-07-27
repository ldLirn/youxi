<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ReportController
 * @package App\Http\Controllers\Admin
 * 统计
 */
class ReportController extends CommonController
{
    /**
     * 订单统计
     */
    public function order_stats()
    {
        $order = new order();
        if(Input::method()=='POST'){
            $time = Input::except('_token');
            if($time['form']=='ymd'){
                $start_time = strtotime($time['start_time']);
                $end_time = $time['end_time']==''?time():strtotime($time['end_time']);
                $data = $this->getData(array('order_status'=>3),array('order_status'=>0),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array()),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array()),$start_time,$end_time);
                /**
                 * 寄售订单
                 */
                $data_js = $this->getData(array('order_status'=>3,'order_type'=>0),array('order_status'=>0,'order_type'=>0),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array('order_type'=>0)),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array('order_type'=>0)),$start_time,$end_time);
                /**
                 * 担保订单
                 */
                $data_db = $this->getData(array('order_status'=>3,'order_type'=>1),array('order_status'=>0,'order_type'=>1),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array('order_type'=>1)),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array('order_type'=>1)),$start_time,$end_time);

            }elseif($time['form']=='ym'){
                unset($time['form']);
                if(empty(implode('',$time))){
                    return back()->with('msg','请选择年月');
                }
                for($i=1;$i<=5;$i++){
                    if($time['ym'.$i]!='' && $this->isDateTime($time['ym'.$i])){
                        $v =  date('Y-m',strtotime($time['ym'.$i]));
                        $category[] = $v;
                        $mon[$i]['start_range'] = $this->getMonthRange($v);
                        $mon[$i]['end_range'] = $this->getMonthRange($v,false);
                        $data[$i]['name'] = $v;
                        $data[$i]['type'] = 'bar';
                        $data[$i]['data'] = [$order->getCountByVerifyAndTime(1,array('order_status'=>3),$mon[$i]['start_range'],$mon[$i]['end_range']),$order->getCountByVerifyAndTime(1,array('order_status'=>0),$mon[$i]['start_range'],$mon[$i]['end_range']),$order->getCountByVerifyAndTime(2,array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array()),$mon[$i]['start_range'],$mon[$i]['end_range']),$order->getCountByVerifyAndTime(2,array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array()),$mon[$i]['start_range'],$mon[$i]['end_range'])];  //已成交
                    }
                }
                $data = json_encode(array_values($data));
                $category_time = $category;
                $category = json_encode($category);
                $data_js ='';
                $data_db ='';
            }
        }elseif(Input::method()=='PUT'){
            $time = Input::except('_token');
            $start_time = strtotime($time['start_time']);
            $end_time = $time['end_time']==''?time():strtotime($time['end_time']);

            $data = ($this->getDataForExcel(array('order_status'=>3),array('order_status'=>0),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array()),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array()),$start_time,$end_time));
            $data_js = $this->getDataForExcel(array('order_status'=>3,'order_type'=>0),array('order_status'=>0,'order_type'=>0),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array('order_type'=>0)),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array('order_type'=>0)),$start_time,$end_time);
            $data_db = $this->getDataForExcel(array('order_status'=>3,'order_type'=>1),array('order_status'=>0,'order_type'=>1),array(0=>array('order_status'=>4),1=>array('order_status'=>5),'2'=>array('order_type'=>1)),array(0=>array('order_status'=>1),1=>array('order_status'=>2),'2'=>array('order_type'=>1)),$start_time,$end_time);
            if (empty($data)) {
                return back()->with('msg', '没有数据');
            }

            $celldata[] = $data;
            $celldata_js[] = $data_js;
            $celldata_db[] = $data_db;
            $name = "订单统计报表(" . date('Y-m-d',$start_time) . '---' . date('Y-m-d',$end_time) . ")";
            Excel::create($name, function ($excel) use ($celldata,$name,$celldata_js,$celldata_db) {
                $excel->sheet($name, function ($sheet) use ($celldata) {
                    $sheet->fromArray($celldata);
                });
                $excel->sheet('寄售订单', function ($sheet) use ($celldata_js) {
                    $sheet->fromArray($celldata_js);
                });
                $excel->sheet('担保订单', function ($sheet) use ($celldata_db) {
                    $sheet->fromArray($celldata_db);
                });
            })->export('xls');
        }
        else{
            $data = '';
            $category = '';
            $data_js ='';
            $data_db ='';
        }
        $start_time = Input::get('start_time')===null?date('Y-m-d',strtotime('-15 days')):Input::get('start_time');
        $end_time = Input::get('end_time')===null?date('Y-m-d',time()):Input::get('end_time');
        $all_money = abs(Order::whereIn('order_status',[0,1,2,3])->select('order_amount')->sum('order_amount'));
        return view('admin.report.order_stats',compact('data','start_time','end_time','all_money','category','category_time','data_js','data_db'));
    }


    /**
     * 销售概况
     */
    public function sale_general()
    {
        $order = new order();
        if(Input::method()=='POST'){
            $time = Input::except('_token');
            if($time['form']=='y'){
                $start_time = $time['start_time']==''?date('Y',$time()):$time['start_time'];
                $end_time = $time['end_time']==''?date('Y',$time()):$time['end_time'];
                if($end_time-$start_time<0){
                    return back()->with('msg','开始时间不能大于结束时间');
                }
                for($i=0;$i<=$end_time-$start_time;$i++){
                    $category[] = $start_time+$i;
                    $year = ($start_time+$i);
                    $all_time[$year]['s']=strtotime($year."-01-01 00:00:00");
                    $all_time[$year]['e']=strtotime($year."-12-31 23:59:59");
                    $num[$year] = $order->wherebetween('created_at', array($all_time[$year]['s'], $all_time[$year]['e']))->count(); //订单数量
                    $money[$year] = $order->where('order_status',3)->wherebetween('created_at', array($all_time[$year]['s'], $all_time[$year]['e']))->sum('order_amount'); //销售总额
                }
                $category = json_encode($category);
                $num = json_encode(array_values($num));
                $money = json_encode(array_values($money));
            }elseif($time['form']=='ym'){
                $time1 = strtotime($time['ym1']); // 自动为00:00:00 时分秒
                $time2 = strtotime($time['ym2']);
                $monarr = array();
                $monarr[] = $time['ym1']; // 当前月;
                while( ($time1 = strtotime('+1 month', $time1)) <= $time2){
                    $monarr[] = date('Y-m',$time1); // 取得递增月;
                }
                $category = json_encode($monarr);
                foreach($monarr as $k=>$v){
                    $all_time[$v]['s']=strtotime($v."-01 00:00:00");
                    $all_time[$v]['e']=strtotime($v."-31 23:59:59");
                    $num[$v] = $order->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->count(); //订单数量
                    $money[$v] = $order->where('order_status',3)->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->sum('order_amount')?$order->where('order_status',3)->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->sum('order_amount'):0; //销售总额
                }
                $num = json_encode(array_values($num));
                $money = json_encode(array_values($money));
                $type = 'tm';
                $start_time = $time['ym1'];
                $end_time = $time['ym2'];
            }
        }elseif(Input::method()=='PUT') {
            $time = Input::except('_token');
            if ($time['act'] == 'y') {
                $start_time = $time['start_time'] == '' ? date('Y', $time()) : $time['start_time'];
                $end_time = $time['end_time'] == '' ? date('Y', $time()) : $time['end_time'];
                if ($end_time - $start_time < 0) {
                    return back()->with('msg', '开始时间不能大于结束时间');
                }
                for ($i = 0; $i <= $end_time - $start_time; $i++) {
                    $year = ($start_time + $i);
                    $all_time[$year]['s'] = strtotime($year . "-01-01 00:00:00");
                    $all_time[$year]['e'] = strtotime($year . "-12-31 23:59:59");
                    $money[$year]['num'] = $order->wherebetween('created_at', array($all_time[$year]['s'], $all_time[$year]['e']))->count(); //订单数量
                    $money[$year]['money'] = $order->where('order_status', 3)->wherebetween('created_at', array($all_time[$year]['s'], $all_time[$year]['e']))->sum('order_amount'); //销售总额
                }
                if (empty($money)) {
                    return back()->with('msg', '没有数据');
                }
                foreach ($money as $k => $v) {
                    $celldata[] = array(
                        '时间段' => $k,
                        '订单数(单位:个)' => $v['num'],
                        '销售额(单位:元)' => $v['money'],
                    );
                }
                $name = "年销售概况报表(" . $start_time . '---' . $end_time . ")";
                Excel::create($name, function ($excel) use ($celldata,$name) {
                    $excel->sheet($name, function ($sheet) use ($celldata) {
                        $sheet->fromArray($celldata);
                    });
                })->export('xls');
            } elseif ($time['act'] == 'ym') {
                $time1 = strtotime($time['ym1']); // 自动为00:00:00 时分秒
                $time2 = strtotime($time['ym2']);
                $monarr = array();
                $monarr[] = $time['ym1']; // 当前月;
                while (($time1 = strtotime('+1 month', $time1)) <= $time2) {
                    $monarr[] = date('Y-m', $time1); // 取得递增月;
                }
                foreach ($monarr as $k => $v) {
                    $all_time[$v]['s'] = strtotime($v . "-01 00:00:00");
                    $all_time[$v]['e'] = strtotime($v . "-31 23:59:59");
                    $money[$v]['num'] = $order->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->count(); //订单数量
                    $money[$v]['money'] = $order->where('order_status', 3)->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->sum('order_amount') ? $order->where('order_status', 3)->wherebetween('created_at', array($all_time[$v]['s'], $all_time[$v]['e']))->sum('order_amount') : 0; //销售总额
                }
                $start_time = $time['ym1'];
                $end_time = $time['ym2'];
                if (empty($money)) {
                    return back()->with('msg', '没有数据');
                }
                foreach ($money as $k => $v) {
                    $celldata[] = array(
                        '时间段' => $k,
                        '订单数(单位:个)' => $v['num'],
                        '销售额(单位:元)' => $v['money'],
                    );
                }
                $name = "月销售概况报表(" . $start_time . '---' . $end_time . ")";
                Excel::create($name, function ($excel) use ($celldata,$name) {
                    $excel->sheet($name, function ($sheet) use ($celldata) {
                        $sheet->fromArray($celldata);
                    });
                })->export('xls');
            }
        }else{
            $num = '';
            $category = '';
            $money ='';
            $start_time = Input::get('start_time')===null?date('Y',strtotime('-15 days')):Input::get('start_time');
            $end_time = Input::get('end_time')===null?date('Y',time()):Input::get('end_time');
        }
        return view('admin.report.sale_general',compact('num','category','start_time','end_time','money','type'));
    }


    /**
     * 销售明细
     */
    public function sale_list()
    {
        if(Input::method()=='POST'){
            $start_time = strtotime(Input::get('start_time'));
            $end_time = strtotime(Input::get('end_time').' 23:59:59');
            if($start_time>$end_time){
                return back()->with('msg','开始时间不能大于结束时间');
            }
            $data = DB::table('order')->join('goods_game','order.goods_id','=','goods_game.id')->where('order.order_status',3)->wherebetween('order.created_at', array($start_time,$end_time))->select('order.order_sn','order.order_amount','order.created_at','order.buy_number','goods_game.goods_name')->Paginate(PAGE);
        }elseif(Input::method()=='PUT'){
            $start_time = strtotime(Input::get('start_time'));
            $end_time = strtotime(Input::get('end_time').' 23:59:59');
            if($start_time>$end_time){
                return back()->with('msg','开始时间不能大于结束时间');
            }
            $data = DB::table('order')->join('goods_game','order.goods_id','=','goods_game.id')->where('order.order_status',3)->wherebetween('order.created_at', array($start_time,$end_time))->select('order.order_sn','order.order_amount','order.created_at','order.buy_number','goods_game.goods_name')->get();
            if(!isset($data[0])){
                return back()->with('msg','没有数据');
            }
            foreach($data as $k=>$v){
                $celldata[] = array(
                    '商品名称' => $v->goods_name,
                    '订单编号' => $v->order_sn,
                    '数量' => $v->buy_number,
                    '订单金额' => $v->order_amount,
                    '售出时间'   => date('Y-m-d H:i:s',$v->created_at),
                );
            }
            $name = "销售明细表(".Input::get('start_time').'---'.Input::get('end_time').")";
            Excel::create($name, function($excel) use ($celldata) {
                $excel->sheet('export', function($sheet) use ($celldata) {
                    $sheet->fromArray($celldata);
                });
            })->export('xls');
        }
        else{
            $start_time = Input::get('start_time')===null?strtotime('-15 days'):strtotime(Input::get('start_time'));
            $end_time = Input::get('end_time')===null?time():strtotime(Input::get('end_time'));
            $data = Order::where('id','0')->select('id')->Paginate(PAGE);
        }
        return view('admin.report.sale_list',compact('start_time','end_time','data'));
    }

    /**
     * @param $dateTime
     * @return bool
     * 验证是否为时间
     */
    function isDateTime($dateTime){
        $ret = strtotime($dateTime);
        return $ret !== FALSE && $ret != -1;
    }


    /**
    * 获取指定日期所在月的开始日期与结束日期
    * @param string $date
    * @param boolean 为true返回开始日期，否则返回结束日期
    * @return array
    * @access private
    */
    private function getMonthRange( $date, $returnFirstDay = true ) {
        $timestamp = strtotime( $date );
        if ( $returnFirstDay ) {
            $monthFirstDay = date( 'Y-m-1 00:00:00', $timestamp );
            return strtotime($monthFirstDay);
        } else {
            $mdays = date( 't', $timestamp );
            $monthLastDay = date( 'Y-m-' . $mdays . ' 23:59:59', $timestamp );
            return strtotime($monthLastDay);
        }
    }

    /**
     *    数据处理
     */
    private function getData($where_complete,$where_not,$where_invalid,$where_confirm,$start_time,$end_time){
        $order = new Order();
        $COMPLETE = $order->getCountByVerifyAndTime(1,$where_complete,$start_time,$end_time);  //已成交
        $NOT_OPERATE=$order->getCountByVerifyAndTime(1,$where_not,$start_time,$end_time);  //未操作
        $INVALID=$order->getCountByVerifyAndTime(2,$where_invalid,$start_time,$end_time); //无效或取消
        $CONFIRM=$order->getCountByVerifyAndTime(2,$where_confirm,$start_time,$end_time); //待确认收获
        $data[] = array('name'=>COMPLETE,'value'=>$COMPLETE);
        $data[] = array('name'=>NOT_OPERATE,'value'=>$NOT_OPERATE);
        $data[] = array('name'=>INVALID.'或取消','value'=>$INVALID);
        $data[] = array('name'=>CONFIRM,'value'=>$CONFIRM);
        $data = json_encode($data);
        return $data;
    }

    /**
     *    数据处理
     */
    private function getDataForExcel($where_complete,$where_not,$where_invalid,$where_confirm,$start_time,$end_time){
        $order = new Order();
        $data[COMPLETE] = $order->getCountByVerifyAndTime(1,$where_complete,$start_time,$end_time);  //已成交
        $data[NOT_OPERATE]=$order->getCountByVerifyAndTime(1,$where_not,$start_time,$end_time);  //未操作
        $data[INVALID]=$order->getCountByVerifyAndTime(2,$where_invalid,$start_time,$end_time); //无效或取消
        $data[CONFIRM]=$order->getCountByVerifyAndTime(2,$where_confirm,$start_time,$end_time); //待确认收获
        return $data;
    }


}
