<?php
/**
 * Created by PhpStorm.
 * User: l
 * Date: 2016/7/21
 * Time: 14:20
 */
namespace App\Http\Controllers\Admin;




use App\Http\model\MenuModel;
use App\Http\Model\Permission;
use App\Http\Model\User;
use App\Http\Requests;

use Arcanedev\LogViewer\LogViewer;
use Bican\Roles\Models\Role;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends CommonController{

    //首页视图
    public function index(){

        $model = new MenuModel();

        //判断菜单缓存
        if(!Cache::has('menu')){
            $userData = User::with('role')->where('name',session('users.admin_name'))->first()->toArray();
            $userPermission = DB::table('permission_role')->select('permission_id')->where('role_id',$userData['role']['0']['id'])->get();
            $permission = array();
            //取得当前用户的菜单id
            foreach ($userPermission as $v){
                $permission[]= $v->permission_id;
            }
            //把当前用户的菜单顶级id和菜单id 合并 并查找出这个数组
            $menuAll = $model->orderBy('order','asc')->get()->toArray();
            $in_menu = array();
            foreach ($menuAll as $m) {
                if (in_array($m['bind_permission'], $permission)) {
                    $in_menu[] = $m['id'];
                    $in_menu[] = $m['pid'];
                }
            }
            $in_menu = array_unique($in_menu);
            $menuData = $model->whereIn('id',$in_menu)->orderBy('order','asc')->get();
            $menuList = $model->getTree($menuData);
            Cache::forever('menu', $menuList);
        }
        
        $menu = Cache::get('menu');
       // dd($menu);
        return view('admin.index',compact('menu'));

    }
    //数据统计页面
    public function start()
    {
        return view('admin.start');
    }
    
   

   
}