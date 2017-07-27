<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class GameQu extends Model
{
    protected $table="game_qu";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = false;


    public function GameDaQu($game_id)
    {
        $data = $this->where('pid','0')->where('game_id',$game_id)->get();
        return $data;
    }

    public function GameQu($qu_id)
    {
        $data = $this->where('pid',$qu_id)->get();
        return $data;
    }
}
