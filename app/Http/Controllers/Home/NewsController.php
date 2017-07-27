<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\ArtCategoryModel;
use App\Http\Model\ArticleModel;
use App\Http\Requests;

use Illuminate\Support\Facades\Input;

/**
 * Class NewsController
 * @package App\Http\Controllers\Home
 * 新闻
 */
class NewsController extends CommonController
{

    /**
     * Create a new controller instance.
     * @return void
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cat_data = ArtCategoryModel::where('p_id',24)->orderBy('cat_order','asc')->get();
        if(Input::get('cat')!==null){
            $cat_id = intval(Input::get('cat'))?intval(Input::get('cat')):25;
            if($cat_id==0){
                return back();
            }else{
                $page_path['cat']=Input::get('cat');
                $data = (new ArticleModel)->getListById($cat_id);
                $cat_name = (new ArtCategoryModel())->getCatName($cat_id);
                $cat_name = $cat_name->cat_name;
            }
        }
        return view('news.list',compact('cat_data','data','page_path','cat_name'));
    }

    public function detail($id)
    {
        $cat_data = ArtCategoryModel::where('p_id',24)->orderBy('cat_order','asc')->get();
        $id = $this->getId($id);
        $data = ArticleModel::findOrFail($id);
        return view('news.detail',compact('data','cat_data'));
    }
}
