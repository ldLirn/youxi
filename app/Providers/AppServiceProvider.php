<?php

namespace App\Providers;

use App\Http\Model\AdModel;
use App\Http\Model\Game;
use App\Http\Model\LinkModel;
use App\Http\Model\NavModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        \Carbon\Carbon::setLocale('zh'); //设置时区

        if(!Cache::has('middnav')){
            $middnav = NavModel::where('nav_wz','2')->where('p_id','0')->where('is_show','1')->select('nav_name','nav_order','nav_url')->orderBy('nav_order','asc')->limit(7)->get()->toArray(); //主导航数据
            Cache::forever('middnav', $middnav);
        }
        $middnav = Cache::get('middnav');
        View::share('middnav',$middnav);


        if(!Cache::has('link_data')){
            $link_data = LinkModel::where('link_type','0')->orderBy('link_order','desc')->limit(16)->get()->toArray(); //友情链接
            Cache::forever('link_data', $link_data);
        }
        $link_data = Cache::get('link_data');
        View::share('link_data',$link_data);

        if(!Cache::has('footnav')){
            $footnav = NavModel::where('nav_wz','3')->where('is_show','1')->select('nav_name','nav_order','nav_url','p_id','id')->orderBy('nav_order','asc')->get()->toArray(); //尾部导航数据
            $footnav = (new NavModel())->getTree_y($footnav);
            Cache::forever('footnav', $footnav);
        }
        $footnav = Cache::get('footnav');
        View::share('footnav',$footnav);


        /**
         * 二维码
         */
        if(!Cache::has('ewm')){
            $ewm = AdModel::with('position')->where('position_id','5')->where('is_open','0')->first()->toArray();
            $ad = "<img src='".$ewm['ad_code']."'  width='".$ewm['position']['adp_width']."' height='".$ewm['position']['adp_height']."' alt='".$ewm['ad_name']."'>";
            Cache::forever('ewm', $ad);
        }
        $ad = Cache::get('ewm');
        View::share('ewm',$ad);

        /**
         * 顶部导航
         */
        if(!Cache::has('topnav')){
            $topnav = NavModel::where('nav_wz','1')->where('is_show','1')->select('nav_name','nav_order','nav_url','id','p_id')->orderBy('nav_order','asc')->get()->toArray(); //主导航数据
            $topnav = (new NavModel())->getTree_y($topnav);
            Cache::forever('topnav', $topnav);
        }
        $topnav = Cache::get('topnav');
        View::share('topnav',$topnav);
        View::share('num','1');

        /**
         * 热门搜索词
         */
       
        if(!Cache::has('hot_keywords')){
            $hot_keywords = Game::where('is_keyword','1')->lists('game_name','id')->toArray();
            Cache::forever('hot_keywords', $hot_keywords);
        }
        $hot_keywords = Cache::get('hot_keywords');
        View::share('hot_keywords',$hot_keywords);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
