<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class NavModel extends Model
{
    protected $table="nav";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;

    //递归查询
    public function getTree($dig_list=array(),$pid=0,$level=0){
        $list = $this->where('p_id',$pid)->orderBy('nav_order','asc')->get();
        foreach($list as $k=>$v){
            for($i=0;$i<$level;$i++){
                $v['nav_name']='└─ '.$v['nav_name'];
            }
            $v['p_id'] = $v['p_id']=='0'?'顶级分类':'';
            $dig_list[]=$v;
            $dig_list=$this->getTree($dig_list,$v['id'],$level+1);
        }
        return $dig_list;
    }

    /**
     * @param $data
     * @param int $pid
     * @return array  得到树形结构
     */
    public function getTree_y($data,$pid=0)
    {
        $arr = [];
        foreach($data as $k => $v){
            if($v['p_id'] == $pid){
                $arr[$k] = $v;
                $arr[$k]['child'] = self::getTree_y($data,$v['id']);
            }
        }

        return $arr;
    }
}
