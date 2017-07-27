<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArtCategoryModel extends Model
{
    protected $table="art_category";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = false;


    //递归查询
    public function getTree($dig_list=array(),$pid=0,$level=0){
        $list = $this->where('p_id',$pid)->orderBy('cat_order','asc')->get();
        foreach($list as $k=>$v){
            for($i=0;$i<$level;$i++){
                $v['cat_name']='└─ '.$v['cat_name'];
            }
            $v['p_id'] = $v['p_id']=='0'?'顶级分类':'';
            $dig_list[]=$v;
            $dig_list=$this->getTree($dig_list,$v['id'],$level+1);
        }
        return $dig_list;
    }


    public function getHelp()
    {
        $list =$this->where('p_id',28)->orderBy('cat_order','asc')->get()->toArray();
            foreach($list as $k=>$v){
            $list[$k]['son']=$this->where('p_id',$v['id'])->orderBy('cat_order','asc')->get()->toArray();
        }
        return $list;
    }
    

    //递归查询 当前下的所属子类id
    public function getPid($id='',$dig_list=array()){
        $list = $this->where('p_id',$id)->select('id')->orderBy('cat_order','asc')->get();
        foreach($list as $k=>$v){
            $dig_list[]=$id ;
            $dig_list[]=$v['id'];
            $dig_list=$this->getPid($v['id'],$dig_list);
        }
        return $dig_list;
    }
    
    //取得分类名称
    public function getCatName($id)
    {
        return DB::table('art_category')
            ->select('cat_name')->
            where('id',$id)
            ->first();
    }
}
