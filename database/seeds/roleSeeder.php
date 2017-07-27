<?php

use Illuminate\Database\Seeder;
use App\Http\Model\Role;
use App\Http\Model\Permission;
class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = new Role();
        $owner->name = 'owner';
        $owner->display_name = '网站管理员';
        $owner->description = '';
        $owner->save();

        $admin = new Role();
        $admin->name = 'Administrator';
        $admin->display_name = '超级管理员';
        $admin->description = '最高权限拥有者';
        $admin->save();


        $manageUsers = new Permission;
        $manageUsers->name = 'news_manage';
        $manageUsers->display_name = '新闻管理';
        $manageUsers->save();

        $power = new Permission;
        $power->name = 'power_manage';
        $power->display_name = '权限管理';
        $power->save();

        $ad = new Permission;
        $ad->name = 'ad_manage';
        $ad->display_name = '广告管理';
        $ad->save();

        $sys = new Permission;
        $sys->name = 'sys_manage';
        $sys->display_name = '系统设置';
        $sys->save();



        $user = \App\Http\Model\AdminModel::where('name', '=', 'admin1')->first();
        $user1 = \App\Http\Model\AdminModel::where('name', '=', 'admin')->first();
        //调用hasRole提供的attachRole方法
        $user->attachRole($owner); // 参数可以是Role对象，数组或id
        $user1->attachRole($admin); // 参数可以是Role对象，数组或id

        $admin->attachPermissions(array($manageUsers, $ad,$power,$sys));
        $owner->attachPermissions(array($manageUsers, $ad));
       // $owner->attachPermissions(array($manageUsers, $ad));
    }
}
