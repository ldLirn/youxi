<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CateGame extends Model
{
    protected $table="game_category";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = false;


    //递归查询
    public function getTree($dig_list=array(),$pid=0,$level=0){
        $list = $this->where('pid',$pid)->orderBy('cat_order','asc')->get();
        foreach($list as $k=>$v){
            for($i=0;$i<$level;$i++){
                $v['cat_name']='└─ '.$v['cat_name'];
            }
            $v['num'] = Game::where('cate_id',$v['id'])->count();
            $v['pid'] = $v['pid']=='0'?'顶级分类':'';
            $dig_list[]=$v;
            $dig_list=$this->getTree($dig_list,$v['id'],$level+1);
        }
       
        return $dig_list;
    }

    //将分类缓存
    public function getCache()
    {
        if(!Cache::has('CateGame')){
            $data = $this->getTree();
            Cache::forever('CateGame', $data);  //缓存
        }else{
            $CateGame = Cache::get('CateGame');
            return $CateGame;
        }
    }

    //递归查询 当前下的所属子类id
    public function getPid($id='',$dig_list=array()){
        $list = $this->where('pid',$id)->select('id')->orderBy('cat_order','asc')->get();
        foreach($list as $k=>$v){
            $dig_list[]=$id ;
            $dig_list[]=$v['id'];
            $dig_list=$this->getPid($v['id'],$dig_list);
        }
        if(empty($dig_list)){$dig_list[]=$id;}
      //  dd($dig_list);
        return $dig_list;
    }
}
