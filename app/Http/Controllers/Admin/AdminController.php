<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Role;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 * 管理员控制器
 */
class AdminController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.admin',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.admin', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.admin', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.admin', ['only' => ['destroy']]);
    }


    //管理员列表
    public function index(){
        $data = User::with('roles')->where('is_admin','=','1')->Paginate(15);
        foreach ($data as $k=>$v){
            $a = json_decode($v->roles,true);
           $data[$k]['role']= $a['0']['description'];
        }
        return view('admin.power.list',compact('data'));
    }


    //添加管理员操作
    public function store(Requests\AdminCreateRequest $request){
        $user = new User();
        $role_id = $request->role_id;
        $input = $request->except('_token','password_confirmation','role_id');
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = encrypt($input['password']);
        $user->is_admin = '1';
        if($user->save()){
            Log::info(session('users.admin_name').'添加管理员');
            // 自动更新用户角色关系
            if (isset($role_id) && $role_id) {
                $arr = array('0'=>$role_id);
                $user->role()->sync($arr);
                return redirect('admin/power');
            }else{
                return back()->with('msg','角色不存在');
            }
        }else{
            return back()->with('msg','管理员新增失败，请稍后重试');
        }
    }

    //添加管理员页面
    public function create(){
        $cate = Role::where('id','>','1')->get();
        return view('admin.power.add',compact('cate'));
    }

    //删除管理员
    public function destroy($id){
        $status = User::destroy($id);
        if($status){
            DB::table('role_user')->where('user_id',$id)->delete();
            Log::info(session('users.admin_name').'删除管理='.$id);
            $data = [
                'status' => 0,
                'info' => '管理员删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '管理员删除失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //修改管理员操作
    public function update(Requests\AdminEditRequest $request,$id){
        $user = User::find($id);
        $role_id = $request->role_id;
        $input = $request->except('_token','_method','role_id','_token');
        $user->name = $input['name'];
        $user->email = $input['email'];
        if($user->save()){
            Log::info(session('users.admin_name').'修改管理员');
            // 自动更新用户角色关系
            if (isset($role_id) && $role_id) {
                $arr = array('0'=>$role_id);
                $user->role()->sync($arr);
                return redirect('admin/power');
            }else{
                return back()->with('msg','角色不存在');
            }
        }else{
            return back()->with('msg','管理员修改失败，请稍后重试');
        }

    }

    public function show(){

    }
    
    //修改页面
    public function edit($id){
        $cate = Role::where('id','>','1')->get();
        $data = User::with('role')->find($id)->toArray();
        if ($data['role']) {
            $data['role'] =$data['role']['0']['id'];
        }
        return view('admin.power.edit',compact('cate','data'));
    }

//    //管理日志
//    public function log()
//    {
//        
//    }
    
    
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
    
    /**
     * 修改个人资料
     */
    public function edit_info()
    {
        if(Input::method()=='POST'){
           $input['qq'] = Input::get('qq');
            //dd(Input::get('question'));
           $input['question'] = htmlspecialchars(Input::get('question'));
          // dd($input['question']);
           $input['head_img'] = Input::get('head_img');
           $msg = User::where('name',session('users.admin_name'))->update($input);
            if($msg){
                Log::info(session('users.admin_name').'修改个人信息');
                return back()->with('msg','资料更新成功！');
            }else{
                return back()->with('msg',trans('com.system_error'));
            }
        }
        $data = User::where('name',session('users.admin_name'))->select('qq','head_img','question')->first();
        $data['question'] = htmlspecialchars_decode($data['question']);
        return view('admin.power.edit_info',compact('data'));
    }
}
