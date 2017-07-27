<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DkOrderModel extends Model
{
    protected $table="dk_order";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;


    public function user()
    {
        return $this->hasOne('App\Http\Model\User', 'id', 'user_id');
    }
}
