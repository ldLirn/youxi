<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\LinkModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class LinkController
 * @package App\Http\Controllers\Admin
 * 友情链接
 */
class LinkController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.link',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.link', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.link', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.link', ['only' => ['destroy']]);
    }

    //友情链接列表=页面
    public function index(){
        //友情链接列表数据
       $data =  LinkModel::Paginate(15);
        return view('admin.link.link_list',compact('data'));
    }

    //友情链接添加页面
    public function create(){
        return view('admin.link.link_add');
    }

    //友情链接分类添加操作
    public function store(Requests\LinkCreateRequest $request)
    {
        $input = $request->except('_token');
        $status = LinkModel::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加友情链接'.$input['link_name']);
            Cache::forget('link_data');  //清除缓存
            return redirect('admin/link');
        }else{
            return back()->with('msg','友情链接新增失败，请稍后重试');
        }
    }

    //友情链接删除
    public function destroy($id){
        $status = LinkModel::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除友情链接ID='.$id);
            Cache::forget('link_data');  //清除缓存
            $data = [
                'status' => 0,
                'info' => '友情链接删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //友情链接修改操作
    public function update(Requests\LinkEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $status = LinkModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改友情链接'.$input['link_name']);
            Cache::forget('link_data');  //清除缓存
            return redirect('admin/link');
        }else{
            return back()->with('msg','友情链接更新失败，请稍后重试！');
        }
    }

    //友情链接修改页面
    public function edit($id){

        $data = LinkModel::find($id);
        return view('admin.link.link_edit',compact('data'));
    }


    //批量删除
    public function deleteAll()
    {
        $input = Input::except('_token');
        $status = LinkModel::whereIn('id',$input['id'])->delete();
        if($status){
            Log::info(session('users.admin_name').'批量删除友情链接');
            Cache::forget('link_data');  //清除缓存
            return back()->with('msg','友情链接删除成功！');
        }else{
            return back()->with('msg','友情链接删除失败，请稍后重试！');
        }
    }

    public function show(){

    }
}
