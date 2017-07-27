<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table="order";

    protected $guarded=[];
    public $timestamps = false;


    public function getNewInfo(){
        //最新发布动态
        $new = GoodsGame::select('goods_name','id')->where('is_trash','0')->orderBy('created_at','desc')->limit(6)->get()->toArray();
        //最新成交动态
        $data = DB::table('order')->join('goods_game','goods_game.id','=','order.goods_id')->select('order.order_sn','goods_game.goods_name','goods_game.id','order.order_amount','order.buy_number')->whereNotIn('order_status',['4','5'])->orderBy('order.pay_time','desc')->limit(6)->get();

        //$data = $data->toArray();
        foreach ($data as $k=>$v){
            $data[$k]->new = $new[$k];
        }
        return $data;
    }

    /**
     * @param $type  查询类型
     * @param $where 查询条件
     * @param $start_time
     * @param $end_time
     * @return mixed
     */
    public function getCountByVerifyAndTime($type,$where,$start_time,$end_time)
    {
        if($type==1){
            return $this->where($where)->wherebetween('created_at', array($start_time, $end_time))->count();
        }else{
           return $this->where(function($query)use($where){
                $query->where($where[0])
                    ->orWhere(function($query)use($where){
                        $query->where($where[1]);
                    });
            })->where($where[2])->wherebetween('created_at', array($start_time, $end_time))->count();
            //dd(DB::getQueryLog());
        }
    }


}
