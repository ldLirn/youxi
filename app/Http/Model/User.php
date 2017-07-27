<?php

namespace App\Http\Model;

use Fenos\Notifynder\Notifable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Illuminate\Auth\Passwords\CanResetPassword;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends  Model  implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract
{

    use Authenticatable, CanResetPassword, HasRoleAndPermission,Notifable;
    
    protected $guarded=[];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function permission()
    {
        return $this->belongsToMany('App\Http\Model\Permission','permission_user','user_id','permission_id')->withTimestamps();
    }


    public function role()
    {
        return $this->belongsToMany('App\Http\Model\Role','role_user','user_id','role_id')->withTimestamps();
    }


    public function getPermission()
    {
        return $this->belongsToMany('App\Http\Model\Permission','permission_user','user_id','permission_id')->withTimestamps();
    }
    //当前用户资金
    public function money($id)
    {
        return $this->where('id',$id)->select('name','money','frozen_money','integral','user_point_buy','user_point_sell')->first()->toArray();
    }
    
    //得到用户的id
    public function getUserId($user_name)
    {
        return $this->where('name','like','%'.$user_name.'%')->where('is_admin','0')->lists('id');
    }
}
