<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exchange extends Model
{
    protected $table="exchange";

    protected $guarded=[];

    public $timestamps = false;
    
}
