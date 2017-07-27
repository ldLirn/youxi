<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    protected $table="link";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;
}
