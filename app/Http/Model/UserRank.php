<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRank extends Model
{
    protected $table="user_rank";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;

    
    
}
