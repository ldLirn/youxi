<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExchangeOrder extends Model
{
    protected $table="exchange_order";

    protected $guarded=[];

    public $timestamps = false;


    public function exchange()
    {
        return $this->hasOne('App\Http\Model\Exchange', 'id', 'goods_id');
    }

    public function user()
    {
        return $this->hasOne('App\Http\Model\User', 'id', 'user_id');
    }
}
