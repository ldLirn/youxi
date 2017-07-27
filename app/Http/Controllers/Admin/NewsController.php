<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ArticleModel;
use App\Http\Model\ArtCategoryModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


/**
 * Class NewsController
 * @package App\Http\Controllers\Admin
 * 新闻
 */
class NewsController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.news',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.news', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.news', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.news', ['only' => ['destroy']]);
    }

    //文章列表=页面
    public function index(){
        //文章列表数据
        $news = new ArticleModel();
        $data = $news->getlist();
        $model = new ArtCategoryModel();
        $cate = $model->getTree();
        return view('admin.news.news_list',compact('data','cate'));
    }

    //文章添加页面
    public function create(){
        $model = new ArtCategoryModel();
        $cate = $model->getTree();
        return view('admin.news.news_add',compact('cate'));
    }
    //文章分类添加操作
    public function store(Requests\NewsCreateRequest $request)
    {
        $input = $request->except('_token');
        $status = ArticleModel::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加文章'.$input['title']);
            return redirect('admin/news');
        }else{
            return back()->with('msg','文章新增失败，请稍后重试');
        }
    }
    
    //文章删除
    public function destroy($id){
        $status = ArticleModel::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除文章ID='.$id);
            $data = [
                'status' => 0,
                'info' => '文章删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //文章修改操作
    public function update(Requests\NewsEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $status = ArticleModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改文章'.$input['title']);
            return redirect('admin/news');
        }else{
            return back()->with('msg','文章更新失败，请稍后重试！');
        }
    }

    //文章修改页面
    public function edit($id){
        $model = new ArtCategoryModel();
        $cate = $model->getTree();
        $data = ArticleModel::find($id);
        return view('admin.news.news_edit',compact('cate','data'));
    }


    //搜索功能
    public function search(){
        $model = new ArtCategoryModel();
        $cate = $model->getTree();
        $cat_id = Input::get('cat_id');
        $keywords = Input::get('keywords');
      //  dd((new ArtCategoryModel())->getPid(Input::get('cat_id')));
        if(empty($keywords)){
            $model = new ArtCategoryModel();
            $arr = $model->getPid($cat_id);
           if(count($arr)){
               $data = DB::table('article')->join('art_category', function($join)
               {$join->on('article.cat_id', '=', 'art_category.id');})
                   ->select('article.id', 'article.title','article.desc','article.created_at', 'article.cat_id','article.updated_at','art_category.cat_name')->whereIn('cat_id',$arr)->orderBy('id','desc')->Paginate(15);
           }else{
               $data = DB::table('article')->join('art_category', function($join)
               {$join->on('article.cat_id', '=', 'art_category.id');})
                   ->select('article.id', 'article.title','article.desc','article.created_at', 'article.cat_id','article.updated_at','art_category.cat_name')->where('cat_id',$cat_id)->orderBy('id','desc')->Paginate(15);
           }
        }else{
            $data = DB::table('article')->join('art_category', function($join)
            {$join->on('article.cat_id', '=', 'art_category.id');})->select('article.id', 'article.title','article.desc','article.created_at', 'article.cat_id','article.updated_at','art_category.cat_name')->where(function($query){
                    $query->where('title','like','%'.Input::get('keywords').'%')
                        ->Where(function($query){
                            $query->whereIn('cat_id', (new ArtCategoryModel())->getPid(Input::get('cat_id')));
                        });
                })->orderBy('id','desc')->Paginate(15);
        }
        Log::info(session('users.admin_name').'搜索文章'.$keywords);
        return view('admin.news.news_search',compact('cate','data'));
    }


    //批量删除
    public function deleteAll()
    {
        $input = Input::except('_token');
        $status = ArticleModel::whereIn('id',$input['id'])->delete();
        if($status){
            Log::info(session('users.admin_name').'批量删除文章');
            return back()->with('msg','文章删除成功！');
        }else{
            return back()->with('msg','文章删除失败，请稍后重试！');
        }
    }

    public function show(){

    }


    //改变状态
    public function change()
    {
        $id = intval(Input::get('id'));
        $status = intval(Input::get('status'));
        if($status=='1'){
            $status = ArticleModel::where('id',$id)->update(['is_recommend'=>'0']);
            Cache::forget('news_detail_'.$id);  //清除缓存
        }else{
            $status = ArticleModel::where('id',$id)->update(['is_recommend'=>'1']);
            Cache::forget('news_detail_'.$id);  //清除缓存
        }
        if($status){
            return '1';
        }else{
            return '2';
        }

    }
}
