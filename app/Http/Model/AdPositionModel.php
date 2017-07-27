<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class AdPositionModel extends Model
{
    protected $table="ad_position";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;

    
    public function ad()
    {
        return $this->hasOne('App\Http\Model\AdModel');
    }
    
    public function getCate(){
        $cate = $this->select('id','adp_name','adp_width','adp_height')->get();
        foreach ($cate as $k=>$v){
            $cate[$k]['adp_name'] = $v['adp_name']. ' ['.$v['adp_width'].'*'.$v['adp_height'].']';
        }
        return $cate;
    }
}
