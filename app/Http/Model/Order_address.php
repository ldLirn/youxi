<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order_address extends Model
{
    protected $table="user_order_address";

    protected $guarded=[];
    public $timestamps = false;


    public function game_name()
    {
        return $this->hasOne('App\Http\Model\Game','id','game_id');
    }

    public function da_qu_name()
    {
        return $this->hasOne('App\Http\Model\GameQu','id','da_qu_id');
    }

    public function xia_qu_name()
    {
        return $this->hasOne('App\Http\Model\GameQu','id','xia_qu_id');
    }
    
}
