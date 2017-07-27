<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Application;

use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

/**
 * Class ApplicationController
 * @package App\Http\Controllers\Admin
 * 异常申请
 */
class ApplicationController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.application',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.application', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.application', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.application', ['only' => ['destroy']]);
    }

    //异常申请列表
    public function index(){
        $data = Application::with('withUser')->orderBy('created_at','desc')->orderBy('result','asc')->Paginate(PAGE);
        return view('admin.application.list',compact('data'));
    }

    //添加页面
    public function create(){
        return view('admin.application.add');
    }
    //添加操作
    public function store(Requests\ApplicationRequest $request)
    {
        $input = $request->except('_token');
        $input['created_at'] = time();
        $status = Application::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加异常申请，绑定手机为'.$input['BindPhone']);
            return redirect('admin/application');
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }
    
    //删除
    public function destroy($id){
        $msg = Application::where('id',$id)->delete();
        if($msg){
            Log::info(session('users.admin_name') . '删除异常申请ID='.$id);
            $data = [
                'status' => 0,
                'info' => trans('com.delete_success'),
            ];
        }else{
            $data = [
                'status' => 1,
                'info' =>trans('com.system_error'),
            ];
        }
        return $data;
    }


    //修改页面
    public function edit($id){
        $data = Application::find($id);
        return view('admin.application.edit',compact('data'));
    }


    //修改操作
    public function update(Requests\ApplicationRequest $request,$id){
            $input = $request->except('_token','_method');
            $status = Application::where('id',$id)->update($input);
            if($status){
                Log::info(session('users.admin_name').'修改用户异常申请，绑定手机为'.$input['BindPhone']);
                return redirect('admin/application');
            }else{
                return back()->with('msg',trans('com.system_error'));
            }
    }


    //搜索功能
    public function search(){
    }

    

    public function show($id){
        if(Input::method()=='POST'){
            $result = is_numeric(Input::get('result'))?Input::get('result'):'';
            $re_content = htmlspecialchars(Input::get('re_content'));
            if(trim($result)==''){
                return back()->with('msg','请选择审核结果');
            }
            if($result=='2' && trim($re_content)==''){
                return back()->with('msg','请填写不通过原因');
            }
            $msg = Application::where('id',$id)->update(['result'=>$result,'re_content'=>$re_content]);
            if($msg){
                return redirect('admin/application')->with('msg','审核成功');
            }else{
                return back()->with('msg',trans('com.system.error'));
            }
        }else{
            try{
                $data = Application::with('withUser')->findOrFail($id);
                return view('admin.application.show',compact('data'));
            }catch (ModelNotFoundException $e){
                return redirect('admin/application')->with('msg','不存在的ID');
            }
        }
    }
}
