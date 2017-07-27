<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table="attribute";
    //protected $primaryKey="";
    protected $guarded=[];
     public $timestamps = false;

    public function game()
    {
        return $this->belongsTo('App\Http\Model\Game');
    }
    
    public function game_type()
    {
        return $this->belongsTo('App\Http\Model\GameType','game_goods_type_id');
    }

    public function attr($game_id,$type_id)
    {
        $data = $this->where('game_id',$game_id)->where('game_goods_type_id',$type_id)->first();
        return $data;
    }
}
