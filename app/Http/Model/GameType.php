<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    protected $table="game_type";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = false;


    public function game()
    {
        return $this->belongsToMany('App\Http\Model\Game','game_qu','game_id');
    }

    public function type($game_id)
    {
        $data = $this->where('game_id',$game_id)->get();
        return $data;
    }
}
