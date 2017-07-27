<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/**
 * Class BannerController
 * @package App\Http\Controllers\Admin
 * 轮播图
 */
class BannerController extends CommonController
{
    public function index()
    {
        $data = Banner::orderBy('banner_order','asc')->get();
        return view('admin.banner.list',compact('data'));
    }

    public function create()
    {
        return view('admin.banner.add');
    }

    public function store(Requests\BannerCreateRequest $request)
    {
        $data = $request->except('token');
        $status = Banner::create($data);
        if($status){
            Log::info(session('users.admin_name').'添加友情链接'.$data['banner_name']);
            return redirect('admin/banner');
        }else{
            return back()->with('msg','新增失败，请稍后重试');
        }
    }

    public function update(Requests\BannerCreateRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        $status = Banner::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改轮播图'.$input['banner_name']);
            return redirect('admin/banner');
        }else{
            return back()->with('msg','更新失败，请稍后重试！');
        }
    }

    public function edit($id)
    {
        $data = Banner::find($id);
        return view('admin.banner.edit',compact('data'));
    }

    public function show()
    {
        
    }

    public function destroy($id)
    {
        $status = Banner::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除轮播图ID='.$id);
            $data = [
                'status' => 0,
                'info' => '轮播图删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '轮播图删除失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //改变排序 AJAX
    public function changeOrder()
    {
        $input = Input::all();
        $data = Banner::find($input['id']);
        $data->banner_order = $input['banner_order'];
        $code = $data->update();
        if($code){
            $msg=[
                'status'=>'0',
                'info'=>'排序修改成功,请点击更新排序'
            ];
        }else{
            $msg=[
                'status'=>'1',
                'info'=>'失败了，系统错误请稍后重试'
            ];
        }
        return $msg;
    }
}
