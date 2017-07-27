<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DkGame extends Model
{
    protected $table="dk_game_list";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;

}
