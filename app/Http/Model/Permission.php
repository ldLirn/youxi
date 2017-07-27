<?php
/**
 * Created by PhpStorm.
 * User: l
 * Date: 2016/7/26
 * Time: 16:57
 */


namespace App\Http\Model;

use Bican\Roles\Models\Permission as BicanPermission;
class Permission extends BicanPermission{
    protected $table = 'permissions';

    protected $fillable = ['name','slug','description','model'];

    public function role()
    {
        return $this->belongsToMany('App\Http\Model\Role');
    }


    public function getTree($data,$pid=0)
    {
        $arr = [];
        foreach($data as $k =>  $v){
            if($v['pid'] == $pid){
                $arr[$k] = $v;
                $arr[$k]['child'] = self::getTree($data,$v['id']);
            }
        }
        return $arr;
    }



}
