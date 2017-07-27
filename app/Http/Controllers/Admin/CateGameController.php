<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\CateGame;
use App\Http\Model\Game;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class CateGameController
 * @package App\Http\Controllers\Admin
 * 游戏分类
 */
class CateGameController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.categame',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.categame', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.categame', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.categame', ['only' => ['destroy']]);
    }

    public function index()
    {
        $CateGame = new CateGame();
        $data = $CateGame->getTree();
        return view('admin.game.game_category',compact('data'));
    }

    public function create()
    {
        $CateGame = new CateGame();
        $data = $CateGame->getTree();
        return view('admin.game.game_category_add',compact('data'));
    }

    public function store(Requests\CateGameCreateRequest $request)
    {
        $input = $request->except('_token');

        $input['display_name'] = $this->Pinyin($input['cat_name']);
        $status = CateGame::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加游戏分类'.$input['cat_name']);
            return redirect('admin/cate_game');
        }else{
            return back()->with('msg','游戏分类新增失败，请稍后重试');
        }
    }

    public function update(Requests\CateGameEditRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        $input['display_name'] = $this->Pinyin($input['cat_name']);
        $status = CateGame::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改游戏分类'.$input['cat_name']);
            return redirect('admin/cate_game');
        }else{
            return back()->with('msg','游戏分类更新失败，请稍后重试！');
        }
    }

    public function edit($id)
    {
        $CateGame = new CateGame();
        $data = CateGame::find($id);
        $cate = $CateGame->getTree();
        return view('admin.game.game_category_edit',compact('data','cate'));
    }

    public function destroy($id)
    {
        $hasGame = Game::where('cate_id',$id)->first();

        if($hasGame){
            $data = [
                'status' => 2,
                'info' => '请先删除当前分类下的游戏！',
            ];
        }else{
            $hasChild = CateGame::where('pid',$id)->first();
            if($hasChild){
                $data = [
                    'status' => 3,
                    'info' => '请先删除当前分类下的子分类！',
                ];
            }else{
                $status = CateGame::where('id',$id)->delete();
                if($status){
                    Log::info(session('users.admin_name').'删除游戏分类ID='.$id);
                    $data = [
                        'status' => 0,
                        'info' => '游戏分类删除成功！',
                    ];
                }else{
                    $data = [
                        'status' => 1,
                        'info' => '游戏分类删除失败，请稍后重试！',
                    ];
                }
            }
           
        }
       
        return $data;
    }

    public function show()
    {

    }
}
