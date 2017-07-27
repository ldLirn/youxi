<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleModel extends Model
{
    protected $table="article";
    //protected $primaryKey="";
    protected $guarded=[];
   // public $timestamps = false;


    public function getlist()
    {
        return DB::table('article')->join('art_category', function($join)
        {$join->on('article.cat_id', '=', 'art_category.id');})
            ->select('article.id','article.is_recommend', 'article.title','article.desc','article.created_at', 'article.cat_id','article.updated_at','art_category.cat_name')->orderBy('id','desc')->Paginate(15);
    }

    public function getListById($id)
    {
        $id = is_array($id)?$id:array('0'=>$id);
        return DB::table('article')->join('art_category', function($join)
        {$join->on('article.cat_id', '=', 'art_category.id');})
            ->select('article.id', 'article.title','article.is_recommend','article.desc','article.created_at', 'article.cat_id','article.updated_at','art_category.cat_name')->
            whereIn('article.cat_id',$id)
            ->orderBy('article.created_at','desc')->Paginate(10);
    }
    
}
