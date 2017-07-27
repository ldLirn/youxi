<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ArtCategoryModel;
use App\Http\Model\ArticleModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class ArtCateController
 * @package App\Http\Controllers\Admin
 * 文章分类
 */
class ArtCateController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.artCate',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.artCate', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.artCate', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.artCate', ['only' => ['destroy']]);
    }
    
    //全部文章分类
    public function index(){
        $model = new ArtCategoryModel();
        $data = $model->getTree();
        return view('admin.news.news_category',compact('data'));
    }

    //文章分类添加页面
    public function create(){
        $model = new ArtCategoryModel();
        $data = $model->getTree();
        return view('admin.news.cat_add',compact('data'));
    }

    

    //文章分类添加操作
    public function store(Requests\ArtCateCreateRequest $request)
    {
            $input = $request->except('_token');
            $status = ArtCategoryModel::create($input);
            if($status){
                Log::info(session('users.admin_name').'添加文章分类'.$input['cat_name']);
                return redirect('admin/ArtCate');
            }else{
                return back()->with('msg','分类新增失败，请稍后重试');
            }
    }
    //文章分类删除
    public function destroy($id){
        $has = ArtCategoryModel::where('p_id',$id)->first();
        if($has){
            $data = [
                'status' => 2,
                'info' => '请先删除子分类！',
            ];
        }else{
            $has_art = ArticleModel::where('cat_id',$id)->first();
            if($has_art){
                $data = [
                    'status' => 3,
                    'info' => '此分类下存在文章不能删除！',
                ];
            }else{
                $status = ArtCategoryModel::where('id',$id)->delete();
                if($status){
                    Log::info(session('users.admin_name').'删除文章分类ID='.$id);
                    $data = [
                        'status' => 0,
                        'info' => '分类删除成功！',
                    ];
                }else{
                    $data = [
                        'status' => 1,
                        'info' => '分类删除失败，请稍后重试！',
                    ];
                }
            }
        }
        return $data;
    }
    //文章分类修改操作
    public function update(Requests\ArtCateEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $status = ArtCategoryModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改文章分类'.$input['cat_name']);
            return redirect('admin/ArtCate');
        }else{
            return back()->with('msg','文章分类更新失败，请稍后重试！');
        }

    }
    
    //文章分类修改页面
    public function edit($id){
        $model = new ArtCategoryModel();
        $cate = $model->getTree();
        $data = ArtCategoryModel::find($id);
        return view('admin.news.cat_edit',compact('cate','data'));
    }

    //改变排序 AJAX
    public function changeOrder()
    {
        $input = Input::all();
        $data = ArtCategoryModel::find($input['id']);
        $data->cat_order = $input['cat_order'];
        $code = $data->update();
        if($code){
            $msg=[
                'status'=>'0',
                'info'=>'分类排序修改成功,请点击更新排序'
            ];
        }else{
            $msg=[
                'status'=>'1',
                'info'=>'失败了，系统错误请稍后重试'
            ];
        }
        return $msg;
    }
    
    public function show(){

    }
    
    
}
