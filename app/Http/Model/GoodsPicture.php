<?php
/**
 * Created by PhpStorm.
 * User: l
 * Date: 2016/8/29
 * Time: 18:34
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsPicture extends Model
{
    protected $table="goods_game_picture";
    //protected $primaryKey="";
    protected $guarded=[];

    public $timestamps = false;
}