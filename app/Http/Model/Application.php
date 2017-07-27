<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table="applications";

    protected $guarded=[];

    public $timestamps = false;


    public function withUser()
    {
        //会员信息
      return $this->hasOne('App\Http\Model\User','id','user_id');
    }
}
