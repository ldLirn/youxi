<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdModel;
use App\Http\Model\AdPositionModel;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdController
 * @package App\Http\Controllers\Admin
 * 广告控制器
 */
class AdController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.ad',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.ad', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.ad', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.ad', ['only' => ['destroy']]);
    }



    public function model(){
       return $ad = new AdModel();
    }

    //广告列表=页面
    public function index(){

        //广告列表数据
        $data = $this->model()->lists();
        return view('admin.ad.ad_list',compact('data'));
    }

    //广告添加页面
    public function create(){
       $adpostin = new AdPositionModel();
        $cate = $adpostin->getCate();
        return view('admin.ad.ad_add',compact('cate'));
    }
    //广告分类添加操作
    public function store(Requests\CreateAdRequest $request)
    {
        $input = $request->except('_token');
        if(!empty($input['ad_img'])){
            $input['ad_code'] = $input['ad_img'];
            $input = array_except($input,'ad_img');
        }else{
            $input = array_except($input,'ad_img');
        }
            $status =  $this->model()->create($input);
            if($status){
                Log::info(session('users.admin_name').'添加广告'.$input['ad_name']);
                return redirect('admin/ad');
            }else{
                return back()->with('msg','广告新增失败，请稍后重试');
            }
    }
    
    //广告删除
    public function destroy($id){
        
        $status = $this->model()->where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除广告ID='.$id);
            $data = [
                'status' => 0,
                'info' => '广告删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '广告删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //广告修改操作
    public function update(Requests\EditAdRequest $request,$id){
            $row = $this->model()->find($id);
            if($row){
                $input = $request->except('_token','_method');
                if(!empty($input['ad_img'])){
                    $input['ad_code'] = $input['ad_img'];
                    $input = array_except($input,'ad_img');
                }else{
                    $input = array_except($input,'ad_img');
                }
                $status = $this->model()->where('id',$id)->update($input);
                if($status){
                    Log::info(session('users.admin_name').'修改广告'.$input['ad_name']);
                    return redirect('admin/ad');
                }else{
                    return back()->with('msg','广告更新失败，请稍后重试！');
                }
            }else{
                abort(404);
            }
    }

    //广告修改页面
    public function edit($id){
        $adpostin = new AdPositionModel();
        $cate = $adpostin->getCate();
        $data =$this->model()->find($id);
        if($data['type']=='1'){
            $data['ad_img'] = $data['ad_code'];
            $data = array_except($data,'ad_code');
        }
        return view('admin.ad.ad_edit',compact('cate','data'));
    }


    //搜索功能
    public function search(){

        $keywords = Input::get('keywords');
        $data = AdModel::where('ad_name','like','%'.$keywords.'%')->Paginate(15);

        Log::info(session('users.admin_name').'搜索广告位'.$keywords);
        return view('admin.ad.ad_search',compact('data'));
    }



    public function show(){

    }
}
