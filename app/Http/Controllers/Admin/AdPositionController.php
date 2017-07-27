<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdPositionModel;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

/**
 * Class AdPositionController
 * @package App\Http\Controllers\Admin
 * 广告位置
 */
class AdPositionController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.adposition',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.adposition', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.adposition', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.adposition', ['only' => ['destroy']]);
    }

    //广告位置列表=页面
    public function index(){
        //广告位置列表数据
        $data = AdPositionModel::Paginate(15);
        return view('admin.ad.ad_position_list',compact('data'));
    }

    //广告位置添加页面
    public function create(){
        return view('admin.ad.ad_position_add');
    }
    //广告位置分类添加操作
    public function store(Requests\AdPositionCreateRequest $request)
    {
            $input = $request->except('_token');
            $status = AdPositionModel::create($input);
            if($status){
                Log::info(session('users.admin_name').'添加广告位'.$input['adp_name']);
                return redirect('admin/ad_position');
            }else{
                return back()->with('msg','广告位置新增失败，请稍后重试');
            }
    }
    
    //广告位置删除
    public function destroy($id){
        try {
            DB::transaction(function () use($id){
                DB::table('ad_position')->where('id',$id)->delete();
                DB::table('ad')->where('position_id',$id)->delete();
            });
            Log::info(session('users.admin_name') . '删除广告位ID='.$id);
            $data = [
                'status' => 0,
                'info' => '广告位置删除成功！',
            ];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 1,
                'info' => '广告位置删除失败，请稍后重试！',
            ];
            return $data;
        }

    }
    //广告位置修改操作
    public function update(Requests\AdPositionEditRequest $request,$id){
            $input = $request->except('_token','_method');
            $status = AdPositionModel::where('id',$id)->update($input);
            if($status){
                Log::info(session('users.admin_name').'修改广告位'.$input['adp_name']);
                return redirect('admin/ad_position');
            }else{
                return back()->with('msg','广告位置更新失败，请稍后重试！');
            }
    }

    //广告位置修改页面
    public function edit($id){
        $data = AdPositionModel::find($id);
        return view('admin.ad.ad_position_edit',compact('data'));
    }


    //搜索功能
    public function search(){
        $keywords = Input::get('keywords');
        $data = AdPositionModel::where('adp_name','like','%'.$keywords.'%')->Paginate(15);

        Log::info(session('users.admin_name').'搜索广告位');
        return view('admin.ad.ad_position_search',compact('data'));
    }

    

    public function show(){

    }
}
