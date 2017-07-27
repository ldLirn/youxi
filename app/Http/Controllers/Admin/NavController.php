<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\NavModel;


use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Request;

/**
 * Class NavController
 * @package App\Http\Controllers\Admin
 * 前台 导航
 */
class NavController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.nav',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.nav', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.nav', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.nav', ['only' => ['destroy']]);
    }

    //自定义导航列表
    public function index()
    {
        $model = new NavModel();
        $list = $model->orderBy('nav_wz','asc')->orderBy('nav_order','asc')->get()->toArray();
        //dd($list);
        $data = $model->getTree_y($list);
        /**
         * 取出的数组使用分页
         */
            $perPage = PAGE;
            if (request()->has('page')) {
                $current_page = request()->input('page');
                $current_page = $current_page <= 0 ? 1 :$current_page;
            } else {
                $current_page = 1;
            }

            $item = array_slice($data, ($current_page-1)*$perPage, $perPage); //注释1
            $total = count($data);
            $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
                'path' => Paginator::resolveCurrentPath(),  //注释2
                'pageName' => 'page',
            ]);
            $data = $paginator->toArray()['data'];
            return view('admin.nav.nav_list', compact('data', 'paginator'));
    }

    //导航添加页面
    public function create()
    {
        $model = new NavModel();
        $cate = $model->getTree();
        return view('admin.nav.nav_add',compact('cate'));
    }

    //导航添加操作
    public function store(Requests\NavCreateRequest $request)
    {
        $input = $request->except('_token');
        $status = NavModel::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加导航'.$input['nav_name']);
            Cache::forget('topnav');  //清除缓存
            Cache::forget('middnav');  //清除缓存
            Cache::forget('footnav');  //清除缓存
            return redirect('admin/nav');
        }else{
            return back()->with('msg','导航新增失败，请稍后重试');
        }
    }

    //导航修改页面
    public function edit($id)
    {
        $model = new NavModel();
        $cate = $model->getTree();
        $data = NavModel::find($id);
        return view('admin.nav.nav_edit',compact('cate','data'));
    }

    //导航修改操作
    public function update(Requests\NavEditRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        $status = NavModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改导航'.$input['nav_name']);
            Cache::forget('topnav');  //清除缓存
            Cache::forget('middnav');  //清除缓存
            Cache::forget('footnav');  //清除缓存
            return redirect('admin/nav');
        }else{
            return back()->with('msg','导航更新失败，请稍后重试！');
        }
    }

    //导航删除
    public function destroy($id)
    {
        $has = NavModel::where('p_id',$id)->first();
        if($has){
            $data = [
                'status' => 2,
                'info' => '请先删除子导航！',
            ];
        }else{
                $status = NavModel::where('id',$id)->delete();
                if($status){
                    Log::info(session('users.admin_name').'删除导航ID='.$id);
                    Cache::forget('topnav');  //清除缓存
                    Cache::forget('middnav');  //清除缓存
                    Cache::forget('footnav');  //清除缓存
                    $data = [
                        'status' => 0,
                        'info' => '导航删除成功！',
                    ];
                }else{
                    $data = [
                        'status' => 1,
                        'info' => '导航删除失败，请稍后重试！',
                    ];
                }
        }
        return $data;

    }


    //改变排序 AJAX
    public function changeOrder()
    {
        $input = Input::all();
        $data = NavModel::find($input['id']);
        $data->nav_order = $input['nav_order'];
        $code = $data->update();
        if($code){
            Cache::forget('topnav');  //清除缓存
            Cache::forget('middnav');  //清除缓存
            Cache::forget('footnav');  //清除缓存
            $msg=[
                'status'=>'0',
                'info'=>'导航排序修改成功,请点击更新排序'
            ];
        }else{
            $msg=[
                'status'=>'1',
                'info'=>'系统错误请稍后重试！'
            ];
        }
        return $msg;
    }


    //单个页面的显示
    public function show()
    {

    }
}
