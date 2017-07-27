<?php

namespace App\Http\Controllers\Admin;


use App\Http\model\MenuModel;
use App\Http\Model\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

/**
 * Class MenuController
 * @package App\Http\Controllers\Admin
 * 后台 菜单
 */
class MenuController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.menu',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.menu', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.menu', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.menu', ['only' => ['destroy']]);
    }


    //全部菜单分类
    public function index(){
        
        $model = new MenuModel();
        $data = $model->getTree($model->orderBy('order','asc')->get());
        return view('admin.menu.list',compact('data'));
    }

    //菜单分类添加页面
    public function create(){
        $model = new MenuModel();
        
        $permission = new Permission();
        $power = $permission->getTree($permission->all());

        $data = $model->getTree($model->orderBy('order','asc')->get());
        return view('admin.menu.add',compact('data','power'));
    }

    

    //菜单分类添加操作
    public function store(Requests\MenuCreateRequest $request)
    {
            $input = $request->except('_token');
            $status = MenuModel::create($input);
            if($status){
                Cache::forget('menu');
                Log::info(session('users.admin_name').'添加菜单分类'.$input['name']);
                return redirect('admin/menu');
            }else{
                return back()->with('msg','菜单新增失败，请稍后重试');
            }
    }
    //菜单分类删除
    public function destroy($id){
        $has = MenuModel::where('pid',$id)->first();
        if($has){
            $data = [
                'status' => 2,
                'info' => '请先删除下级菜单！',
            ];
        }else{
                $status = MenuModel::where('id',$id)->delete();
                if($status){
                    Log::info(session('users.admin_name').'删除菜单ID='.$id);
                    Cache::forget('menu');
                    $data = [
                        'status' => 0,
                        'info' => '菜单删除成功！',
                    ];
                }else{
                    $data = [
                        'status' => 1,
                        'info' => '菜单删除失败，请稍后重试！',
                    ];
            }
        }
        return $data;
    }
    //菜单分类修改操作
    public function update(Requests\MenuEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $status = MenuModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改菜单'.$input['name']);
            Cache::forget('menu');
            return redirect('admin/menu');
        }else{
            return back()->with('msg','菜单更新失败，请稍后重试！');
        }

    }
    
    //菜单分类修改页面
    public function edit($id){
        $model = new MenuModel();
        $cate = $model->getTree($model->all());
        $data = MenuModel::find($id);
        $permission = new Permission();
        $power = $permission->getTree($permission->all());
        return view('admin.menu.edit',compact('cate','data','power'));
    }

    //改变排序 AJAX
    public function changeOrder()
    {
        $input = Input::all();
        $data = MenuModel::find($input['id']);
        $data->order = $input['order'];
        $code = $data->update();
        if($code){
            Cache::forget('menu');
            $msg=[
                'status'=>'0',
                'info'=>'排序修改成功,请点击更新排序'
            ];
        }else{
            $msg=[
                'status'=>'1',
                'info'=>'系统错误请稍后重试'
            ];
        }
        return $msg;
    }
    
    public function show(){

    }
    
    
}
