<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdModel extends Model
{
    protected $table="ad";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;


    public function position()
    {
        return $this->belongsTo('App\Http\Model\AdPositionModel');
    }

    //获取广告列表
    public function lists()
    {
        return DB::table('ad')->join('ad_position', function($join)
        {$join->on('ad.position_id', '=', 'ad_position.id');})
            ->select('ad.id', 'ad.ad_name','ad.ad_code','ad.type', 'ad.start_time','ad.end_time','ad.position_id','ad_position.adp_name','ad.is_open')->orderBy('id','desc')->Paginate(PAGE);
    }
    
    
}
