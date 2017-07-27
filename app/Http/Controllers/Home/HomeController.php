<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\DKApiController;
use App\Http\Controllers\Controller;

use App\Http\Model\ArtCategoryModel;
use App\Http\Model\ArticleModel;
use App\Http\Model\Ask;
use App\Http\Model\Banner;
use App\Http\Model\Exchange;
use App\Http\Model\ExchangeOrder;
use App\Http\Model\Game;
use App\Http\Model\GameType;
use App\Http\Model\GoodsGame;
use App\Http\Model\Order;
use App\Http\Model\Order_address;
use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use PhpParser\Node\Expr\UnaryMinus;
use Toplan\FilterManager\Facades\FilterManager;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class HomeController
 * @package App\Http\Controllers\Home
 * 前台  主要功能
 */
class HomeController extends CommonController
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
        $str = Letter;
        $banner = Banner::orderBy('banner_order','asc')->get()->toArray();  //banner
        $gameData = $this->getGameByFirst(1);   //全部游戏列表  排序  BY  A-Z
        $recommendGame=Game::with('hasManyType')->select('')->where('is_recommend','1') ->select('id', 'game_name','thumb')->limit(6)->get()->toArray();  //推荐游戏
        $top5 = $this->top5();
        $notice = ArticleModel::whereIn('cat_id',[24,25,26,27])->select('title','id','created_at')->orderBy('updated_at','desc')->limit(6)->get();

        $order = new Order();
        $new = $order->getNewInfo();
        $jb = $this->getRecommendGameByType('游戏币','1',2);
        $xy = $this->getNewGameByType('1',2);
        $jhm = $this->getRecommendGameByType('激活码','1',2);
        $zb = $this->getRecommendGameByType('装备','1',2);
        $zh = $this->getRecommendGameByType('帐号','1',2);
        $yb = $this->getRecommendGameByType('元宝','1',2);
        $s_hot = $this->getGameByHot('3');
        $s_yxb = $this->getRecommendGameByType('游戏币','3',2);
        $s_zb = $this->getRecommendGameByType('装备','3',2);
        $s_zh = $this->getRecommendGameByType('帐号','3',2);

        $w_hot = $this->getGameByHot('2');
        $w_yxb = $this->getRecommendGameByType('游戏币','2',2);
        $w_zb = $this->getRecommendGameByType('装备','2',2);
        $w_zh = $this->getRecommendGameByType('帐号','2',2);
        $w_xy = $this->getNewGameByType('2',2);
        $w_yb = $this->getRecommendGameByType('元宝','2',2);
        $freeGame = $this->getGameByFree();

        $s_data = GoodsGame::with('game','DaQu','XiaQu')->where('traded_type','0')->limit(9)->get()->toArray();  //寄售信息
        $d_data = GoodsGame::with('game','DaQu','XiaQu')->where('traded_type','1')->limit(9)->get()->toArray();  //担保信息
        $q_data = GoodsGame::with('game','DaQu','XiaQu')->where('traded_type','2')->limit(9)->get()->toArray();  //求购信息
        $g = GameType::where('type','帐号')->orwhere('type','游戏帐号')->lists('game_id')->toArray();
        $zhxx = GoodsGame::with('game','DaQu','XiaQu')->whereIn('game_id',$g)->limit(9)->get()->toArray();  //求购信息

        $dk_game_list = $this->getDkGameList();  //取得点卡游戏列表

        $help = (new HelpController())->recommend(6);
        $ask  = Ask::select('ask_title','answer','type_id','id')->where('answer','<>','')->where('user_id','>',0)->orderBy('ask_time','desc')->limit(4)->get();
        return view('home.index',compact('banner','str','gameData','recommendGame','top5','notice','new','jb','xy','jhm','zb','zh','yb','s_hot','s_yxb','s_zb','s_zh','w_hot','w_yxb','w_zb','w_zh',
            'w_xy','w_yb','freeGame','s_data','d_data','q_data','zhxx','help','ask','dk_game_list'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 游戏列表
     */
    public function category()
    {
        $id = Route::input('id');
        $input = Input::all();
        if($id && !isset($input['k'])){
            $id = $this->getId($id);
            $condition = $this->getCondition($id);
            $order_by = isset($input['order_by'])?$input['order_by']:'zh';
           if($order_by=='zh'){
               $order_by = ['sale_end_time','asc'];
           }elseif($order_by=='time'){
               $order_by = ['sale_start_time','desc'];
           }elseif($order_by=='pd'){
               $order_by = ['goods_price','desc'];
           }elseif($order_by=='pa'){
               $order_by = ['goods_price','asc'];
           }

            if(!empty($id) && !empty($input['type']) || !empty($input['qu']) || !empty($input['fwq']) || !empty($input['traded_type'])) {
                $type = '';
                $qu = '';
                $page_path = '';
                for ($i = 0; $i < count($condition['has_many_type']); $i++) {  //得到类型数组
                    $type [$condition['has_many_type'][$i]['id']] = $condition['has_many_type'][$i]['type'];
                }

                for ($i = 0; $i < count($condition['has_many_qu']); $i++) {  //得到区数组
                    $qu [$condition['has_many_qu'][$i]['id']] = $condition['has_many_qu'][$i]['qu_name'];
                }
                if (!empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type)) {
                        return abort(404);
                    }
                    $type_id = array_search($input['type'], $type);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id];

                } elseif (!empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu)) {
                        return abort(404);
                    }
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['qu']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;

                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id];

                } elseif (!empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(404);
                    }
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['qu']);
                    unset($input['fwq']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;

                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id,'game_qu_id'=>$xia_qu_id];

                }elseif (!empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type)) {
                        return abort(403);
                    }
                    $type_id = array_search($input['type'], $type);
                    $traded_type = $this->traded_type($input['traded_type']);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;

                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id,'traded_type'=>$traded_type];

                }elseif(!empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){

                    $type_id = array_search($input['type'], $type);
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['qu']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;

                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id,'traded_type'=>$traded_type];

                } elseif (!empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(403);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['qu']);
                    unset($input['fwq']);
                    unset($input['order_by']);
                    unset($input['page']);
                    $attr = $input;

                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id,'traded_type'=>$traded_type,'game_qu_id'=>$xia_qu_id];


                } elseif (empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu)) {
                        return abort(403);
                    }
                    $da_qu_id = array_search($input['qu'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id];

                } elseif (empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(503);
                    }
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['fwq']=$input['fwq'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'game_qu_id'=>$xia_qu_id];

                } elseif (empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(403);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['fwq']=$input['fwq'];
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'traded_type'=>$traded_type,'game_qu_id'=>$xia_qu_id];

                }elseif (empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){
                    if (!in_array($input['qu'], $qu)) {
                        return abort(404);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['qu']=$input['qu'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'traded_type'=>$traded_type];

                }elseif (empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){
                    $traded_type = $this->traded_type($input['traded_type']);
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type];
                }else{
                    return abort(404);
                }
            }else{
                $where = ['game_id'=>$id];
            }
            $paginator = GoodsGame::with('DaQu','XiaQu','game_user_info','hasManyType')->where($where)->where('is_trash','0')->where('is_on_sale','1')->where('sale_end_time','>=',time())->select()->orderBy($order_by[0],$order_by[1])->Paginate(PAGE);
        }elseif($id && isset($input['k'])){
            $keyword = $input['k'];
            $id = $this->getId($id);
            $condition = $this->getCondition($id);
            $order_by = isset($input['order_by'])?$input['order_by']:'zh';
            if($order_by=='zh'){
                $order_by = ['sale_end_time','asc'];
            }elseif($order_by=='time'){
                $order_by = ['sale_start_time','desc'];
            }elseif($order_by=='pd'){
                $order_by = ['goods_price','desc'];
            }elseif($order_by=='pa'){
                $order_by = ['goods_price','asc'];
            }

            if(!empty($id) && !empty($input['type']) || !empty($input['qu']) || !empty($input['fwq']) || !empty($input['traded_type'])) {
                $type = '';
                $qu = '';
                $page_path = '';
                for ($i = 0; $i < count($condition['has_many_type']); $i++) {  //得到类型数组
                    $type [$condition['has_many_type'][$i]['id']] = $condition['has_many_type'][$i]['type'];
                }
                for ($i = 0; $i < count($condition['has_many_qu']); $i++) {  //得到类型数组
                    $qu [$condition['has_many_qu'][$i]['id']] = $condition['has_many_qu'][$i]['qu_name'];
                }
                if (!empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type)) {
                        return abort(404);
                    }
                    $type_id = array_search($input['type'], $type);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'goods_type_id'=>$type_id];
                } elseif (!empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu)) {
                        return abort(404);
                    }
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['qu']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'goods_type_id'=>$type_id];

                } elseif (!empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(403);
                    }
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['qu']);
                    unset($input['fwq']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'goods_type_id'=>$type_id,'game_qu_id'=>$xia_qu_id];

                }elseif (!empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type)) {
                        return abort(403);
                    }
                    $type_id = array_search($input['type'], $type);
                    $traded_type = $this->traded_type($input['traded_type']);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type,'goods_type_id'=>$type_id];

                }elseif(!empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){

                    $type_id = array_search($input['type'], $type);
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['qu']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id];

                } elseif (!empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['type'], $type) || !in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(404);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $type_id = array_search($input['type'], $type);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    foreach($input as $k=>$v){
                        $page_path[$k]=$v;
                    }
                    unset($input['type']);
                    unset($input['traded_type']);
                    unset($input['qu']);
                    unset($input['fwq']);
                    unset($input['order_by']);
                    unset($input['page']);
                    unset($input['k']);
                    $attr = $input;
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type,'goods_type_id'=>$type_id,'qu_id'=>$da_qu_id,'game_qu_id'=>$xia_qu_id];

                } elseif (empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu)) {
                        return abort(404);
                    }
                    $da_qu_id = array_search($input['qu'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id];

                } elseif (empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(404);
                    }
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['fwq']=$input['fwq'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'qu_id'=>$da_qu_id,'game_qu_id'=>$xia_qu_id];

                } elseif (empty($input['type']) && !empty($input['qu']) && !empty($input['fwq']) && !empty($input['traded_type'])) {
                    if (!in_array($input['qu'], $qu) || !in_array($input['fwq'], $qu)) {
                        return abort(404);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $xia_qu_id = array_search($input['fwq'], $qu);
                    $page_path['qu']=$input['qu'];
                    $page_path['fwq']=$input['fwq'];
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type,'qu_id'=>$da_qu_id,'game_qu_id'=>$xia_qu_id];

                }elseif (empty($input['type']) && !empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){
                    if (!in_array($input['qu'], $qu)) {
                        return abort(404);
                    }
                    $traded_type = $this->traded_type($input['traded_type']);
                    $da_qu_id = array_search($input['qu'], $qu);
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['qu']=$input['qu'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type,'qu_id'=>$da_qu_id];

                }elseif (empty($input['type']) && empty($input['qu']) && empty($input['fwq']) && !empty($input['traded_type'])){
                    $traded_type = $this->traded_type($input['traded_type']);
                    $page_path['traded_type']=$input['traded_type'];
                    $page_path['order_by']=$input['order_by'];
                    $where = ['game_id'=>$id,'traded_type'=>$traded_type];
                }else{
                    return abort(404);
                }
            }else{
                $where = ['game_id'=>$id];
            }
            $paginator = GoodsGame::with('DaQu','XiaQu','game_user_info','hasManyType')->where($where)->where('is_trash','0')->where('goods_code',$keyword)->where('is_on_sale','1')->where('sale_end_time','>=',time())->select()->Paginate(PAGE);
        }elseif (!$id && !empty(Input::get('k'))){
            $keyword = $input['k'];
            foreach($input as $k=>$v){
                $page_path[$k]=$v;
            }
            $paginator = GoodsGame::with('DaQu','XiaQu','game_user_info','hasManyType')->where('goods_code',$keyword)->where('is_trash','0')->where('is_on_sale','1')->where('sale_end_time','>=',time())->select()->Paginate(PAGE);
            if($paginator->toArray()['data']){
                $data =  $paginator->toArray()['data'];
                $condition = $this->getCondition($data[0]['game_id']);
            }
        }
        if(!isset($type_id)){
            $type_id = false;
        }
        if(!isset($attr)){
            $attr = array();
        }
        $attr = array_values($attr);
       if(isset($condition)){
           foreach($condition['has_many_s_type'] as $k=>$v){
               foreach($v['data'] as $n=>$m){
                   $type_s_title[] = $m[0];
               }
           }
       }
        if(!isset($type_s_title)){
            $type_s_title = [];
        }
        $goods = $paginator->toArray()['data'];
        foreach($goods as $k=>$v){
            foreach($attr as $m){
                if(!in_array($m,unserialize($v['attr_value']))){
                    unset($goods[$k]);
                };
            }
        }
      //  dd($goods);
        return view('home.category',compact('condition','goods','paginator','da_qu_id','page_path','type_id','type_s_title','arrt'));
    }


    /**
     * 商品详情
     *
     */
    public function goods($id)
    {
        $id = $this->getId($id);
        $data = $this->GetGameById($id);
        $user = $this->getUser($data['user_id']);
        if($user['id']==0){    //自营
            $buy_rank = 0;  //买家会员等级
            $sell_rank = 0;  //卖家会员等级
        }else{
            $buy_rank = $this->vip_level($user['user_point_buy']);  //买家会员等级
            $sell_rank = $this->vip_level($user['user_point_sell']);  //卖家会员等级
        }
        $buy_sum =$this->buy_sum($user['id']);  //买家成交总数
        $sell_sum = $this->sell_sum($user['id']); //卖家成交总数
        return view('home.goods',compact('data','user','buy_sum','sell_sum','buy_rank','sell_rank'));
    }
    
    
    /**
     * 加入收藏
     */
    public function add_Collection()
    {
        if(Auth::check() == false){
            return $data =[
                'status' =>'30',
                'info' =>'请您先登录！'
            ];
        }
        $user_id = Auth::user()->id;
        $goods_id = intval(Input::get('goods_id'));
        $has = DB::table('collection')->where('user_id',$user_id)->where('goods_id',$goods_id)->first();
        if($has){
            return $data =[
                'status' =>'40',
                'info' =>'您已经收藏过此商品了！'
            ];
        }
        $status = DB::table('collection')->insert(['user_id'=>$user_id,'goods_id'=>$goods_id]);
        if($status){
            return $data =[
                'status' =>'1',
                'info' =>'加入收藏成功！'
            ];
        }else{
            return $data =[
                'status' =>'2',
                'info' =>'系统错误，请稍后重试！'
            ];
        }
    }
    
    

    
    /**
     * need   求购
     */
    public function need()
    {
		//最新求购信息
        $needs = GoodsGame::with('game','user','DaQu','XiaQu','hasManyType')->where('traded_type','2')->where('is_trash','0')->orderBy('created_at','desc')->limit(3)->get();
       // dd($needs);
        foreach ($needs as $v){
            if($v->traded_type=='0'){
                $v->traded_type = 's';
            }elseif ($v->traded_type=='1'){
                $v->traded_type = 'd';
            }elseif($v->traded_type=='2'){
                $v->traded_type = 'q';
            }
        }
        $cat_id = ArtCategoryModel::where('p_id',28)->pluck('id')->toArray();
        $cate_id = ArtCategoryModel::whereIn('p_id',$cat_id)->pluck('id')->toArray();
        $recommend_art = ArticleModel::whereIn('cat_id',$cate_id)->where('is_recommend',1)->select('title','id','cat_id')->orderBy('created_at','desc')->limit(3)->get();
        return view('home.need',compact('needs','recommend_art'));
    }
    
    /**
     * category_zh  帐号交易
     */
    public function category_zh()
    {
        return view('home.category_zh');
    }


    /**
     * 购买页面
     */
    public function buy($id)
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $id = $this->getId($id);
        $goods_data = $this->GetGameById($id);
        if($goods_data['goods_stock']=='0' || $goods_data['is_on_sale']=='0' || $goods_data['sale_end_time']<time()){
            return back();
        }
        
        $goods_data['order_sn'] = $this->orderSn($this->Pinyin($goods_data['has_many_type']['type']));  //生成订单编号
         return view('home.buy',compact('goods_data'));
    }

    /**
     * 生成订单信息
     */
    public function postBuy()
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $input = Input::except('_token');

        if(isset($input['game_user_name'])){    //求购订单,生成寄售订单，并下单给求购人
            $user = $this->getUser();
           if($input['game_user_pwd']!=$input['re_game_user_pwd']){
               return back()->with(trans('com.comfirm'));
           }
            unset($input['re_game_user_pwd']);
            if($input['game_user_name']=='' || $input['game_user_pwd']=='' || $input['game_user']==''){
                return back()->with('请检查信息的完整性');
            }
            $game_user_info = $input;
            $game_user_info['goods_id'] = $game_user_info['id'];
            $order_sn = $game_user_info['order_sn'];
            unset($game_user_info['id']);
            unset($game_user_info['order_sn']);
            $goods_data = $this->GetGameById($input['id']); //读取商品缓存
            $need_info['need_code'] = $goods_data['goods_code'];
            $need_info['need_name'] = $goods_data['goods_name'];
            $need_info['need_game'] = $goods_data['game']['game_name'].'/'.$goods_data['da_qu']['qu_name'].'/'.$goods_data['xia_qu']['qu_name'];
            $need_info['sell_code'] = $order_sn;
            $user_id = $goods_data['user_id'];
            $buy_info = $goods_data['game_user_info'];
            unset($goods_data['id']);
            $goods_data['goods_code'] = $this->GoodsCode($goods_data['goods_type_id']);
            $goods_data['created_at'] = date('Y-m-d H:i:s',time());
            $goods_data['is_check'] ='1';
            $goods_data['user_id'] = $user['id'];
            $goods_data['traded_type']='0';
            unset($goods_data['da_qu']);
            unset($goods_data['xia_qu']);
            unset($goods_data['game']);
            unset($goods_data['game_user_info']);
            unset($goods_data['has_many_type']);
            unset($goods_data['goods_pic']);
            try{
                DB::transaction(function () use($goods_data,$game_user_info,$order_sn,$user_id,$buy_info) {  //开启事务
                    $id = DB::table('goods_game')->insertGetId($goods_data);    //返回id
                    DB::table('game_user_info')->insert($game_user_info);
                    //下单
                    $order['order_sn'] = $order_sn;
                    $order['order_type'] = $goods_data['traded_type'];
                    $order['user_id'] = Auth::user()->id;
                    $order['buy_number'] = $goods_data['goods_stock'];
                    $order['goods_amount'] = $order['buy_number']*$goods_data['goods_price'];
                    $order['order_amount'] = $order['goods_amount'];
                    $order['goods_id'] = $id;
                    $order['created_at'] = time();
                    $order['flag'] = trans('com.need_order');
                    $order_id = DB::table('order')->insertGetId($order);  //写入订单数据
                    $order_address['order_id'] = $order_id;
                    $order_address['user_id'] = $user_id;
                    $order_address['game_id'] = $goods_data['game_id'];
                    $order_address['da_qu_id'] = $goods_data['qu_id'];
                    $order_address['xia_qu_id'] = $goods_data['game_qu_id'];
                    $order_address['role_name'] = htmlspecialchars($buy_info['game_user']);
                    $order_address['telphone'] = $buy_info['game_user_tel'];
                    $order_address['qq'] = $buy_info['game_user_qq'];
                    DB::table('user_order_address') -> insert($order_address);
                });
                return redirect('/need/SellFinish')->with('need_info',$need_info);
            }catch (Exception $e) {
                return back()->with('msg', $e);
            }
        }
        $rules = [
            'order_sn' =>'required',
            'buy_number'=>'required|regex:/^(?!0)[0-9]{1,3}$/',
            'role_name'=>'required',
            'telphone'=>'required|regex:/^1[34578]\d{9}$/',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
        ];
        $messages = [
            'order_sn.required'=>'订单编号不存在!',
            'role_name.required'=>'请填写角色昵称!',
            'telphone.required'=>'手机号码必须填写!',
            'telphone.regex'=>'手机号码格式不正确!',
            'qq.required'=>'QQ号码必须填写!',
            'qq.regex'=>'QQ号码格式不正确!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if ($validator->fails())
        {
            return back()->with('errors',$validator->messages());
        }
        $id = intval($input['id']);
        $goods_data = $this->GetGameById($id); //读取商品缓存
       if($input['buy_number']>$goods_data['goods_stock']){
           return back()->with('msg','最大购买件数为'.$goods_data['goods_stock']);
       }
        if($goods_data['pwd']!='' && $goods_data['pwd']!=$input['pwd']){
            return back()->with('msg','交易密码错误');
        }
        try {
            DB::transaction(function () use($input,$id,$goods_data){  //开启事务
                $order['order_sn'] = $input['order_sn'];
                $order['order_type'] = $goods_data['traded_type'];
                $order['user_id'] = Auth::user()->id;
                $order['goods_price'] = $goods_data['goods_price'];
                $order['buy_number'] = intval($input['buy_number']);
                $order['goods_amount'] = $order['buy_number']*$order['goods_price'];
                $order['order_amount'] = $order['goods_amount'];
                $order['goods_id'] = $id;
                $order['created_at'] = time();
                $order_id = DB::table('order')->insertGetId($order);  //写入订单数据
                $order_address['order_id'] = $order_id;
                $order_address['user_id'] = $order['user_id'];
                $order_address['game_id'] = $goods_data['game_id'];
                $order_address['da_qu_id'] = $goods_data['qu_id'];
                $order_address['xia_qu_id'] = $goods_data['game_qu_id'];
                $order_address['role_name'] = htmlspecialchars($input['role_name']);
                $order_address['telphone'] = $input['telphone'];
                $order_address['qq'] = $input['qq'];
                DB::table('user_order_address') -> insert($order_address);
            });
            return redirect('/pay_order?order_sn='.$input['order_sn']);

        } catch (Exception $e) {
            return back()->with('msg', $e);
        }
    }

    /**
     *
     */
    public function SellFinish()
    {
            return view('home.SellFinish');
    }

    /**
     * 付款 页面
     */
    public function pay_order()
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $order_sn = htmlspecialchars(Input::get('order_sn'));
        $order = Order::where('order_sn',$order_sn)->first()->toArray();
        if($order['pay_status']=='1'){
            return response()->view('errors.info',['message'=>'您的订单已经支付完成了，无需再次支付']);
        }
        $goods_data = $this->GetGameById($order['goods_id']); //读取商品缓存

        return view('home.pay_order',compact('goods_data','order'));
    }


    /**
     * 所有游戏页面
     */
    public function all_game()
    {
        $str = Letter;
        $hotMobile = $this->getGameByHot(3);  
        $hotWeb = $this->getGameByHot(2);
        $zb = $this->getRecommendGameByType('装备',1,3);
        $gold = $this->getRecommendGameByType('金币',1,3);
        $zh = $this->getRecommendGameByType('帐号',1,3);
        $hotGame = $this->getGameByHot(1);
        return view('home.all_game',compact('str','hotMobile','hotWeb','gold','zb','zh','hotGame'));
    }

    /**
     * 求降价申请
     */
    public function changePrice($id)
    {
        $id = $this->getId($id);
        $data = $this->GetGameById($id);
        $user = $this->getUser();
        $buy_rank = $this->vip_level($user['user_point_buy']);  //得到用户对应权限
        if(Input::method()=='POST'){
            $has = DB::table('cut_price')->where('user_id',$user['id'])->where('goods_id',$id)->first();
            if($has){
                return $data=[
                    'status'=>'n',
                    'info' => trans('home.has_cut_price')
                ];
            }
            $input = Input::except('_token');
            $rules = [
                'buy_number'=>'required|regex:/^(?!0)[0-9]{1,3}$/',
                'role_name'=>'required',
                'telphone'=>'required|regex:/^1[34578]\d{9}$/',
                'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
                'old_price'=>'required|regex:/^[1-9]{1}\d*(\.\d{1,2})?$/',
                'new_price'=>'required|regex:/^[1-9]{1}\d*(\.\d{1,2})?$/',
            ];
            $messages = [
                'buy_number.required'=>trans('com.no_buy_number'),
                'buy_number.regex'=>trans('com.error_buy_number'),
                'role_name.required'=>trans('com.no_role_name'),
                'telphone.required'=>trans('com.no_phone'),
                'telphone.regex'=>trans('com.error_phone'),
                'qq.required'=>trans('com.no_qq'),
                'qq.regex'=>trans('com.error_qq'),
                'goods_price.required'=>trans('com.no_goods_price'),
                'goods_price.regex'=>trans('com.error_goods_price'),
                'new_price.required'=>trans('com.no_goods_price'),
                'new_price.regex'=>trans('com.error_goods_price'),
            ];
            $validator = Validator::make($input,$rules,$messages);
            if ($validator->fails())
            {
                return $data=[
                    'status'=>'n',
                    'info' => json_encode($validator->messages(),JSON_UNESCAPED_UNICODE)
                ];
            }else{
                if($this->format_money($input['old_price']*0.8)>$this->format_money($input['new_price'])){
                    return $data=[
                        'status'=>'n',
                        'info' => trans('home.changePrice')
                    ];
                }
                if(intval($input['buy_number'])>$buy_rank['max_changePrice']){
                    return $data=[
                        'status'=>'n',
                        'info' => trans('home.max_changePrice')
                    ];
                }
                $input['user_id'] = $user['id'];
                $input['created_time'] = time();
                $input['to_user_id'] = $data['user_id'];
                $msg = DB::table('cut_price') -> insert($input);
                if($msg){
                    return $data=[
                        'status'=>'y',
                        'info'=>trans('home.changePrice_success')
                    ];
                }else{
                    return $data=[
                        'status'=>'n',
                        'info'=>trans('com.system_error')
                    ];
                }
            }
        }
       return view('home.changePrice',compact('data','buy_rank','user'));
    }

    /**
     * 积分商品
     */
    public function exchange()
    {
        $ads = $this->getAdByPosition(8,3);
        $data = Exchange::Paginate(10);
        $notice = ArticleModel::whereIn('cat_id',[24,25,26,27])->select('title','id','created_at')->orderBy('updated_at','desc')->limit(3)->get();
        $help = (new HelpController())->recommend(3);
        return view('home.exchange',compact('data','ads','notice','help'));
    }
    /**
     * 积分商品详情
     */
    public function exchange_info($id)
    {
        if(!Auth::check()){
            return redirect('/login?redirectUrl='.url()->full() );
        }
        $user = $this->getUser();
        $id = $this->getId($id);
        if(!Cache::has('exchange_info_'.$id)){
            $info = Exchange::where('id',$id)->first()->toArray();
            Cache::forever('exchange_info_'.$id,$info);
        }
        $data = Cache::get('exchange_info_'.$id);
        $count = abs(ExchangeOrder::where('user_id',$user['id'])->where('goods_id',$id)->sum('num'));
        $sy_count = $data['max_exchange'] - $count >0?$data['max_exchange'] - $count:0;
        if(Input::method()=='POST'){
            $num = intval(Input::get('num'));
            if($num>$sy_count || $num>$data['stock']){
                return back()->with('msg','兑换数量不正确');
            }
            if($user['integral']<$data['integral']*$num){
                return back()->with('msg','您的积分不足');
            }
            $url = Input::url();
            $order_code = 'DH'.date('YmdHis',time()).rand('10000','100000');
            session()->put('num',$num);
            return view('home.exchange_order',compact('data','user','order_code','num','url'));
        }
        if(Input::method()=='DELETE'){
            $num = session('num');
            session()->forget('num');
            $input = Input::all();
            if(password_verify($input['pay_password'],$user['pay_password'])===false){
                return $data = [
                    'status'=>'n',
                    'info'  =>trans('com.pay_pass_error')
                ];
            }
            if(!preg_match('/^1([0-9]{9})/',$input['telphone'])){
                return $data = [
                    'status'=>'n',
                    'info'  =>trans('com.error_phone')
                ];
            }
            $order['order_code'] = Input::get('o');
            $order['tel'] = $input['telphone'];
            $order['qq'] = $input['qq'];
            $order['user_info'] = $input['user_info']?$input['user_info']:'';
            $order['create_time'] = time();
            $order['order_integral'] = $data['integral']*$num;
            $order['num'] = $num;
            $order['integral'] = $data['integral'];
            $order['user_id'] = $user['id'];
            $order['goods_id'] = $data['id'];
            try {
                DB::transaction(function () use($user,$order){
                    $msg = ExchangeOrder::insert($order);   //写入积分订单表
                    $accoun['integral'] = -$order['order_integral'];
                    $accoun['change_time'] = time();
                    $accoun['change_desc'] = '用户积分兑换';
                    $accoun['change_type'] ='99';
                    $accoun['user_id'] =$user['id'];
                    DB::table('account_log')->insert($accoun);
                    DB::table('users')->where('id',$user['id'])->decrement('integral',$accoun['integral']);
                    DB::table('exchange')->where('id',$order['goods_id'])->decrement('stock',$order['num']);
                });
                Cache::forget('user_info_'.$user['id']);
                Cache::forget('exchange_info_'.$order['goods_id']);
                return $data = [
                    'status'=>'y',
                    'info'  =>trans('com.operation_success')
                ];
            } catch (Exception $e) {
                return $data = [
                    'status'=>'n',
                    'info'  =>trans('com.system_error')
                ];
            }
        }
        return view('home.exchange_info',compact('data','user','sy_count'));
    }

}
