<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Attribute;
use App\Http\Model\CateGame;
use App\Http\Model\Game;
use App\Http\Model\GameQu;
use App\Http\Model\GameType;
use App\Http\Model\GameUserInfo;
use App\Http\Model\GoodsGame;
use App\Http\Model\GoodsPicture;
use App\Http\Model\GoodsPictureModel;
use App\Http\model\MenuModel;
use App\Http\Model\Permission;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

/**
 * Class GoodsGameController
 * @package App\Http\Controllers\Admin
 * 商品
 */
class GoodsGameController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.goodsgame',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.goodsgame', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.goodsgame', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.goodsgame', ['only' => ['destroy']]);
        $this->middleware('checkpermission:check.goodsgame', ['only' => ['check']]);
        $this->middleware('checkpermission:clear.stock', ['only' => ['trash']]);
        $this->middleware('checkpermission:clear.expired', ['only' => ['expired']]);
    }


    //全部游戏商品
    public function index(){
        $where = Input::get('type')?Input::get('type'):'0';
        $data_all = (new GoodsGame())->where('traded_type',$where)->where('is_trash','0')->Paginate(PAGE);  //为了使用分页
        $data = (new GoodsGame())->with('game','DaQu','hasManyType','XiaQu','user')->where('traded_type',$where)->where('is_trash','0')->Paginate(PAGE)->toArray();  //得到所有数据
        return view('admin.game.goods_list',compact('data','data_all'));
    }

    //游戏商品添加页面
    public function create(){
        $js = Input::get('js');
        $db = Input::get('db');
        $qg = Input::get('qg');
        //获取所有游戏分类
        $CateGame = new CateGame();
        $CateGameDate = $CateGame->getCache();
        //获取所有用户
        $userData = User::select('id','name')->where('is_admin','<>','1')->get();
        //寄售添加
        if($js=='1'){$make = 'js';}
        //担保添加
        if($db=='1'){$make = 'db';}
        //求购添加
        if($qg=='1'){$make = 'qg';}
        return view('admin.game.goods_add',compact('CateGameDate','make','userData'));
    }


    //修改页面
    public function edit($id){
        //获取所有游戏分类
        $CateGame = new CateGame();
        $CateGameDate = $CateGame->getCache();
        //获取所有用户
        $userData = User::select('id','name')->where('is_admin','<>','1')->get();
        $data = (new GoodsGame())->with('game','game_user_info','goods_pic')->where('id',$id)->first()->toArray();
        //dd($data);
        return view('admin.game.goods_edit',compact('CateGameDate','data','userData'));
    }

    //菜单商品添加操作
    public function store(Requests\GoodsGameCreateRequest $request)
    {
        $input = $request->except('_token');
        $goods = new GoodsGame();
        $goods->goods_price = $input['goods_price'];
        $goods->goods_name = $input['goods_name'];
        //得到添加类型的首字母
        $chinese = GameType::where('id',$input['game_goods_type_id'])->pluck('type')->toArray();
        $re = $this->Pinyin($chinese[0]);
        $goods->goods_code =  strtoupper($re). date('YmdHis',time()).'-'.mt_rand(10000,100000);  //生成商品编号
        $goods->game_id = $input['game_id'];
        $goods->traded_type = $input['traded_type'];
        $goods->goods_type_id = $input['game_goods_type_id'];
        $goods->goods_stock = $input['goods_stock'];
        $goods->sale_start_time = time();
        $goods->sale_end_time = strtotime($input['sale_end_time']);
        $goods->cate_id = $input['game_cate_id'];
        if(isset($input['goods_content'])){
            $goods->goods_content = $input['goods_content'];
        }
        $goods->user_id = $input['user_id'] ;
        $goods->qu_id = $input['qu_id'] ;
        $goods->game_qu_id = $input['game_qu_id'] ;
        if(isset($input['attr_value'])){
            $goods->attr_value = serialize($input['attr_value']);
          //  $goods->attr_value = json_encode($input['attr_value'],JSON_UNESCAPED_UNICODE);
        }

        if($input['traded_type']=='0'){  //寄售类型添加
            $goods->pwd = $input['pwd'];
            $goods->to_money = $input['to_money'];
            $goods->account = $input['account'];
            $goods->security = $input['security'];
            $goods->best_time = $input['best_time'];
        }elseif ($input['traded_type']=='1'){   //担保类型添加
            $goods->pwd = $input['pwd'];
            $goods->to_money = $input['to_money'];
            $goods->account = $input['account'];
            $goods->security = $input['security'];
            $goods->is_cut_price = $input['is_cut_price'];  //是否议价
            $goods->code = $input['code'];  //暗号
            $goods->best_time = $input['best_time'];
        }elseif ($input['traded_type']=='2'){   //求购类型添加

        }
        if($goods->save()){
            if(isset($input['pictrue'])){
                foreach ($input['pictrue'] as $v){
                    $goods_pic = new GoodsPicture();
                    $goods_pic->goods_id = $goods->id;
                    $goods_pic->picture = $v;
                    $goods_pic->create_time = time();
                    $status = $goods_pic->save();
                }
            }else{
                $status ='1';
            }
            if($status){
                $game_user_info = new GameUserInfo();
                $game_user_info->goods_id = $goods->id;
                if($input['traded_type']=='0') {
                    $game_user_info->game_user_name = $input['game_user_name'];  //帐号
                    $game_user_info->game_user_pwd = $input['game_user_pwd'];
                    $game_user_info->is_datacard = $input['is_datacard'];
                    $game_user_info->is_secretcard = $input['is_secretcard'];
                    $game_user_info->secretcard_img = $input['secretcard_img'];
                    $game_user_info->mb_tel = $input['mb_tel'];
                    $game_user_info->mb_question = $input['mb_question'];
                    $game_user_info->mb_answer = $input['mb_answer'];
                    $game_user_info->is_bind_tel = $input['is_bind_tel'];
                    $game_user_info->is_man_day = $input['is_man_day'];
                }
                if($input['traded_type']=='2'){
                    $game_user_info->game_user_name = $input['game_user_name'];  //帐号
                    $game_user_info->game_user_pwd = $input['game_user_pwd'];
                    $game_user_info->is_secretcard = $input['is_secretcard'];
                    $game_user_info->secretcard_img = $input['secretcard_img'];
                }
                $game_user_info->game_user_phone = $input['game_user_phone'];
                $game_user_info->game_user_qq = $input['game_user_qq'];
                $game_user_info->game_user_tel = $input['game_user_tel'];
                $game_user_info->game_user = $input['game_user'];  //角色昵称
                if($game_user_info->save()){
                    Log::info(session('users.admin_name').'添加游戏商品'.$input['goods_name']);
                    return redirect('admin/goodsgame')->with('msg','添加成功');
                }else{
                    $goods->destroy($goods->id);
                    GoodsPicture::where('goods_id',$goods->id)->delete();
                    return back()->with('msg','新增失败，请稍后重试');
                }
            }else{
                $goods->destroy($goods->id);
                return back()->with('msg','新增失败，请稍后重试');
            }
        }else{
            return back()->with('msg','新增失败，请稍后重试');
        }
    }

    //修改操作
    public function update(Requests\GoodsGameEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $goods = GoodsGame::find($id);
        $goods->goods_price = $input['goods_price'];
        $goods->goods_name = $input['goods_name'];
        //得到添加类型的首字母
        $goods->game_id = $input['game_id'];
        $goods->goods_type_id = $input['game_goods_type_id'];
        $goods->goods_stock = $input['goods_stock'];
        $goods->sale_end_time = strtotime($input['sale_end_time']);
        $goods->cate_id = $input['game_cate_id'];
        if(isset($input['goods_content'])){
            $goods->goods_content = $input['goods_content'];
        }
        $goods->user_id = $input['user_id'];
        $goods->qu_id = $input['qu_id'];
        $goods->game_qu_id = $input['game_qu_id'];
        if(isset($input['attr_value'])){
            $goods->attr_value = json_encode($input['attr_value'],JSON_UNESCAPED_UNICODE);
        }

        if($input['traded_type']=='0'){  //寄售类型添加
            $goods->pwd = $input['pwd'];
            $goods->to_money = $input['to_money'];
            $goods->account = $input['account'];
            $goods->security = $input['security'];
            $goods->best_time = $input['best_time'];
        }elseif ($input['traded_type']=='1'){   //担保类型添加
            $goods->pwd = $input['pwd'];
            $goods->to_money = $input['to_money'];
            $goods->account = $input['account'];
            $goods->security = $input['security'];
            $goods->is_cut_price = $input['is_cut_price'];  //是否议价
            $goods->code = $input['code'];  //暗号
            $goods->best_time = $input['best_time'];
        }elseif ($input['traded_type']=='2'){   //求购类型添加
            $chinese = GameType::where('id',$input['game_goods_type_id'])->pluck('type')->toArray();
        }

        if($goods->save()){
            $key = '';
            if(isset($input['picture']) && !empty($input['picture'])){
                $picture=array_combine($input['picture_id'],$input['picture']);  //合并商品相册数组
                foreach ($picture as $k=>$v){
                    if(is_numeric($k)){
                        $key []= $k;
                        $goods_pic = GoodsPicture::find($k);
                        $goods_pic->picture = $v;
                        $status =$goods_pic->save();
                        unset($picture[$k]);
                    }else{
                      //  dd($picture);
                        $goods_pic = new GoodsPicture();
                        $goods_pic->goods_id = $id;
                        $goods_pic->picture = $v;
                        $goods_pic->create_time = time();
                        $status = $goods_pic->save();
                        $key []= $goods_pic->id;
                    }
                }
            }else{
                $status ='1';
            }
            if($status){
                GoodsPicture::where('goods_id',$id)->whereNotIn('id',$key)->delete();
                $game_user_info = GameUserInfo::where('goods_id',$id)->first();
                if($input['traded_type']=='0') {
                    $game_user_info->game_user_name = $input['game_user_name'];  //帐号
                    $game_user_info->game_user_pwd = $input['game_user_pwd'];
                    $game_user_info->is_datacard = $input['is_datacard'];
                    $game_user_info->is_secretcard = $input['is_secretcard'];
                    $game_user_info->secretcard_img = $input['secretcard_img'];
                    $game_user_info->mb_tel = $input['mb_tel'];
                    $game_user_info->mb_question = $input['mb_question'];
                    $game_user_info->mb_answer = $input['mb_answer'];
                    $game_user_info->is_bind_tel = $input['is_bind_tel'];
                    $game_user_info->is_man_day = $input['is_man_day'];
                }
                if($input['traded_type']=='2' &&  strpos($chinese[0],'帐号')){
                    $game_user_info->game_user_name = $input['game_user_name'];  //帐号

                    $game_user_info->game_user_pwd = $input['game_user_pwd'];
                    $game_user_info->is_secretcard = $input['is_secretcard'];
                    $game_user_info->secretcard_img = $input['secretcard_img'];
                }
                $game_user_info->game_user_phone = $input['game_user_phone'];
                $game_user_info->game_user_qq = $input['game_user_qq'];
                $game_user_info->game_user_tel = $input['game_user_tel'];
                $game_user_info->game_user = $input['game_user'];  //角色昵称
                if($game_user_info->save()){
                    Log::info(session('users.admin_name').'修改商品'.$input['goods_name']);
                    Cache::forget('goods_detail_'.$id);  //清除缓存

                    return redirect('admin/goodsgame')->with('msg','修改成功');
                }else{
                    return back()->with('msg','新增失败，请稍后重试');
                }
            }else{
                return back()->with('msg','新增失败，请稍后重试');
            }
        }else{
            return back()->with('msg','新增失败，请稍后重试');
        }
    }

    //放入回收站
    public function destroy($id){
            $status = GoodsGame::where('id',$id)->update(array('is_trash'=>'1'));
            if($status){
                Cache::forget('goods_detail_'.$id);  //清除缓存
                $data = [
                    'status' => 0,
                    'info' => '放入回收站成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'info' => '失败，请稍后重试！',
                ];
        }

        return $data;
    }

    
    //审核查看页面
    public function show($id){
        $data = GoodsGame::with('game','game_user_info','DaQu','hasManyType','XiaQu','user','goods_pic','game_cate')->where('id',$id)->first()->toArray();
        return view('admin.game.goods_check',compact('data'));
    }

    //审核操作
    public function is_check()
    {
        $id = Input::get('id');
        $is_check =  Input::get('is_check');
        $error_reson = Input::get('error_reson')===false?'':Input::get('error_reson');
        $status = GoodsGame::where('id',$id)->update(array('is_check'=>$is_check,'error_reson'=>$error_reson));
        if($status){
            Log::info(session('users.admin_name').'审核商品'.Input::get('goods_name'));
            Cache::forget('goods_detail_'.$id);  //清除缓存
            return redirect('admin/goodsgame');
        }else{
            return back()->with('msg','系统错误，请稍后重试');
        }
    }
    
    //自动清理库存为0商品
    public function trash()
    {
        $query=GoodsGame::where('goods_stock','0')->first();
        if($query){
            $data = GoodsGame::where('goods_stock','0')->update(array('is_trash'=>'1'));
            if($data){
                $data = [
                    'status' => 0,
                    'info' => '清理成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'info' => '失败，请稍后重试！',
                ];
            }
        }else{
            $data = [
                'status' => 2,
                'info' => '没有需要清理的商品！',
            ];
        }
        return $data;
    }

    
    //清理过期商品
    public function expired()
    {
        $query=GoodsGame::where('sale_end_time','<',time())->first();
        if($query){
            $data = GoodsGame::where('sale_end_time','<',time())->update(array('is_trash'=>'1'));
            if($data){
                $data = [
                    'status' => 0,
                    'info' => '清理成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'info' => '失败，请稍后重试！',
                ];
            }
        }else{
            $data = [
                'status' => 2,
                'info' => '没有需要清理的商品！',
            ];
        }
        return $data;
    }

    //Ajax获取数据
    public function AjaxGame()
    {
        if(Input::get('cate_id')){
            $cate_id = Input::get('cate_id');
            $game = Game::select('game_name','id')->where('cate_id',$cate_id)->get();
            return json_encode($game);
            exit;
        }

        if(Input::get('game_id')){
            $game_id = Input::get('game_id');
            $data = (new GameQu())->GameDaQu($game_id);
            return json_encode($data);
            exit;
        }

        if(Input::get('qu_id')){
            $qu_id = Input::get('qu_id');
            $data = (new GameQu())->GameQu($qu_id);
            return json_encode($data);
            exit;
        }

        if(Input::get('show_id')){
            $show_id = Input::get('show_id');
            $data = (new GameType())->type($show_id);
            return json_encode($data);
            exit;
        }

        if(Input::get('type_id')){
            $type_id= Input::get('type_id');
            $game_id = Input::get('id');
            $data = (new Attribute())->attr($game_id,$type_id);
            if($data){
                $type = $this->getQuData($data['data']);
                $html ='';
                foreach ($type as $k=>$v){
                    $html.='<tr class="addSele"><th width="200"><i class="require">*</i>'.$v[0].'</th><td>';
                    $html.='<select name="attr_value[]">';
                    foreach ($v[1]['son'] as $i){
                        $html.='<option value="'.$i.'">'.$i.'</option>';
                    }
                    $html.=' </select></td></tr>';
                }
                return $html;
            }

           // return json_encode($data);
            exit;
        }
    }
//批量操作
    public function all_do()
    {
        $type = Input::except('_token');
        switch (intval($type['all_do'])){
            case '1':
                $status = GoodsGame::whereIn('id',$type['id'])->update(array('is_trash'=>'1'));
                if($status){
                    foreach($type['id'] as $v){
                        Cache::forget('goods_detail_'.$v);  //清除缓存
                    }
                    return redirect('admin/goodsgame')->with('msg','加入回收站成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
            case '2':
                $status = GoodsGame::whereIn('id',$type['id'])->update(array('is_check'=>'1'));
                if($status){
                    foreach($type['id'] as $v){
                        Cache::forget('goods_detail_'.$v);  //清除缓存
                    }
                    return redirect('admin/goodsgame')->with('msg','所选审核成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
        }
    }
    
    
    /**
     * 搜索
     */
    public function search()
    {

        $type = Input::get('type_id');
        $keywords =  Input::get('keywords');
        $goods_type = intval(Input::get('type'));
        $goods = new GoodsGame();
        switch ($type){
            case '0':
               $field = 'goods_code';
                break;
            case '1':
                $field = 'goods_name';
                break;
        }

        $data_all = $goods->where('is_trash','0')->where('traded_type',$goods_type)->where($field,'like','%'.$keywords.'%')->Paginate(PAGE);  //为了使用分页

        $data = $goods->with('game','DaQu','hasManyType','XiaQu','user')->where('traded_type',$goods_type)->where('is_trash','0')->where($field,'like','%'.$keywords.'%')->Paginate(PAGE)->toArray();  //得到所有数据

        return view('admin.game.goods_list',compact('data','data_all','type','keywords'));
    }

    /**
     * 上下架
     */
    public function sale_on_off()
    {
        $goods_id = intval(Input::get('id'));
        $status = intval(Input::get('status'));
        $msg = GoodsGame::where('id',$goods_id)->update(['is_on_sale'=>$status]);
        if($msg){
            Cache::forget('goods_detail_'.$goods_id);  //清除缓存
           return '1';
        }
    }
}
