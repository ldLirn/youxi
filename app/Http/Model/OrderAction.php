<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderAction extends Model
{
    protected $table="order_action";

    protected $guarded=[];
    public $timestamps = false;
    
    
}
