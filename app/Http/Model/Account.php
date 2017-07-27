<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    protected $table="account_log";

    protected $guarded=[];
    public $timestamps = false;

//判断是增加还是减少
    public function is_add($data,$do)
    {
        $money ='';
        if(trim($data) && is_numeric($data)){
            if($do=='add'){
                $money = $data;
            }elseif ($do=='lost'){
                $money = '-'.$data;
            }
        }
        $money = $money?$money:'0';
        return $money;
    }

    public function user_money($id)
    {
        $user = (new User())->money($id);
        $html = '当前会员:'.$user['name'].' 可用资金帐户：'. $user['money'] .' 冻结资金帐户： '.$user['frozen_money'] .' 消费积分帐户： '. $user['integral'].' 买家信用积分帐户：' .$user['user_point_buy']. ' 卖家信用积分帐户：'. $user['user_point_sell'];
        return $html;
    }

    public function show_type($type,$id)
    {
        switch ($type){
            case '0':
                $data = Account::where('user_id',$id)->Paginate(PAGE);
                break;
            case '1':
                $data = Account::where('user_id',$id)->where('money','!=','0')->Paginate(PAGE);
                break;
            case '2':
                $data = Account::where('user_id',$id)->where('frozen_money','!=','0')->Paginate(PAGE);
                break;
            case '3':
                $data = Account::where('user_id',$id)->where('integral','!=','0')->Paginate(PAGE);
                break;
            case '4':
                $data = Account::where('user_id',$id)->where('user_point_buy','!=','0')->Paginate(PAGE);
                break;
            case '5':
                $data = Account::where('user_id',$id)->where('user_point_sell','!=','0')->Paginate(PAGE);
                break;
        }
        return $data;
    }
    
}
