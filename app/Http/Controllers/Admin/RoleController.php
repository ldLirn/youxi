<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Permission;
use App\Http\Model\Role;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 * 角色
 */
class RoleController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.role',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.role', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.role', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.role', ['only' => ['destroy']]);
    }

    //角色列表
    public function index(){


        $data = Role::Paginate(15);

        return view('admin.power.role_list',compact('data'));
    }

    //添加角色操作
    public function store(Requests\RoleCreateRequest $request){
        $input = $request->except('_token');

        if(isset($input['permission1'])&&isset($input['permission'])){
            $arr = array_merge($input['permission1'],$input['permission']);
        }

        $role = new Role();
        $role->name = $input['name'];
        $role->slug = $input['name'];
        $role->description = $input['description'];
        $role->level = $input['level'];

        $adminRole = $role->save();

        if($adminRole){
            //自动更新角色权限关系
            if (isset($arr)){
                $role->permission()->sync($arr);
            }
            Log::info(session('users.admin_name').'添加角色'.$input['name']);
            return redirect('admin/role');
        }else{
            return back()->with('msg','角色新增失败，请稍后重试');
        }
    }

    //添加角色页面
    public function create(){
        $permission = new Permission();
        $power = $permission->getTree($permission->all());
        return view('admin.power.role_add',compact('power'));
    }

    //删除角色
    public function destroy($id){
        $role = Role::with('users')->find($id)->toArray();
        if($role['users']) {
            $data = [
                'status' => 2,
                'info' => '请先删除拥有此角色的管理员！',
            ];
        }else{
            $isDelete = Role::destroy($id);
            if($isDelete){
                  Permission::where('role_id',$id)->delete();
                  Log::info(session('users.admin_name').'删除管理');
                $data = [
                    'status' => 0,
                    'info' => '删除成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'info' => '失败了，请稍后重试！',
                ];
            }
        }
        return $data;
    }

    //修改角色操作
    public function update(Requests\RoleEditRequest $request,$id){

            $role = Role::find($id);
            if(isset($request->permission1)&&isset($request->permission)){
                $arr = array_merge($request->permission1,$request->permission);
            }
            $input = $request->except('_token');

            $role->id = $input['id'];
            $role->name = $input['name'];
            $role->slug = $input['name'];
            $role->description = $input['description'];
            $role->level = $input['level'];
            $adminRole = $role->save();
            if ($adminRole) {
                //自动更新角色权限关系
                if (isset($arr)){
                 //   dd($arr);
                    $role->permission()->sync($arr);
                  //  dd($arr);
                }
                Log::info(session('users.admin_name').'修改角色'.$input['name']);
                return redirect('admin/role');
            }else{
                return back()->with('msg','修改角色失败，请稍后重试');
            }
        }


    public function show(){

    }

    //修改页面
    public function edit($id){
        /*
         * 获取当前角色的信息和权限
         */
        $role = Role::with('permission')->find($id);
        if ($role) {
            $data = $role->toArray();
            if ($data['permission']) {
                $data['permission'] = array_column($data['permission'],'id');
            }
        }
        /*
        * 获取所有的权限
        */
        $permission = new Permission();
        $power = $permission->getTree($permission->all());
        return view('admin.power.role_edit',compact('power','data'));
    }

    
    //修改密码
    public function edit_pass()
    {
        if($data = Input::all()){
            $rules=[
                'password'=>'required|alpha_num|between:6,20|confirmed',
                'password_o'=>'required|alpha_num',
            ];
            $msg=[
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码应该是6到20位!',
                'password.confirmed'=>'两次输入的密码不相同!',
                'password_o.required'=>'原密码不能为空!',
            ];

            $validator = Validator::make($data,$rules,$msg);
            if($validator->passes()){
                $user = User::where('name',session('users.admin_name'))->first();
                if($data['password_o'] ==  decrypt($user->password)){
                    $user->password = encrypt($data['password']);
                    $user->update();
                    Log::info(session('users.admin_name').'修改密码');
                    return back()->with('msg','密码修改成功！');
                }else{
                    return back()->with('msg','原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.power.edit_pass',compact('email'));
        }
    }
}
