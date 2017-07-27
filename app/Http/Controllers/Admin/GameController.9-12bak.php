<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\CateGame;
use App\Http\Model\Game;
use App\Http\Model\GameQu;
use App\Http\Model\GameType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;


/**
 * Class GameController
 * @package App\Http\Controllers\Admin
 * 游戏
 */
class GameController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.game',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.game', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.game', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.game', ['only' => ['destroy']]);
    }


    public function index()
    {
        $data = (new Game())->lists();
        $cate = (new CateGame())->getTree();
        return view('admin.game.game_list',compact('data','cate'));
    }

    public function create()
    {
        $data = (new CateGame())->getTree();
        return view('admin.game.game_add',compact('data'));
    }

    public function store(Requests\GameCreateRequest $request)
    {

        $input = $request->except('_token');
        $game = new Game();
        $qu = $game->getQuData($input['data']);
        try{
            DB::transaction(function () use($input,$qu) {     //事务
                $game_data['game_name'] = $input['game_name'];
                $game_data['cate_id'] = $input['cate_id'];
                $game_data['game_desc'] = $input['game_desc'];
                $game_data['game_order'] = $input['game_order'];
                $game_data['display_name'] = $this->Pinyin($input['game_name']);
                $game_data['thumb'] = $input['thumb'];
                $game_id = DB::table('game')->insertGetId($game_data);
                $input['type_name'] = array_filter($input['type_name']); //去掉数组中的空元素
                foreach ($input['type_name'] as $o=>$i){     //保存类型
                    $type['game_id'] = $game_id;
                    $type['type'] = $i;
                    $type['fee'] = $input['fee'][$o]?$input['fee'][$o]:'0';
                    DB::table('game_type')->insert($type);
                }
                foreach ($qu as $k=>$v){        //保存大区
                    $q['game_id'] = $game_id;
                    $q['qu_name'] = $v['0'];
                    $q['pid'] ='0';
                    $qu_id = DB::table('game_qu')->insertGetId($q);
                    foreach ($v['1']['son'] as $m=>$n){     //保存小区
                        $item['game_id'] = $game_id;
                        $item['qu_name'] = $n;
                        $item['pid'] = $qu_id;
                        DB::table('game_qu')->insert($item);
                    }
                }
            });
            Cache::forget('gameData');  //清除缓存
            Cache::forget('GetGameByFirst');  //清除缓存
            return redirect('admin/game');
        }catch (Exception $e) {
            return back()->with('msg', $e);
        }
    }

    public function update(Requests\GameEditRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        $game = Game::find($id);
        $qu = $game->EditQuData($input['data']);
        $type = $game->typeData($input['type_name'],$input['type_id'],$input['fee']);
        $fee = $game->typeFee($input['type_id'],$input['fee']);
        try {
            DB::transaction(function () use($id,$input,$qu,$type,$fee){     //事务
                $game_data['game_name'] = $input['game_name'];
                $game_data['cate_id'] = $input['cate_id'];
                $game_data['game_desc'] = $input['game_desc'];
                $game_data['game_order'] = $input['game_order'];
                $game_data['display_name'] = $this->Pinyin($input['game_name']);
                $game_data['thumb'] = $input['thumb'];
                DB::table('game')->where('id',$id)->update($game_data);

                foreach ($type as $u=>$i){
                    if($u>0 && $i!=''){  //大于0 修改数据
                        DB::table('game_type')->where('id',$u)->update(array('type'=>$i,'fee'=>$fee[$u]));
                    }elseif($u>0 && $i==''){
                        DB::table('game_type')->where('id',$u)->delete();
                    }elseif ($u<0 && $i!=''){
                        DB::table('game_type')->insert(array('type'=>$i,'game_id'=>$id,'fee'=>$fee[$u]));
                    }
                }

                foreach ($qu as $k=>$v){
                    if($v['qu_id']!=''){    //如果不为空  则是修改的数据
                        if($v['qu_name']!=''){
                            DB::table('game_qu')->where('id',$v['qu_id'])->update(array('qu_name'=>$v['qu_name']));
                        }else{
                            DB::table('game_qu')->where('id',$v['qu_id'])->orwhere('pid',$v['qu_id'])->delete(); //删除这个id的所有及下级
                            unset($qu[$k]);    //删除这个数组
                        }
                        foreach ($v['qu_data'] as $m=>$n){
                            if($m>0 && $n!=''){   //大于0则是修改的数据
                                DB::table('game_qu')->where('id',$m)->update(array('qu_name'=>$n));
                            }elseif($m<0 && $n!=''){
                                DB::table('game_qu')->insert(array('qu_name'=>$n,'game_id'=>$id,'pid'=>$v['qu_id']));
                            }elseif($m>0 && $n==''){
                                DB::table('game_qu')->where('id',$m)->delete(); //删除这个id
                            }
                        }
                    }else{     //新增数据的处理
                        if($v['qu_name']!=''){   //顶级大区不为空则放入数据库
                            $pid = DB::table('game_qu')->insertGetId(array('qu_name'=>$v['qu_name'],'game_id'=>$id,'pid'=>'0'));//插入顶级大区并返回id
                            foreach ($v['qu_data'] as $a=>$s){
                                if($a<0 && $s!=''){
                                    DB::table('game_qu')->insert(array('qu_name'=>$s,'game_id'=>$id,'pid'=>$pid));
                                }
                            }
                        }
                    }
                }
            });
            Cache::forget('gameData');  //清除缓存
            Cache::forget('condition_'.$id);
            Log::info(session('users.admin_name') . '修改游戏'.$input['game_name']);
            return redirect('admin/game')->with('msg', '修改成功');

        } catch (Exception $e) {
            return back()->with('msg', $e);
        }
    }



    public function edit($id)
    {
        $game = new Game();
        $data = $game->with('hasManyQu','hasManyType')->find($id)->toArray(); //游戏基本数据

        $cate = (new CateGame())->getTree();  //游戏分类
        $qu = $this->getTree($data['has_many_qu']);  //游戏区服
        $type =$data['has_many_type']; //游戏商品类型

        return view('admin.game.game_edit',compact('data','cate','qu','type'));
    }

    public function destroy($id)
    {
        $status = Game::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除游戏ID='.$id);
            Cache::forget('gameData');  //清除缓存
            Cache::forget('GetGameByFirst');  //清除缓存
            Cache::forget('condition_'.$id);
            $data = [
                'status' => 0,
                'info' => '游戏删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '游戏删除失败，请稍后重试！',
            ];
        }
        return $data;
    }


    public function search(){
        $cat_id = Input::get('cat_id');
        $keywords = Input::get('keywords');
        $cate = (new CateGame())->getTree();

        if(empty($keywords)){
            $model = new CateGame();
            $arr = $model->getPid($cat_id);
            if(count($arr)){
                $data = DB::table('game')->join('game_category', function($join)
                {$join->on('game.cate_id', '=', 'game_category.id');})
                    ->select('game.id', 'game.game_name','game.game_desc','game.game_order', 'game.thumb','game.cate_id','game.is_recommend','game.is_free','game.is_keyword','game.is_hot','game_category.cat_name')
                    ->whereIn('cate_id',$arr)->orderBy('game_order','asc')->Paginate(PAGE);
                foreach ($data as $k=>$v){
                    $data[$k]->num =DB::table('goods_game')->where('game_id',$v->id)->count();
                }
            }else{
                $data = DB::table('game')->join('game_category', function($join)
                {$join->on('game.cate_id', '=', 'game_category.id');})
                    ->select('game.id', 'game.game_name','game.game_desc','game.game_order', 'game.thumb','game.cate_id','game.is_free','game.is_recommend','game.is_keyword','game.is_hot','game_category.cat_name')
                    ->where('cate_id',$cat_id)->orderBy('game_order','asc')->Paginate(PAGE);
                foreach ($data as $k=>$v){
                    $data[$k]->num =DB::table('goods_game')->where('game_id',$v->id)->count();
                }
            }
        }else{

            $data = DB::table('game')->join('game_category', function($join)
            {$join->on('game.cate_id', '=', 'game_category.id');})
                ->select('game.id', 'game.game_name','game.game_desc','game.game_order','game.is_recommend','game.is_hot','game.is_free', 'game.thumb','game.is_keyword','game.cate_id','game_category.cat_name')
                ->where(function($query){
                    $query->where('game_name','like','%'.Input::get('keywords').'%')
                        ->Where(function($query){
                            $query->whereIn('cate_id', (new CateGame())->getPid(Input::get('cat_id')));
                        });
                })->orderBy('game_order','asc')->Paginate(PAGE);
            foreach ($data as $k=>$v){
                $data[$k]->num =DB::table('goods_game')->where('game_id',$v->id)->count();
            }
            // dd(DB::getquerylog());
        }
        return view('admin.game.game_list',compact('data','cate','cat_id','keywords'));
    }

    public function show()
    {

    }


    /**
     * 改变状态  AJAX
     */
    public function change()
    {
       $id = intval(Input::get('id'));
       $status = intval(Input::get('status'));
       $type = intval(Input::get('type'));
        switch ($type){
            case '1':  //1是改变推荐状态
                $field = 'is_recommend';
                break;
            case '2': //2是改变热门状态
                $field = 'is_hot';
                break;
            case '3'://3是改变免费
                $field = 'is_free';
                break;
            case '4'://4是改变是否关键词
                $field = 'is_keyword';
                break;
        }
        if($status=='1'){
            $status = Game::where('id',$id)->update([$field=>'0']);
            Cache::forget('gameData');  //清除缓存
            Cache::forget('all_game');  //清除缓存
            Cache::forget('freeGame');  //清除缓存
            Cache::forget('GetGameByFirst');  //清除缓存
            Cache::forget('condition_'.$id);
            Cache::forget('hot_keywords');
        }else{
            $status = Game::where('id',$id)->update([$field=>'1']);
            Cache::forget('gameData');  //清除缓存
            Cache::forget('all_game');  //清除缓存
            Cache::forget('freeGame');  //清除缓存
            Cache::forget('GetGameByFirst');  //清除缓存
            Cache::forget('condition_'.$id);
            Cache::forget('hot_keywords');
        }
        if($status){
            return '1';
        }else{
            return '2';
        }

    }

}
