<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Http\Model\ArtCategoryModel;
use App\Http\Model\ArticleModel;
use App\Http\Model\Ask;
use App\Http\Model\Banner;
use App\Http\Model\Game;
use App\Http\Model\GoodsGame;
use App\Http\Model\User;
use App\Http\Requests;

use Fenos\Notifynder\Facades\Notifynder;
use Fenos\Notifynder\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Toplan\FilterManager\Facades\FilterManager;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class HelpController
 * @package App\Http\Controllers\Home
 * 客服中心
 */
class HelpController extends CommonController
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

    /**
     * Show the application dashboard.
     *  首页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('help.index');
    }

   /**
    * 帮助中心
    */
    public function help()
    {
        $menu = $this->menu();
        return view('help.help',compact('menu'));
    }
    
    /**
     * 帮助中心  小分类
     */
    public function cate($id)
    {
        $menu = $this->menu();
        $id = intval($id);
        $list = (new ArticleModel())->getListById($id);
        $cat_name = $this->cat_name($id);
        return view('help.help_list',compact('menu','list','cat_name','id'));
    }

    /**
     * 帮助中心，文章详细
     */
    public function detail($id)
    {
        $menu = $this->menu();
        $id = intval($id);
        $data = ArticleModel::findOrFail($id);
        $cat_name = $this->cat_name(intval(Input::get('cat')));
        $tag = 'd';
        return view('help.help_list',compact('menu','data','cat_name','tag'));
    }

    /**
     * 搜索
     */
    public function SearchArticle()
    {
        $keywords = trim(Input::get('keywords'));
        if($keywords==''){return back()->with('msg','请输入搜索关键词');}
        if(Input::get('tag')!==null){   //投诉建议 搜索
            $data = Ask::where('ask_title','like','%'.$keywords.'%')->orwhere('answer','like','%'.$keywords.'%')->select()->Paginate(15);
            $ask = $this->count_user();
            foreach($data as $k=>$v){
                $data[$k]['ask_title'] = str_replace($keywords,"<span style='color: red;'>$keywords</span>",$v->ask_title);
            }
            return view('help.ask_search',compact('data','ask'));
        }else{                          //帮助中心 搜索
            $menu = $this->menu();
            $cat_id = ArtCategoryModel::where('p_id',28)->pluck('id')->toArray();
            $cate_id = ArtCategoryModel::whereIn('p_id',$cat_id)->pluck('id')->toArray();
            $data = ArticleModel::whereIn('cat_id',$cate_id)->where('title','like','%'.$keywords.'%')->select('title','id','cat_id','desc','created_at')->orderBy('created_at','desc')->get();
            foreach($data as $k=>$v){
                $data[$k]['title'] = str_replace($keywords,"<span style='color: red;'>$keywords</span>",$v['title']);
            }
            return view('help.SearchArticle',compact('menu','data'));
        }
    }

    /**
     * 投诉建议，提问
     */
    public function ask()
    {
        if(Input::get('type')!==null && in_array(Input::get('type'),[1,2,3])){
            $type = Input::get('type');
            $type_next_data = $this->count_next($type);
        }
        if(Input::get('t')!==null && in_array(Input::get('t'),[1,2,3])){
            $t = Input::get('t');
            /**
             *  统计小分数 总数
             */
            $next[1] = $this->count_next(1);
            $next[3] = $this->count_next(3);
            $next[2] = $this->count_next(2);
        }
        /**
         * 统计个人总数
         */
        $ask = $this->count_user();
        /**
         *  统计大类 总数
         */
        $count_ask = $this->count(0,1);
        $count_complaint = $this->count(0,3);
        $count_advise = $this->count(0,2);
        $ask_next = $this->count_next(1);
        return view('help.ask',compact('type','count_ask','count_complaint','count_advise','ask','ask_next','next','t','type_next_data'));
    }
    /**
     * 选择类别
     */
    public function ask_type()
    {
        return view('help.ask_type');
    }

    /**
     * 填写投诉建议
     */
    public function ask_detail($id)
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $user = $this->getUser();
        if(Input::get('type')!==null && in_array(Input::get('type'),[1,2,3])){
            $type = Input::get('type');
        }else{
            return back();
        }
        if(Input::method()=='PUT'){
            if(!preg_match("/^1[34578]{1}\d{9}$/",Input::get('telphone'))){
                return back()->with('msg',trans('com.error_phone'));
            }
            if(!preg_match("/^[1-9]\d{4,12}$/",Input::get('qq'))){
                return back()->with('msg',trans('com.error_qq'));
            }
           if(Input::get('ask_title')=='' || Input::get('type')=='' || Input::get('ask_content')==''){
               return back()->with('msg','请检查输入信息的完整性');
           }
           $ask['ask_title'] = htmlspecialchars(Input::get('ask_title'));
           $ask['type_id'] = intval(Input::get('type'));
           $ask['ask_time'] = time();
           $ask['pic'] = Input::get('pic');
           $ask['ask_content'] = htmlspecialchars(Input::get('ask_content'));
           $ask['user_id'] =  $user['id'];
           $ask['tel'] = Input::get('telphone');
           $ask['qq'] = Input::get('qq');
           $ask['cate_id'] = $id;
           $msg = Ask::insert($ask);
            if($msg){
               return redirect('/help/ask');
            }else{
                return back()->with('msg',trans('com.system.error'));
            }
        }
        $ask_category = trans('ask_category');
        $cate = $ask_category[$id];
        return view('help.ask_detail',compact('cate','user','type'));
    }

    /**
     * 小分类  问题类别页
     */
    public function ask_list($id)
    {
        $type_id = intval(Input::get('type'));
        $cate_id = intval($id);
        $data = Ask::where('type_id',$type_id)->where('cate_id',$cate_id)->where('answer','<>','')->Paginate(15);
        $ask = $this->count_user();
        $ask_category = trans('ask_category');
        $cate = $ask_category[$id];
        return view('help.ask_list',compact('data','ask','cate'));
    }

    /**
     * 我的问题 列表
     */
    public function ask_MyList($id)
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $user = $this->getUser();
        $ask = $this->count_user();
        $id = intval($id);
        $data = Ask::where('user_id',$user['id'])->where('type_id',$id)->Paginate(15);
        if($id==1){
            $cate = '我的咨询';
        }elseif($id==2){
            $cate = '我的建议';
        }elseif($id==3){
            $cate = '我的投诉';
        }
        return view('help.ask_list',compact('data','ask','cate'));
    }

    /**
     * 问题详情页
     */
    public function ask_reply($id)
    {
        $data = Ask::findOrFail($id);
        $ask = $this->count_user();
        $ask_category = trans('ask_category');
        $cate = $ask_category[$data['cate_id']];
        return view('help.ask_reply',compact('data','ask','cate'));
    }


    /**
     * 安全中心
     */
    public function safe()
    {
        $ads = $this->getAdByPosition(9,6);  //轮播图
        $recommend = $this->recommend(20);
        return view('help.safe',compact('ads','recommend'));
    }

    /**
     * 安全中心——信息
     */
    public function safe_news()
    {
        $nav = ArtCategoryModel::where('p_id',60)->get();
        $pid = ArtCategoryModel::where('p_id',60)->lists('id')->toArray();
        if($id = Route::input('id')){
            $list = (new ArticleModel)->getListById($id); //取得文章
        }else{
            $list = (new ArticleModel)->getListById($pid); //取得所有文章
        }
        $recommend = ArticleModel::whereIn('cat_id',$pid)->where('is_recommend',1)->orderBy('created_at','desc')->limit(8)->get(); //取得推荐文章
        return view('help.safe_news',compact('nav','list','recommend'));
    }
    /**
     * 安全中心——信息详情
     */
    public function safe_news_detail($id)
    {
        $id = intval($id);
        $data = ArticleModel::findOrFail($id);
        $nav = ArtCategoryModel::where('p_id',60)->get();
        $recommend = $this->recommend();
        $tag = 'detail';
        return view('help.safe_news',compact('nav','recommend','data','tag'));
    }

    /**
     * 验证中心
     */
    public function verification()
    {
        $nav = ArtCategoryModel::where('p_id',60)->get();
        $recommend = $this->recommend(11);
        return view('help.verification',compact('nav','recommend','data'));
    }

    /**
     * 验证中心-验证
     */
    public function safe_test()
    {
       $input = Input::all();
       if(trim($input['qq'])!=''){
           if(!preg_match("/^[1-9]\d{4,12}$/",$input['qq'])){
               return $data = ['status'=>'n','info'=>'QQ：'.$input['qq'].' 为假客服，请立即停止交易','tag'=>'qq'];
           }
           return $data = ['status'=>'y','info'=>'QQ：'.$input['qq'].' 为官方客服，请放心交易','tag'=>'qq'];
       }
       if(trim($input['email'])!=''){
           if(!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/",$input['email'])){
               return $data = ['status'=>'n','info'=>'邮箱：'.$input['email'].' 不是官方邮箱，请不要点击任何链接','tag'=>'email'];
           }
           return $data = ['status'=>'y','info'=>'邮箱：'.$input['email'].' 为官方邮箱，请放心交易','tag'=>'email'];
       }
       if(trim($input['url'])!=''){
           if(!preg_match("/^(\w+:\/\/)?\w+(\.\w+)+.*$/",$input['url'])){
               return $data = ['status'=>'n','info'=>'网址：'.$input['url'].' 不是官方网站，请不要点击任何链接','tag'=>'url'];
           }
           return $data = ['status'=>'y','info'=>'网址：'.$input['url'].' 为官方网站，请放心交易','tag'=>'url'];
       }
       if(trim($input['bank'])!=''){
           if(!preg_match("/^\d{15,24}$/",$input['bank'])){
               return $data = ['status'=>'n','info'=>'银行卡号：'.$input['bank'].' 不是官方卡号，请不要汇款','tag'=>'bank'];
           }
           return $data = ['status'=>'y','info'=>'银行卡号：'.$input['bank'].' 为官方帐号，请放心交易','tag'=>'bank'];
       }
    }
    /**
     * @return mixed
     * 帮助中心菜单
     */
    public function menu()
    {
        if(!Cache::has('help_nav')){
            $menu = (new ArtCategoryModel)->getHelp();
            Cache::forever('help_nav',$menu);
        }
        $menu = Cache::get('help_nav');
        return $menu;
    }
    /**
     * 当前栏目名称
     * 
     */
    public function cat_name($id)
    {
        $cat_name = (new ArtCategoryModel())->getCatName($id);
        $cat_name = $cat_name->cat_name;
        return $cat_name;
    }


    /**
     * 统计咨询投诉建议总数
     */
    protected function count($user_id=0,$type_id){
        if($user_id==0){
            $count = Ask::where('type_id',$type_id)->count();
        }else{
            $count = Ask::where('user_id',$user_id)->where('type_id',$type_id)->count();
        }
        return $count;
    }
    
    /**
     * 统计各个大类下的小类的总数
     */
    protected function count_next($type_id){
        $ask_category = trans('ask_category');
        $category = '';
        foreach ($ask_category as $k=>$v){
            $category[$k]['num'] = Ask::where('type_id',$type_id)->where('cate_id',$k)->count();
            $category[$k]['name'] = $v;
        }
        return $category;
    }
    
    /**
     * 右侧  个人统计
     */
    protected function count_user(){
        if(Auth::check()){
            $user = $this->getUser();
            $count_ask_user = $this->count($user['id'],1);
            $count_complaint_user = $this->count($user['id'],3);
            $count_advise_user = $this->count($user['id'],2);
        }
        $ask['ask'] = isset($count_ask_user)?$count_ask_user:0;
        $ask['complaint'] = isset($count_complaint_user)?$count_complaint_user:0;
        $ask['advise'] = isset($count_advise_user)?$count_advise_user:0;
        return $ask;
    }
    
    /**
     * 推荐安全文章
     */
    public function recommend($num=8){
        if(!Cache::has('recommend_safe_'.$num)){
            $pid = ArtCategoryModel::where('p_id',60)->lists('id')->toArray();
            $recommend = ArticleModel::whereIn('cat_id',$pid)->where('is_recommend',1)->orderBy('created_at','desc')->limit($num)->get(); //取得推荐文章
            Cache::forever('recommend_safe_'.$num,$recommend);
        }
        $recommend = Cache::get('recommend_safe_'.$num);
        return $recommend;
    }
}


