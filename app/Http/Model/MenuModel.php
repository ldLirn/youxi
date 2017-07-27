<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $guarded=[];

    public $timestamps = false;

    
    public function getTree($data,$pid=0)
    {
        $arr = [];
        foreach($data as $k => $v){
            if($v['pid'] == $pid){
                $arr[$k] = $v;
                $arr[$k]['child'] = self::getTree($data,$v['id']);
            }
        }

        return $arr;
    }
}
