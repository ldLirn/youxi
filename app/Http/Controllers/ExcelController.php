<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home\CommonController;
use App\Http\Model\Account;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


/**
 * Class ExcelController
 * @package App\Http\Controllers
 * 前台 用户资金导出
 */
class ExcelController extends CommonController
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     * 导出用户资金明细
     */
    public function exportMoneyInfo(){
        $user = $this->getUser();
        $data = Account::where('user_id',$user['id'])->where(function($query){
            $query->where('money','<>',0)
                ->orWhere(function($query){
                    $query->where('frozen_money','<>',0);
                });})->orderBy('change_time','desc')->select('change_time','money','frozen_money','change_desc')->get();
        if(!isset($data[0])){
            return back()->with('msg','没有数据');
        }
        foreach($data as $k=>$v){
            $celldata[] = array(
                '时间'   => date('Y-m-d H:i:s',$v['change_time']),
                '金额' => $v['money']>0?'+'.$v['money']:$v['money'],
                '冻结资金' => $v['frozen_money'],
                '变动原因' => $v['change_desc'],
            );
       }
        $name = '用户资金明细';
        Excel::create($name, function($excel) use ($celldata) {
            $excel->sheet('export', function($sheet) use ($celldata) {
                $sheet->fromArray($celldata);
            });
        })->export('xls');
    }

    /**
     * 导出销售明细
     */
    public function exprotSellInfo()
    {
        
    }
}
