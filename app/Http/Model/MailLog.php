<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $table="mail_log";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;

}
