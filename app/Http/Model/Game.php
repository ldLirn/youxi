<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $table="game";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = false;


    public function hasManyQu()
    {
        return $this->hasMany('App\Http\Model\GameQu', 'game_id', 'id');
    }

    public function hasManyType()
    {
        return $this->hasMany('App\Http\Model\GameType', 'game_id', 'id');
    }

    public function hasManySType()
    {
        return $this->hasMany('App\Http\Model\Attribute', 'game_id', 'id');
    }

    /**
     * @return array
     * 添加数据处理
     */
    public function getQuData($data)
    {
        $quData = json_decode($data,true);
       // dd($quData);
        $qu = '';
        $quData['name'] = array_filter($quData['name']); //去掉数组中的空元素
        foreach ($quData['name'] as $k=>$v) {
            $qu[$k][] = $v;
            foreach ($quData['value'] as $m => $n) {
                if ($k === $m) {
                    $n = array_filter($n); //去掉数组中的空元素
                    $qu[$k][]['son'] = $n;
                }
            }
        }
        return $qu;
    }


    
    /**
     * @return array
     * 修改数据处理
     */
    public function EditQuData($data)
    {
        $quData = json_decode($data,true);
//        $da_qu = array_combine($quData['name_id'],$quData['name']);
//        foreach ($quData['value'])
//        dd($quData);
        $qu = '';
        $num = 0;
        foreach ($quData['name'] as $k=>$v) {
            $qu[$k]['qu_name'] = $v;
            foreach ($quData['name_id'] as $q=>$w){  //将大区id放入
                $qu[$q]['qu_id'] = $w;
            }
            foreach ($quData['value'] as $m => $n) {
                if ($k === $m) {
                   // $n = array_filter($n); //去掉数组中的空元素
                    $qu[$k]['son'] = $n;
                }
            }
            foreach ($quData['value_id'] as $a => $s) {
                    $qu[$a]['son_id'] = $s;
            }
          //  $qu[$k]['aa'] = array_combine($qu[$k]['son_id'],$qu[$k]['son']);
        }
        foreach ($qu as $k=>$v){
            foreach ($v['son_id'] as $m=>$n){
                if($n==''){
                    $num--;
                    $qu[$k]['son_id'][$m] = $num;
                }
            }
            $qu[$k]['qu_data'] = array_combine($qu[$k]['son_id'],$qu[$k]['son']);
            unset($qu[$k]['son']);
            unset($qu[$k]['son_id']);
        }
        return $qu;
    }


    /**
     * @return mixed
     * 整合类型名和id
     */
    public function typeData($type,$type_id)
    {

        $num=0;
        foreach ($type_id as $k=>$v){
            if($v==''){
                $num--;
                $type_id[$k] = $num;
            }
        }
       // dd($type_id);
        $qu = array_combine($type_id,$type);
        return $qu;
    }
    /**
     * @return mixed
     * 整合类型对的手续费和id
     */
    public function typeFee($type_id,$fee)
    {
        $num=0;
        foreach ($type_id as $k=>$v){
            if($v==''){
                $num--;
                $type_id[$k] = $num;
            }
        }
        $qu = array_combine($type_id,$fee);
        return $qu;
    }

    public function lists()
    {
       // $first = DB::table('goods_game')->where('cate_id');
//         DB::table('game')->join('game_category', function($join)
//        {$join->on('game.cate_id', '=', 'game_category.id');})->join('goods_game', function($join)
//        {$join->on('game.cate_id', '=', 'goods_game.id');})
        $data = DB::table('game')->join('game_category', 'game.cate_id', '=', 'game_category.id')->select('game.*','game_category.cat_name')->orderBy('cate_id','asc')->Paginate(PAGE);
        foreach ($data as $k=>$v){
            $data[$k]->num =DB::table('goods_game')->where('game_id',$v->id)->count();
        }
        return $data;
    }
}
